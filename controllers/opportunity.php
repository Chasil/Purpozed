<?php

namespace Purpozed2\Controllers;

class Opportunity extends \Purpozed2\Controller
{
    protected $description = 'Opportunity';
    protected $menuActiveButton = 'find-opportunity';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_volunteers_menu')[0]) ? get_option('purpozed_volunteers_menu')[0] : NULL;

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
            $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
            $singleOpportunity = new \Purpozed2\Models\Opportunity();
            $organization = new \Purpozed2\Models\Organization();

            $this->view->isRejected = $singleOpportunity->isRejected($opportunityId, get_current_user_id());

            $organizationId = $singleOpportunity->getOrganization($opportunityId);
            $this->view->organizationId = $organizationId;
            $organizationDetails = $organization->getDetailsById($organizationId);
            $this->view->orgDet = $organization->getDetailsById($organizationId);
            $mainGoal = $organizationDetails['main_goal'][0];
            $this->view->mainGoalName = $organization->getMainGoal($mainGoal);
            $this->view->openOpportunities = $organization->openOpportunitiesById($organizationId);
            $this->view->succeededOpportunities = $organization->succeededOpportunitiesById($organizationId);

            $this->view->task_type = $opportunityManager->getType($opportunityId);
            $this->view->opportunity_status = $singleOpportunity->getStatus($opportunityId);

            if ($this->view->dashboard_type === 'volunteer' && $this->view->opportunity_status === 'completed') {

                $userWhoCompletedOpportunity = $singleOpportunity->getVolunteersWhoComplete($opportunityId);
                $thisUser = $userWhoCompletedOpportunity[0]->user_id;

                $startEndDates = $singleOpportunity->getOpportunityCompletedStartAndEndDate($opportunityId, $thisUser);
                $this->view->start_date = $startEndDates->start_date;
                $this->view->end_date = $startEndDates->end_date;
            }

            $this->view->has_applied = $opportunityManager->hasApplied(get_current_user_id(), $opportunityId);
            $this->view->is_bookmarked = $opportunityManager->isBookmarked(get_current_user_id(), $opportunityId);
            $this->view->is_lost = $singleOpportunity->lost($opportunityId, get_current_user_id());
            $this->view->signToOther = $singleOpportunity->assignedToOther($opportunityId, get_current_user_id());

