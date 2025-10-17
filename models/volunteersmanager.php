<?php

namespace Purpozed2\Models;

class VolunteersManager
{

    public function getCurrentUser($userId = null): \Purpozed2\Models\Volunteer
    {
        if (is_null($userId)) {
            $userId = get_current_user_id();
        }
        return new \Purpozed2\Models\Volunteer($userId);
    }

    public function getColleagues($currentCompanyId)
    {

        $users = get_users(array('fields' => array('ID')));

        $companyUsers = array();

        $userCompanyId = 0;

        $company = new \Purpozed2\Models\Company();
        $companyName = $company->getNameByVolunteer(get_current_user_id());

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles) && ((int)$user->ID !== get_current_user_id())) {
                $lastLogin = isset(get_user_meta($user->ID, 'last_login')[0]) ? time() - get_user_meta($user->ID, 'last_login')[0] : 0;

                $companyUsers[] = array(
                    'first_name' => get_user_meta($user->ID, 'first_name')[0],
                    'last_name' => get_user_meta($user->ID, 'last_name')[0],
                    'title' => get_user_meta($user->ID, 'title')[0],
                    'company' => $companyName,
                    'last_login_seconds' => $lastLogin,
                );
            }
        }
        return $companyUsers;
    }

    public function getList()
    {
        $users = get_users(array('fields' => array('ID')));

        $volunteers = array();

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {
                $currentUserCompanyId = get_user_meta($user->ID, 'company_id')[0];
                $companyName = (get_user_meta((int)$currentUserCompanyId, 'first_name')) ? get_user_meta((int)$currentUserCompanyId, 'first_name')[0] : 'No company connected';

                $volunteers[] = array(
                    'id' => $user->ID,
                    'first_name' => get_user_meta($user->ID, 'first_name')[0],
                    'last_name' => get_user_meta($user->ID, 'last_name')[0],
                    'title' => get_user_meta($user->ID, 'title')[0],
                    'organization' => $companyName,
                );
            }
        }
        return $volunteers;
    }

    public function countAll()
    {

        return count($this->getList());
    }

    public function getAppliedByOrganization($organizationId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_volunteer_applied wpva
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpva.opportunity_id
                                        WHERE wpo.organization_id = '%d'", $organizationId);

        return $wpdb->get_results($query);
    }

    public function getListByCompany(): array
    {
        $users = get_users(array('fields' => array('ID')));

        $companyUsers = array();

        $companyId = get_user_meta(get_current_user_id(), 'company_id')[0];

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {
                if (get_user_meta($user->ID, 'company_id')[0] !== NULL) {
                    if (get_user_meta($user->ID, 'company_id')[0] === $companyId) {
                        $img = (get_user_meta($user->ID, 'image')) ? get_user_meta($user->ID, 'image')[0] : '';
                        $companyUsers[] = array(
                            'id' => $user->ID,
                            'first_name' => get_user_meta($user->ID, 'first_name')[0],
                            'last_name' => get_user_meta($user->ID, 'last_name')[0],
                            'title' => get_user_meta($user->ID, 'title')[0],
                            'image' => $img
                        );
                    }
                }
            }
        }
        return $companyUsers;
    }

    public function activeEmployeesAmount(): int
    {

        $users = get_users(array('fields' => array('ID')));
        $companyId = get_user_meta(get_current_user_id(), 'company_id')[0];

        $activeUsers = 0;

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {
                if (get_user_meta($user->ID, 'company_id')[0] === $companyId) {

                    $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
                    $inProgress = $opportunitiesManager->getInProgress($user->ID);

                    $wasUserLoggedLastMonth = $this->userLoggedPreviousMonth($user->ID);

                    if ($wasUserLoggedLastMonth === '1' || $inProgress) {
                        $activeUsers++;
                    }
                }
            }
        }
        return $activeUsers;

    }

    public function engagedEmplyeesAmount(): int
    {

        $users = get_users(array('fields' => array('ID')));
        $companyId = get_user_meta(get_current_user_id(), 'company_id')[0];

        $engagedUnsers = 0;

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {
                if (get_user_meta($user->ID, 'company_id')[0] === $companyId) {

                    $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
                    $inProgress = $opportunitiesManager->getInProgress($user->ID);
                    $completed = $opportunitiesManager->getCompleted($user->ID);

                    if (!empty($completed)) {
                        $count = 0;
                        foreach ($completed as $complete) {
                            if ($count < 1) {
                                if (strtotime($complete->posted) >= time() - (60 * 60 * 24 * 30 * 12)) {
                                    $engagedUnsers++;
                                }
                                $count++;
                            }
                        }
                    } elseif (count($inProgress) !== 0) {
                        $engagedUnsers++;
                    }
                }
            }
        }

        return $engagedUnsers;
    }

    public function userLoggedPreviousMonth($userId)
    {
        global $wpdb;

        return $wpdb->get_var("SELECT COUNT(DISTINCT user_id) FROM wp_purpozed_logins WHERE YEAR(login_date) = YEAR(CURRENT_DATE  - INTERVAL 1 MONTH) AND MONTH(login_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND user_id = $userId");
    }

    public function allLogins($currentYear, $currentMonth, $companyUsersIDs)
    {
        global $wpdb;

        $endDate = $currentYear . '-' . $currentMonth . '-01';
        $startDate = date("Y-m-d", strtotime("-12 months"));

        $usersIDs = (implode(',', $companyUsersIDs));

        return $wpdb->get_results("SELECT COUNT(DISTINCT user_id) AS 'Users', DATE_FORMAT(login_date, '%b') AS 'Month' FROM wp_purpozed_logins WHERE (login_date BETWEEN '$startDate' AND '$endDate') AND user_id IN ($usersIDs) GROUP BY YEAR(login_date), MONTH(login_date)", ARRAY_A);
    }

    public function getEngagedUsers($currentYear, $currentMonth, $companyUsersIDs)
    {
        global $wpdb;

        $endDate = $currentYear . '-' . $currentMonth . '-01';
        $startDate = date("Y-m-d", strtotime("-12 months"));

        $usersIDs = (implode(',', $companyUsersIDs));

        return $wpdb->get_results("SELECT COUNT(DISTINCT user_id) AS 'Users', DATE_FORMAT(engaged_date, '%b') AS 'Month' FROM wp_purpozed_engaged_users WHERE (engaged_date BETWEEN '$startDate' AND '$endDate') AND user_id IN ($usersIDs) GROUP BY YEAR(engaged_date), MONTH(engaged_date)", ARRAY_A);
    }

    public function getAllVolunteers()
    {
        $users = get_users(array('fields' => array('ID')));

        $allUsers = array();

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {
                $allUsers[] = $user->ID;
            }
        }

        return $allUsers;
    }

}