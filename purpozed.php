<?php
/*
Plugin Name: Purpozed
Plugin URI: https://proformat.pl
Description: Purpozed
Version: 1.0
Author: Mateusz Wójcik
Author URI: https://proformat.pl
License: GPLv2 or later
Text Domain: purpozed
Domain Path: /languages
*/

namespace Purpozed2;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Purpozed
{

    private $router;

    public function __construct()
    {
        require 'autoload.php';
        $this->router = new Router();
        $this->registerHooks();
    }

    public function registerHooks()
    {
        add_filter('lostpassword_url', array($this, 'wdm_lostpassword_url'), 10, 0);
        add_action('init', array($this, 'addCustomRoles'));
//        add_action('wp_login', array($this, 'lastTimeLogin'));
        add_action('wp_enqueue_scripts', array($this, 'scripts'));
        add_action('after_setup_theme', array($this, 'removeAdminBar'));
        add_action('admin_enqueue_scripts', array($this, 'adminScripts'));
        add_action('admin_menu', array($this, 'adminMenu'));
        add_action('admin_menu', array($this, 'adminSettingsMenu'));
        add_action('wp_ajax_saveItemEdit', array($this, 'saveItemEdit'));
        add_action('wp_ajax_nopriv_saveItemEdit', array($this, 'saveItemEdit'));
        add_action('wp_ajax_loadImage', array($this, 'loadImage'));
        add_action('wp_ajax_nopriv_loadImage', array($this, 'loadImage'));
        add_action('wp_ajax_activateOpportunity', array($this, 'activateOpportunity'));
        add_action('wp_ajax_nopriv_activateOpportunity', array($this, 'activateOpportunity'));

        add_action('wp_ajax_loadTopics', array('\Purpozed2\Controllers\PostOpportunity', 'loadTopics'));
        add_action('wp_ajax_nopriv_loadTopics', array('\Purpozed2\Controllers\PostOpportunity', 'loadTopics'));

        add_action('wp_ajax_loadTopicDescription', array('\Purpozed2\Controllers\PostOpportunity', 'loadTopicDescription'));
        add_action('wp_ajax_nopriv_loadTopicDescription', array('\Purpozed2\Controllers\PostOpportunity', 'loadTopicDescription'));

        add_action('wp_ajax_loadProjectTasks', array('\Purpozed2\Controllers\PostOpportunity', 'loadProjectTasks'));
        add_action('wp_ajax_nopriv_loadProjectTasks', array('\Purpozed2\Controllers\PostOpportunity', 'loadProjectTasks'));

        add_action('wp_ajax_getTopicDetails', array('\Purpozed2\Controllers\PostOpportunity', 'getTopicDetails'));
        add_action('wp_ajax_nopriv_getTopicDetails', array('\Purpozed2\Controllers\PostOpportunity', 'getTopicDetails'));

        add_action('wp_ajax_applyToOpportunity', array('\Purpozed2\Controllers\Opportunity', 'applyToOpportunity'));
        add_action('wp_ajax_nopriv_applyToOpportunity', array('\Purpozed2\Controllers\Opportunity', 'applyToOpportunity'));

        add_action('wp_ajax_signVolunteerToOpportunity', array('\Purpozed2\Controllers\Opportunity', 'signVolunteerToOpportunity'));
        add_action('wp_ajax_nopriv_signVolunteerToOpportunity', array('\Purpozed2\Controllers\Opportunity', 'signVolunteerToOpportunity'));

        add_action('wp_ajax_addBookmarkedOpportunity', array('\Purpozed2\Controllers\Opportunity', 'addBookmarkedOpportunity'));
        add_action('wp_ajax_nopriv_addBookmarkedOpportunity', array('\Purpozed2\Controllers\Opportunity', 'addBookmarkedOpportunity'));

        add_action('wp_ajax_evaluateOpportunityVolunteer', array('\Purpozed2\Controllers\Opportunity', 'evaluateOpportunityVolunteer'));
        add_action('wp_ajax_nopriv_evaluateOpportunityVolunteer', array('\Purpozed2\Controllers\Opportunity', 'evaluateOpportunityVolunteer'));

        add_action('wp_ajax_retractOpportunity', array('\Purpozed2\Controllers\Opportunity', 'retractOpportunity'));
        add_action('wp_ajax_nopriv_retractOpportunity', array('\Purpozed2\Controllers\Opportunity', 'retractOpportunity'));

        add_action('wp_ajax_rejectVolunteer', array('\Purpozed2\Controllers\ManageOpportunity', 'rejectVolunteer'));
        add_action('wp_ajax_nopriv_rejectVolunteer', array('\Purpozed2\Controllers\ManageOpportunity', 'rejectVolunteer'));

        add_action('wp_ajax_deleteOpportunity', array('\Purpozed2\Controllers\Opportunity', 'deleteOpportunity'));
        add_action('wp_ajax_nopriv_deleteOpportunity', array('\Purpozed2\Controllers\Opportunity', 'deleteOpportunity'));

        add_action('wp_ajax_requestVolunteerToOpportunity', array('\Purpozed2\Controllers\Opportunity', 'requestVolunteerToOpportunity'));
        add_action('wp_ajax_nopriv_requestVolunteerToOpportunity', array('\Purpozed2\Controllers\Opportunity', 'requestVolunteerToOpportunity'));

        add_action('wp_ajax_retractVolunteer', array('\Purpozed2\Controllers\Opportunity', 'retractVolunteer'));
        add_action('wp_ajax_nopriv_retractVolunteer', array('\Purpozed2\Controllers\Opportunity', 'retractVolunteer'));

        add_action('wp_ajax_removeFromTheList', array('\Purpozed2\Controllers\Opportunity', 'removeFromTheList'));
        add_action('wp_ajax_nopriv_removeFromTheList', array('\Purpozed2\Controllers\Opportunity', 'removeFromTheList'));

        add_action('wp_ajax_removeApplication', array('\Purpozed2\Controllers\Opportunity', 'removeApplication'));
        add_action('wp_ajax_nopriv_removeApplication', array('\Purpozed2\Controllers\Opportunity', 'removeApplication'));

        add_action('wp_ajax_closeEngagement', array('\Purpozed2\Controllers\Opportunity', 'closeEngagement'));
        add_action('wp_ajax_nopriv_closeEngagement', array('\Purpozed2\Controllers\Opportunity', 'closeEngagement'));

        add_action('wp_ajax_remindOrganizationAboutEvaluation', array('\Purpozed2\Controllers\Opportunity', 'remindOrganizationAboutEvaluation'));
        add_action('wp_ajax_nopriv_remindOrganizationAboutEvaluation', array('\Purpozed2\Controllers\Opportunity', 'remindOrganizationAboutEvaluation'));

        add_action('wp_ajax_getDistances', array('\Purpozed2\Controllers\FindOpportunity', 'getDistances'));
        add_action('wp_ajax_nopriv_getDistances', array('\Purpozed2\Controllers\FindOpportunity', 'getDistances'));

        add_action('wp_ajax_deleteUserAccount', array('\Purpozed2\Controllers\VolunteerSettings', 'deleteUserAccount'));
        add_action('wp_ajax_nopriv_deleteUserAccount', array('\Purpozed2\Controllers\VolunteerSettings', 'deleteUserAccount'));

        add_action('wp_ajax_deleteOpportunityAdmin', array($this, 'deleteOpportunityAdmin'));
        add_action('wp_ajax_nopriv_deleteOpportunityAdmin', array($this, 'deleteOpportunityAdmin'));

        add_action('wp_ajax_nopriv_cron', array($this, 'cronExpired'));

        add_action('admin_enqueue_scripts', function () {
            if (is_admin())
                wp_enqueue_media();
        });
    }

