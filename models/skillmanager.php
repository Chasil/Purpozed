<?php

namespace Purpozed2\Models;

class SkillManager
{

    public function getList()
    {

        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_purpozed_skills ORDER BY name");
    }

    public function getUsersBySkill($skillId, $usersIDs)
    {

        $usersIDsArray = implode(',', $usersIDs);
        global $wpdb;
        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_user_skills WHERE skill_id = %d AND user_id IN ($usersIDsArray)", $skillId);
        return $wpdb->get_results($query);
    }
}