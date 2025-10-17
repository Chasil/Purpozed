<?php

namespace Purpozed2\Models;

class Company
{

    public function getDetails($companyId = null)
    {
        if (is_null($companyId)) {
            $userCompanyId = get_user_meta(get_current_user_id(), 'company_id')[0];
            $users = get_users(array('fields' => array('ID')));

            foreach ($users as $user) {
                $userData = get_user_by('ID', $user->ID);
                if (in_array('company', $userData->roles)) {
                    $currentCompanyId = get_user_meta($user->ID, 'company_id')[0];

                    if ($currentCompanyId === $userCompanyId) {
                        $companyDetails = get_user_meta($user->ID);
                    }
                }
            }
        } else {
            $companyDetails = get_user_meta($companyId);
        }

        return $companyDetails;
    }

    public function getCompanyIDByKey($companyKey)
    {

        $users = get_users(array('fields' => array('ID')));

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('company', $userData->roles)) {
                $currentCompanyId = get_user_meta($user->ID, 'company_id')[0];

                if ($currentCompanyId === $companyKey) {
                    $companyID = $user->ID;
                }
            }
        }

        return $companyID;
    }

    public function getLinks($companyId = null): array
    {
        global $wpdb;

        $currentUserOrganizationId = $companyId;
        if (is_null($companyId)) {
            $currentUserOrganizationId = get_user_meta(get_current_user_id(), 'company_id')[0];
        }

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_user_links WHERE user_id = '%d'", $currentUserOrganizationId);

        return $wpdb->get_results($query);
    }

    public function getInvitedAmount(): int
    {

        $users = get_users(array('fields' => array('ID')));

        $invitedUsers = 0;

        $companyId = get_user_meta(get_current_user_id(), 'company_id')[0];

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {
                $userCompanyId = get_user_meta($user->ID, 'company_id')[0];
                $isInvited = isset(get_user_meta($user->ID, 'invited')[0]) ? get_user_meta($user->ID, 'invited')[0] : 0;
                if ($isInvited === '1' && $userCompanyId === $companyId) {
                    $invitedUsers++;
                }
            }
        }

        return $invitedUsers;
    }

    public function getInvitedAmountFromCompanySettings()
    {

        $users = get_users(array('fields' => array('ID')));

        $invitedUsers = 0;

        $companyId = get_user_meta(get_current_user_id(), 'company_id')[0];

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('company', $userData->roles)) {
                $userCompanyId = get_user_meta($user->ID, 'company_id')[0];
                if ($userCompanyId === $companyId) {
                    $invitedUsers = (get_user_meta($user->ID, 'invited_users')) ? get_user_meta($user->ID, 'invited_users')[0] : '0';
                }
            }
        }

        return $invitedUsers;
    }

    public function getAllUsersAmount()
    {

        $users = get_users(array('fields' => array('ID')));

        $invitedUsers = 0;

        $companyId = get_user_meta(get_current_user_id(), 'company_id')[0];

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {
                $userCompanyId = get_user_meta($user->ID, 'company_id')[0];

                if ($userCompanyId === $companyId) {
                    $invitedUsers++;
                }
            }
        }

        return $invitedUsers;
    }

    public function getAllUsersIDs()
    {
        $users = get_users(array('fields' => array('ID')));

        $usersIDs = array();

        $companyId = get_user_meta(get_current_user_id(), 'company_id')[0];

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('volunteer', $userData->roles)) {
                $userCompanyId = get_user_meta($user->ID, 'company_id')[0];

                if ($userCompanyId === $companyId) {
                    $usersIDs[] = $user->ID;
                }
            }
        }

        return $usersIDs;
    }

    public function getNameByVolunteer($userId = null)
    {
        $users = get_users(array('fields' => array('ID')));

        if (!$userId) {
            $userId = get_current_user_id();
        }

        $companyId = get_user_meta($userId, 'company_id')[0];

        if ($userId) {
            array_push($users, (object)[
                'ID' => $userId
            ]);
        }

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('company', $userData->roles)) {
                $userCompanyId = get_user_meta($user->ID, 'company_id')[0];

                if ($userCompanyId === $companyId) {
                    $matchedCompany = get_user_by('ID', $user->ID);
                    return get_user_meta($matchedCompany->ID, 'first_name')[0];
                }
            }
        }
    }

    public function getDetailsById($companyId)
    {

        $users = get_users(array('fields' => array('ID')));

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('company', $userData->roles)) {
                $currentCompanyId = get_user_meta($user->ID, 'company_id')[0];

                if ($currentCompanyId === $companyId) {
                    return get_userdata($user->ID);
                }
            }
        }
    }

    public function doesExist($companyId)
    {
        $users = get_users(array('fields' => array('ID')));

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('company', $userData->roles)) {
                $currentCompanyId = get_user_meta($user->ID, 'company_id')[0];

                if ($currentCompanyId === $companyId) {
                    return get_userdata($user->ID);
                }
            }
        }
    }

    public function getDistanceBetweenCompanyAndOrganizations(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit = '')
    {
        $latitudeFrom = $latitudeFrom;
        $longitudeFrom = $longitudeFrom;
        $latitudeTo = $latitudeTo;
        $longitudeTo = $longitudeTo;

        // Calculate distance between latitude and longitude
        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        // Convert unit and return distance
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return round($miles * 1.609344, 2);
        } elseif ($unit == "M") {
            return round($miles * 1609.344, 2);
        } else {
            return round($miles, 2);
        }
    }

    public function getDistances($maxDistance = null)
    {
        $company = new \Purpozed2\Models\Company();
        $postCodeManager = new \Purpozed2\Models\postcodes();
        $orgranizationsManager = new \Purpozed2\Models\OrganizationManager();
        $singleOrganization = new \Purpozed2\Models\Organization();

        $currentUserID = get_current_user_id();
        $currentUserCompanyKey = get_user_meta($currentUserID, 'company_id')[0];
        $currentUserCompanyId = $company->getCompanyIDByKey($currentUserCompanyKey);

        $currentUserCompanyPostCode = $currentCompanyId = get_user_meta($currentUserCompanyId, 'zip')[0];
        $currentUserCompanyCoordinates = $postCodeManager->getCoordinates($currentUserCompanyPostCode);
        $allOrganizations = $orgranizationsManager->getList();

        $distances = array();

        foreach ($allOrganizations as $organization) {

            $currentOrganizationCoordinates = $postCodeManager->getCoordinates($organization['postcode']);
            $distance = $company->getDistanceBetweenCompanyAndOrganizations($currentUserCompanyCoordinates->lat, $currentUserCompanyCoordinates->lon, $currentOrganizationCoordinates->lat, $currentOrganizationCoordinates->lon, 'K');
            $hasOrganizationOpenOpportunities = $singleOrganization->openOpportunities($organization['id']);

            $distanceLimit = 200;
            if ($maxDistance !== null) {
                $distanceLimit = (int)max($maxDistance);
            }

            if ($distance <= $distanceLimit && $distance > 0 && $hasOrganizationOpenOpportunities !== '0') {
                $organizationsIDs[] = $organization['id'];
            }

            if ($distance <= 200 && $distance > 0 && $hasOrganizationOpenOpportunities !== '0') {
                $distances[] = ceil($distance / 10) * 10;
            }

            array_push($distances, 200);
        }

        $distancesList = array_unique($distances);
        arsort($distancesList);
        $distancesList = array_values($distancesList);

        $distancesItems['distancesList'] = $distancesList;
        $distancesItems['organizationsIDs'] = $organizationsIDs;

        return $distancesItems;
    }
}