    public function cronExpired()
    {
        var_dump(23432);
    }

    public function addCustomRoles()
    {
        add_role('volunteer', 'Valunteer');
        add_role('organization', 'Organization');
        add_role('company', 'Company');
        add_role('deactivated', 'Deactivated');
    }

    public function removeAdminBar()
    {
        if (!current_user_can('administrator') && !is_admin()) {
            show_admin_bar(false);
        }
    }

    public function lastTimeLogin()
    {
        update_user_meta(get_current_user_id(), 'last_login', time());
    }

    public function adminMenu()
    {
        add_menu_page('Purpozed', 'Purpozed', 'manage_options', 'dashboard', array($this, 'adminPanel'), 'dashicons-calendar-alt');
        add_submenu_page('dashboard', 'Mapping', 'Mapping', 'manage_options', 'mapping', array($this, 'mapping'));
        add_submenu_page('mapping', 'Area of expertise', 'Area of expertise', 'manage_options', 'areas-of-expertise', array($this, 'areasOfExpertise'));
        add_submenu_page('mapping', 'Project tasks', 'Project tasks', 'manage_options', 'project-tasks', array($this, 'projectTasks'));
        add_submenu_page('mapping', 'Skills', 'Skills', 'manage_options', 'skills', array($this, 'skills'));
        add_submenu_page('mapping', 'Call focuses', 'Call focuses', 'manage_options', 'call-focuses', array($this, 'callFocuses'));
        add_submenu_page('mapping', 'Project Task', 'Project Task', 'manage_options', 'project-task', array($this, 'projectTask'));
        add_submenu_page('mapping', 'Call Topic', 'Call Topic', 'manage_options', 'call-topic', array($this, 'callTopic'));
        add_submenu_page('mapping', 'Goals', 'Goals', 'manage_options', 'goals', array($this, 'goals'));

        add_submenu_page('dashboard', 'Opportunities', 'Opportunities', 'manage_options', 'opportunities', array($this, 'opportunities'));
        add_submenu_page('opportunities', 'Edit Opportunity', 'Edit Opportunity', 'manage_options', 'edit-opportunity', array($this, 'editOpportunity'));

        add_submenu_page('dashboard', 'Users', 'Users', 'manage_options', 'users-volunteers', array($this, 'usersVolunteers'));
        add_submenu_page('users-volunteers', 'Edit Volunteer', 'Users', 'manage_options', 'edit-volunteer', array($this, 'editVolunteer'));
        add_submenu_page('users-volunteers', 'Organizations', 'Organizations', 'manage_options', 'users-organizations', array($this, 'usersOrganizations'));
        add_submenu_page('users-volunteers', 'Edit Organization', 'Organization', 'manage_options', 'edit-organization', array($this, 'editOrganization'));
        add_submenu_page('users-volunteers', 'Companies', 'Companies', 'manage_options', 'users-companies', array($this, 'usersCompanies'));
        add_submenu_page('users-volunteers', 'Edit Company', 'Company', 'manage_options', 'edit-company', array($this, 'editCompany'));

        add_submenu_page('dashboard', 'Statistics', 'Statistics', 'manage_options', 'statistics', array($this, 'statistics'));

        add_submenu_page('dashboard', 'Settings', 'Settings', 'manage_options', 'main-settings', array($this, 'mainSettings'));

    }

    public function adminPanel()
    {
        require(dirname(__FILE__) . '/views/admin/dashboard.php');
    }

    public function adminSettingsMenu()
    {
        add_menu_page('Purpozed Settings', 'Purpozed Settings', 'manage_options', 'purpozed-settings', array($this, 'adminSettingsPanel'));
    }

    public function adminSettingsPanel()
    {
        if (isset($_POST['save_menus'])) {
            foreach ($_POST as $menuKey => $value) {
                update_option('purpozed_' . $menuKey, $value);
            }
        }

        if (isset($_POST['save_footers'])) {
            foreach ($_POST as $menuKey => $value) {
                update_option('purpozed_' . $menuKey, $value);
                update_option('purpozed_' . $menuKey, $value);
            }
        }

        require(dirname(__FILE__) . '/views/admin/settings.php');
    }

