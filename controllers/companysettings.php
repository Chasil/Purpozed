<?php

namespace Purpozed2\Controllers;

class CompanySettings extends \Purpozed2\Controller
{
    protected $description = 'Company Settings';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_company_menu')[0]) ? get_option('purpozed_company_menu')[0] : NULL;

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $this->view->all_goals = $goalsManager->getList();

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();

        $logoId = '';
        if (!empty($_FILES) && $_FILES['image']['size'] !== 0) {
            $registerOrganization = new \Purpozed2\Controllers\RegisterOrganization();
            $logoId = $registerOrganization->uploadLogo($_FILES);
        }

        if (!empty($_POST)) {
            $this->view->returnData = $volunteerManager->getCurrentUser()->saveCompanySettings($logoId);
        }

        $organization = new \Purpozed2\Models\Organization();
        $company = new \Purpozed2\Models\Company();

        $this->view->details = $company->getDetails();
        $this->view->links = $company->getLinks();

        $userData = get_userdata(get_current_user_id());
        $this->view->email = $userData->data->user_email;

        $this->view->experiences = $volunteerManager->getCurrentUser()->getExperiences();

    }

    public function getDashboardType()
    {

        if (is_user_logged_in()) {

            $user = new \WP_User(get_current_user_id());
            if (get_user_meta(get_current_user_id(), 'is_admin')[0] === '1') {
                return 'company';
            }
        } else {
            header('Location: /?route=' . $_SERVER['REQUEST_URI']);
        }
        return;
    }

}