<?php

namespace Purpozed2\Controllers;

class PostOpportunity extends \Purpozed2\Controller
{
    protected $description = 'Post Opportunity';
    protected $menuActiveButton = 'post-opportunity';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->taskType = $this->loadTaskTemplate();

        $this->view->organizationMenu = (get_option('purpozed_organization_menu')[0]) ? get_option('purpozed_organization_menu')[0] : NULL;

        if (isset($_POST['post']) || isset($_POST['save'])) {
            $this->view->taskSave = $this->postOpportunity();
            $this->view->status = 'review';
            if (isset($_POST['save'])) {
                $this->view->status = 'prepared';
            }
        }

        $expertiseManager = new \Purpozed2\Models\ExpertiseManager();
        $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
        $opportunity = new \Purpozed2\Models\Opportunity();
        $singleOpportunity = new \Purpozed2\Models\Opportunity();
        $organization = new \Purpozed2\Models\Organization();
        $focusManager = new \Purpozed2\Models\FocusManager();

        $this->view->organizationDetails = $organization->getDetailsById(get_current_user_id());
        $organizationDetails = $organization->getDetailsById(get_current_user_id());
        $mainGoal = $organizationDetails['main_goal'][0];
        $this->view->mainGoalName = $organization->getMainGoal($mainGoal);
        $this->view->openOpportunities = $organization->openOpportunitiesById(get_current_user_id());
        $this->view->succeededOpportunities = $organization->succeededOpportunitiesById(get_current_user_id());

        $this->view->editedOpportunityId = 0;
        if (isset($_GET['id'])) {
            $opportunityId = $_GET['id'];

            $this->view->opportunity = $opportunityManager->getSingleCall($opportunityId);
            $this->view->editedOpportunityId = $opportunityId;
            $this->view->status = $opportunity->getStatus($opportunityId);

            if (isset($_GET['task'])) {
                if ($_GET['task'] === 'call') {
                    $this->view->opportunity = $opportunityManager->getSingleCall($opportunityId);
                    $this->view->skills = $opportunityManager->getCallSkills($this->view->opportunity->id);
                    $this->view->topic = $opportunityManager->getTopic($this->view->opportunity->topic);
                    $this->view->focus = $opportunityManager->getFocuses($this->view->opportunity->id);
                    $this->view->description = $expertiseManager->getCurrentTopicDescription($this->view->topic->id);
                    $this->view->areas_of_expertise = $expertiseManager->getAreaOfExpertises();
                    $this->view->focuses = $focusManager->getList();

                    $this->view->aoe = $currentAoe = $singleOpportunity->getCallAreaOfExpertise($opportunityId);
                    $this->view->edit_topics = $expertiseManager->getCallTopicList($currentAoe->id);
                    $this->view->focuses = $focusManager->getList();

                } elseif ($_GET['task'] === 'project') {
                    $this->view->opportunity = $opportunityManager->getSingleProject($opportunityId);
                    $this->view->topic = $opportunityManager->getTopic($this->view->opportunity->topic);
                    $this->view->areas_of_expertise = $expertiseManager->getAreaOfExpertises();

                    $this->view->aoe = $currentAoe = $singleOpportunity->getProjectAreaOfExpertise($opportunityId);
                    $this->view->edit_tasks = $expertiseManager->getProjectTasksList($currentAoe->id);

                    if (!is_null($this->view->opportunity->topic)) {
                        $task = new \Purpozed2\Models\TaskManager();
                        $this->view->taskData = $task->getChosenProjectTask($this->view->opportunity->topic);
                    }
                    $this->view->description = $expertiseManager->getCurrentTopicDescription($this->view->topic->id);
                } elseif ($_GET['task'] === 'mentoring') {
                    $this->view->opportunity = $opportunityManager->getSingleMentoring($opportunityId);
                    $this->view->duration_overall = $this->view->opportunity->frequency * $this->view->opportunity->duration * $this->view->opportunity->time_frame;

                    $frequencies = array(
                        '1.00' => __('Every week', 'purpozed'),
                        '0.50' => __('Every two weeks', 'purpozed'),
                        '0.25' => __('Every month', 'purpozed'),
                    );

                    $this->view->frequency = $frequencies[$this->view->opportunity->frequency];

                    $timeFrames = array(
                        '12' => __('12 weeks', 'purpozed'),
                        '24' => __('24 weeks', 'purpozed'),
                        '48' => __('48 weeks', 'purpozed'),
                    );

                    $this->view->time_frame = $timeFrames[$this->view->opportunity->time_frame];
                } elseif ($_GET['task'] === 'engagement') {
                    $this->view->opportunity = $opportunityManager->getSingleEngagement($opportunityId);

                    $this->view->duration_overall = $this->view->opportunity->frequency * $this->view->opportunity->duration * $this->view->opportunity->time_frame + $this->view->opportunity->training_duration;

                    $frequencies = array(
                        '1.00' => __('Every week', 'purpozed'),
                        '0.50' => __('Every two weeks', 'purpozed'),
                        '0.25' => __('Every month', 'purpozed'),
                    );

                    $this->view->frequency = $frequencies[$this->view->opportunity->frequency];

                    $timeFrames = array(
                        '1' => __('1 week', 'purpozed'),
                        '12' => __('12 weeks', 'purpozed'),
                        '24' => __('24 weeks', 'purpozed'),
                        '48' => __('48 weeks', 'purpozed'),
                    );

                    $this->view->time_frame = $timeFrames[$this->view->opportunity->time_frame];

                    $durationOfTraining = array(
                        '0' => __('Not needed', 'purpozed'),
                        '1' => __('1 hour', 'purpozed'),
                        '2' => __('2 hours', 'purpozed'),
                        '3' => __('3 hours', 'purpozed'),
                        '4' => __('4 hours', 'purpozed'),
                        '5' => __('5 hours', 'purpozed'),
                        '6' => __('6 hours', 'purpozed'),
                        '7' => __('7 hours', 'purpozed'),
                        '8' => __('8 hours', 'purpozed'),
                    );

                    $this->view->training_duration = $durationOfTraining[$this->view->opportunity->training_duration];
                }
            }
        } else {
            $this->view->status = '';
        }

