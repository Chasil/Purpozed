<?php

namespace Purpozed2\Controllers;

class Evaluate extends \Purpozed2\Controller
{
    protected $description = 'Evaluate';
    protected $menuActiveButton = 'evaluate';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        if ($this->view->dashboard_type === 'volunteer') {
            $this->view->volunteersMenuId = get_option('purpozed_volunteers_menu', array(null))[0];
        } elseif ($this->view->dashboard_type === 'organization') {
            $this->view->organizationMenu = get_option('purpozed_organization_menu', array(null))[0];
        }

        $this->view->hasId = true;
        if (!isset($_GET['id'])) {
            $this->view->hasId = false;
        } else {

            $opportunityId = $_GET['id'];
            $this->view->opportunityId = $opportunityId;
            $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
            $singleOpportunity = new \Purpozed2\Models\Opportunity();
            $organization = new \Purpozed2\Models\Organization();
            $volunteersManager = new \Purpozed2\Models\VolunteersManager();

            $organizationId = $this->view->organizationId = $singleOpportunity->getOrganization($opportunityId);
            $this->view->organizationDetails = $organization->getDetailsById($organizationId);
            $this->view->orgDet = $organization->getDetailsById($organizationId);
            $organizationDetails = $organization->getDetailsById($organizationId);
            $mainGoal = $organizationDetails['main_goal'][0];
            $this->view->mainGoalName = $organization->getMainGoal($mainGoal);
            $this->view->openOpportunities = $organization->openOpportunitiesById($organizationId);
            $this->view->succeededOpportunities = $organization->succeededOpportunitiesById($organizationId);
            $this->view->opportunity_status = $singleOpportunity->getStatus($opportunityId);


            $this->view->task_type = $opportunityManager->getType($opportunityId);

            if ($this->view->task_type === 'engagement' && $this->view->dashboard_type === 'organization') {

                $isEvaluatedEngagement = $singleOpportunity->isEvaluatedEngagement($opportunityId, $_GET['user']);

                $startEndDates = $singleOpportunity->getOpportunityCompletedStartAndEndDateEngagement($opportunityId, $_GET['user']);
                $this->view->start_date = $startEndDates->start_date;
                $this->view->end_date = $startEndDates->end_date;
            }

            if ((($this->view->opportunity_status === 'succeeded' || $this->view->opportunity_status === 'canceled'))) {

                $thisUser = get_current_user_id();
                if ($this->view->dashboard_type === 'organization') {
                    $userWhoCompletedOpportunity = $singleOpportunity->getVolunteersWhoComplete($opportunityId);
                    $thisUser = $userWhoCompletedOpportunity[0]->user_id;
                }

                $startEndDates = $singleOpportunity->getOpportunityCompletedStartAndEndDate($opportunityId, $thisUser);
                $this->view->start_date = $startEndDates->start_date;
                $this->view->end_date = $startEndDates->end_date;
            } elseif (($this->view->dashboard_type === 'volunteer' && $this->view->opportunity_status === 'open')) {
                if ($isEvaluatedEngagement = $singleOpportunity->isEvaluatedEngagement($opportunityId, get_current_user_id())) {
                    $startEndDates = $singleOpportunity->getOpportunityCompletedStartAndEndDateEngagement($opportunityId, get_current_user_id());
                    $this->view->start_date = $startEndDates->start_date;
                    $this->view->end_date = $startEndDates->end_date;
                }
            }


            $this->view->is_evaluated = $singleOpportunity->isEvaluated($opportunityId);
            if ($this->view->is_evaluated) {
                $this->view->volunteer_evaluation_text = $singleOpportunity->getVolunteerEvaluationText($opportunityId);
                $this->view->volunteer_evaluation_organization_text = $singleOpportunity->getOrganizationEvaluationText($opportunityId);
                $this->view->volunteer_evaluation_date = $singleOpportunity->getVolunteerEvaluationDate($opportunityId);
                $this->view->volunteer_evaluation_organization_date = $singleOpportunity->getOrganizationEvaluationTextDate($opportunityId);
            }
            $this->view->has_applied = $opportunityManager->hasApplied(get_current_user_id(), $opportunityId);
            $this->view->is_bookmarked = $opportunityManager->isBookmarked(get_current_user_id(), $opportunityId);
            $this->view->canceled_by = $singleOpportunity->canceledBy($opportunityId);

            if ($this->view->opportunity_status === 'in_progress') {
                $this->view->in_progress_users = $singleOpportunity->getInProgress($opportunityId);
            }

            if ($this->view->task_type === 'call') {
                $this->view->opportunity = $opportunityManager->getSingleCall($opportunityId);
                $this->view->topic = $opportunityManager->getTopic($this->view->opportunity->topic);
                $this->view->skills = $opportunityManager->getCallSkills($this->view->opportunity->id);
                $this->view->focus = $opportunityManager->getFocuses($this->view->opportunity->id);
                $this->view->call_focuses = $singleOpportunity->getCallFocusesText();

            } elseif ($this->view->task_type === 'project') {
                $this->view->opportunity = $opportunityManager->getSingleProject($opportunityId);
                $this->view->topic = $opportunityManager->getTopic($this->view->opportunity->topic);

                $task = new \Purpozed2\Models\TaskManager();
                $this->view->taskData = $task->getChosenProjectTask($this->view->opportunity->topic);

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

            } elseif ($this->view->task_type === 'engagement') {
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
    }

    public function getDashboardType()
    {

        if (is_user_logged_in()) {

            $user = new \WP_User(get_current_user_id());
            if (in_array('volunteer', $user->roles)) {
                return 'volunteer';
            } elseif (in_array('organization', $user->roles)) {
                return 'organization';
            }
        } else {
            header('Location: /?route=' . $_SERVER['REQUEST_URI']);
        }
        return;
    }

}