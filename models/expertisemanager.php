<?php

namespace Purpozed2\Models;

class ExpertiseManager
{

    public function getList()
    {

        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_purpozed_areas_of_expertise");
    }

    public function getCallList()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT wpaof.id as aoe_id, wpaof.name as aoe_name  
                                            FROM wp_purpozed_areas_of_expertise wpaof 
                                            LEFT JOIN wp_purpozed_project_tasks wppt ON wpaof.id = wppt.area_of_expertise 
                                            WHERE wppt.type = 'call' GROUP BY wpaof.id ORDER BY wpaof.name");
    }

    public function getFirstCall()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT wpaof.id as aoe_id  
                                            FROM wp_purpozed_areas_of_expertise wpaof 
                                            LEFT JOIN wp_purpozed_project_tasks wppt ON wpaof.id = wppt.area_of_expertise 
                                            WHERE wppt.type = 'call' GROUP BY wpaof.id ORDER BY wpaof.name LIMIT 1");
    }

    public function getCallTopicList($id)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT wppt.id as call_id, wppt.name as call_name, wppt.description as call_description  
                                            FROM wp_purpozed_project_tasks wppt 
                                            LEFT JOIN wp_purpozed_areas_of_expertise wpaof ON wpaof.id = wppt.area_of_expertise 
                                            WHERE wppt.type = 'call' AND wpaof.id = $id");
    }

    public function getCurrentTopicDescription($topic_id)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT wppt.description as call_description  
                                            FROM wp_purpozed_project_tasks wppt 
                                            WHERE wppt.id = $topic_id");
    }

    public function getProjectTasksList($id)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT wppt.id as task_id, wppt.name as task_name, wppt.description as task_description 
                                            FROM wp_purpozed_project_tasks wppt 
                                            LEFT JOIN wp_purpozed_areas_of_expertise wpaof ON wpaof.id = wppt.area_of_expertise 
                                            WHERE wppt.type = 'project' AND wpaof.id = $id");
    }

    public function getAreaOfExpertises()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_purpozed_areas_of_expertise wpaof");
    }

    public function getAreaOfExpertiseById($id)
    {
        global $wpdb;
        return $wpdb->get_row("SELECT * FROM wp_purpozed_areas_of_expertise wpaof WHERE id=$id");
    }
}