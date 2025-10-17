<?php

namespace Purpozed2\Controllers;

class FindOpportunity extends \Purpozed2\Controller
{
    protected $description = 'Find Opportunity';
    protected $menuActiveButton = 'find-opportunity';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_volunteers_menu')[0]) ? get_option('purpozed_volunteers_menu')[0] : NULL;

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $goals = $goalsManager->getListAsArray();
        usort($goals, array($this, 'sort_skills'));
        $this->view->goals = $goals;

        $skillsManager = new \Purpozed2\Models\SkillManager();
        $this->view->skills = $skillsManager->getList();

        $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();

        $this->view->allOpenOpportunitiesNumber = $opportunitiesManager->countAllOpen();

        $searchedFormats = array();

        if (isset($_GET['filters-types'])) {
            if ($_GET['filter-type'] === '1') {
                $searchedFormats = array('engagement', 'call', 'project', 'mentoring');
            } elseif ($_GET['filter-type'] === '2') {
                $searchedFormats = array('engagement');
            } elseif ($_GET['filter-type'] === '3') {
                $searchedFormats = array('call', 'project', 'mentoring');
            }
        }

        $searchedGoals = null;
        $searchedSkills = null;
        $this->view->myActivities = false;

        if (isset($_GET['my-activities'])) {
            $volunteerManager = new \Purpozed2\Models\VolunteersManager();
            $searchedSkillsObject = $volunteerManager->getCurrentUser()->getSkills();
            $searchedGoalsObject = $volunteerManager->getCurrentUser()->getGoals();

            $searchedGoals = array();
            foreach ($searchedGoalsObject as $searchedGoal) {
                $searchedGoals[] = $searchedGoal->goal_id;
            }

            $searchedSkills = array();
            foreach ($searchedSkillsObject as $searchedSkill) {
                $searchedSkills[] = $searchedSkill->skill_id;
            }

            $_GET['goals'] = $searchedGoals;
            $_GET['skills'] = $searchedSkills;

            $this->view->myActivities = true;
        } else {
            $searchedGoals = (isset($_GET['goals'])) ? $_GET['goals'] : null;
            $searchedSkills = (isset($_GET['skills'])) ? $_GET['skills'] : null;
        }

        $searchedStatuses = array(0 => 'open');
//        $searchedFormats = (isset($_GET['formats'])) ? $_GET['formats'] : null;

        $searchedDuration = (isset($_GET['durations'])) ? $_GET['durations'] : null;
        $onlyOpenEngagements = '0';

        $organizationsIDs = array();
        $distancesItems = array();

        if (isset($_GET['distance'])) {

            $company = new \Purpozed2\Models\Company();

            $distancesItems = $company->getDistances($_GET['distance']);
        }

        $lista = $opportunitiesManager->getList($distancesItems['organizationsIDs'], $searchedStatuses, $searchedFormats, $searchedGoals, $searchedSkills, $searchedDuration, $onlyOpenEngagements);

        usort($lista, array($this, 'date_sort'));

        $this->view->organizationsIDs = $organizationsIDs;
        $this->view->distancesList = $distancesItems['distancesList'];
        $this->view->distancesOrganizations = $distancesItems['organizationsIDs'];
        $this->view->opportunities = $lista;

        $this->view->currentOpportunitiesNumber = count($this->view->opportunities);

        $this->view->taskType = array(
            'call' => __('call', 'purpozed'),
            'project' => __('project', 'purpozed'),
            'mentoring' => __('mentoring', 'purpozed'),
            'engagement' => __('engagement', 'purpozed'),
        );

        $this->view->statusesTypes = array(
            'prepared' => __('prepared', 'purpozed'),
            'review' => __('review', 'purpozed'),
            'deleted' => __('deleted', 'purpozed'),
            'active' => __('open', 'purpozed'),
            'retracted' => __('retracted', 'purpozed'),
            'expired' => __('expired', 'purpozed'),
            'in_progress' => __('in_progress', 'purpozed'),
            'succeeded' => __('succeeded', 'purpozed'),
            'canceled' => __('canceled', 'purpozed'),
        );

        $this->view->statusesTypesCSS = array(
            'prepared' => 'prepared',
            'review' => 'review',
            'deleted' => 'deleted',
            'active' => 'open',
            'retracted' => 'retracted',
            'expired' => 'expired',
            'in_progress' => 'in_progress',
            'succeeded' => 'succeeded',
            'canceled' => 'canceled'
        );
    }

    public function getDashboardType()
    {

        if (is_user_logged_in()) {

            $user = new \WP_User(get_current_user_id());
            if (in_array('volunteer', $user->roles)) {
                return 'volunteer';
            }
        } else {
            header('Location: /?route=' . $_SERVER['REQUEST_URI']);
        }
        return;
    }

    public function date_sort($a, $b)
    {
        return $b->id - $a->id;
    }

    public function sort_skills($a, $b)
    {
        return strnatcmp($a['name'], $b['name']);
    }

    public function getDistances()
    {
        $company = new \Purpozed2\Models\Company();

        $distancesItems = $company->getDistances();

        echo json_encode(array('distancesItems' => $distancesItems));
        die();
    }

}