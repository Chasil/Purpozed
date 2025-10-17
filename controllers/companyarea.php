<?php

namespace Purpozed2\Controllers;

class CompanyArea extends \Purpozed2\Controller
{
    protected $description = 'Comapny Area';
    protected $menuActiveButton = 'dashboard';

    public function setViewVariables()
    {
        $this->view->dashboard_type = $this->getDashboardType();
        $this->view->volunteersMenuId = (get_option('purpozed_company_menu')[0]) ? get_option('purpozed_company_menu')[0] : NULL;

        $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();
        $this->view->companiesManager = new\Purpozed2\Models\CompaniesManager();
        $volunteersManager = new \Purpozed2\Models\VolunteersManager();
        $skillsManager = new \Purpozed2\Models\SkillManager();
        $this->view->volunteersManager = $volunteersManager;
        $this->view->employees = $volunteersManager->getListByCompany();

        $companyUsersIds = array();
        foreach ($this->view->employees as $employee) {
            $companyUsersIds[] = $employee['id'];
        }

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $goalArray = $goalsManager->getListAsArray();
        usort($goalArray, array($this, 'sort_names'));

        foreach ($goalArray as $key => $singleGoal) {
            $goalCounter = 0;
            $hoursCounter = 0;
            foreach ($companyUsersIds as $userId) {
                $completedByUser = $opportunitiesManager->getCompleted($userId);

                if (count($completedByUser) > 0) {

                    $userGoals = $volunteersManager->getCurrentUser($userId)->getGoals();
                    foreach ($userGoals as $goal) {
                        if ($singleGoal['id'] === $goal->goal_id) {
                            $goalCounter++;

                            foreach ($completedByUser as $completed) {

                                if ($completed->task_type === 'call') {
                                    $hoursCounter += 1;
                                } elseif ($completed->task_type === 'project') {
                                    $project = $opportunitiesManager->getProjectWithTask($completed->id);
                                    $hoursCounter += $project->hours_duration;
                                } elseif ($completed->task_type === 'mentoring') {
                                    $mentoring = $opportunitiesManager->getMentoring($completed->id);
                                    $hoursCounter += $mentoring->frequency * $mentoring->duration * $mentoring->time_frame;
                                } elseif ($completed->task_type === 'engagement') {
                                    $engagement = $opportunitiesManager->getEngagement($completed->id);
                                    $hoursCounter += $engagement->frequency * $engagement->duration * $engagement->time_frame;
                                }
                            }
                        }
                    }
                }
            }
            $goalArray[$key]['goals_amount'] = $goalCounter;
            $goalArray[$key]['goals_hours'] = $hoursCounter;
        }

        $this->view->goals = $goalArray;

        $this->view->skills = $skills = $skillsManager->getList();
        $allVolunteersAmount = count($this->view->employees);

        foreach ($skills as $skill) {
            $countedUsers = count($skillsManager->getUsersBySkill($skill->id, $companyUsersIds));
            $parsedSkills[$skill->id]['name'] = $skill->name;
            $parsedSkills[$skill->id]['volunteers_using'] = $countedUsers;
            $parsedSkills[$skill->id]['percentage'] = round(($countedUsers / $allVolunteersAmount * 100), 1);
        }

        usort($parsedSkills, array($this, 'sort_skills'));

        $this->view->parsedSkills = $parsedSkills;

        $this->view->allOpen = $opportunitiesManager->countAllOpen();
        $status = array('open');
        $this->view->openCalls = count($opportunitiesManager->getCalls(null, $status));
        $this->view->openProjects = count($opportunitiesManager->getProjects(null, $status));
        $this->view->openMentorings = count($opportunitiesManager->getMentorings(null, $status));
        $this->view->openEngagements = count($opportunitiesManager->getEngagements(null, $status));

        $this->view->allCanceled = $opportunitiesManager->countAllCanceled();
        $status = array('canceled');
        $this->view->canceledCalls = count($opportunitiesManager->getCalls(null, $status));
        $this->view->canceledProjects = count($opportunitiesManager->getProjects(null, $status));
        $this->view->canceledMentorings = count($opportunitiesManager->getMentorings(null, $status));
        $this->view->canceledEngagements = count($opportunitiesManager->getEngagements(null, $status));

        $company = new \Purpozed2\Models\Company();

        $invitedUsers = $this->view->invitedUsers = $company->getInvitedAmountFromCompanySettings();
        $allUsers = $this->view->allUsers = $company->getAllUsersAmount();
        $invited = ((int)$allUsers / (int)$invitedUsers) * 100;
        if ($invited > 100) {
            $invited = 100;
        }
        $this->view->invited = $invited;

        $activeUsers = $this->view->activeUsers = $volunteersManager->activeEmployeesAmount();
        $this->view->active = ((int)$activeUsers / (int)$allUsers) * 100;

        $engagedUsers = $this->view->engagedUsers = $volunteersManager->engagedEmplyeesAmount();
        $this->view->engaged = ((int)$engagedUsers / (int)$allUsers) * 100;

        $currentYear = date('Y');
        $currentMonth = date('m');

        $companyUsersIDs = $company->getAllUsersIDs();
        $allLogins = $volunteersManager->allLogins($currentYear, $currentMonth, $companyUsersIDs);
        $engagedUsers = $volunteersManager->getEngagedUsers($currentYear, $currentMonth, $companyUsersIDs);

        for ($i = 1; $i <= 12; $i++) {
            $last12Months[date("M", strtotime(date('Y-m-01') . " -$i months"))] = 0;
        }

        $allLoginsByMonth = $last12Months;
        $allEngagedByMonth = $last12Months;

        foreach ($allLoginsByMonth as $key => $value) {
            foreach ($allLogins as $allLoginsKey => $allLoginsData) {
                if ($allLoginsData['Month'] === $key) {
                    $allLoginsByMonth[$key] = (int)$allLoginsData['Users'];
                }
            }
            foreach ($engagedUsers as $engagedUsersKey => $engagedUsersData) {
                if ($engagedUsersData['Month'] === $key) {
                    $allEngagedByMonth[$key] = (int)$engagedUsersData['Users'];
                }
            }
        }

        $this->view->currentEngagements = json_encode($allEngagedByMonth);
        $this->view->logins = json_encode($allLoginsByMonth);

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

    public function sort_names($left, $right)
    {
        return strnatcmp(strtolower($left['name']), strtolower($right['name']));
    }

    public function sort_skills($a, $b)
    {
        return $b['percentage'] - $a['percentage'];
    }

}