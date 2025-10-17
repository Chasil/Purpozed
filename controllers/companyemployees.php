<?php

namespace Purpozed2\Controllers;

class CompanyEmployees extends \Purpozed2\Controller
{
    protected $description = 'Comapny Employees';
    protected $menuActiveButton = 'company-employees';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_company_menu')[0]) ? get_option('purpozed_company_menu')[0] : NULL;

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $companyManager = new \Purpozed2\Models\Company();
        $this->view->goals = $goalsManager->getList();

        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $this->view->volunteersManager = $volunteersManager;
        $this->view->employees = $volunteersManager->getListByCompany();
        $this->view->companiesManager = new\Purpozed2\Models\CompaniesManager();
        $this->view->colleagues = $volunteersManager->getListByCompany();
        $this->view->companyName = $companyManager->getNameByVolunteer();

        $this->view->register_date = $volunteersManager->getCurrentUser()->getRegisterDate();

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