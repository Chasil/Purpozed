<?php

namespace Purpozed2\Models;

class OpportunitiesManager
{

    const METHOD_GET_CALLS = 1;
    const METHOD_GET_PROJECTS = 2;
    const METHOD_GET_MENTORINGS = 4;
    const METHOD_GET_ENGAGEMENTS = 8;

    public function getList($organizationId = null, $statuses = null, $formats = null, $goals = null, $skills = null, $durations = null, $onlyOpenEngagements = null)
    {

        $disabledMethods = 0;

        if ($skills) {
            $disabledMethods |= self::METHOD_GET_MENTORINGS;
            $disabledMethods |= self::METHOD_GET_ENGAGEMENTS;
        }
        if ($durations && !in_array('1', $durations)) {
            $disabledMethods |= self::METHOD_GET_CALLS;
        }

        $results = array();

        if (!($disabledMethods & self::METHOD_GET_CALLS)) {
            $results = array_merge($results, $this->getCalls($organizationId, $statuses, $formats, $goals, $skills, $durations));
        }
        if (!($disabledMethods & self::METHOD_GET_PROJECTS)) {
            $results = array_merge($results, $this->getProjects($organizationId, $statuses, $formats, $goals, $skills, $durations));
        }
        if (!($disabledMethods & self::METHOD_GET_MENTORINGS)) {
            $results = array_merge($results, $this->getMentorings($organizationId, $statuses, $formats, $goals, $durations));
        }
        if (!($disabledMethods & self::METHOD_GET_ENGAGEMENTS)) {
            $results = array_merge($results, $this->getEngagements($organizationId, $statuses, $formats, $goals, $durations, $onlyOpenEngagements));
        }

        return $results;
    }

    protected function prepareOpportunityQuery($organizationId = null, $statuses = null, $formats = null, $goals = null)
    {

        global $wpdb;

        $wheres = array();

        $query = " LEFT JOIN wp_users wpu
                    ON wpu.ID = wpo.organization_id ";

        if ($organizationId) {
            if (is_int($organizationId)) {
                $wheres[] = $wpdb->prepare(' organization_id = %d', $organizationId);
            } elseif (is_array($organizationId)) {
                $wheres[] = $wpdb->prepare(' organization_id IN (' . implode(', ', array_fill(0, count($organizationId), '%s')) . ')', $organizationId);
            }
        }
        if ($statuses) {
            $inValues = [];
            foreach ($statuses as $key => $value) {
                $inValues[] = $wpdb->prepare(' %s ', $value);
            }
            $implodedStatuses = implode(',', $inValues);
            $wheres[] = " status IN (" . $implodedStatuses . ") ";
        }
        if ($formats) {
            $inValues = [];
            foreach ($formats as $key => $value) {
                $inValues[] = $wpdb->prepare(' %s ', $value);
            }
            $implodedStatuses = implode(',', $inValues);
            $wheres[] = " task_type IN (" . $implodedStatuses . ") ";
        }
        if ($goals) {
            $inValues = [];
            foreach ($goals as $key => $value) {
                $inValues[] = $wpdb->prepare(' %s ', $value);
            }
            $implodedStatuses = implode(',', $inValues);
            $organizationsIDs = $wpdb->get_col("SELECT organization_id FROM wp_purpozed_organization_goals WHERE goal_id IN (" . $implodedStatuses . ")");

            if (empty(($organizationsIDs))) {
                $organizationsIDs = array(1);
            }

            $inOrganizations = [];
            foreach ($organizationsIDs as $key => $value) {
                $inOrganizations[] = $wpdb->prepare(' %s ', $value);
            }
            $implodedOrganizations = implode(',', $inOrganizations);
            $wheres[] = " organization_id IN (" . $implodedOrganizations . ") ";
        }

        return array(
            'query' => $query,
            'wheres' => $wheres
        );
    }