            $this->view->is_evaluated = $singleOpportunity->isEvaluated($opportunityId);
            if ($this->view->is_evaluated) {
                $this->view->volunteer_evaluation_text = $singleOpportunity->getVolunteerEvaluationText($opportunityId);
                $this->view->volunteer_evaluation_date = $singleOpportunity->getVolunteerEvaluationDate($opportunityId);
                $this->view->volunteer_evaluation_organization_text = $singleOpportunity->getOrganizationEvaluationText($opportunityId);
                $this->view->volunteer_evaluation_organization_date = $singleOpportunity->getOrganizationEvaluationTextDate($opportunityId);
                $startEndDates = $singleOpportunity->getOpportunityCompletedStartAndEndDate($opportunityId, get_current_user_id());
                $this->view->start_date = $startEndDates->start_date;
                $this->view->end_date = $startEndDates->end_date;
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
            }
        }
    }

    public function getDashboardType()
    {
        if (is_user_logged_in()) {

            $user = new \WP_User(get_current_user_id());
            if (in_array('volunteer', $user->roles)) {
                return 'volunteer';
            }
        } else {
            header('Location: /?route=' . $_SERVER['REQUEST_URI']);
        }
        return;
    }

    public function applyToOpportunity()
    {

        $opportunityID = $_POST['opportunity_id'];

        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $addVolunteerToOpportunty = $volunteersManager->getCurrentUser()->applyToOpportunity($opportunityID);

        $status = false;
        if ($addVolunteerToOpportunty) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();
    }

    public function removeFromTheList()
    {
        $opportunityID = $_POST['opportunity_id'];
        $rejectedByVolunteer = (isset($_POST['reject'])) ? 1 : 0;
        $retractByVolunteer = (isset($_POST['retract'])) ? 1 : 0;

        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $volunteersManager->getCurrentUser()->removeFromTheList($opportunityID, $rejectedByVolunteer, $retractByVolunteer);

        echo json_encode(array('status' => true));
        die();
    }

    public function removeApplication()
    {
        $opportunityID = $_POST['opportunity_id'];

        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $volunteersManager->getCurrentUser()->removeApplication($opportunityID);

        echo json_encode(array('status' => true));
        die();
    }

    public function closeEngagement()
    {
        $opportunityID = $_POST['opportunity_id'];
        $status = $_POST['status'];

        $opportunity = new \Purpozed2\Models\Opportunity();
        $opportunity->engagementCloseOpen($opportunityID, $status);

        echo json_encode(array('status' => true));
        die();
    }

    public function signVolunteerToOpportunity()
    {
        $opportunityID = $_POST['opportunity_id'];
        $acceptedUser = (isset($_POST['user_id'])) ? $_POST['user_id'] : get_current_user_id();
        $applyAccepted = (isset($_POST['accept'])) ? $_POST['accept'] : null;

        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $signVolunteerToOpportunity = $volunteersManager->getCurrentUser($acceptedUser)->signInToOpportunity($opportunityID, $applyAccepted, $acceptedUser);

        $status = false;
        if ($signVolunteerToOpportunity) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();
    }

    public function addBookmarkedOpportunity()
    {

        $opportunityID = $_POST['opportunity_id'];

        $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
        $addBookmarked = $opportunityManager->bookmarkOpportunity(get_current_user_id(), $opportunityID);

        $status = false;
        if ($addBookmarked) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();
    }

    public function evaluateOpportunityVolunteer()
    {
        $opportunityId = $_POST['opportunity_id'];
        $text = $_POST['text'];
        $type = $_POST['type'];
        $hours = $_POST['hours'];
        $canceledBy = $_POST['canceled_by'];
        $userId = $_POST['user_id'];
        $alreadyCanceled = $_POST['already_canceled'];
        $complain = $_POST['complain'];
        $collaboration = $_POST['collaboration'];
        $opportunityName = $_POST['opportunityName'];
        $hours_disagree = $_POST['hours_disagree'];

        $singleOpportunity = new \Purpozed2\Models\Opportunity();
        $taskType = $singleOpportunity->getType($opportunityId);

        if (($complain || $collaboration || $hours_disagree) && $type === 'organization') {

            $volunteerName = get_user_meta($userId, 'first_name')[0];

            $organizationName = get_user_meta(get_current_user_id(), 'organization_name')[0];

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/complain-about-volunteer.php');
            $message = ob_get_contents();
            ob_clean();

            $to = 'support@purpozed.org';
            $subject = 'Complain about volunteer';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);

        }

        if (($complain || $collaboration || $hours_disagree) && $type === 'volunteer') {

            $volunteerName = get_user_meta($userId, 'first_name')[0];

            $organizationName = get_user_meta(get_current_user_id(), 'organization_name')[0];

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/complain-about-organization.php');
            $message = ob_get_contents();
            ob_clean();

            $to = 'support@purpozed.org';
            $subject = 'Complain about volunteer';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }

        $status = false;

        if ($taskType !== 'engagement') {

            if (!$singleOpportunity->isEvaluated($opportunityId)) {
                $setComplete = $singleOpportunity->setCompleted($opportunityId, $userId, $hours);
            } else {
                $setComplete = true;
            }
            if ($setComplete) {
                $status = true;
            }
        }

        $volunteersManager = new \Purpozed2\Models\VolunteersManager();

        if (isset($_POST['cancel'])) {
            if ($taskType !== 'engagement') {
                $evaluateVolunteer = $volunteersManager->getCurrentUser()->cancelOpportunity($opportunityId, $text, $canceledBy);
            } else {
                $evaluateVolunteer = $volunteersManager->getCurrentUser()->cancelOpportunityEngagement($opportunityId, $text, $canceledBy, $userId);
            }
        } else {
            if ($taskType !== 'engagement') {
                $evaluateVolunteer = $volunteersManager->getCurrentUser()->evaluateVolunteer($opportunityId, $text, $type, $hours);
            } else {
                $evaluateVolunteer = $volunteersManager->getCurrentUser()->evaluateVolunteerEngagement($opportunityId, $text, $type, $userId, $hours);
            }
        }

        if ($evaluateVolunteer) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();

    }

    public function remindOrganizationAboutEvaluation()
    {

        $opportunityId = $_POST['opportunity_id'];

        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $evaluateVolunteer = $volunteersManager->getCurrentUser()->remindOrganizationAboutEvaluation($opportunityId);


        $status = false;
        if ($evaluateVolunteer) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();
    }

    public function retractOpportunity()
    {

        $opportunityId = $_POST['opportunity_id'];

        $SingleOpportunity = new \Purpozed2\Models\Opportunity();
        $retractedOpportunity = $SingleOpportunity->retractOpportunity($opportunityId);

        $status = false;
        if ($retractedOpportunity) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();

    }

    public function deleteOpportunity()
    {

        $opportunityId = $_POST['opportunity_id'];

        $SingleOpportunity = new \Purpozed2\Models\Opportunity();
        $retractedOpportunity = $SingleOpportunity->deleteOpportunity($opportunityId);

        $status = false;
        if ($retractedOpportunity) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();

    }

    public function requestVolunteerToOpportunity()
    {
        $opportunityId = $_POST['opportunity_id'];
        $userId = $_POST['user_id'];
        $SingleOpportunity = new \Purpozed2\Models\Opportunity();

        $request = $SingleOpportunity->requestVolunteer($opportunityId, $userId);

        $status = false;
        if ($request) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();

    }

    public function retractVolunteer()
    {

        $opportunityId = $_POST['opportunity_id'];
        $userId = $_POST['user_id'];
        $SingleOpportunity = new \Purpozed2\Models\Opportunity();

        $request = $SingleOpportunity->retractVolunteer($opportunityId, $userId);

        $status = false;
        if ($request) {
            $status = true;
        }

        echo json_encode(array('status' => $status));
        die();
    }
}