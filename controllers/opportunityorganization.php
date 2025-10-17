<?php

namespace Purpozed2\Controllers;

class OpportunityOrganization extends \Purpozed2\Controller
{
    protected $description = 'Opportunity Organization';
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
            $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
            $this->view->opportunity_id = $opportunityId;

            $this->view->task_type = $opportunityManager->getType($opportunityId);
            $this->view->has_applied = $opportunityManager->hasApplied(get_current_user_id(), $opportunityId);
            $this->view->is_bookmarked = $opportunityManager->isBookmarked(get_current_user_id(), $opportunityId);

            $singleOpportunity = new \Purpozed2\Models\Opportunity();
            $this->view->is_evaluated = $singleOpportunity->isEvaluated($opportunityId);
            if ($this->view->is_evaluated) {
                $this->view->volunteer_evaluation_text = $singleOpportunity->getVolunteerEvaluationText($opportunityId);
                $this->view->volunteer_evaluation_organization_text = $singleOpportunity->getOrganizationEvaluationText($opportunityId);
            }

            if ($this->view->task_type === 'call') {
                $this->view->opportunity = $opportunityManager->getSingleCall($opportunityId);
                $this->view->topic = $opportunityManager->getTopic($this->view->opportunity->topic);
                $this->view->skills = $opportunityManager->getCallSkills($this->view->opportunity->id);
                $this->view->focuses = $opportunityManager->getFocuses($this->view->opportunity->id);

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

            } else {
                $this->view->opportunity = $opportunityManager->getSingleEngagement($opportunityId);
                $this->view->duration_overall = $this->view->opportunity->frequency * $this->view->opportunity->duration * $this->view->opportunity->time_frame;

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
            if (in_array('organization', $user->roles)) {
                return 'organization';
            }
        } else {
            header('Location: /?route=' . $_SERVER['REQUEST_URI']);
        }
        return;
    }

    public function evaluateOpportunityOrganization()
    {

        $opportunityId = $_POST['opportunity_id'];
        $text = $_POST['text'];

        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $evaluateVolunteer = $volunteersManager->getCurrentUser()->evaluateOrganization($opportunityId, $text);

        $status = false;
        if ($evaluateVolunteer) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();

    }

}