    public function getCalls($organizationId = null, $statuses = null, $formats = null, $goals = null, $skills = null, $durations = null)
    {

        global $wpdb;

        $query = "SELECT DISTINCT wpoc.*, wpo.*, wpu.display_name as organization_name, 
                    TIMESTAMPDIFF(DAY, FROM_UNIXTIME(wpo.status_change_date), NOW()) as status_since, 
                    TIMESTAMPDIFF(DAY, NOW(), FROM_UNIXTIME(wpoc.expire)) as expire_in, 
                    TIMESTAMPDIFF(DAY, FROM_UNIXTIME(wpo.in_progress_since), NOW()) as due_since,
                    '0' as duration_overall
                    FROM wp_purpozed_opportunities_call wpoc
                    JOIN wp_purpozed_opportunities wpo
                    ON wpo.id = wpoc.task_id";

        $queryItems = $this->prepareOpportunityQuery($organizationId, $statuses, $formats, $goals);

        $wheres = $queryItems['wheres'];

        if ($skills) {
            $query .= " LEFT JOIN wp_purpozed_opportunities_call_skills wpocs
                        ON wpoc.id = wpocs.call_id ";

            $inValues = [];
            foreach ($skills as $key => $value) {
                $inValues[] = $wpdb->prepare(' %s ', $value);
            }
            $implodedSkills = implode(',', $inValues);
            $wheres[] = " wpocs.skill_id IN (" . $implodedSkills . ") ";
        }

        $query .= $queryItems['query'];

        if (!empty($wheres)) {
            $query .= ' WHERE ' . implode(' AND', $wheres);
        }

        return $wpdb->get_results($query);
    }

    public function getProjects($organizationId = null, $statuses = null, $formats = null, $goals = null, $skills = null, $durations = null)
    {
        global $wpdb;

        $query = "SELECT DISTINCT wpop.*, wpo.*, wpu.display_name as organization_name, 
                    TIMESTAMPDIFF(DAY, FROM_UNIXTIME(wpo.status_change_date), NOW()) as status_since, 
                    TIMESTAMPDIFF(DAY, NOW(), FROM_UNIXTIME(wpop.expire)) as expire_in, 
                    TIMESTAMPDIFF(DAY, FROM_UNIXTIME(wpo.in_progress_since), NOW()) - FLOOR(wppt.hours_duration / 24) as due_since,
                    FLOOR(wppt.hours_duration) as duration_overall,
                    FLOOR(wppt.hours_duration / 8) as days_overall
                    FROM wp_purpozed_opportunities_project wpop
                    JOIN wp_purpozed_opportunities wpo 
                    ON wpo.id = wpop.task_id
                    LEFT JOIN wp_purpozed_project_tasks wppt 
                    ON wpop.topic = wppt.id";

        $queryItems = $this->prepareOpportunityQuery($organizationId, $statuses, $formats, $goals);

        $wheres = $queryItems['wheres'];

        if ($skills) {
            $query .= " LEFT JOIN wp_purpozed_project_tasks_skills wppts 
                        ON wppts.project_task_id = wppt.id ";

            $inValues = [];
            foreach ($skills as $key => $value) {
                $inValues[] = $wpdb->prepare(' %s ', $value);
            }
            $implodedSkills = implode(',', $inValues);
            $wheres[] = " wppts.skill_id IN (" . $implodedSkills . ") ";
        }

        if ($durations) {
            if (in_array('1', $durations)) {
                $wheres[] = " wppt.hours_duration = 1 ";
            }
            if (in_array('2', $durations)) {
                $wheres[] = " (wppt.hours_duration > 1 AND wppt.hours_duration <= 8) ";
            }
            if (in_array('3', $durations)) {
                $wheres[] = " (wppt.hours_duration > 8 AND wppt.hours_duration <= 24) ";
            }
            if (in_array('4', $durations)) {
                $wheres[] = " wppt.hours_duration > 24 ";
            }
        }

        $query .= $queryItems['query'];

        if (!empty($wheres)) {
            $query .= ' WHERE ' . implode(' AND', $wheres);
        }

        return $wpdb->get_results($query);
    }

    public function getMentorings($organizationId = null, $statuses = null, $formats = null, $goals = null, $durations = null)
    {
        global $wpdb;

        $query = "SELECT DISTINCT wpom.*, wpo.*, wpu.display_name as organization_name, 
                    TIMESTAMPDIFF(DAY, FROM_UNIXTIME(wpo.status_change_date), NOW()) as status_since, 
                    TIMESTAMPDIFF(DAY, NOW(), FROM_UNIXTIME(wpom.expire)) as expire_in, 
                    TIMESTAMPDIFF(DAY, FROM_UNIXTIME(wpo.in_progress_since), NOW()) - FLOOR(wpom.frequency * wpom.duration * wpom.time_frame / 24) as due_since,
                    FLOOR (wpom.frequency * wpom.duration * wpom.time_frame) as duration_overall,
                    FLOOR (wpom.frequency * wpom.duration * wpom.time_frame / 8) as days_overall
                    FROM wp_purpozed_opportunities_mentoring wpom 
                    JOIN wp_purpozed_opportunities wpo 
                    ON wpo.id = wpom.task_id";

        $queryItems = $this->prepareOpportunityQuery($organizationId, $statuses, $formats, $goals);

        $query .= $queryItems['query'];
        $wheres = $queryItems['wheres'];

        if ($durations) {

            $durationQueries = array();
            if (in_array('1', $durations)) {
                $durationQueries[] = " (wpom.frequency * wpom.duration * wpom.time_frame) = 1 ";
            }
            if (in_array('2', $durations)) {
                $durationQueries[] = " ((wpom.frequency * wpom.duration * wpom.time_frame) > 1 AND (wpom.frequency * wpom.duration * wpom.time_frame) <= 8) ";
            }
            if (in_array('3', $durations)) {
                $durationQueries[] = " ((wpom.frequency * wpom.duration * wpom.time_frame) > 8 AND (wpom.frequency * wpom.duration * wpom.time_frame) <= 24) ";
            }
            if (in_array('4', $durations)) {
                $durationQueries[] = " (wpom.frequency * wpom.duration * wpom.time_frame) > 24 ";
            }

            if (!empty($durationQueries)) {
                $wheres[] = ' ( ' . implode('OR', $durationQueries) . ' ) ';
            }

        }

        if (!empty($wheres)) {
            $query .= ' WHERE ' . implode(' AND', $wheres);
        }

        return $wpdb->get_results($query);
    }