    public function mapping()
    {
        require(dirname(__FILE__) . '/views/admin/mapping.php');
    }

    public function opportunities()
    {

        $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
        $statuses = $opportunityManager->getStatuses();

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $goals = $goalsManager->getList();

        $skillsManager = new \Purpozed2\Models\SkillManager();
        $skills = $skillsManager->getList();

        $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();

        $allOpportunitiesNumber = $opportunitiesManager->countAll();

        $searchedStatuses = (isset($_GET['statuses'])) ? $_GET['statuses'] : null;
        $searchedFormats = (isset($_GET['formats'])) ? $_GET['formats'] : null;
        $searchedGoals = (isset($_GET['goals'])) ? $_GET['goals'] : null;
        $searchedSkills = (isset($_GET['skills'])) ? $_GET['skills'] : null;
        $searchedDuration = (isset($_GET['durations'])) ? $_GET['durations'] : null;
        $opportunities = $opportunitiesManager->getList(null, $searchedStatuses, $searchedFormats, $searchedGoals, $searchedSkills, $searchedDuration);

        $opportunities = $opportunitiesManager->sort($opportunities);

        $singleOpportunity = new \Purpozed2\Models\Opportunity();

        foreach ($opportunities as $opportunity) {
            $opportunity->applied3plus = $singleOpportunity->getApplied3Plus($opportunity->id);
            $opportunity->requested3plus = $singleOpportunity->getRequested3Plus($opportunity->id);
            $opportunity->engagedSince = $singleOpportunity->engagementsLongerEngaged($opportunity->id);
        }

        $currentOpportunitiesNumber = count($opportunities);

        $statusesTypes = array(
            'prepared' => 'prepared',
            'review' => 'review',
            'deleted' => 'deleted',
            'open' => 'open',
            'retracted' => 'retracted',
            'expired' => 'expired',
            'in_progress' => 'in_progress',
            'succeeded' => 'succeeded',
            'canceled' => 'canceled'
        );

        require(dirname(__FILE__) . '/views/admin/opportunities.php');
    }

    public function mainSettings()
    {
        if (isset($_POST['save-main-settings'])) {
            update_option('max_number_of_opportunities_a_volunteer_can_apply_same_time', $_POST['max_number_of_opportunities_a_volunteer_can_apply_same_time']);
            update_option('max_number_of_opportunities_a_volunteer_can_be_requested', $_POST['max_number_of_opportunities_a_volunteer_can_be_requested']);
            update_option('max_number_of_opportunities_a_volunteer_can_work_on_same_time', $_POST['max_number_of_opportunities_a_volunteer_can_work_on_same_time']);
            update_option('max_number_of_volunteers_a_organization_can_request_same_time_in_total', $_POST['max_number_of_volunteers_a_organization_can_request_same_time_in_total']);
            update_option('max_number_of_volunteers_a_organization_can_request_same_time_for_specyfic_opportunity', $_POST['max_number_of_volunteers_a_organization_can_request_same_time_for_specyfic_opportunity']);
            update_option('max_number_of_opportunities_of_an_organization', $_POST['max_number_of_opportunities_of_an_organization']);
        }

        $max_number_of_opportunities_a_volunteer_can_apply_same_time = (get_option('max_number_of_opportunities_a_volunteer_can_apply_same_time')) ? get_option('max_number_of_opportunities_a_volunteer_can_apply_same_time') : 0;
        $max_number_of_opportunities_a_volunteer_can_be_requested = (get_option('max_number_of_opportunities_a_volunteer_can_be_requested')) ? get_option('max_number_of_opportunities_a_volunteer_can_be_requested') : 0;
        $max_number_of_opportunities_a_volunteer_can_work_on_same_time = (get_option('max_number_of_opportunities_a_volunteer_can_work_on_same_time')) ? get_option('max_number_of_opportunities_a_volunteer_can_work_on_same_time') : 0;
        $max_number_of_volunteers_a_organization_can_request_same_time_in_total = (get_option('max_number_of_volunteers_a_organization_can_request_same_time_in_total')) ? get_option('max_number_of_volunteers_a_organization_can_request_same_time_in_total') : 0;
        $max_number_of_volunteers_a_organization_can_request_same_time_for_specyfic_opportunity = (get_option('max_number_of_volunteers_a_organization_can_request_same_time_for_specyfic_opportunity')) ? get_option('max_number_of_volunteers_a_organization_can_request_same_time_for_specyfic_opportunity') : 0;
        $max_number_of_opportunities_of_an_organization = (get_option('max_number_of_opportunities_of_an_organization')) ? get_option('max_number_of_opportunities_of_an_organization') : 0;

        require(dirname(__FILE__) . '/views/admin/main-settings.php');
    }

