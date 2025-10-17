<?php

namespace Purpozed2\Models;

class OrganizationManager
{

    public function getList($searchedGoals = null): array
    {

        $users = get_users(array('fields' => array('ID')));

        $organizations = array();

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            $userData2 = get_userdata($user->ID);
            if (in_array('organization', $userData->roles)) {
                $organizationData = get_user_meta($user->ID, 'organization_name');
                $organizationName = (isset($organizationData[0])) ? $organizationData[0] : 'No organization name';
                $organizations[] = array(
                    'id' => $user->ID,
                    'organization_name' => $organizationName,
                    'main_goal' => get_user_meta($user->ID, 'main_goal')[0],
                    'logo' => get_user_meta($user->ID, 'logo')[0],
                    'registered' => $userData2->user_registered,
                    'postcode' => get_user_meta($user->ID, 'zip')[0],
                );
            }
        }

        if ($searchedGoals) {
            $filteredOrganizations = array();
            foreach ($organizations as $organization) {
                if (in_array($organization['main_goal'], $searchedGoals)) {
                    $filteredOrganizations[] = $organization;
                }
            }
            $organizations = $filteredOrganizations;
        }

        return $organizations;
    }

    public function countAll()
    {

        return count($this->getList());
    }
}