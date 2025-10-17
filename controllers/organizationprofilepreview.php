<?php

namespace Purpozed2\Controllers;

class OrganizationProfilePreview extends \Purpozed2\Controller
{
    protected $description = 'Organization Profile Preview';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_volunteers_menu')[0]) ? get_option('purpozed_volunteers_menu')[0] : NULL;

        $organizationId = $_GET['id'];

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $this->view->details = $volunteerManager->getCurrentUser($organizationId)->getDetails();

        $organization = new \Purpozed2\Models\Organization();
        $this->view->organizationName = $organization->getName($organizationId);
        $this->view->links = $organization->getLinks($organizationId);

        $this->view->succeeded = $organization->succeededOpportunities($organizationId);
        $this->view->openOpportunities = $organization->openOpportunitiesById($organizationId);
        $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
        $succeededNoCalls = array('succeeded');
        $formatNoCalls = array('project', 'mentoring', 'engagement');
        $opportunitiesNoCalls = $opportunitiesManager->getList($organizationId, $succeededNoCalls, $formatNoCalls);

        $days = 0;
        foreach ($opportunitiesNoCalls as $opportunitiesNoCall) {
            $days += $opportunitiesNoCall->duration_overall;
        }

        $this->view->hours_overall = $days * 8;
        $mainGoalId = $this->view->details['main_goal'][0];
        $this->view->main_goal = $organization->getMainGoal($mainGoalId);

        $this->view->goals = $organization->getGoals($organizationId);

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

}