        if (isset($_GET['task']) && !isset($_GET['id'])) {
            if ($_GET['task'] === 'call' || $_GET['task'] === 'project' || $_GET['task'] === 'mentoring') {

                $this->view->areas_of_expertise = $expertiseManager->getAreaOfExpertises();
                $firstCall = $expertiseManager->getFirstCall();

                $this->view->edit_topics = $expertiseManager->getCallTopicList($firstCall[0]->aoe_id);
                $this->view->edit_tasks = $expertiseManager->getProjectTasksList($firstCall[0]->aoe_id);

                $this->view->adminData = get_user_meta(61);
                $this->view->adminExtraData = get_userdata(61);
            }
            if ($_GET['task'] === 'call') {
                $this->view->focuses = $focusManager->getList();
//                $organization = new \Purpozed2\Models\Organization();
//                $this->view->organizationDetails = $organization->getDetailsById(get_current_user_id());
//                $organizationDetails = $organization->getDetailsById(get_current_user_id());
//                $mainGoal = $organizationDetails['main_goal'][0];
//                $this->view->mainGoalName = $organization->getMainGoal($mainGoal);
//                $this->view->openOpportunities = $organization->openOpportunitiesById(get_current_user_id());
//                $this->view->succeededOpportunities = $organization->succeededOpportunitiesById(get_current_user_id());
            }
            if ($_GET['task'] === 'mentoring') {
                $this->view->focuses = $focusManager->getList();
            }
        }

//        global $wpdb;
//        $stringInserter = new \WPML_ST_Bulk_Strings_Insert($wpdb);
//        $string = new \WPML_ST_Models_String_Translation(
//            '713',
//            'en',
//            '10',
//            '',
//            'goal po angielsku',
//        );
//        $stringInserter->insert_string_translations([$string]);

    }

    public function loadTopics()
    {

        $aoe_id = $_POST['aoe_id'];

        $expertiseManager = new \Purpozed2\Models\ExpertiseManager();
        $topics = $expertiseManager->getCallTopicList($aoe_id);

        echo json_encode(array('topics' => $topics));
        die();
    }

    public function loadTopicDescription()
    {

        $topic_id = $_POST['topic_id'];
        $expertiseManager = new \Purpozed2\Models\ExpertiseManager();
        $description = $expertiseManager->getCurrentTopicDescription($topic_id);

        echo json_encode($description);
        die();
    }

    public function loadProjectTasks()
    {

        $aoe_id = $_POST['aoe_id'];

        $expertiseManager = new \Purpozed2\Models\ExpertiseManager();
        $topics = $expertiseManager->getProjectTasksList($aoe_id);

        echo json_encode(array('topics' => $topics));
        die();
    }

    public function getTopicDetails()
    {

        $topic_id = $_POST['topic_id'];

        $topicManager = new \Purpozed2\Models\TaskManager();
        $topicData = $topicManager->getChosenProjectTask($topic_id);

        echo json_encode(array('topicData' => $topicData));
        die();
    }

    public function getTopicDetailsPHP($topic_id)
    {
        $topicManager = new \Purpozed2\Models\TaskManager();
        return $topicManager->getChosenProjectTask($topic_id);
    }

    public function getDashboardType()
    {

        if (is_user_logged_in()) {
            $user = new \WP_User(get_current_user_id());
            if (in_array('organization', $user->roles)) {
                return 'organization';
            }
        } else {
            header('Location: /?route=' . $_SERVER['REQUEST_URI']);
        }
        return;
    }

    public function loadTaskTemplate()
    {

        $taskType = (!isset($_GET['task'])) ? false : $_GET['task'];

        $taskTypes = array('call', 'project', 'mentoring', 'engagement');

        return $currentTask = (in_array($taskType, $taskTypes)) ? $taskType : false;

    }

    public function postOpportunity()
    {

        $taskType = $_POST['task_type'];

        // TODO WALIDACJA

        $status = (isset($_POST['post'])) ? 'review' : 'prepared';

        global $wpdb;

        $editedOpportunityId = (isset($_POST['opportunity_id']) && ($_POST['opportunity_id'] !== 0)) ? $_POST['opportunity_id'] : '0';

        $opportunity = new \Purpozed2\Models\Opportunity();

        if ($editedOpportunityId !== '0') {

            $currentStatus = $wpdb->get_var("SELECT status FROM wp_purpozed_opportunities where id = $editedOpportunityId");

            if ($currentStatus !== $status) {

                $opportunity->setStatusChangeDate($editedOpportunityId);

                $wpdb->update(
                    'wp_purpozed_opportunities',
                    array(
                        'status' => $status,
                    ),
                    array(
                        'id' => $editedOpportunityId
                    )
                );
                $message = (isset($_POST['post'])) ? 'review' : 'prepared';
                header('Location: /post-opportunity/?status=' . $message);
            }
            $isTaskSaved = true;
            $existed = true;

        } else {
            $isTaskSaved = (bool)$wpdb->insert(
                'wp_purpozed_opportunities',
                array(
                    'task_type' => $taskType,
                    'status' => $status,
                    'organization_id' => get_current_user_id()
                ),
                array(
                    '%s',
                    '%s'
                )
            );
        }

        if ($isTaskSaved) {

            if (isset($existed)) {
                $taskId = $editedOpportunityId;
            } else {
                $taskId = $wpdb->insert_id;
            }

            if ($taskType === 'call') {
                return $this->postCall($taskId, $editedOpportunityId, $status);
            } elseif ($taskType === 'project') {
                return $this->postProject($taskId, $editedOpportunityId, $status);
            } elseif ($taskType === 'mentoring') {
                return $this->postMentoring($taskId, $editedOpportunityId, $status);
            } elseif ($taskType === 'engagement') {
                return $this->postEngagement($taskId, $editedOpportunityId, $status);
            }

            $opportunity->setStatusChangeDate($editedOpportunityId);

        } else {
            return false;
        }


    }

    public function postCall($taskId, $editedOpportunityId, $saveStatus)
    {

        $validPostKeys = array('topic', 'topic_typed', 'goal', 'expire', 'contact_name', 'contact_surname', 'contact_email', 'contact_phone', 'task_type');
        $_POST['expire'] = strtotime($_POST['expire']);
        $taskData = array();
        foreach ($validPostKeys as $validKey) {
            $taskData[$validKey] = (isset($_POST[$validKey])) ? $_POST[$validKey] : '';
        }

        if (!isset($_POST['topic'])) {
            unset($taskData['topic']);
        }

        if (isset($_POST['topic'])) {
            $skillsData = $_POST['skills'];
        }
        $focusesData = $_POST['focus'];

        $taskData['task_id'] = $taskId;
        unset($taskData['task_type']);

        global $wpdb;

        if ($editedOpportunityId !== '0') {

            unset($taskData['task_id']);

            $wpdb->update(
                'wp_purpozed_opportunities_call',
                $taskData,
                array(
                    'task_id' => $editedOpportunityId
                )
            );

            $isTaskSaved = true;

            $singleOpportunity = new \Purpozed2\Models\Opportunity();
            $callId = $singleOpportunity->getCallIdByOpportunityId($editedOpportunityId);

            if (isset($_POST['topic'])) {
                $wpdb->delete(
                    'wp_purpozed_opportunities_call_skills',
                    array(
                        'call_id' => $callId
                    )
                );

                foreach ($skillsData as $key => $skillId) {
                    $wpdb->insert(
                        'wp_purpozed_opportunities_call_skills',
                        array(
                            'call_id' => $callId,
                            'skill_id' => $skillId
                        )
                    );
                }
            }

            $wpdb->delete(
                'wp_purpozed_opportunities_call_focuses',
                array(
                    'call_id' => $callId,
                )
            );

            foreach ($focusesData as $key => $focusId) {
                $wpdb->insert(
                    'wp_purpozed_opportunities_call_focuses',
                    array(
                        'call_id' => $callId,
                        'focus_id' => $focusId
                    )
                );
            }

        } else {
            $isTaskSaved = (bool)$wpdb->insert(
                'wp_purpozed_opportunities_call',
                $taskData
            );

            $callId = $wpdb->insert_id;

            if (isset($_POST['topic'])) {
                foreach ($skillsData as $key => $skillId) {
                    $wpdb->insert(
                        'wp_purpozed_opportunities_call_skills',
                        array(
                            'call_id' => $callId,
                            'skill_id' => $skillId
                        )
                    );
                }
            }

            foreach ($focusesData as $key => $focusId) {
                $wpdb->insert(
                    'wp_purpozed_opportunities_call_focuses',
                    array(
                        'call_id' => $callId,
                        'focus_id' => $focusId
                    )
                );
            }
        }

        if ($isTaskSaved) {
            header('Location: /post-opportunity/?status=' . $saveStatus);
        } else {
            $wpdb->delete(
                'wp_purpozed_opportunities',
                array(
                    'id' => $taskId
                )
            );
            return false;
        }
    }

    public function postProject($taskId, $editedOpportunityId, $saveStatus)
    {
        $validPostKeys = array('topic', 'task_typed', 'benefits', 'details', 'expire', 'contact_name', 'contact_surname', 'contact_email', 'contact_phone', 'task_type');
        $_POST['expire'] = strtotime($_POST['expire']);
        $taskData = array();
        foreach ($validPostKeys as $validKey) {
            $taskData[$validKey] = (isset($_POST[$validKey])) ? $_POST[$validKey] : '';
        }

        if (!isset($_POST['topic'])) {
            unset($taskData['topic']);
        }

        $taskData['task_id'] = $taskId;
        unset($taskData['task_type']);

        global $wpdb;

        $isTaskSaved = true;
        if ($editedOpportunityId !== '0') {
            unset($taskData['task_id']);
            $wpdb->update(
                'wp_purpozed_opportunities_project',
                $taskData,
                array(
                    'task_id' => $editedOpportunityId
                )
            );
        } else {
            $isTaskSaved = (bool)$wpdb->insert(
                'wp_purpozed_opportunities_project',
                $taskData
            );
        }

        if ($isTaskSaved) {
            header('Location: /post-opportunity/?status=' . $saveStatus);
        } else {
            $wpdb->delete(
                'wp_purpozed_opportunities',
                array(
                    'id' => $taskId
                )
            );
            return false;
        }
    }

    public function postMentoring($taskId, $editedOpportunityId, $saveStatus)
    {

        $validPostKeys = array('mentor_area', 'expectations', 'frequency', 'duration', 'time_frame', 'expire', 'contact_name', 'contact_surname', 'contact_email', 'contact_phone', 'task_type');
        $_POST['expire'] = strtotime($_POST['expire']);
        $taskData = array();
        foreach ($validPostKeys as $validKey) {
            $taskData[$validKey] = (isset($_POST[$validKey])) ? $_POST[$validKey] : '';
        }

        $taskData['task_id'] = $taskId;
        unset($taskData['task_type']);

        global $wpdb;

        $isTaskSaved = true;

        if ($editedOpportunityId !== '0') {

            unset($taskData['task_id']);
            $wpdb->update(
                'wp_purpozed_opportunities_mentoring',
                $taskData,
                array(
                    'task_id' => $editedOpportunityId
                )
            );
        } else {
            $isTaskSaved = (bool)$wpdb->insert(
                'wp_purpozed_opportunities_mentoring',
                $taskData
            );
        }


        if ($isTaskSaved) {
            header('Location: /post-opportunity/?status=' . $saveStatus);
        } else {
            $wpdb->delete(
                'wp_purpozed_opportunities',
                array(
                    'id' => $taskId
                )
            );
            return false;
        }
    }

    public function postEngagement($taskId, $editedOpportunityId, $saveStatus)
    {
        $validPostKeys = array('title', 'why', 'task', 'requirements', 'frequency', 'duration', 'time_frame', 'training_duration', 'expire', 'volunteers_needed', 'contact_name', 'contact_surname', 'contact_email', 'contact_phone', 'task_type');
        $_POST['expire'] = strtotime($_POST['expire']);
        $taskData = array();
        foreach ($validPostKeys as $validKey) {
            $taskData[$validKey] = (isset($_POST[$validKey])) ? $_POST[$validKey] : '';
        }

        $taskData['task_id'] = $taskId;
        unset($taskData['task_type']);

        if (!isset($_POST['need_training'])) {
            $taskData['training_duration'] = '0';
        }

        global $wpdb;

        $isTaskSaved = true;

        if ($editedOpportunityId !== '0') {
            unset($taskData['task_id']);
            $wpdb->update(
                'wp_purpozed_opportunities_engagement',
                $taskData,
                array(
                    'task_id' => $editedOpportunityId
                )
            );
        } else {
            $isTaskSaved = (bool)$wpdb->insert(
                'wp_purpozed_opportunities_engagement',
                $taskData
            );
        }

        if ($isTaskSaved) {
            header('Location: /post-opportunity/?status=' . $saveStatus);
        } else {
            $wpdb->delete(
                'wp_purpozed_opportunities',
                array(
                    'id' => $taskId
                )
            );
            return false;
        }
    }
}