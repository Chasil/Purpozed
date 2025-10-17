<?php

namespace Purpozed2\Models;

class GoalsManager
{

    public function getList()
    {

        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_purpozed_goals ORDER BY name");
    }

    public function getListAsArray()
    {

        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_purpozed_goals ORDER BY name ASC", ARRAY_A);
    }

    public function getName($id)
    {
        global $wpdb;

        return $wpdb->get_var("SELECT name FROM wp_purpozed_goals WHERE id = $id");
    }
}