    public function getEngagements($organizationId = null, $statuses = null, $formats = null, $goals = null, $durations = null, $onlyOpenEngagements = null)
    {
        global $wpdb;

        $query = "SELECT DISTINCT wpoe.*, wpo.*, wpu.display_name as organization_name, 
                    TIMESTAMPDIFF(DAY, FROM_UNIXTIME(wpo.status_change_date), NOW()) as status_since, 
                    TIMESTAMPDIFF(DAY, NOW(), FROM_UNIXTIME(wpoe.expire)) as expire_in, 
                    TIMESTAMPDIFF(DAY, FROM_UNIXTIME(wpo.in_progress_since), NOW()) - FLOOR(wpoe.frequency * wpoe.duration * wpoe.time_frame + wpoe.training_duration / 24 + wpoe.training_duration) as due_since,
                    FLOOR(wpoe.frequency * wpoe.duration * wpoe.time_frame + wpoe.training_duration ) as duration_overall,
                    FLOOR(wpoe.frequency * wpoe.duration * wpoe.time_frame / 8 + wpoe.training_duration ) as days_overall
                    FROM wp_purpozed_opportunities_engagement wpoe 
                    JOIN wp_purpozed_opportunities wpo 
                    ON wpo.id = wpoe.task_id";

        $queryItems = $this->prepareOpportunityQuery($organizationId, $statuses, $formats, $goals);

        $query .= $queryItems['query'];
        $wheres = $queryItems['wheres'];

        if ($durations) {

            $durationQueries = array();
            if (in_array('1', $durations)) {
                $durationQueries[] = " (wpoe.frequency * wpoe.duration * wpoe.time_frame) + wpoe.training_duration = 1 ";
            }
            if (in_array('2', $durations)) {
                $durationQueries[] = " (((wpoe.frequency * wpoe.duration * wpoe.time_frame) + wpoe.training_duration) > 1 AND (wpoe.frequency * wpoe.duration * wpoe.time_frame) <= 8) ";
            }
            if (in_array('3', $durations)) {
                $durationQueries[] = " (((wpoe.frequency * wpoe.duration * wpoe.time_frame) + wpoe.training_duration) > 8 AND (wpoe.frequency * wpoe.duration * wpoe.time_frame) <= 24) ";
            }
            if (in_array('4', $durations)) {
                $durationQueries[] = " ((wpoe.frequency * wpoe.duration * wpoe.time_frame) + wpoe.training_duration) > 24 ";
            }

            if (!empty($durationQueries)) {
                $wheres[] = ' ( ' . implode('OR', $durationQueries) . ' ) ';
            }

        }

        if ($onlyOpenEngagements !== null) {
            $wheres[] = ' closed = 0 ';
        }

        if (!empty($wheres)) {
            $query .= ' WHERE ' . implode(' AND', $wheres);
        }

        return $wpdb->get_results($query);

    }

    public function countAll()
    {
        global $wpdb;

        return $wpdb->get_var("SELECT count(*) FROM wp_purpozed_opportunities");
    }

    public function countAllOpen()
    {
        global $wpdb;

        return $wpdb->get_var("SELECT count(*) FROM wp_purpozed_opportunities WHERE status = 'open'");
    }

    public function countAllCanceled()
    {
        global $wpdb;

        return $wpdb->get_var("SELECT count(*) FROM wp_purpozed_opportunities WHERE status = 'canceled'");
    }

