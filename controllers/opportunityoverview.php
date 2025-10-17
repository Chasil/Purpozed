<?php

namespace Purpozed2\Controllers;

class OpportunityOverview extends \Purpozed2\Controller
{
    protected $description = 'Opportunity Overview';
    protected $menuActiveButton = 'opportunity-overview';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_company_menu')[0]) ? get_option('purpozed_company_menu')[0] : NULL;

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $this->view->goals = $goalsManager->getList();

        $skillsManager = new \Purpozed2\Models\SkillManager();
        $this->view->skills = $skillsManager->getList();

        $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
        $this->view->allOpportunitiesNumber = $opportunitiesManager->countAll();

        $this->view->statuses = $statuses = array('open', 'in_progress', 'succeeded', 'canceled');

        $searchedStatuses = (isset($_GET['statuses'])) ? $_GET['statuses'] : $statuses;
        $searchedFormats = (isset($_GET['formats'])) ? $_GET['formats'] : null;
        $searchedGoals = (isset($_GET['goals'])) ? $_GET['goals'] : null;
        $searchedSkills = (isset($_GET['skills'])) ? $_GET['skills'] : null;
        $searchedDuration = (isset($_GET['durations'])) ? $_GET['durations'] : null;
        $this->view->opportunities = $opportunitiesManager->getList(null, $searchedStatuses, $searchedFormats, $searchedGoals, $searchedSkills, $searchedDuration);

        $this->view->currentOpportunitiesNumber = count($this->view->opportunities);

        $this->view->taskType = array(
            'call' => __('call', 'purpozed'),
            'project' => __('project', 'purpozed'),
            'mentoring' => __('mentoring', 'purpozed'),
            'engagement' => __('engagement', 'purpozed'),
        );

        $statusesTypesCSS = array(
            'active' => 'open',
            'in_progress' => 'in_progress',
            'succeeded' => 'succeeded',
            'canceled' => 'canceled'
        );

        $statusesTypes = array(
            'active' => __('open', 'purpozed'),
            'in_progress' => __('in_progress', 'purpozed'),
            'succeeded' => __('succeeded', 'purpozed'),
            'canceled' => __('canceled', 'purpozed'),
        );

        $this->view->statusesTypesCSS = $statusesTypesCSS;
        $this->view->statusesTypes = $statusesTypes;
    }

    public function getDashboardType()
    {

        if (is_user_logged_in()) {

            $user = new \WP_User(get_current_user_id());
            if (get_user_meta(get_current_user_id(), 'is_admin')[0] === '1') {
                return 'company';
            }
        } else {
            header('Location: /?route=' . $_SERVER['REQUEST_URI']);
        }
        return;
    }

}