    public function editOpportunity()
    {
        if (isset($_POST['post']) || isset($_POST['save'])) {
            $taskSave = $this->postOpportunity();
        }

        if (isset($_POST['save_image'])) {

            $imageID = $_POST['image_id'];
            $opportunityID = $_POST['opportunity_id'];

            global $wpdb;
            $wpdb->update('wp_purpozed_opportunities',
                array(
                    'image' => $imageID,
                    'image_caption' => $_POST['caption']
                ),
                array(
                    'id' => $opportunityID
                ),
                array(
                    '%d',
                    '%s'
                ));
        }

        $hasId = true;
        if (!isset($_GET['id'])) {
            $hasId = false;
        } else {

            $statusesTypes = array(
                'prepared' => 'prepared',
                'review' => 'review',
                'deleted' => 'deleted',
                'open' => 'open',
                'retracted' => 'retracted',
                'expired' => 'expired',
                'in_progress' => 'in_progress',
                'succeeded' => 'succeeded',
                'canceled' => 'canceled'
            );

            $opportunityId = $_GET['id'];
            $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();

            $singleOpportunity = new \Purpozed2\Models\Opportunity();
            $organization = new \Purpozed2\Models\Organization();
            $expertiseManager = new \Purpozed2\Models\ExpertiseManager();

            $task_type = $opportunityManager->getType($opportunityId);
            $organizationId = $singleOpportunity->getOrganization($opportunityId);
            $organizationDetails = $organization->getDetailsById($organizationId);
            $opportunityStatus = $singleOpportunity->getStatus($opportunityId);

            if ($task_type === 'call') {
                $focusManager = new \Purpozed2\Models\FocusManager();
                $focuses = $focusManager->getList();
                $opportunity = $opportunityManager->getSingleCall($opportunityId);
                $topic = $opportunityManager->getTopic($opportunity->topic);
                $skills = $opportunityManager->getCallSkills($opportunity->id);

                $focus = $opportunityManager->getFocuses($opportunity->id);
                $areas_of_expertise = $expertiseManager->getAreaOfExpertises();

                $firstCall = $expertiseManager->getFirstCall();
                $call_topics = $expertiseManager->getCallTopicList($firstCall[0]->aoe_id);

                $aoe = $singleOpportunity->getCallAreaOfExpertise($opportunityId);
                $edit_topics = $expertiseManager->getCallTopicList($aoe->id);

            } elseif ($task_type === 'project') {
                $opportunity = $opportunityManager->getSingleProject($opportunityId);

                $firstCall = $expertiseManager->getFirstCall();
                $project_tasks = $expertiseManager->getProjectTasksList($firstCall[0]->aoe_id);
                $skills = $opportunityManager->getProjectSkillsByTask($opportunity->task_id);

                $aoe = $currentAoe = $singleOpportunity->getProjectAreaOfExpertise($opportunityId);
                $edit_tasks = $expertiseManager->getProjectTasksList($currentAoe->id);

                $task = new \Purpozed2\Models\TaskManager();
                $topic = $opportunityManager->getTopic($opportunity->topic);

                $taskData = $task->getChosenProjectTask($opportunity->topic);

//                $task = new \Purpozed2\Models\TaskManager();
//                if (!is_null($opportunity->topic)) {
//                    $topic = $opportunityManager->getTopic($opportunity->topic);
//                    $taskData = $task->getChosenProjectTask($opportunity->topic);
//                }
                $areas_of_expertise = $expertiseManager->getAreaOfExpertises();

            } elseif ($task_type === 'mentoring') {
                $opportunity = $opportunityManager->getSingleMentoring($opportunityId);
                $current_area_of_expertis = $expertiseManager->getAreaOfExpertiseById($opportunity->mentor_area);
                $duration_overall = $opportunity->frequency * $opportunity->duration * $opportunity->time_frame;
                $areas_of_expertise = $expertiseManager->getAreaOfExpertises();

                $frequencies = array(
                    '1.00' => 'Every week',
                    '0.50' => 'Every two weeks',
                    '0.25' => 'Every month'
                );

                $frequency = $frequencies[$opportunity->frequency];

                $timeFrames = array(
                    '12' => '12 weeks',
                    '24' => '24 weeks',
                    '48' => '48 weeks'
                );

                $time_frame = $timeFrames[$opportunity->time_frame];

            } elseif ($task_type === 'engagement') {

                $opportunity = $opportunityManager->getSingleEngagement($opportunityId);
                $duration_overall = $opportunity->frequency * $opportunity->duration * $opportunity->time_frame + $opportunity->training_duration;

                $frequencies = array(
                    '1.00' => 'Every week',
                    '0.50' => 'Every two weeks',
                    '0.25' => 'Every month'
                );

                $frequency = $frequencies[$opportunity->frequency];

                $timeFrames = array(
                    '1' => '1 week',
                    '12' => '12 weeks',
                    '24' => '24 weeks',
                    '48' => '48 weeks'
                );

                $time_frame = $timeFrames[$opportunity->time_frame];

                $durationOfTraining = array(
                    '0' => 'Not needed',
                    '1' => '1 hour',
                    '2' => '2 hours',
                    '3' => '3 hours',
                    '4' => '4 hours',
                    '5' => '5 hours',
                    '6' => '6 hours',
                    '7' => '7 hours',
                    '8' => '8 hours',
                );

                $training_duration = $durationOfTraining[$opportunity->training_duration];
            }
        }


        require(dirname(__FILE__) . '/views/admin/edit-opportunity.php');
    }

    public function postOpportunity()
    {

        $taskType = $_POST['task_type'];

        // TODO WALIDACJA


        $editedOpportunityId = $_GET['id'];

        if ($taskType === 'call') {
            return $this->postCall($editedOpportunityId);
        } elseif ($taskType === 'project') {
            return $this->postProject($editedOpportunityId);
        } elseif ($taskType === 'mentoring') {
            return $this->postMentoring($editedOpportunityId);
        } elseif ($taskType === 'engagement') {
            return $this->postEngagement($editedOpportunityId);
        }

    }