    public function getSingleCall($id)
    {

        global $wpdb;
        $query = $wpdb->prepare("SELECT wpo.id as o_id, wpo.task_type as o_task_type, wpo.status, wpo.posted, wpo.image, wpo.image_caption, wpoc.*, wpo.image as image
                                        FROM wp_purpozed_opportunities_call wpoc
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpoc.task_id
                                        WHERE wpo.id = %d", $id);
        return $wpdb->get_row($query);
    }

    public function getSingleProject($id)
    {

        global $wpdb;
        $query = $wpdb->prepare("SELECT wpo.id as o_id, wpo.task_type as o_task_type, wpo.status, wpo.posted, wpop.*, wpaoe.name as aoe_name, wpo.image_caption, wpo.image as image
                                        FROM wp_purpozed_opportunities_project wpop
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpop.task_id
                                        LEFT JOIN wp_purpozed_project_tasks wppt
                                        ON wppt.id = wpop.topic
                                        LEFT JOIN wp_purpozed_areas_of_expertise wpaoe
                                        ON wppt.area_of_expertise = wpaoe.id
                                        WHERE wpo.id = %d", $id);
        return $wpdb->get_row($query);
    }

    public function getCallSkills($id)
    {

        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_purpozed_opportunities_call_skills wpocs
                                            LEFT JOIN wp_purpozed_skills wps
                                            ON wpocs.skill_id = wps.id WHERE wpocs.call_id = $id");

    }

    public function getSkillsByOportunity($opportunityId)
    {

        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_purpozed_opportunities_call wpoc
                                            LEFT JOIN wp_purpozed_opportunities_call_skills wpocs
                                            ON wpocs.call_id = wpoc.id 
                                            LEFT JOIN wp_purpozed_skills wps
                                            ON wpocs.skill_id = wps.id
                                            WHERE wpoc.task_id = $opportunityId");
    }

    public function getCallSkillsByCall($callId)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT wps.name, wps.id FROM wp_purpozed_opportunities_call_skills wpocs
                                            LEFT JOIN wp_purpozed_opportunities_call wpoc
                                            ON wpocs.call_id = wpoc.id 
                                            LEFT JOIN wp_purpozed_skills wps
                                            ON wpocs.skill_id = wps.id
                                            WHERE wpoc.task_id = $callId");
    }

    public function getProjectWithTask($taskId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT wpop.*, wppt.name, wppt.description, wppt.hours_duration, wppt.area_of_expertise FROM wp_purpozed_opportunities_project wpop
                                        LEFT JOIN wp_purpozed_project_tasks wppt
                                        ON wpop.topic = wppt.id
                                        WHERE wpop.task_id = %d", $taskId);
        return $wpdb->get_row($query);
    }

    public function getProjectSkillsByTask($taskId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT wps.name, wps.id FROM wp_purpozed_skills wps
                                        LEFT JOIN wp_purpozed_project_tasks_skills wppts
                                        ON wps.id = wppts.skill_id
                                        LEFT JOIN wp_purpozed_project_tasks wppt
                                        ON wppt.id = wppts.project_task_id
                                        LEFT JOIN wp_purpozed_opportunities_project wpop
                                        ON wpop.topic = wppt.id
                                        WHERE wpop.task_id = '%d'", $taskId);

        return $wpdb->get_results($query);
    }

    public function getMentoring($id)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities_mentoring 
                                        WHERE task_id = %d", $id);

        return $wpdb->get_row($query);
    }

    public function getEngagement($id)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities_engagement 
                                        WHERE task_id = %d", $id);

