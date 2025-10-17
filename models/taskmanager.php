<?php

namespace Purpozed2\Models;

class TaskManager
{

    public function saveProjectTask($data, $type, $isEdition, $taskId = 0)
    {

        global $wpdb;
        unset($data['skills']);
        $data['type'] = $type;

        if ($isEdition) {
            return (bool)$wpdb->update(
                'wp_purpozed_project_tasks',
                $data,
                array(
                    'id' => $taskId
                )
            );
        } else {
            return (bool)$wpdb->insert(
                'wp_purpozed_project_tasks',
                $data
            );
        }
    }

    public function saveProjectSkills($skillsIds, $task_id, $isEdition)
    {

        global $wpdb;

        $errors = array();
        if (empty($skillsIds)) {
            return false;
        }

        if ($isEdition) {
            $saveSkill = $wpdb->delete(
                'wp_purpozed_project_tasks_skills',
                array(
                    'project_task_id' => $task_id
                )
            );
        }
        foreach ($skillsIds as $skillId => $skillValue) {

            $saveSkill = $wpdb->insert(
                'wp_purpozed_project_tasks_skills',
                array(
                    'project_task_id' => $task_id,
                    'skill_id' => $skillId
                )
            );

            if (!$saveSkill) {
                $errors[] = 'false';
            }
        }

        if (in_array('false', $errors)) {
            return false;
        } else {
            return true;
        }
    }

    public function getAllProjectTasks($type, $areaOfExpertise)
    {

        global $wpdb;

        $where = '';
        if (!empty($type)) {
            $where = " WHERE wppt.type = '$type'";
        }
        if (!empty($areaOfExpertise)) {
            $where = " WHERE wppt.area_of_expertise = '$areaOfExpertise'";
        }

        $allTasks = $wpdb->get_results("SELECT wppt.*, wppts.skill_id, wps.id skill_id, wps.name skill_name, wpaoe.name as aoe_name 
                                            FROM wp_purpozed_project_tasks wppt 
                                            LEFT JOIN wp_purpozed_project_tasks_skills wppts ON wppt.id = wppts.project_task_id 
                                            LEFT JOIN wp_purpozed_skills wps ON wppts.skill_id = wps.id
                                            LEFT JOIN wp_purpozed_areas_of_expertise wpaoe ON wppt.area_of_expertise = wpaoe.id $where");

        $parsedTasks = array();
        foreach ($allTasks as $task) {

            if (!isset($parsedTasks[$task->id])) {
                $parsedTasks[$task->id] = $task;
            }

            $newSkills = array(
                'skill_id' => $task->skill_id,
                'skill_name' => $task->skill_name
            );

            if (!isset($parsedTasks[$task->id]->skills)) {
                $parsedTasks[$task->id]->skills = array();
            }
            $parsedTasks[$task->id]->skills[] = $newSkills;
        }

        return $parsedTasks;
    }

    public function getChosenProjectTask($topicId)
    {

        global $wpdb;

        $allTasks = $wpdb->get_results("SELECT wppt.*, wppts.skill_id, wps.id skill_id, wps.name skill_name 
                                            FROM wp_purpozed_project_tasks wppt 
                                            LEFT JOIN wp_purpozed_project_tasks_skills wppts ON wppt.id = wppts.project_task_id 
                                            LEFT JOIN wp_purpozed_skills wps ON wppts.skill_id = wps.id
                                            WHERE wppt.id = $topicId");

        $parsedTasks = array();
        foreach ($allTasks as $task) {

            if (!isset($parsedTasks[$task->id])) {
                $parsedTasks[$task->id] = $task;
            }

            $newSkills = array(
                'skill_id' => $task->skill_id,
                'skill_name' => $task->skill_name
            );

            if (!isset($parsedTasks[$task->id]->skills)) {
                $parsedTasks[$task->id]->skills = array();
            }
            $parsedTasks[$task->id]->skills[] = $newSkills;
        }

        return $parsedTasks;
    }

    public function getTaskSkillsByAreaOfExpertise($areaOfExpertise)
    {
        return $this->getTaskIdByAreaOfExpertise($areaOfExpertise);
    }

    public function getTaskIdByAreaOfExpertise($areaOfExpertiseId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT id FROM wp_purpozed_project_tasks WHERE area_of_expertise = '%d'", $areaOfExpertiseId);

        return $wpdb->get_results($query);
    }

    public function getSkills($taskId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT wps.id, wps.name FROM wp_purpozed_project_tasks_skills wppts
                                        LEFT JOIN wp_purpozed_project_tasks wppt
                                        ON wppt.id = wppts.project_task_id
                                        LEFT JOIN wp_purpozed_skills wps
                                        ON wps.id = wppts.skill_id                                        
                                        WHERE wppt.id = '%d'", $taskId);

        return $wpdb->get_results($query);
    }
}