    public function postCall($editedOpportunityId)
    {

        $validPostKeys = array('topic', 'topic_typed', 'goal', 'expire', 'contact_name', 'contact_surname', 'contact_email', 'contact_phone', 'task_type');
        $_POST['expire'] = strtotime($_POST['expire']);
        $taskData = array();
        foreach ($validPostKeys as $validKey) {
            $taskData[$validKey] = (isset($_POST[$validKey])) ? $_POST[$validKey] : '';
        }

        if (!isset($_POST['topic'])) {
            unset($taskData['topic']);
        }

        if (isset($_POST['topic'])) {
            $skillsData = $_POST['skills'];
        }
        $focusesData = $_POST['focus'];

        $taskData['task_id'] = $editedOpportunityId;
        unset($taskData['task_type']);

        global $wpdb;

        unset($taskData['task_id']);

        $wpdb->update(
            'wp_purpozed_opportunities_call',
            $taskData,
            array(
                'task_id' => $editedOpportunityId
            )
        );

        $singleOpportunity = new \Purpozed2\Models\Opportunity();
        $callId = $singleOpportunity->getCallIdByOpportunityId($editedOpportunityId);

        if (isset($_POST['topic'])) {
            $wpdb->delete(
                'wp_purpozed_opportunities_call_skills',
                array(
                    'call_id' => $callId
                )
            );
        }

        if (isset($_POST['topic'])) {
            foreach ($skillsData as $key => $skillId) {
                $wpdb->insert(
                    'wp_purpozed_opportunities_call_skills',
                    array(
                        'call_id' => $callId,
                        'skill_id' => $skillId
                    )
                );
            }
        }

        $wpdb->delete(
            'wp_purpozed_opportunities_call_focuses',
            array(
                'call_id' => $callId,
            )
        );

        foreach ($focusesData as $key => $focusId) {
            $wpdb->insert(
                'wp_purpozed_opportunities_call_focuses',
                array(
                    'call_id' => $callId,
                    'focus_id' => $focusId
                )
            );
        }

        return true;
    }

    public function postProject($editedOpportunityId)
    {
        $validPostKeys = array('topic', 'task_typed', 'benefits', 'details', 'expire', 'contact_name', 'contact_surname', 'contact_email', 'contact_phone', 'task_type');
        $_POST['expire'] = strtotime($_POST['expire']);
        $taskData = array();
        foreach ($validPostKeys as $validKey) {
            $taskData[$validKey] = (isset($_POST[$validKey])) ? $_POST[$validKey] : '';
        }

        if (!isset($_POST['topic'])) {
            unset($taskData['topic']);
        }

        $taskData['task_id'] = $editedOpportunityId;
        unset($taskData['task_type']);

        global $wpdb;

        unset($taskData['task_id']);
        $wpdb->update(
            'wp_purpozed_opportunities_project',
            $taskData,
            array(
                'task_id' => $editedOpportunityId
            )
        );

        return true;

    }

    public function postMentoring($editedOpportunityId)
    {

        $validPostKeys = array('mentor_area', 'expectations', 'frequency', 'duration', 'time_frame', 'expire', 'contact_name', 'contact_surname', 'contact_email', 'contact_phone', 'task_type');
        $_POST['expire'] = strtotime($_POST['expire']);
        $taskData = array();
        foreach ($validPostKeys as $validKey) {
            $taskData[$validKey] = (isset($_POST[$validKey])) ? $_POST[$validKey] : '';
        }

        $taskData['task_id'] = $editedOpportunityId;
        unset($taskData['task_type']);

        global $wpdb;

        unset($taskData['task_id']);
        $wpdb->update(
            'wp_purpozed_opportunities_mentoring',
            $taskData,
            array(
                'task_id' => $editedOpportunityId
            )
        );

        return true;
    }

    public function postEngagement($editedOpportunityId)
    {

        $validPostKeys = array('title', 'why', 'task', 'requirements', 'frequency', 'duration', 'time_frame', 'training_duration', 'expire', 'volunteers_needed', 'contact_name', 'contact_surname', 'contact_email', 'contact_phone', 'task_type');
        $_POST['expire'] = strtotime($_POST['expire']);
        $taskData = array();
        foreach ($validPostKeys as $validKey) {
            $taskData[$validKey] = (isset($_POST[$validKey])) ? $_POST[$validKey] : '';
        }

        $taskData['task_id'] = $editedOpportunityId;
        unset($taskData['task_type']);

        global $wpdb;

        unset($taskData['task_id']);
        $wpdb->update(
            'wp_purpozed_opportunities_engagement',
            $taskData,
            array(
                'task_id' => $editedOpportunityId
            )
        );

        return true;
    }

    public function usersVolunteers()
    {

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $goals = $goalsManager->getList();

        $skillsManager = new \Purpozed2\Models\SkillManager();
        $skills = $skillsManager->getList();

        $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();

        $companyManager = new \Purpozed2\Models\CompaniesManager();
        $companies = $companyManager->getList();

        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $volunteers = $volunteersManager->getList();

        $allVolunteersNumber = $volunteersManager->countAll();

        $searchedStatuses = (isset($_GET['statuses'])) ? $_GET['statuses'] : null;
        $searchedFormats = (isset($_GET['formats'])) ? $_GET['formats'] : null;
        $searchedGoals = (isset($_GET['goals'])) ? $_GET['goals'] : null;
        $searchedSkills = (isset($_GET['skills'])) ? $_GET['skills'] : null;
        $searchedDuration = (isset($_GET['durations'])) ? $_GET['durations'] : null;
        $opportunities = $opportunitiesManager->getList(null, $searchedStatuses, $searchedFormats, $searchedGoals, $searchedSkills, $searchedDuration);

        $currentVolunteersNumber = count($volunteers);

        require(dirname(__FILE__) . '/views/admin/users.php');
    }

    public function editVolunteer()
    {

        $userId = '';
        $userError = false;
        if (!isset($_GET['id'])) {
            $userError = true;
        } else {
            $userId = $_GET['id'];
        }

        if (isset($_POST['submit'])) {
            if (isset($_POST['admin_rights'])) {
                update_user_meta($userId, 'is_admin', true);
            } else {
                update_user_meta($userId, 'is_admin', false);
            }
            if (isset($_POST['invited'])) {
                update_user_meta($userId, 'invited', true);
            } else {
                update_user_meta($userId, 'invited', false);
            }
        }

        $isAdmin = isset(get_user_meta($userId, 'is_admin')[0]) ? get_user_meta($userId, 'is_admin')[0] : 0;
        $invited = isset(get_user_meta($userId, 'invited')[0]) ? get_user_meta($userId, 'invited')[0] : 0;

        require(dirname(__FILE__) . '/views/admin/users/editVolunteer.php');
    }