        return $wpdb->get_row($query);
    }

    public function getTopic($id)
    {

        global $wpdb;
        return $wpdb->get_row("SELECT * FROM wp_purpozed_project_tasks WHERE id = $id");
    }

    public function getFocuses($id)
    {

        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_purpozed_opportunities_call_focuses wpocf
                                            LEFT JOIN wp_purpozed_focuses wps
                                            ON wpocf.focus_id = wps.id WHERE wpocf.call_id = $id");
    }

    public function getType($id)
    {
        global $wpdb;
        return $wpdb->get_var("SELECT wpo.task_type
                                        FROM wp_purpozed_opportunities wpo
                                        WHERE wpo.id = $id");
    }

    public function getStatuses()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT wpo.status
                                        FROM wp_purpozed_opportunities wpo
                                        GROUP BY wpo.status ORDER BY wpo.status ASC");
    }

    public function getSingleMentoring($id)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT wpo.*, wpom.*, wpaofe.name as aoe_name FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_opportunities_mentoring wpom
                                        ON wpom.task_id = wpo.id
                                        LEFT JOIN wp_purpozed_areas_of_expertise wpaofe
                                        ON wpaofe.id = wpom.mentor_area 
                                        WHERE wpo.id = '%d'", $id);

        return $wpdb->get_row($query);
    }

    public function getSingleEngagement($id)
    {
        global $wpdb;

        return $wpdb->get_row("SELECT wpo.*, wpoe.* FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_opportunities_engagement wpoe
                                        ON wpoe.task_id = wpo.id                                 
                                        WHERE wpo.id = $id");
    }

    public function getApllied($userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_volunteer_applied wpvo
                                        ON wpvo.opportunity_id = wpo.id
                                        WHERE user_id = %d AND wpvo.removed = 0", $userId);

        return $wpdb->get_results($query);
    }

    public function getInProgress($userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_volunteer_in_progress wpvi
                                        ON wpvi.opportunity_id = wpo.id
                                        WHERE user_id = %d AND status IN ('in_progress')", $userId);

        return $wpdb->get_results($query);
    }

    public function getInProgressVolunteer($userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT wpo.*, wpvip.* FROM wp_purpozed_volunteer_in_progress wpvip
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpvip.opportunity_id = wpo.id
                                        WHERE user_id = %d", $userId);

        return $wpdb->get_results($query);
    }

    public function getCompleted($userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT wpo.*, wpoee.canceled_by FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_volunteer_completed wpvc
                                        ON wpvc.opportunity_id = wpo.id
                                        LEFT JOIN wp_purpozed_opportunities_engagement_evaluation wpoee
                                        ON wpoee.opportunity_id = wpo.id
                                        WHERE (wpvc.user_id = %d AND wpo.status IN ('succeeded', 'canceled')) OR (wpoee.user_id = %d) ", $userId, $userId);

        return $wpdb->get_results($query);
    }

    public function getRequested($userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_volunteer_request wpvr
                                        ON wpvr.opportunity_id = wpo.id
                                        WHERE user_id = %d AND wpvr.removed = 0", $userId);

        return $wpdb->get_results($query);
    }

    public function getBookmarked($userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_volunteer_bookmarked wpvr
                                        ON wpvr.opportunity_id = wpo.id
                                        WHERE user_id = %d", $userId);

        return $wpdb->get_results($query);
    }

    public function isBookmarked($userId, $opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_volunteer_bookmarked WHERE user_id = %d AND opportunity_id = %d", $userId, $opportunityId);
        return $wpdb->get_var($query);
    }


    public function bookmarkOpportunity($userId, $opportunityId)
    {

        global $wpdb;

        return $wpdb->insert('wp_purpozed_volunteer_bookmarked',
            array(
                'user_id' => $userId,
                'opportunity_id' => $opportunityId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function hasApplied($userId, $opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) 
                                        FROM wp_purpozed_volunteer_applied 
                                        WHERE user_id = %d 
                                        AND opportunity_id = %d AND removed = '0'", $userId, $opportunityId);
        return $wpdb->get_var($query);
    }

    public function sort($opportunities): array
    {
        usort($opportunities, array($this, 'date_sort'));
        return $opportunities;
    }

    public function date_sort($a, $b)
    {
        return strtotime($b->posted) - strtotime($a->posted);
    }

    public function getOpenCalls()
    {
        $status = array('open');
        return $this->getCalls(null, $status);
    }

    public function getOpenProjects()
    {
        $status = array('open');
        return $this->getProjects(null, $status);
    }

    public function countOpenCallsOpportunitiesWithSkill($skillID)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) as amount FROM wp_purpozed_opportunities wpo 
                                        LEFT JOIN wp_purpozed_opportunities_call wpoc ON wpo.id = wpoc.task_id 
                                        LEFT JOIN wp_purpozed_opportunities_call_skills wpocs ON wpoc.id = wpocs.call_id WHERE wpocs.skill_id = %d AND wpo.status = 'open' AND wpo.task_type = 'call'", $skillID);

        return $wpdb->get_row($query);
    }

    public function countOpenProjectsOpportunitiesWithSkill($skillID)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) as amount FROM wp_purpozed_opportunities wpo 
                                        LEFT JOIN wp_purpozed_opportunities_project wpop ON wpo.id = wpop.task_id 
                                        LEFT JOIN wp_purpozed_project_tasks_skills wppts ON wpop.topic = wppts.project_task_id 
                                        WHERE wppts.skill_id = %d AND wpo.status = 'open' AND wpo.task_type = 'project'", $skillID);

        return $wpdb->get_row($query);
    }
}