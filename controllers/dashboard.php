<?php

namespace Purpozed2\Controllers;

class Dashboard extends \Purpozed2\Controller
{
    protected $description = 'Dashboard';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->volunteersMenuId = (get_option('purpozed_volunteers_menu')[0]) ? get_option('purpozed_volunteers_menu')[0] : NULL;
        $this->view->organizationMenu = (get_option('purpozed_organization_menu')[0]) ? get_option('purpozed_organization_menu')[0] : NULL;
        $this->view->companyMenu = (get_option('purpozed_company_menu')[0]) ? get_option('purpozed_company_menu')[0] : NULL;

        if (isset($_POST['submit'])) {
            $login = esc_attr($_POST['login']);
            $password = esc_attr($_POST['password']);

            $loginData = array(
                'user_login' => $login,
                'user_password' => $password,
                'remember' => true
            );

            $user = wp_signon($loginData, false);

            if ($user->errors) {
                $this->view->login_errors = $user->errors;
            } else {
                $userKey = get_user_meta($user->ID, 'is_confirmed')[0];

                $userData = new \WP_User($user->ID);

                if (in_array('deactivated', $userData->roles)) {
                    $this->view->deactivated = true;
                    wp_logout();
                } elseif ($userKey != '1') {
                    $this->view->not_register = true;
                    wp_logout();
                } else {
                    if (is_wp_error($user)) {
                        $this->view->errors = $user->get_error_message();
                        wp_logout();
                    } else {

                        wp_set_current_user($user->ID);
                        update_user_meta($user->ID, 'last_login', time());

                        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                        $volunteerManager->getCurrentUser()->saveUserLogin();

                        if (isset($_GET['route'])) {
                            header('Location: ' . $_SERVER['HTTP_HOST'] . $_GET['route']);
                        }
                    }
                }
            }

            if (isset($_POST['logged-in'])) {
                apply_filters('auth_cookie_expiration', function () {
                    return YEAR_IN_SECONDS * 2;
                });
            }
        }

        $this->view->dashboard_type = $this->getDashboardType();
        $organization = new \Purpozed2\Models\Organization();
        $opportunities = new \Purpozed2\Models\OpportunitiesManager();

        $this->view->taskType = array(
            'call' => __('call', 'purpozed'),
            'project' => __('project', 'purpozed'),
            'mentoring' => __('mentoring', 'purpozed'),
            'engagement' => __('engagement', 'purpozed'),
        );

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

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $singleOpportunity = $this->view->singleOpportuity = new \Purpozed2\Models\Opportunity();
        $company = new \Purpozed2\Models\Company();

        if ($this->view->dashboard_type === 'organization') {
            $this->view->details = $organization->getDetails();

            $goal = new \Purpozed2\Models\GoalsManager();
            $this->view->goalName = $goal->getName($this->view->details['main_goal'][0]);

            $dashboardPosted = array('open');
            $this->view->opportunities = $opportunities->getList(get_current_user_id(), $dashboardPosted);

            $callOpportunities = array('call');
            $matchedCallUsers = $singleOpportunity->bestMatchedCallVolunteers($opportunities->getList(get_current_user_id(), $dashboardPosted, $callOpportunities));
            $this->view->matchedCallUsers = $matchedCallUsers;

            $projectOpportunities = array('project');
            $matchedProjectUsers = $singleOpportunity->bestMatchedProjectVolunteers($opportunities->getList(get_current_user_id(), $dashboardPosted, $projectOpportunities));
            $this->view->matchedProjectUsers = $matchedProjectUsers;

            $mentoringOpportunities = array('mentoring');
            $matchedMentoringUsers = $singleOpportunity->bestMatchedMentoringVolunteers($opportunities->getList(get_current_user_id(), $dashboardPosted, $mentoringOpportunities));
            $this->view->matchedMentoringUsers = $matchedMentoringUsers;

            $engagementOpportunities = array('engagement');
            $matchedEngagementUsers = $singleOpportunity->bestMatchedEngagementVolunteers($opportunities->getList(get_current_user_id(), $dashboardPosted, $engagementOpportunities));
            $this->view->matchedEngagementUsers = $matchedEngagementUsers;

            $this->view->applied = $singleOpportunity->getApplied(get_current_user_id());

            $dashboardSavedAndReviewed = array('prepared', 'review');
            $this->view->saved_and_reviewed = $opportunities->getList(get_current_user_id(), $dashboardSavedAndReviewed);
            $dashboardInProgress = array('in_progress');
            $this->view->in_progress = $opportunities->getList(get_current_user_id(), $dashboardInProgress);
            $dashboardCompleted = array('succeeded', 'canceled');
            $this->view->completed = $opportunities->getList(get_current_user_id(), $dashboardCompleted);

            $this->view->organizationDetails = $volunteerManager->getCurrentUser()->getDetails();

        } elseif ($this->view->dashboard_type === 'volunteer') {
            $this->view->details = $volunteerManager->getCurrentUser()->getDetails();
            $this->view->organizationName = $company->getNameByVolunteer();
            $this->view->opportunitiesManager = $opportunities;

            $this->view->bestMatchedCall = $singleOpportunity->getBestMatchedCall();
            $this->view->bestMatchedProject = $singleOpportunity->getBestMatchedProject();
            $this->view->bestMatchedMentoring = $singleOpportunity->getBestMatchedMentoring();
            $this->view->bestMatchedEngagement = $singleOpportunity->getBestMatchedEngagement();

            $this->view->applied = $opportunities->getApllied(get_current_user_id());
            $this->view->requested = $opportunities->getRequested(get_current_user_id());
            $this->view->in_progress = $opportunities->getInProgressVolunteer(get_current_user_id());
            $this->view->completed = $opportunities->getCompleted(get_current_user_id());
            $this->view->bookmarked = $opportunities->getBookmarked(get_current_user_id());

        }

        /*
         * Dashboard
         */

        //todo sprawdzić czy są pasujące ogłoszenia
        $this->view->matching = true;
    }

    public function getDashboardType()
    {
        $user = wp_get_current_user();
        if (in_array('volunteer', $user->roles)) {
            return 'volunteer';
        }
        if (in_array('organization', $user->roles)) {
            return 'organization';
        }
        return 'guest';
    }
}