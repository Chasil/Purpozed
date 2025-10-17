<?php

namespace Purpozed2\Models;

class Opportunity
{

    public function isEvaluated($opportunityId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT status FROM wp_purpozed_opportunities WHERE id = '%d'", $opportunityId);
        $status = $wpdb->get_var($query);

        $isEvaluated = false;
        if ($status === 'succeeded' || $status === 'canceled') {
            $isEvaluated = true;
        }
        return $isEvaluated;
    }

    public function isEvaluatedEngagement($opportunityId, $userId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_opportunities_engagement_evaluation WHERE opportunity_id = '%d' AND user_id = '%d'", $opportunityId, $userId);
        $isEvaluated = $wpdb->get_var($query);

        return $isEvaluated;
    }

    public function getCompletedEngagementFully($opportunityId, $userId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities_engagement_evaluation WHERE opportunity_id = '%d' AND user_id = '%d'", $opportunityId, $userId);
        $isEvaluated = $wpdb->get_row($query);

        return $isEvaluated;
    }

    public function getVolunteerEvaluationText($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT evaluation_volunteer FROM wp_purpozed_opportunities WHERE id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function getVolunteerEvaluationDate($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT evaluation_volunteer_date FROM wp_purpozed_opportunities WHERE id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function getOrganizationEvaluationText($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT evaluation_organization FROM wp_purpozed_opportunities WHERE id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function getOrganizationEvaluationTextDate($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT evaluation_organization_date FROM wp_purpozed_opportunities WHERE id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function setCompleted($opportunityId, $userId, $hours)
    {

        global $wpdb;

        $startTime = $this->getStartOportunityTime($opportunityId, $userId);
        $this->removeFromInProgress($opportunityId, $userId);

        $this->setStatusChangeDate($opportunityId);

        if ($hours === null) {
            $hours = 0;
        }

        return $wpdb->insert('wp_purpozed_volunteer_completed',
            array(
                'opportunity_id' => $opportunityId,
                'user_id' => $userId,
                'start_date' => $startTime,
                'mentoring_hours' => $hours
            ),
            array(
                '%d',
                '%d',
                '%s',
                '%d'
            )
        );
    }

    public function getAreaOfExpertise($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT wpaoe.id, wpaoe.name FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_opportunities_mentoring wpom
                                        ON wpo.id = wpom.task_id
                                        LEFT JOIN wp_purpozed_areas_of_expertise wpaoe
                                        ON wpaoe.id = wpom.mentor_area
                                        WHERE wpo.id = '%d'", $opportunityId);

        return $wpdb->get_results($query);
    }

    public function getCallAreaOfExpertise($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT wpaoe.id, wpaoe.name FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_opportunities_call wpoc
                                        ON wpo.id = wpoc.task_id
                                        LEFT JOIN wp_purpozed_project_tasks wppt
                                        ON wppt.id = wpoc.topic
                                        LEFT JOIN wp_purpozed_areas_of_expertise wpaoe
                                        ON wpaoe.id = wppt.area_of_expertise
                                        WHERE wpo.id = '%d'", $opportunityId);

        return $wpdb->get_row($query);
    }

    public function getProjectAreaOfExpertise($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT wpaoe.id, wpaoe.name, wpoc.task_id FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_opportunities_project wpoc
                                        ON wpo.id = wpoc.task_id
                                        LEFT JOIN wp_purpozed_project_tasks wppt
                                        ON wppt.id = wpoc.topic
                                        LEFT JOIN wp_purpozed_areas_of_expertise wpaoe
                                        ON wpaoe.id = wppt.area_of_expertise
                                        WHERE wpo.id = '%d'", $opportunityId);

        return $wpdb->get_row($query);
    }

    public function getStartOportunityTime($opportunityId, $userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT start_date FROM wp_purpozed_volunteer_in_progress
                            WHERE opportunity_id = %d AND user_id = %d", $opportunityId, $userId);

        return $wpdb->get_var($query);

    }

    public function getOpportunityCompletedStartAndEndDate($opportunityId, $userId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT start_date, end_date FROM wp_purpozed_volunteer_completed
                            WHERE opportunity_id = %d AND user_id = %d", $opportunityId, $userId);

        return $wpdb->get_row($query);
    }

    public function getOpportunityCompletedStartAndEndDateEngagement($opportunityId, $userId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT start_date, end_date FROM wp_purpozed_opportunities_engagement_evaluation
                            WHERE opportunity_id = %d AND user_id = %d", $opportunityId, $userId);

        return $wpdb->get_row($query);
    }

    public function getVolunteerWhoCompleted($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT user_id FROM wp_purpozed_volunteer_completed
                            WHERE opportunity_id = %d", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function removeFromInProgress($opportunityId, $userId)
    {

        global $wpdb;

        return $wpdb->delete('wp_purpozed_volunteer_in_progress',
            array(
                'opportunity_id' => $opportunityId,
                'user_id' => $userId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function retractOpportunity($opportunityId)
    {

        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();

        $users = $opportunity->getApplied($opportunityId);
        $type = $opportunity->getType($opportunityId);
        $organizationId = $opportunity->getOrganization($opportunityId);
        $organizationName = get_user_meta($organizationId, 'organization_name')[0];

        foreach ($users as $user) {

            $userName = get_user_meta($user->user_id, 'first_name')[0];

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/retracted.php');
            $message = ob_get_contents();
            ob_clean();

            $to = get_userdata($user->user_id)->data->user_email;
            $subject = 'Schade, eine Organisation hat eine Tätigkeit zurückgezogen, für die Du Interesse bekundet hast';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
            $this->removeFromInProgress($opportunityId, $user->user_id);
        }

        $this->setStatusChangeDate($opportunityId);

        return $wpdb->update('wp_purpozed_opportunities',
            array(
                'status' => 'retracted'
            ),
            array(
                'id' => $opportunityId,
            ),
            array(
                '%s',
            )
        );
    }

    public function deleteOpportunity($opportunityId)
    {

        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();

        $organizationId = $opportunity->getOrganization($opportunityId);
        ob_start();
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/opportunity-has-been-deleted.php');
        $message = ob_get_contents();
        ob_clean();

        $to = get_userdata($organizationId)->data->user_email;
        $subject = 'The opportunity has been deleted';
        $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

        wp_mail($to, $subject, $message, $headers);

        return $wpdb->delete('wp_purpozed_opportunities',
            array(
                'id' => $opportunityId,
            ),
            array(
                '%d',
            )
        );
    }

    public function getStatus($opportunityId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT status FROM wp_purpozed_opportunities WHERE id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function getType($opportunityId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT task_type FROM wp_purpozed_opportunities WHERE id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function postedDaysAgo($opportunityId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT posted FROM wp_purpozed_opportunities WHERE id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function appliedDaysAgo($opportunityId, $userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT posted FROM wp_purpozed_volunteer_applied WHERE opportunity_id = '%d' AND user_id = '%d'", $opportunityId, $userId);

        return $wpdb->get_var($query);
    }

    public function getRejected($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_request 
                                        WHERE opportunity_id = '%d' AND removed = '1'", $opportunityId);

        return $wpdb->get_results($query);
    }

    public function getApplied($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_applied wpva
                                        WHERE wpva.opportunity_id = '%d' AND wpva.rejected = '0' AND removed = '0'", $opportunityId);

        return $wpdb->get_results($query);
    }

    public function getApplied3Plus($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) as sum FROM wp_purpozed_volunteer_applied 
                                        WHERE opportunity_id = '%d' AND rejected = '0' AND removed = '0' AND DATE(posted) < DATE_SUB(CURDATE(), INTERVAL 3 DAY)", $opportunityId);

        return $wpdb->get_row($query);
    }

    public function getRequested($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_request wpvr
                                        WHERE wpvr.opportunity_id = '%d' 
                                        AND wpvr.removed = '0'", $opportunityId);

        return $wpdb->get_results($query);

    }

    public function getRequested3Plus($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) as sum FROM wp_purpozed_volunteer_request 
                                        WHERE opportunity_id = '%d' 
                                        AND removed = '0' AND DATE(posted) < DATE_SUB(CURDATE(), INTERVAL 3 DAY)", $opportunityId);

        return $wpdb->get_row($query);

    }

    public function getAppliedAndRequested($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_request wpvr
                                        WHERE wpvr.opportunity_id = '%d'
                                        UNION 
                                        SELECT * FROM wp_purpozed_volunteer_applied wpva
                                        WHERE wpva.opportunity_id = '%d'", $opportunityId, $opportunityId);

        return $wpdb->get_results($query);

    }

    public function getInProgress($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_in_progress 
                                WHERE opportunity_id = '%d'", $opportunityId);

        return $wpdb->get_results($query);

    }

    public function getCompletedEngagement($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT user_id FROM wp_purpozed_opportunities_engagement_evaluation 
                                WHERE opportunity_id = '%d'", $opportunityId);

        return $wpdb->get_results($query);

    }

    public function getFitted($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_in_progress 
                                WHERE opportunity_id = '%d'", $opportunityId);
        $wpdb->get_results($query);
        return array();
    }

    public function getOrganization($opportunityId)
    {

        global $wpdb;
        $query = $wpdb->prepare("SELECT organization_id FROM wp_purpozed_opportunities 
                                WHERE id = '%d'", $opportunityId);
        return $wpdb->get_var($query);
    }

    public function activateOpportunity($opportunityId)
    {

        global $wpdb;

        ob_start();
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/activate-opportunity.php');

        $message = ob_get_contents();
        ob_clean();

        $organizationId = $this->getOrganization($opportunityId);

        $to = get_userdata($organizationId)->data->user_email;
        $subject = 'Gratulation! Deine eingestellte Tätigkeit wurde gerade veröffentlicht. So geht es jetzt weiter...';
        $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

        wp_mail($to, $subject, $message, $headers);

        $this->setStatusChangeDate($opportunityId);

        return $wpdb->update('wp_purpozed_opportunities',
            array(
                'status' => 'open'
            ),
            array(
                'id' => $opportunityId,
            ),
            array(
                '%s',
            )
        );
    }

    public function startOpportunity($opportunityId)
    {

        global $wpdb;

        $this->setStatusChangeDate($opportunityId);
        $this->setInProgressDate($opportunityId);

        return $wpdb->update('wp_purpozed_opportunities',
            array(
                'status' => 'in_progress'
            ),
            array(
                'id' => $opportunityId,
            ),
            array(
                '%s',
            )
        );
    }

    public function removeFromBookmarked($opportunityId, $userId)
    {
        global $wpdb;

        return $wpdb->delete('wp_purpozed_volunteer_bookmarked',
            array(
                'opportunity_id' => $opportunityId,
                'user_id' => $userId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function removeFromApplied($opportunityId, $userId)
    {
        global $wpdb;

        return $wpdb->delete('wp_purpozed_volunteer_applied',
            array(
                'opportunity_id' => $opportunityId,
                'user_id' => $userId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function removeFromRequested($opportunityId, $userId)
    {
        global $wpdb;

        return $wpdb->delete('wp_purpozed_volunteer_request',
            array(
                'opportunity_id' => $opportunityId,
                'user_id' => $userId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    /*
     * Volunteer
     */
    public function getBestMatchedCall()
    {
        $opportunities = new \Purpozed2\Models\OpportunitiesManager();
        $openCalls = $opportunities->getOpenCalls();

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $userSkills = $volunteerManager->getCurrentUser()->getSkills();

        $userSkillsNames = array();
        foreach ($userSkills as $skill) {
            $userSkillsNames[] = $skill->name;
        }

        $tasksSkills = array();
        foreach ($openCalls as $call) {
            $tasksSkills[$call->id] = $opportunities->getCallSkillsByCall($call->id);
        }

        $matchedOpportunities = array();
        foreach ($tasksSkills as $key => $tasksSkill) {
            $matchedSkills = 0;
            $taskSkillsValue = 0;
            foreach ($tasksSkill as $skill) {
                if (in_array($skill->name, $userSkillsNames)) {
                    $matchedSkills += 1;
                }
                $taskSkillsValue++;
            }
            if ($matchedSkills > 0) {
                $matchedOpportunities[$key] = (int)(($matchedSkills / $taskSkillsValue) * 100);
            }
        }

        $bestMatchedCall = array();

        if (!empty($matchedOpportunities)) {
            arsort($matchedOpportunities);
            $bestMatchedCallId = array_key_first($matchedOpportunities);

            foreach ($openCalls as $key => $openCall) {
                if ((int)$openCall->id === $bestMatchedCallId) {
                    $bestMatchedCall = $openCall;
                }
            }
        }

        if (empty($bestMatchedCall)) {
            return array();
        }

        return $bestMatchedCall;
    }

    /*
     * Volunteer
     */
    public function getBestMatchedProject()
    {
        $opportunities = new \Purpozed2\Models\OpportunitiesManager();
        $openProjects = $opportunities->getOpenProjects();

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $userSkills = $volunteerManager->getCurrentUser()->getSkills();

        $userSkillsNames = array();
        foreach ($userSkills as $skill) {
            $userSkillsNames[] = $skill->name;
        }

        $tasksSkills = array();
        foreach ($openProjects as $project) {
            $tasksSkills[$project->id] = $opportunities->getProjectSkillsByTask($project->id);
        }

        $matchedOpportunities = array();
        foreach ($tasksSkills as $key => $tasksSkill) {
            $matchedSkills = 0;
            $taskSkillsValue = 0;
            foreach ($tasksSkill as $skill) {
                if (in_array($skill->name, $userSkillsNames)) {
                    $matchedSkills++;
                }
                $taskSkillsValue++;
            }
            if ($matchedSkills > 0) {
                $matchedOpportunities[$key] = (int)(($matchedSkills / $taskSkillsValue) * 100);
            }
        }

        $bestMatchedProject = array();

        if (!empty($matchedOpportunities)) {
            arsort($matchedOpportunities);
            $bestMatchedProjectId = array_key_first($matchedOpportunities);

            foreach ($openProjects as $key => $openProject) {
                if ((int)$openProject->id === $bestMatchedProjectId) {
                    $bestMatchedProject = $openProject;
                }
            }
        }

        if (empty($bestMatchedProject)) {
            return array();
        }

        return $bestMatchedProject;
    }

    /*
     * Volunteer
     */
    public function getBestMatchedMentoring()
    {
        $opportunities = new \Purpozed2\Models\OpportunitiesManager();
        $openMentorings = $opportunities->getList(null, array('open'), array('mentoring'));
        $taskManager = new \Purpozed2\Models\TaskManager();

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $userSkills = $volunteerManager->getCurrentUser()->getSkills();

        $parsedTaskIDs = array();
        foreach ($openMentorings as $openMentoring) {
            $areasOfExpertises = $this->getAreaOfExpertise($openMentoring->id);
            foreach ($areasOfExpertises as $areasOfExpertise) {
                $tasksIDs = $taskManager->getTaskSkillsByAreaOfExpertise($areasOfExpertise->id);
                foreach ($tasksIDs as $tasksID) {
                    $parsedTaskIDs[$openMentoring->id][] = $tasksID->id;
                }
            }
        }

        $parsedUserSkills = array();
        foreach ($userSkills as $userSkill) {
            $parsedUserSkills[] = $userSkill->name;
        }

        $matchedOpportunities = array();
        $matchedTaskSkills = array();
        foreach ($parsedTaskIDs as $key => $parsedTaskID) {
            $matchedSkills = 0;
            $taskSkillsValue = 0;
            foreach ($parsedTaskID as $item) {
                foreach ($parsedUserSkills as $parsedUserSkill) {
                    $taskSkillsData = $taskManager->getSkills($item);
                    foreach ($taskSkillsData as $taskSkillsDatum) {
                        if ($parsedUserSkill == $taskSkillsDatum->name) {
                            $matchedSkills++;
                            $matchedTaskSkills[$key][] = $taskSkillsDatum->name;
                        }
                        $taskSkillsValue++;
                    }
                }
                if ($matchedSkills > 0) {
                    $matchedOpportunities[$key] = (int)(($matchedSkills / $taskSkillsValue) * 100);
                }
            }
        }

        $bestMatchedMentoring = array();

        if (!empty($matchedOpportunities)) {
            arsort($matchedOpportunities);
            $bestMatchedProjectId = array_key_first($matchedOpportunities);

            foreach ($openMentorings as $key => $openMentoring) {
                if ((int)$openMentoring->id === $bestMatchedProjectId) {
                    $bestMatchedMentoring = $openMentoring;
                }
            }

            foreach ($matchedTaskSkills as $key => $matchedTaskSkill) {
                $matchedTaskSkill = array_unique($matchedTaskSkill);
                if ($key == $bestMatchedMentoring->id) {
                    $bestMatchedMentoring->matched_skills = $matchedTaskSkill;
                }
            }
        }

        if (empty($bestMatchedMentoring)) {
            return array();
        }

        return $bestMatchedMentoring;
    }

    /*
     * Volunteer
     */
    public function getBestMatchedEngagement()
    {

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $userGoals = $volunteerManager->getCurrentUser()->getGoals();
        $organization = new \Purpozed2\Models\Organization();

        $userGoalsNames = array();
        foreach ($userGoals as $userGoal) {
            $userGoalsNames[] = $userGoal->name;
        }

        $users = get_users(array('fields' => array('ID')));

        $organizationGoals = array();
        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('organization', $userData->roles)) {
                $organizationGoals[$user->ID] = array(
                    'goals' => $organization->getGoals($user->ID)
                );
            }
        }

        $totalOrganizationGoals = count($organizationGoals);

        $matchedOrganizations = array();
        foreach ($organizationGoals as $key => $organizationGoal) {
            $matchedScore = 0;
            foreach ($organizationGoal as $item) {
                foreach ($item as $it) {
                    foreach ($userGoalsNames as $userGoalsName) {
                        if ($userGoalsName === $it->name) {
                            $matchedScore += 1;
                        }
                    }
                }
                if ($matchedScore > 0) {
                    $matchedOrganizations[$key] = (int)(($matchedScore / $totalOrganizationGoals) * 100);
                }
            }
        }

        if (!empty($matchedOrganizations)) {
            arsort($matchedOrganizations);
            $bestMatchedOrganizationId = array_key_first($matchedOrganizations);

            $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
            $bestMatchedEngagements = $opportunitiesManager->getEngagements(array($bestMatchedOrganizationId), array('open'));

        }

        if (!empty($bestMatchedEngagements)) {
            foreach ($bestMatchedEngagements as $bestMatchedEngagement) {
                $bestMatchedEngagements = $bestMatchedEngagement;
                break;
            }
        }

        if (empty($bestMatchedEngagement)) {
            return array();
        }

        $bestMatchedEngagements->best_matched_organization_id = $bestMatchedOrganizationId;
        $bestMatchedEngagements->user_goals_names = $userGoalsNames;

        return $bestMatchedEngagements;
    }

    /*
     * Organization Dashboard - Fitting volunteers you can request
     */
    public function bestMatchedCallVolunteers($opportunities): array
    {
        $opoprtunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
        $volunteerManager = new \Purpozed2\Models\VolunteersManager();

        $matchedUsers = array();
        foreach ($opportunities as $opportunity) {
            $taskSkills = $opoprtunitiesManager->getCallSkillsByCall($opportunity->id);

            $users = get_users(array('fields' => array('ID')));

            foreach ($users as $user) {
                $userData = get_user_by('ID', $user->ID);
                if (in_array('volunteer', $userData->roles)) {

                    $userSkills = $volunteerManager->getCurrentUser($user->ID)->getSkills();

                    $userSkillsNames = array();
                    foreach ($userSkills as $skill) {
                        $userSkillsNames[] = $skill->name;
                    }

                    foreach ($taskSkills as $taskSkill) {
                        foreach ($userSkillsNames as $userSkillsName) {
                            if ($taskSkill->name === $userSkillsName) {
                                $matchedUsers[$opportunity->id][$user->ID][] = $userSkillsName;
                            }
                        }
                    }
                }
            }
        }

        return $matchedUsers;
    }

    /*
     * Organization Single Opportunity
     */
    public function bestMatchedSingleCallVolunteers($opportunity): array
    {
        $opoprtunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $singleOpportunity = new \Purpozed2\Models\Opportunity();

        $matchedUsers = array();
        $taskSkills = $opoprtunitiesManager->getCallSkillsByCall($opportunity->o_id);

        $users = get_users(array('fields' => array('ID')));

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {

                $readyForRequestData = get_user_meta($user->ID, 'ready_for_request');
                $readyForRequest = (!empty($readyForRequestData[0])) ? $readyForRequestData[0] : false;
                $isRejected = $singleOpportunity->isRejected($opportunity->o_id, $user->ID);
                $isRemoved = $singleOpportunity->isRemoved($opportunity->o_id, $user->ID);

                if ($readyForRequest === 'on' && !$isRejected && !$isRemoved) {
                    $userSkills = $volunteerManager->getCurrentUser($user->ID)->getSkills();

                    $userSkillsNames = array();
                    foreach ($userSkills as $skill) {
                        $userSkillsNames[] = $skill->name;
                    }

                    foreach ($taskSkills as $taskSkill) {
                        foreach ($userSkillsNames as $userSkillsName) {
                            if ($taskSkill->name === $userSkillsName) {
                                $matchedUsers[$user->ID][] = $userSkillsName;
                            }
                        }
                    }
                }
            }
        }

        return $matchedUsers;
    }

    /*
     * Organization Dashboard - Fitting volunteers you can request
     */
    public function bestMatchedProjectVolunteers($opportunities): array
    {
        $opoprtunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $singleOpportunity = new \Purpozed2\Models\Opportunity();

        $matchedUsers = array();
        foreach ($opportunities as $opportunity) {
            $taskSkills = $opoprtunitiesManager->getProjectSkillsByTask($opportunity->id);

            $users = get_users(array('fields' => array('ID')));

            foreach ($users as $user) {
                $userData = get_user_by('ID', $user->ID);
                if (in_array('volunteer', $userData->roles)) {

                    $readyForRequestData = get_user_meta($user->ID, 'ready_for_request');
                    $readyForRequest = (!empty($readyForRequestData[0])) ? $readyForRequestData[0] : false;
                    $isRejected = $singleOpportunity->isRejected($opportunity->id, $user->ID);

                    if ($readyForRequest === 'on' && !$isRejected) {

                        $userSkills = $volunteerManager->getCurrentUser($user->ID)->getSkills();

                        $userSkillsNames = array();
                        foreach ($userSkills as $skill) {
                            $userSkillsNames[] = $skill->name;
                        }

                        foreach ($taskSkills as $taskSkill) {
                            foreach ($userSkillsNames as $userSkillsName) {
                                if ($taskSkill->name === $userSkillsName) {
                                    $matchedUsers[$opportunity->id][$user->ID][] = $userSkillsName;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $matchedUsers;
    }

    /*
     * Organization Single Opportunity
     */
    public function bestMatchedSingleProjectVolunteers($opportunity): array
    {
        $opoprtunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $singleOpportunity = new \Purpozed2\Models\Opportunity();

        $matchedUsers = array();
        $taskSkills = $opoprtunitiesManager->getProjectSkillsByTask($opportunity->o_id);

        $users = get_users(array('fields' => array('ID')));

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {

                $readyForRequestData = get_user_meta($user->ID, 'ready_for_request');
                $readyForRequest = (!empty($readyForRequestData[0])) ? $readyForRequestData[0] : false;
                $isRejected = $singleOpportunity->isRejected($opportunity->o_id, $user->ID);

                if ($readyForRequest === 'on' && !$isRejected) {

                    $userSkills = $volunteerManager->getCurrentUser($user->ID)->getSkills();

                    $userSkillsNames = array();
                    foreach ($userSkills as $skill) {
                        $userSkillsNames[] = $skill->name;
                    }

                    foreach ($taskSkills as $taskSkill) {
                        foreach ($userSkillsNames as $userSkillsName) {
                            if ($taskSkill->name === $userSkillsName) {
                                $matchedUsers[$user->ID][] = $userSkillsName;
                            }
                        }
                    }
                }
            }
        }

        return $matchedUsers;
    }

    /*
     * Organization Dashboard - Fitting volunteers you can request
     */

    public function bestMatchedMentoringVolunteers($opportunities)
    {
        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $taskManager = new \Purpozed2\Models\TaskManager();
        $users = get_users(array('fields' => array('ID')));
        $singleOpportunity = new \Purpozed2\Models\Opportunity();

        $matchedUsers = array();
        foreach ($opportunities as $opportunity) {
            $areasOfExpertises = $this->getAreaOfExpertise($opportunity->id);
            foreach ($areasOfExpertises as $areasOfExpertise) {
                $tasksIDs = $taskManager->getTaskSkillsByAreaOfExpertise($areasOfExpertise->id);
                foreach ($tasksIDs as $tasksID) {
                    $taskSkillsData = $taskManager->getSkills($tasksID->id);
                    foreach ($taskSkillsData as $taskSkillsDatum) {

                        foreach ($users as $user) {
                            $userData = get_user_by('ID', $user->ID);
                            if (in_array('volunteer', $userData->roles)) {

                                $isRejected = $singleOpportunity->isRejected($opportunity->id, $user->ID);
                                if (!$isRejected) {

                                    $userSkills = $volunteerManager->getCurrentUser($user->ID)->getSkills();

                                    $userSkillsNames = array();
                                    foreach ($userSkills as $skill) {
                                        $userSkillsNames[] = $skill->name;
                                    }

                                    foreach ($userSkillsNames as $userSkillsName) {
                                        if ($taskSkillsDatum->name === $userSkillsName) {
                                            $matchedUsers[$opportunity->id][$user->ID][] = $userSkillsName;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $matchedUsers;
    }

    /*
     * Organization Dashboard - cont fitting
     */

    public function bestMatchedMentoringVolunteer($opportunities)
    {
        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $taskManager = new \Purpozed2\Models\TaskManager();
        $users = get_users(array('fields' => array('ID')));

        $matchedUsers = array();
        foreach ($opportunities as $opportunity) {
            $areasOfExpertises = $this->getAreaOfExpertise($opportunity->id);
            foreach ($areasOfExpertises as $areasOfExpertise) {
                $tasksIDs = $taskManager->getTaskSkillsByAreaOfExpertise($areasOfExpertise->id);
                foreach ($tasksIDs as $tasksID) {
                    $taskSkillsData[] = $taskManager->getSkills($tasksID->id);
                    foreach ($taskSkillsData as $taskSkillsDatum) {
                        foreach ($taskSkillsDatum as $item) {

                            foreach ($users as $user) {
                                $userData = get_user_by('ID', $user->ID);
                                if (in_array('volunteer', $userData->roles)) {

                                    $userSkills = $volunteerManager->getCurrentUser($user->ID)->getSkills();

                                    $userSkillsNames = array();
                                    foreach ($userSkills as $skill) {
                                        $userSkillsNames[] = $skill->name;
                                    }

                                    foreach ($userSkillsNames as $userSkillsName) {
                                        if ($item->name === $userSkillsName) {
                                            $matchedUsers[$opportunity->o_id][$user->ID][] = $userSkillsName;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $matchedUsers;
    }

    /*
     * Organization Dashboard - fitting
     */

    public function bestMatchedSingleMentoringVolunteer($opportunity)
    {
        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $taskManager = new \Purpozed2\Models\TaskManager();
        $users = get_users(array('fields' => array('ID')));

        $matchedUsers = array();
        $areasOfExpertises = $this->getAreaOfExpertise($opportunity->task_id);
        foreach ($areasOfExpertises as $areasOfExpertise) {
            $tasksIDs = $taskManager->getTaskSkillsByAreaOfExpertise($areasOfExpertise->id);
            foreach ($tasksIDs as $tasksID) {
                $taskSkillsData[] = $taskManager->getSkills($tasksID->id);
                foreach ($taskSkillsData as $taskSkillsDatum) {
                    foreach ($taskSkillsDatum as $item) {

                        foreach ($users as $user) {
                            $userData = get_user_by('ID', $user->ID);
                            if (in_array('volunteer', $userData->roles)) {

                                $readyForRequestData = get_user_meta($user->ID, 'ready_for_request');
                                $readyForRequest = (!empty($readyForRequestData[0])) ? $readyForRequestData[0] : false;

                                if ($readyForRequest === 'on') {

                                    $userSkills = $volunteerManager->getCurrentUser($user->ID)->getSkills();

                                    $userSkillsNames = array();
                                    foreach ($userSkills as $skill) {
                                        $userSkillsNames[] = $skill->name;
                                    }
                                    foreach ($userSkillsNames as $userSkillsName) {
                                        if ($item->name === $userSkillsName) {
                                            $matchedUsers[$user->ID][] = $userSkillsName;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $matchedUsers;
    }

    /*
     * Organization Dashboard - Fitting volunteers you can request
     */
    public
    function bestMatchedEngagementVolunteers()
    {
        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $organization = new \Purpozed2\Models\Organization();

        $organizationGoals = $organization->getGoals(get_current_user_id());
        $organizationMainGoalId = get_user_meta(get_current_user_id(), 'main_goal');
        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

        $organizationGoalsNames = array();
        foreach ($organizationGoals as $organizationGoal) {
            $organizationGoalsNames[] = $organizationGoal->name;
        }

        $organizationGoalsNames[] = $organizationMainGoal;

        $users = get_users(array('fields' => array('ID')));

        $volunteerGoals = array();
        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {

                $readyForRequestData = get_user_meta($user->ID, 'ready_for_request');
                $readyForRequest = (!empty($readyForRequestData[0])) ? $readyForRequestData[0] : false;

                if ($readyForRequest === 'on') {
                    $volunteerGoals[$user->ID] = array(
                        'goals' => $volunteerManager->getCurrentUser($user->ID)->getGoals()
                    );
                }
            }
        }

        $matchedVolunteers = array();
        foreach ($organizationGoals as $organizationGoal) {
            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                foreach ($volunteerGoal as $goal) {
                    foreach ($goal as $item) {
                        if ($organizationGoal->name === $item->name) {
                            $matchedVolunteers[$userId][] = $item->name;
                        }
                    }
                }
            }
        }

        return $matchedVolunteers;
    }

    public function requestVolunteer($opportunityId, $userId)
    {
        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();
        $users = $opportunity->getApplied($opportunityId);
        $type = $opportunity->getType($opportunityId);
        $organizationId = $opportunity->getOrganization($opportunityId);
        $organizationName = get_user_meta($organizationId, 'organization_name')[0];

        ob_start();
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/request-to-opportunity.php');
        $message = ob_get_contents();
        ob_clean();

        $to = get_userdata($userId)->data->user_email;
        $subject = 'Gratuliere! Du wurdest gerade für eine Tätigkeit angefragt. Bitte antworte jetzt...';
        $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

        wp_mail($to, $subject, $message, $headers);

        return $wpdb->insert('wp_purpozed_volunteer_request',
            array(
                'opportunity_id' => $opportunityId,
                'user_id' => $userId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function retractVolunteer($opportunityId, $userId)
    {
        global $wpdb;

        return $wpdb->delete('wp_purpozed_volunteer_request',
            array(
                'opportunity_id' => $opportunityId,
                'user_id' => $userId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function rejectVolunteer($opportunityId, $userId)
    {
        global $wpdb;

        $opportunityType = $this->getType($opportunityId);

        if ($opportunityType !== 'engagement') {
            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/rejected_application.php');
            $message = ob_get_contents();
            ob_clean();

            $to = get_userdata($userId)->data->user_email;
            $subject = 'Purpozed notification';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        } else {
            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/rejected_application_engagement.php');
            $message = ob_get_contents();
            ob_clean();

            $to = get_userdata($userId)->data->user_email;
            $subject = 'Purpozed notification';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }

        return $wpdb->update('wp_purpozed_volunteer_applied',
            array(
                'rejected' => 1
            ),
            array(
                'opportunity_id' => $opportunityId,
                'user_id' => $userId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function isRejected($opportunityId, $userId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT rejected FROM wp_purpozed_volunteer_applied WHERE opportunity_id = '%d' AND user_id = '%d'", $opportunityId, $userId);

        return $wpdb->get_var($query);
    }

    public function isRemoved($opportunityId, $userId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT removed FROM wp_purpozed_volunteer_request WHERE opportunity_id = '%d' AND user_id = '%d'", $opportunityId, $userId);

        return $wpdb->get_var($query);
    }

    public function lost($opportunity, $userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT count(wpo.status) FROM wp_purpozed_volunteer_applied wpva
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpva.opportunity_id
                                        LEFT JOIN wp_purpozed_volunteer_request wpvr
                                        ON wpo.id = wpvr.opportunity_id                                        
                                        WHERE (wpva.user_id = '%d' AND wpva.opportunity_id = '%d') OR (wpvr.user_id = '%d' AND wpvr.opportunity_id = '%d')", $userId, $opportunity, $userId, $opportunity);

        return $wpdb->get_var($query);
    }

    public function assignedToOther($opportunity, $userId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_in_progress wpvip
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpvip.opportunity_id
                                        LEFT JOIN wp_purpozed_volunteer_completed wpvc
                                        ON wpo.id = wpvc.opportunity_id
                                        WHERE wpo.id = '%d' AND (wpvip.user_id = '%d' OR wpvc.user_id = '%d')", $opportunity, $userId, $userId);

        return $wpdb->get_results($query);
    }

    public function isMine($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT user_id FROM wp_purpozed_volunteer_in_progress
                                WHERE opportunity_id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function interested($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT user_id FROM wp_purpozed_volunteer_applied
                                WHERE opportunity_id = '%d'", $opportunityId);

        return $wpdb->get_results($query);

    }

    public function getCallFocusesText()
    {
        return get_option('call_focuses');
    }

    public function canceledBy($opportunityId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT canceled_by FROM wp_purpozed_opportunities
                                        WHERE id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function getVolunteersWhoComplete($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_completed 
                                WHERE opportunity_id = '%d'", $opportunityId);

        return $wpdb->get_results($query);
    }

    public function getVolunteersWhoCompleteEngagement($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities_engagement_evaluation 
                                WHERE opportunity_id = '%d'", $opportunityId);

        return $wpdb->get_results($query);
    }

    public function getVolunteersWaitingForFeedbackEngagement($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities_engagement_evaluation 
                                WHERE opportunity_id = '%d'  AND evaluation_volunteer is not null AND evaluation_organization is null", $opportunityId);

        return $wpdb->get_results($query);
    }

    public function getVolunteersWhoCompleteSucceeded($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_completed wpvc 
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpvc.opportunity_id
                                        WHERE wpvc.opportunity_id = '%d' AND wpo.status= 'succeeded'", $opportunityId);

        return $wpdb->get_results($query);
    }

    public function getVolunteersWaitingForFeedback($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_completed wpvc 
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpvc.opportunity_id
                                        WHERE wpvc.opportunity_id = '%d' AND wpo.evaluation_volunteer is not null AND wpo.evaluation_organization is null", $opportunityId);

        return $wpdb->get_results($query);
    }

    public function getVolunteersWhoCommented($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_completed wpvc 
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpvc.opportunity_id
                                        WHERE wpvc.opportunity_id = '%d' AND wpo.evaluation_volunteer is not null", $opportunityId);

        return $wpdb->get_results($query);
    }

    public function getCallIdByOpportunityId($opportunityId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT id FROM wp_purpozed_opportunities_call
                                        WHERE task_id = '%d'", $opportunityId);

        return $wpdb->get_var($query);
    }

    public function setStatusChangeDate($opportunityId)
    {
        global $wpdb;

        return $wpdb->update('wp_purpozed_opportunities',
            array(
                'status_change_date' => time()
            ),
            array(
                'id' => $opportunityId
            )
        );
    }

    public function setInProgressDate($opportunityId)
    {
        global $wpdb;

        return $wpdb->update('wp_purpozed_opportunities',
            array(
                'in_progress_since' => time()
            ),
            array(
                'id' => $opportunityId
            )
        );
    }

    public function engagementInProgress($opportunityId, $userId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_volunteer_in_progress 
                                        WHERE opportunity_id = '%d' AND user_id = '%d'", $opportunityId, $userId);

        return $wpdb->get_var($query);
    }

    public function engagementCloseOpen($opportunityId, $status)
    {
        global $wpdb;

        $setStatus = 0;
        if ($status === 'open') {
            $setStatus = 1;
        }

        return $wpdb->update('wp_purpozed_opportunities_engagement',
            array(
                'closed' => $setStatus
            ),
            array(
                'task_id' => $opportunityId
            ));
    }

    public function isEngagementClosed($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT closed FROM wp_purpozed_opportunities_engagement 
                                        WHERE opportunity_id = '%d', $opportunityId");

        return $wpdb->get_var($query);
    }


    public function engagementsLongerEngaged($opportunityId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT MAX(TIMESTAMPDIFF(DAY, start_date, NOW())) as status_since FROM wp_purpozed_volunteer_in_progress WHERE opportunity_id = %d", $opportunityId);

        return $wpdb->get_row($query);

    }
}