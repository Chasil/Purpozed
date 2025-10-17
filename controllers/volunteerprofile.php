<?php

namespace Purpozed2\Controllers;

class VolunteerProfile extends \Purpozed2\Controller
{
    protected $description = 'Volunteer Profile';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_volunteers_menu')[0]) ? get_option('purpozed_volunteers_menu')[0] : NULL;

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $this->view->skills = $volunteerManager->getCurrentUser()->getSkills();
        $this->view->goals = $volunteerManager->getCurrentUser()->getGoals();

        $organization = new \Purpozed2\Models\Organization();
        $this->view->details = $volunteerManager->getCurrentUser()->getDetails();

        $company = new \Purpozed2\Models\Company();
        $this->view->organizationName = $company->getNameByVolunteer();
        $this->view->succeededOpportunties = $volunteerManager->getCurrentUser()->succeededOpportunities();
        $this->view->helpedHours = $volunteerManager->getCurrentUser()->hoursHelped();
        $this->view->experiences = $volunteerManager->getCurrentUser()->getExperiences();
        $this->view->links = $organization->getLinks();

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