<?php

namespace Purpozed2\Controllers;

class OrganizationSettings extends \Purpozed2\Controller
{
    protected $description = 'Organization Settings';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->organizationMenu = (get_option('purpozed_organization_menu')[0]) ? get_option('purpozed_organization_menu')[0] : NULL;

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $all_goals = $goalsManager->getListAsArray();
        usort($all_goals, array($this, 'sort_skills'));
        $this->view->all_goals = $all_goals;

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();

        $logoId = '';
        if (!empty($_FILES) && $_FILES['image']['size'] !== 0) {
            $registerOrganization = new \Purpozed2\Controllers\RegisterOrganization();
            $logoId = $registerOrganization->uploadLogo($_FILES);
        }

        if (!empty($_POST)) {
            $this->view->returnData = $volunteerManager->getCurrentUser()->saveOrganizationSettings($logoId);
        }

        $organization = new \Purpozed2\Models\Organization();

        $this->view->goals = $organization->getGoals();
        $this->view->details = $volunteerManager->getCurrentUser()->getDetails();
        $this->view->organizationName = $organization->getName();
        $this->view->links = $organization->getLinks();

        $userData = get_userdata(get_current_user_id());
        $this->view->userMeta = get_user_meta($userData->ID);
        $this->view->email = $userData->data->user_email;
        $this->view->main_goal = $this->view->details['main_goal'][0];

        $this->view->experiences = $volunteerManager->getCurrentUser()->getExperiences();

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

    public function sort_skills($a, $b)
    {
        return strnatcmp($a['name'], $b['name']);
    }

}