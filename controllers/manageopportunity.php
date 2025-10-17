<?php

namespace Purpozed2\Controllers;

class ManageOpportunity extends \Purpozed2\Controller
{
    protected $description = 'Manage Opportunity';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->organizationMenu = (get_option('purpozed_organization_menu')[0]) ? get_option('purpozed_organization_menu')[0] : NULL;

        $this->view->hasId = true;
        if (!isset($_GET['id'])) {
            $this->view->hasId = false;
        } else {

            $this->view->statusesTypes = array(
                'prepared' => __('prepared', 'purpozed'),
                'review' => __('review', 'purpozed'),
                'deleted' => __('deleted', 'purpozed'),
                'open' => __('open', 'purpozed'),
                'retracted' => __('retracted', 'purpozed'),
                'expired' => __('expired', 'purpozed'),
                'in_progress' => __('in_progress', 'purpozed'),
                'succeeded' => __('succeeded', 'purpozed'),
                'canceled' => __('canceled', 'purpozed'),
            );

            $this->view->statusesTypesCSS = array(
                'prepared' => 'prepared',
                'review' => 'review',
                'deleted' => 'deleted',
                'open' => 'open',
                'retracted' => 'retracted',
                'expired' => 'expired',
                'in_progress' => 'in_progress',
                'succeeded' => 'succeeded',
                'canceled' => 'canceled'
            );

            $opportunityId = $_GET['id'];
            $this->view->opportunityId = $opportunityId;
            $this->view->opportunity_id = $opportunityId;
            $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
            $this->view->opportunityManager = new \Purpozed2\Models\OpportunitiesManager();

            $this->view->singleOpportunity = new \Purpozed2\Models\Opportunity();
            $singleOpportunity = new \Purpozed2\Models\Opportunity();
            $this->view->status = $singleOpportunity->getStatus($opportunityId);
            $organization = new \Purpozed2\Models\Organization();

            $this->view->task_type = $opportunityManager->getType($opportunityId);
            $this->view->has_applied = $opportunityManager->hasApplied(get_current_user_id(), $opportunityId);
            $this->view->is_bookmarked = $opportunityManager->isBookmarked(get_current_user_id(), $opportunityId);
            $organizationId = $singleOpportunity->getOrganization($opportunityId);
            $this->view->organizationDetails = $organization->getDetailsById($organizationId);
            $organizationDetails = $organization->getDetailsById($organizationId);
            $mainGoal = $organizationDetails['main_goal'][0];
            $this->view->mainGoalName = $organization->getMainGoal($mainGoal);
            $this->view->openOpportunities = $organization->openOpportunitiesById($organizationId);
            $this->view->succeededOpportunities = $organization->succeededOpportunitiesById($organizationId);

            if ($this->view->task_type === 'call') {
                $this->view->opportunity = $opportunityManager->getSingleCall($opportunityId);

                $matchedUsers = $singleOpportunity->bestMatchedSingleCallVolunteers($this->view->opportunity);
                $this->view->matchedUsers = $matchedUsers;

                $this->view->topic = $opportunityManager->getTopic($this->view->opportunity->topic);
                $this->view->skills = $opportunityManager->getCallSkills($this->view->opportunity->id);
                $this->view->focus = $opportunityManager->getFocuses($this->view->opportunity->id);
                $this->view->call_focuses = $singleOpportunity->getCallFocusesText();

            } elseif ($this->view->task_type === 'project') {
                $this->view->opportunity = $opportunityManager->getSingleProject($opportunityId);

                $task = new \Purpozed2\Models\TaskManager();

                $matchedUsers = $singleOpportunity->bestMatchedSingleProjectVolunteers($this->view->opportunity);
                $this->view->matchedUsers = $matchedUsers;

                if (!is_null($this->view->opportunity->topic)) {
                    $this->view->topic = $opportunityManager->getTopic($this->view->opportunity->topic);
                    $this->view->taskData = $task->getChosenProjectTask($this->view->opportunity->topic);
                }


            } elseif ($this->view->task_type === 'mentoring') {
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

                $matchedUsers = $singleOpportunity->bestMatchedSingleMentoringVolunteer($this->view->opportunity);
                $this->view->matchedUsers = $matchedUsers;

            } else {
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

                $matchedUsers = $singleOpportunity->bestMatchedEngagementVolunteers();
                $this->view->matchedUsers = $matchedUsers;
            }
        }
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

    public function rejectVolunteer()
    {
        $opportunityId = $_POST['opportunity_id'];
        $userId = $_POST['user_id'];
        $SingleOpportunity = new \Purpozed2\Models\Opportunity();

        $request = $SingleOpportunity->rejectVolunteer($opportunityId, $userId);

        $status = false;
        if ($request) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();
    }

}