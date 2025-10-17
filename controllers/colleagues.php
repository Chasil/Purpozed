<?php

namespace Purpozed2\Controllers;

class Colleagues extends \Purpozed2\Controller
{
    protected $description = 'Colleagues';
    protected $menuActiveButton = 'colleagues';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_volunteers_menu')[0]) ? get_option('purpozed_volunteers_menu')[0] : NULL;

        $organizationManager = new \Purpozed2\Models\Organization();
        $currentCompanyId = $organizationManager->getCompanyId();
        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $this->view->colleagues = $volunteersManager->getColleagues($currentCompanyId);
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