    public function usersOrganizations()
    {

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $goals = $goalsManager->getList();

        $organizationsManager = new \Purpozed2\Models\OrganizationManager();
        $searchedGoals = (isset($_POST['goals'])) ? $_POST['goals'] : null;

        $organizations = $organizationsManager->getList($searchedGoals);

        $allOrganizationsNumber = $organizationsManager->countAll();

        $currentOrganizationsNumber = count($organizations);

        require(dirname(__FILE__) . '/views/admin/usersOrganizations.php');
    }

    public function editOrganization()
    {

        $userId = '';
        $userError = false;
        if (!isset($_GET['id'])) {
            $userError = true;
        } else {
            $userId = $_GET['id'];
        }

        require(dirname(__FILE__) . '/views/admin/users/editOrganization.php');
    }

    public function usersCompanies()
    {

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $goals = $goalsManager->getList();

        $companiesManager = new \Purpozed2\Models\CompaniesManager();
        $searchedGoals = (isset($_POST['goals'])) ? $_POST['goals'] : null;

        $allCompaniesNumber = $companiesManager->countAll();
        $companies = $companiesManager->getList($searchedGoals);
        $currentCompaniesNumber = count($companies);
        $companyUsers = $companiesManager->getCompanyUsers();

        require(dirname(__FILE__) . '/views/admin/usersCompanies.php');
    }

    public function editCompany()
    {

        $userId = '';
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
        }

        if (isset($_POST['submit'])) {

            $existedUser = null;
            if (!empty($userId)) {
                $existedUser = $userId;
            }

            $logoId = '';
            if (!empty($_FILES) && $_FILES['image']['size'] !== 0) {
                $registerOrganization = new \Purpozed2\Controllers\RegisterOrganization();
                $logoId = $registerOrganization->uploadLogo($_FILES);
            }

            $volunteerManager = new \Purpozed2\Models\VolunteersManager();
            $returnData = $volunteerManager->getCurrentUser()->saveCompanySettings($logoId, $existedUser);
        }

        if (!empty($userId)) {

            $company = new \Purpozed2\Models\Company();

            $details = $company->getDetails($userId);
            $links = $company->getLinks($userId);

            $userData = get_userdata($userId);
            $email = '';
            if ($userId) {
                $email = $userData->data->user_email;
            }
        }

