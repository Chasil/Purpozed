<?php

namespace Purpozed2\Controllers;

class VolunteerProfilePreview extends \Purpozed2\Controller
{
    protected $description = 'Volunteer Profile Preview';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->organizationMenu = (get_option('purpozed_organization_menu')[0]) ? get_option('purpozed_organization_menu')[0] : NULL;

        $userId = $_GET['id'];

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $this->view->skills = $volunteerManager->getCurrentUser($userId)->getSkills();
        $this->view->goals = $volunteerManager->getCurrentUser($userId)->getGoals();

        $organization = new \Purpozed2\Models\Organization();
        $this->view->details = $volunteerManager->getCurrentUser($userId)->getDetails();
        $this->view->userData = get_userdata($userId);

        $company = new \Purpozed2\Models\Company();
        $this->view->organizationName = $company->getNameByVolunteer($userId);
        $this->view->succeededOpportunties = $volunteerManager->getCurrentUser($userId)->succeededOpportunities();
        $this->view->helpedHours = $volunteerManager->getCurrentUser($userId)->hoursHelped();
        $this->view->experiences = $volunteerManager->getCurrentUser($userId)->getExperiences();
        $this->view->links = $organization->getLinks();
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