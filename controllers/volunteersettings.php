<?php

namespace Purpozed2\Controllers;

class VolunteerSettings extends \Purpozed2\Controller
{
    protected $description = 'Volunteer Settings';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_volunteers_menu')[0]) ? get_option('purpozed_volunteers_menu')[0] : NULL;

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $company = new \Purpozed2\Models\Company();

        $logoId = '';
        if (!empty($_FILES) && $_FILES['image']['size'] !== 0) {
            $registerOrganization = new \Purpozed2\Controllers\RegisterOrganization();
            $logoId = $registerOrganization->uploadLogo($_FILES);
        }

        if (!empty($_POST)) {
            $this->view->returnData = $volunteerManager->getCurrentUser()->saveSettings($logoId);
        }

        $this->view->skills = $volunteerManager->getCurrentUser()->getSkills();
        $this->view->goals = $volunteerManager->getCurrentUser()->getGoals();

        $skillsManager = new \Purpozed2\Models\SkillManager();
        $this->view->allSkills = $skillsManager->getList();
        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $allGoals = (array)$goalsManager->getListAsArray();
        usort($allGoals, array($this, 'sort_skills'));
        $this->view->allGoals = $allGoals;

        $organization = new \Purpozed2\Models\Organization();
        $this->view->details = $volunteerManager->getCurrentUser()->getDetails();
        $this->view->organizationName = $company->getNameByVolunteer();
        $this->view->links = $organization->getLinks();

        $userData = get_userdata(get_current_user_id());
        $this->view->email = $userData->data->user_email;

        $this->view->readyForRequest = (isset(get_user_meta(get_current_user_id(), 'ready_for_request')[0])) ? get_user_meta(get_current_user_id(), 'ready_for_request')[0] : 0;
        $this->view->commentsVisible = (isset(get_user_meta(get_current_user_id(), 'comments_visible')[0])) ? get_user_meta(get_current_user_id(), 'comments_visible')[0] : 0;

        $this->view->experiences = $volunteerManager->getCurrentUser()->getExperiences();
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

    public function deleteUserAccount()
    {
        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $volunteersManager->getCurrentUser()->deleteAccount();

        echo json_encode(array('status' => true));
        die();
    }

    public function sort_skills($a, $b)
    {
        return strnatcmp($a['name'], $b['name']);
    }

}