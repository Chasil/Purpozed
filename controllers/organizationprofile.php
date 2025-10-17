<?php

namespace Purpozed2\Controllers;

class OrganizationProfile extends \Purpozed2\Controller
{
    protected $description = 'Organization Profile';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->organizationMenu = (get_option('purpozed_organization_menu')[0]) ? get_option('purpozed_organization_menu')[0] : NULL;

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $this->view->details = $volunteerManager->getCurrentUser()->getDetails();

        $organization = new \Purpozed2\Models\Organization();
        $this->view->organizationName = $organization->getName();
        $this->view->links = $organization->getLinks();

        $this->view->succeeded = $organization->succeededOpportunities();
        $this->view->openOpportunities = $organization->openOpportunities();
        $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
        $succeededNoCalls = array('succeeded');
        $formatNoCalls = array('project', 'mentoring', 'engagement');
        $opportunitiesNoCalls = $opportunitiesManager->getList(get_current_user_id(), $succeededNoCalls, $formatNoCalls);

        $days = 0;
        foreach ($opportunitiesNoCalls as $opportunitiesNoCall) {
            $days += $opportunitiesNoCall->duration_overall;
        }

        $this->view->hours_overall = $days * 8;
        $mainGoalId = $this->view->details['main_goal'][0];
        $this->view->main_goal = $organization->getMainGoal($mainGoalId);

        $this->view->goals = $organization->getGoals();

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

}