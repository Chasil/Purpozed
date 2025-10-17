<?php

namespace Purpozed2\Models;

class CompaniesManager
{

    public function getList(): array
    {

        $users = get_users(array('fields' => array('ID')));

        $companies = array();

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            $userData2 = get_userdata($user->ID);
            if (in_array('company', $userData->roles)) {
                $logo = (isset(get_user_meta($user->ID, 'logo')[0]) ? get_user_meta($user->ID, 'logo')[0] : '');
                $companies[] = array(
                    'id' => $user->ID,
                    'first_name' => get_user_meta($user->ID, 'first_name')[0],
                    'logo' => $logo,
                    'registered' => $userData2->user_registered
                );
            }
        }

        return $companies;
    }

    public function countAll()
    {

        return count($this->getList());
    }

    public function countSuccessfull($type = null)
    {
        $users = get_users(array('fields' => array('ID')));

        $organizationUsers = array();

        $andType = '';
        if (!is_null($type)) {
            $andType = " AND wpo.task_type = '" . $type . "'";
        }
        global $wpdb;

        $total = 0;
        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            $currentUserOrganizationId = get_user_meta(get_current_user_id(), 'company_id')[0];

            if (in_array('volunteer', $userData->roles) && get_user_meta($user->ID, 'company_id')[0] === $currentUserOrganizationId) {
                $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_volunteer_completed wpvc 
                                                LEFT JOIN wp_purpozed_opportunities wpo
                                                ON wpvc.opportunity_id = wpo.id
                                                WHERE user_id = '%d' $andType", $user->ID);
                $total += $wpdb->get_var($query);
            }
        }
        return $total;
    }

    public function countCanceled($type = null)
    {
//        $users = get_users(array('fields' => array('ID')));
//
//        $organizationUsers = array();
//
//        $andType = '';
//        if (!is_null($type)) {
//            $andType = " AND wpo.task_type = '" . $type . "'";
//        }
//        global $wpdb;
//
//        $total = 0;
//        foreach ($users as $user) {
//            $userData = get_user_by('ID', $user->ID);
//            $currentUserOrganizationId = get_user_meta(get_current_user_id(), 'company_id')[0];
//
//            if (in_array('volunteer', $userData->roles) && get_user_meta($user->ID, 'company_id')[0] === $currentUserOrganizationId) {
//                $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_volunteer_completed wpvc
//                                                LEFT JOIN wp_purpozed_opportunities wpo
//                                                ON wpvc.opportunity_id = wpo.id
//                                                WHERE user_id = '%d' $andType", $user->ID);
//                $total += $wpdb->get_var($query);
//            }
//        }
//        return $total;
    }

    public function countInProgress($type = null)
    {
        $users = get_users(array('fields' => array('ID')));

        $organizationUsers = array();

        $andType = '';
        if (!is_null($type)) {
            $andType = " AND wpo.task_type = '" . $type . "'";
        }
        global $wpdb;

        $total = 0;
        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            $currentUserOrganizationId = get_user_meta(get_current_user_id(), 'company_id')[0];

            if (in_array('volunteer', $userData->roles) && get_user_meta($user->ID, 'company_id')[0] === $currentUserOrganizationId) {
                $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_volunteer_in_progress wpvip
                                                LEFT JOIN wp_purpozed_opportunities wpo
                                                ON wpvip.opportunity_id = wpo.id 
                                                WHERE user_id = '%d' $andType", $user->ID);
                $total += $wpdb->get_var($query);
            }
        }
        return $total;
    }

    public function getCompanyUsers()
    {
        $users = get_users(array('fields' => array('ID')));

        $companies = $this->getList();
        $companyUsers = array();

        foreach ($companies as $company) {
            foreach ($users as $user) {
                $userData = get_user_by('ID', $user->ID);
                if ((in_array('volunteer', $userData->roles))) {
                    if (get_user_meta($user->ID, 'company_id')[0] === $company['id']) {
                        $companyUsers[$company['id']][] = $user->ID;
                    }
                }
            }
        }
        return $companyUsers;
    }
}