        require(dirname(__FILE__) . '/views/admin/users/editCompany.php');
    }

    public function statistics()
    {
        $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $skillsManager = new \Purpozed2\Models\SkillManager();
        $employees = $volunteersManager->getListByCompany();

        $allUsersIDs = $volunteersManager->getAllVolunteers();

//        $goalsManager = new \Purpozed2\Models\GoalsManager();
//        $goalArray = $goalsManager->getListAsArray();
//        usort($goalArray, array($this, 'sort_names'));

//        foreach ($goalArray as $key => $singleGoal) {
//            $goalCounter = 0;
//            $hoursCounter = 0;
//            foreach ($allUsersIDs as $userId) {
//                $completedByUser = $opportunitiesManager->getCompleted($userId);
//
//                if (count($completedByUser) > 0) {
//
//                    $userGoals = $volunteersManager->getCurrentUser($userId)->getGoals();
//                    foreach ($userGoals as $goal) {
//                        if ($singleGoal['id'] === $goal->goal_id) {
//                            $goalCounter++;
//
//                            foreach ($completedByUser as $completed) {
//
//                                if ($completed->task_type === 'call') {
//                                    $hoursCounter += 1;
//                                } elseif ($completed->task_type === 'project') {
//                                    $project = $opportunitiesManager->getProjectWithTask($completed->id);
//                                    $hoursCounter += $project->hours_duration;
//                                } elseif ($completed->task_type === 'mentoring') {
//                                    $mentoring = $opportunitiesManager->getMentoring($completed->id);
//                                    $hoursCounter += $mentoring->frequency * $mentoring->duration * $mentoring->time_frame;
//                                } elseif ($completed->task_type === 'engagement') {
//                                    $engagement = $opportunitiesManager->getEngagement($completed->id);
//                                    $hoursCounter += $engagement->frequency * $engagement->duration * $engagement->time_frame;
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//            $goalArray[$key]['goals_amount'] = $goalCounter;
//            $goalArray[$key]['goals_hours'] = $hoursCounter;
//        }

        $skills = $skillsManager->getList();
        $allVolunteersAmount = count($allUsersIDs);

        $openCalls = $opportunitiesManager->getOpenCalls();
        $openProjects = $opportunitiesManager->getOpenProjects();

        $properOpportunitiesIDs = array();

        foreach ($openCalls as $call) {
            $properOpportunitiesIDs[] = $call->id;
        }

        foreach ($openProjects as $project) {
            $properOpportunitiesIDs[] = $project->id;
        }

        $allOpenCallsProjectsAmount = count($properOpportunitiesIDs);

        foreach ($skills as $skill) {
            $countedUsers = count($skillsManager->getUsersBySkill($skill->id, $allUsersIDs));
            $parsedSkills[$skill->id]['name'] = $skill->name;
            $parsedSkills[$skill->id]['volunteers_using'] = $countedUsers;
            $parsedSkills[$skill->id]['percentage'] = round(($countedUsers / $allVolunteersAmount * 100), 1);
            $calls = $opportunitiesManager->countOpenCallsOpportunitiesWithSkill($skill->id);
            $projects = $opportunitiesManager->countOpenProjectsOpportunitiesWithSkill($skill->id);
            $parsedSkills[$skill->id]['opportunities'] = $calls->amount + $projects->amount;
            $parsedSkills[$skill->id]['opportunities_percentage'] = round((($calls->amount + $projects->amount) / $allOpenCallsProjectsAmount * 100), 1);
        }

        usort($parsedSkills, array($this, 'sort_skills'));

        require(dirname(__FILE__) . '/views/admin/statistics.php');
    }

    public function projectTasks()
    {

        $tasks = new \Purpozed2\Models\TaskManager();

        $searchType = '';
        $areaOfExpertise = '';
        if (isset($_POST['search_type'])) {
            $searchType = $_POST['search_type'];
        }
        if (isset($_POST['area_of_expertise'])) {
            $areaOfExpertise = $_POST['area_of_expertise'];
        }
        $allProjectTasks = $tasks->getAllProjectTasks($searchType, $areaOfExpertise);

        $aoeManager = new \Purpozed2\Models\ExpertiseManager();
        $aoes = $aoeManager->getList();

        require(dirname(__FILE__) . '/views/admin/mapping/projectTasks.php');
    }

    public function areasOfExpertise()
    {

        if (isset($_POST['submit'])) {

            if (!empty($_POST['item_name'])) {
                $itemName = $_POST['item_name'];
                $tableName = $_POST['table_name'];

                $status = $this->addItem($itemName, $tableName);
            } else {
                $status = false;
            }
        }

        global $wpdb;

        $expertisesManager = new \Purpozed2\Models\ExpertiseManager();
        $items = $expertisesManager->getList();

        require(dirname(__FILE__) . '/views/admin/mapping/areasOfExpertise.php');
    }

    public function skills()
    {

        global $wpdb;

        if (isset($_POST['submit'])) {

            if (!empty($_POST['item_name'])) {
                $itemName = $_POST['item_name'];
                $tableName = $_POST['table_name'];

                $status = $this->addItem($itemName, $tableName);
            } else {
                $status = false;
            }
        }

        $skillsManager = new \Purpozed2\Models\SkillManager();
        $items = $skillsManager->getList();

        require(dirname(__FILE__) . '/views/admin/mapping/skills.php');
    }

    public function callFocuses()
    {
        if (isset($_POST['submit'])) {

            if (!empty($_POST['item_name'])) {
                $itemName = $_POST['item_name'];
                $tableName = $_POST['table_name'];

                $status = $this->addItem($itemName, $tableName);
            } else {
                $status = false;
            }
        }

        if (isset($_POST['save_focus'])) {
            update_option('call_focuses', $_POST['call_focus']);
        }

        $currentCallFocus = get_option('call_focuses');
        if (!$currentCallFocus) {
            $currentCallFocus = '';
        }

        global $wpdb;

        $focusesManager = new \Purpozed2\Models\FocusManager();
        $items = $focusesManager->getList();

        require(dirname(__FILE__) . '/views/admin/mapping/callFocuses.php');
    }

    public function goals()
    {

        if (isset($_POST['submit'])) {

            if (!empty($_POST['item_name'])) {
                $itemName = $_POST['item_name'];
                $tableName = $_POST['table_name'];

                $status = $this->addItem($itemName, $tableName);
            } else {
                $status = false;
            }
        }

        if (isset($_POST['save_image'])) {

            $imageID = $_POST['image_id'];
            $goalID = $_POST['goal_id'];

            global $wpdb;
            $updateGoal = $wpdb->update('wp_purpozed_goals',
                array(
                    'image_id' => $imageID
                ),
                array(
                    'id' => $goalID
                ),
                array(
                    '%d'
                ));
            if ($updateGoal) {
                $imageStatus = true;
            } else {
                $imageStatus = false;
            }
        }

        global $wpdb;

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $items = $goalsManager->getList();

        require(dirname(__FILE__) . '/views/admin/mapping/goals.php');
    }

    public function saveItemEdit()
    {

        if (isset($_POST)) {

            global $wpdb;
            $itemId = $_POST['itemId'];
            $itemName = $_POST['itemName'];
            $itemTable = $_POST['itemTable'];
            $itemTask = $_POST['itemTask'];

            $tableName = 'wp_purpozed_' . $itemTable;

            if ($itemTask === 'edit') {

                $isUpdated = $wpdb->update(
                    $tableName,
                    array(
                        'name' => $itemName
                    ),
                    array(
                        'id' => $itemId
                    ),
                    array(
                        '%s'
                    )
                );
            } elseif ($itemTask === 'delete') {
                $isUpdated = $wpdb->delete(
                    $tableName,
                    array(
                        'id' => $itemId
                    ),
                    array(
                        '%d'
                    )
                );
            }

            echo json_encode($isUpdated);
            die();
        }
    }

    public function addItem($itemName, $tableName)
    {
        global $wpdb;

        $tableName = 'wp_purpozed_' . $tableName;

        $isExpertiseSaved = $wpdb->insert(
            $tableName,
            array(
                'name' => $itemName
            ),
            array(
                '%s'
            )
        );

        if ($isExpertiseSaved) {
            return true;
        } else {
            return false;
        }
    }

    public function projectTask()
    {

        $taskManager = new \Purpozed2\Models\TaskManager();
        $skillsManager = new \Purpozed2\Models\SkillManager();
        $sexpertisesManager = new \Purpozed2\Models\ExpertiseManager();

        $skills = $skillsManager->getList();
        $expertises = $sexpertisesManager->getList();

        $validPostKeys = array('name', 'description', 'hours_duration', 'area_of_expertise', 'skills');
        $parsedPostData = array();
        if (isset($_POST['submit'])) {
            foreach ($validPostKeys as $postKey) {
                $parsedPostData[$postKey] = (isset($_POST[$postKey])) ? $_POST[$postKey] : '';
            }

            global $wpdb;

            $isEdition = false;
            $taskId = 0;
            if (isset($_POST['edit'])) {
                $isEdition = true;
                $taskId = $_POST['task_id'];
            }
            $taskManager->saveProjectTask($parsedPostData, 'project', $isEdition, $taskId);
            $projectId = $wpdb->insert_id;
            if (isset($_POST['edit'])) {
                $projectId = $_POST['task_id'];
            }

            $areSkillsSaved = $taskManager->saveProjectSkills($parsedPostData['skills'], $projectId, $isEdition);
            if ($areSkillsSaved) {
                $status = true;
            } else {
                $status = false;
            }
        }

        if (isset($_GET['id'])) {
            $taskId = $_GET['id'];
            $taskData = $taskManager->getChosenProjectTask($taskId);
        }

        require(dirname(__FILE__) . '/views/admin/mapping/projectTasks/projectTask.php');
    }

    public function callTopic()
    {

        $tasks = new \Purpozed2\Models\TaskManager();
        $skillsManager = new \Purpozed2\Models\SkillManager();
        $sexpertisesManager = new \Purpozed2\Models\ExpertiseManager();

        $skills = $skillsManager->getList();
        $expertises = $sexpertisesManager->getList();

        $validPostKeys = array('name', 'description', 'hours_duration', 'area_of_expertise', 'skills');
        $parsedPostData = array();
        if (isset($_POST['submit'])) {
            foreach ($validPostKeys as $postKey) {
                $parsedPostData[$postKey] = (isset($_POST[$postKey])) ? $_POST[$postKey] : '';
            }

            global $wpdb;

            $isEdition = false;
            $taskId = 0;
            if (isset($_POST['edit'])) {
                $isEdition = true;
                $taskId = $_POST['task_id'];
            }
            $tasks->saveProjectTask($parsedPostData, 'call', $isEdition, $taskId);
            $projectId = $wpdb->insert_id;
            if (isset($_POST['edit'])) {
                $projectId = $_POST['task_id'];
            }
            $areSkillsSaved = $tasks->saveProjectSkills($parsedPostData['skills'], $projectId, $isEdition);
            if ($areSkillsSaved) {
                $status = true;
            } else {
                $status = false;
            }
        }

        if (isset($_GET['id'])) {
            $taskId = $_GET['id'];

            $taskManager = new \Purpozed2\Models\TaskManager();
            $taskData = $taskManager->getChosenProjectTask($taskId);
        }


        require(dirname(__FILE__) . '/views/admin/mapping/projectTasks/callTopic.php');
    }

    public function loadImage()
    {
        $imageID = $_POST['image_id'];

        $imageUrl = wp_get_attachment_image_url($imageID, 'large');
        echo json_encode(array('image_url' => $imageUrl));
        die();
    }

    public function activateOpportunity()
    {

        $opportunity = new \Purpozed2\Models\Opportunity();
        $opportunity->activateOpportunity($_POST['opportunity_id']);

        echo json_encode(array('status' => true));
        die();
    }

    public function deleteOpportunityAdmin()
    {
        $opportunityId = $_POST['opportunity_id'];
        global $wpdb;

        $wpdb->delete('wp_purpozed_opportunities',
            array(
                'id' => $opportunityId,
            ),
            array(
                '%d',
            )
        );

        echo json_encode(array('status' => true));
        die();
    }

    public function wdm_lostpassword_url()
    {
        return site_url('/password-reset/');
    }

    public function sort_names($left, $right)
    {
        return strnatcmp(strtolower($left['name']), strtolower($right['name']));
    }

    public function sort_skills($a, $b)
    {
        return $b['percentage'] - $a['percentage'];
    }

    public function scripts()
    {
        wp_enqueue_style('purpozed-jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        wp_enqueue_style('purpozed-styles', '/wp-content/plugins/purpozed2/assets/css/purpozed.css');

        wp_enqueue_script('purpozed-jquery', 'https://code.jquery.com/jquery-1.12.4.js"', array('jquery'));
        wp_enqueue_script('purpozed-jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'));

        wp_register_script('purpozed-js-translation', plugins_url('/purpozed2/assets/js/opportunities.js'), array('wp-i18n'));
        wp_set_script_translations('purpozed-js-translation', 'purpozed');
        wp_register_script('purpozed-js-translation-register', plugins_url('/purpozed2/assets/js/register.js'), array('wp-i18n'));
        wp_set_script_translations('purpozed-js-translation-register', 'purpozed');


        wp_enqueue_script('purpozed-val', plugins_url('/purpozed2/assets/js/validation.js'), array('jquery'));
        wp_enqueue_script('purpozed-js', plugins_url('/purpozed2/assets/js/register.js'), array('jquery'));
        wp_enqueue_script('purpozed-call', plugins_url('/purpozed2/assets/js/opportunities.js'), array('jquery'));
        wp_localize_script('purpozed-call', 'objectL10n', array(
            'hour' => esc_html__('hour', 'purpozed'),
            'hours' => esc_html__('hours', 'purpozed'),
            'url' => esc_html__('URL', 'purpozed'),
            'social_network' => esc_html__('SOCIAL NETWORK', 'purpozed')
        ));
        wp_enqueue_script('chart', plugins_url('/purpozed2/assets/js/Chart.min.js'), array('jquery'));
        wp_enqueue_script('charts', plugins_url('/purpozed2/assets/js/charts.js'), array('jquery'), true);
        wp_localize_script('purpozed-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));


    }

    public function adminScripts()
    {
        wp_enqueue_script('admin-js', plugins_url('/purpozed2/assets/js/admin.js'), array('jquery', 'media-upload', 'thickbox'), '1.0.0', true);
        wp_localize_script('admin-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_enqueue_style('admin-styles', plugins_url('/purpozed2/assets/css/admin.css'));
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');

        wp_enqueue_style('purpozed-jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        wp_enqueue_script('purpozed-jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'));
    }
}

new Purpozed();