<div class="skills">
    <?php
    if ($task_type === 'call') {
        $taskSkills = $opoprtunitiesManager->getCallSkillsByCall($user->opportunity_id);
        $userSkills = $volunteerManager->getCurrentUser($user->user_id)->getSkills();

        $totalTaskSkills = count($taskSkills);

        $userSkillsNames = array();
        foreach ($userSkills as $skill) {
            $userSkillsNames[] = $skill->name;
        }

        $matchedSkillsValue = 0;
        $matchedSkills = array();
        foreach ($taskSkills as $taskSkill) {
            foreach ($userSkillsNames as $userSkillsName) {
                if ($taskSkill->name === $userSkillsName) {
                    $matchedSkillsValue++;
                    $matchedSkills[] = $userSkillsName;
                }
            }
        }

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $organization = new \Purpozed2\Models\Organization();

        $organizationGoals = $organization->getGoals(get_current_user_id());
        $organizationMainGoalId = get_user_meta(get_current_user_id(), 'main_goal');
        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

        $organizationGoalsNames = array();
        foreach ($organizationGoals as $organizationGoal) {
            $organizationGoalsNames[] = $organizationGoal->name;
        }
        $organizationGoalsNames[] = $organizationMainGoal->name;

        $users = get_users(array('fields' => array('ID')));

        $volunteerGoals[] = array(
            'goals' => $volunteerManager->getCurrentUser($user->user_id)->getGoals()
        );

        $organizationGoalsValue = count($organizationGoalsNames);

        $matchedGoals = array();
        $matchedGoalsValue = 0;
        foreach ($organizationGoals as $organizationGoal) {
            $matchedScore = 0;
            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                foreach ($volunteerGoal as $goal) {
                    foreach ($goal as $item) {
                        if ($organizationGoal->name === $item->name) {
                            $matchedGoals[] = $item->name;
                            $matchedGoalsValue++;
                        }
                    }
                }
            }
        } ?>


        <div class="title">
            <?php _e('Matched skills', 'purpozed'); ?>
            <!--            --><?php
            //            echo (int)(($matchedSkillsValue / $totalTaskSkills) * 100);
            //            ?><!-- % matched skills-->
        </div>
        <?php if (!empty($matchedSkills)): ?>
            <div class="single-skills">
                <?php $matchedAmount = count($matchedSkills); ?>
                <?php $howManyMore = 0; ?>
                <?php if ($matchedAmount > 2) {
                    $howManyMore = $matchedAmount - 2;
                }
                ?>
                <?php $i = 1; ?>
                <?php $elseSkills = array(); ?>
                <?php foreach ($matchedSkills as $skill): ?>
                    <?php if ($i < 3): ?>
                        <div class="single-skill"><?php echo $skill; ?></div>
                        <?php $i++; ?>
                    <?php else: ?>
                        <?php $elseSkills[] = $skill; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!empty($elseSkills)): ?>
                    <span class="show-more-skills">
                        <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                        <div class="tooltip-skills">
                                <?php foreach ($elseSkills as $item): ?>
                                    <div class="single-skill"><?php echo $item; ?></div>
                                <?php endforeach; ?>
                        </div>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="title">
            <?php _e('Matched goals', 'purpozed'); ?>
            <!--            --><?php
            //            echo (int)(($matchedSkillsValue / $totalTaskSkills) * 100);
            //            ?><!-- % matched skills-->
        </div>
        <?php $uniqueGoals = array_unique($matchedGoals); ?>
        <?php if (!empty($uniqueGoals)): ?>
            <div class="single-skills">
                <?php $matchedAmount = count($uniqueGoals);
                $howManyMore = 0;
                if ($matchedAmount > 2) {
                    $howManyMore = $matchedAmount - 2;
                }
                ?>
                <?php $i = 1; ?>
                <?php $elseGoals = array(); ?>
                <?php foreach ($uniqueGoals as $goal): ?>
                    <?php if ($i < 3): ?>
                        <div class="single-skill"><?php echo $goal; ?></div>
                        <?php $i++; ?>
                    <?php else: ?>
                        <?php $elseGoals[] = $goal; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!empty($elseGoals)): ?>
                    <span class="show-more-skills">
                        <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                        <div class="tooltip-skills">
                            <?php foreach ($elseGoals as $item): ?>
                                <div class="single-skill"><?php echo $item; ?></div>
                            <?php endforeach; ?>
                        </div>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
    } elseif ($task_type === 'project') {
        $taskSkills = $opoprtunitiesManager->getProjectSkillsByTask($user->opportunity_id);
        $userSkills = $volunteerManager->getCurrentUser($user->user_id)->getSkills();

        $totalTaskSkills = count($taskSkills);

        $userSkillsNames = array();
        foreach ($userSkills as $skill) {
            $userSkillsNames[] = $skill->name;
        }

        $matchedSkillsValue = 0;
        $matchedSkills = array();
        foreach ($taskSkills as $taskSkill) {
            foreach ($userSkillsNames as $userSkillsName) {
                if ($taskSkill->name === $userSkillsName) {
                    $matchedSkillsValue++;
                    $matchedSkills[] = $userSkillsName;
                }
            }
        }

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $organization = new \Purpozed2\Models\Organization();

        $organizationGoals = $organization->getGoals(get_current_user_id());
        $organizationMainGoalId = get_user_meta(get_current_user_id(), 'main_goal');
        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

        $organizationGoalsNames = array();
        foreach ($organizationGoals as $organizationGoal) {
            $organizationGoalsNames[] = $organizationGoal->name;
        }
        $organizationGoalsNames[] = $organizationMainGoal->name;

        $users = get_users(array('fields' => array('ID')));

        $volunteerGoals[] = array(
            'goals' => $volunteerManager->getCurrentUser($user->user_id)->getGoals()
        );

        $organizationGoalsValue = count($organizationGoalsNames);

        $matchedGoals = array();
        $matchedGoalsValue = 0;
        foreach ($organizationGoals as $organizationGoal) {
            $matchedScore = 0;
            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                foreach ($volunteerGoal as $goal) {
                    foreach ($goal as $item) {
                        if ($organizationGoal->name === $item->name) {
                            $matchedGoals[] = $item->name;
                            $matchedGoalsValue++;
                        }
                    }
                }
            }
        }
        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $organization = new \Purpozed2\Models\Organization();

        $organizationGoals = $organization->getGoals(get_current_user_id());
        $organizationMainGoalId = get_user_meta(get_current_user_id(), 'main_goal');
        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

        $organizationGoalsNames = array();
        foreach ($organizationGoals as $organizationGoal) {
            $organizationGoalsNames[] = $organizationGoal->name;
        }
        $organizationGoalsNames[] = $organizationMainGoal->name;

        $users = get_users(array('fields' => array('ID')));

        $volunteerGoals[] = array(
            'goals' => $volunteerManager->getCurrentUser($user->user_id)->getGoals()
        );

        $organizationGoalsValue = count($organizationGoalsNames);

        $matchedGoals = array();
        $matchedGoalsValue = 0;
        foreach ($organizationGoals as $organizationGoal) {
            $matchedScore = 0;
            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                foreach ($volunteerGoal as $goal) {
                    foreach ($goal as $item) {
                        if ($organizationGoal->name === $item->name) {
                            $matchedGoals[] = $item->name;
                            $matchedGoalsValue++;
                        }
                    }
                }
            }
        } ?>


        <div class="title">
            <?php _e('Matched skills', 'purpozed'); ?>
            <!--            --><?php
            //            echo (int)(($matchedSkillsValue / $totalTaskSkills) * 100);
            //            ?><!-- % matched skills-->
        </div>
        <?php if (!empty($matchedSkills)): ?>
            <div class="single-skills">
                <?php $matchedAmount = count($matchedSkills); ?>
                <?php $howManyMore = 0; ?>
                <?php if ($matchedAmount > 2) {
                    $howManyMore = $matchedAmount - 2;
                }
                ?>
                <?php $i = 1; ?>
                <?php $elseSkills = array(); ?>
                <?php foreach ($matchedSkills as $skill): ?>
                    <?php if ($i < 3): ?>
                        <div class="single-skill"><?php echo $skill; ?></div>
                        <?php $i++; ?>
                    <?php else: ?>
                        <?php $elseSkills[] = $skill; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!empty($elseSkills)): ?>
                    <span class="show-more-skills">
                        <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                        <div class="tooltip-skills">
                                <?php foreach ($elseSkills as $item): ?>
                                    <div class="single-skill"><?php echo $item; ?></div>
                                <?php endforeach; ?>
                        </div>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="title">
            <?php _e('Matched goals', 'purpozed'); ?>
            <!--            --><?php
            //            echo (int)(($matchedSkillsValue / $totalTaskSkills) * 100);
            //            ?><!-- % matched skills-->
        </div>
        <?php $uniqueGoals = array_unique($matchedGoals); ?>
        <?php if (!empty($uniqueGoals)): ?>
            <div class="single-skills">
                <?php $matchedAmount = count($uniqueGoals);
                $howManyMore = 0;
                if ($matchedAmount > 2) {
                    $howManyMore = $matchedAmount - 2;
                }
                ?>
                <?php $i = 1; ?>
                <?php $elseGoals = array(); ?>
                <?php foreach ($uniqueGoals as $goal): ?>
                    <?php if ($i < 3): ?>
                        <div class="single-skill"><?php echo $goal; ?></div>
                        <?php $i++; ?>
                    <?php else: ?>
                        <?php $elseGoals[] = $goal; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!empty($elseGoals)): ?>
                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
    } elseif ($task_type === 'mentoring') {

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $taskManager = new \Purpozed2\Models\TaskManager();
        $opportunityObject = new \Purpozed2\Models\Opportunity();

        $matchedUserSkills = array();
        $areasOfExpertises = $opportunityObject->getAreaOfExpertise($_GET['id']);
        $mentoringSkills = array();
        foreach ($areasOfExpertises as $areasOfExpertise) {
            $tasksIDs = $taskManager->getTaskSkillsByAreaOfExpertise($areasOfExpertise->id);
            foreach ($tasksIDs as $tasksID) {
                $taskSkillsData[] = $taskManager->getSkills($tasksID->id);
                foreach ($taskSkillsData as $taskSkillsDatum) {
                    foreach ($taskSkillsDatum as $item) {

                        $userData = get_user_by('ID', $user->user_id);
                        if (in_array('volunteer', $userData->roles)) {

                            $userSkills = $volunteerManager->getCurrentUser($user->user_id)->getSkills();

                            $userSkillsNames = array();
                            foreach ($userSkills as $skill) {
                                $userSkillsNames[] = $skill->name;
                            }
                            foreach ($userSkillsNames as $userSkillsName) {
                                if ($item->name === $userSkillsName) {
                                    if (!in_array($userSkillsName, $matchedUserSkills)) {
                                        $matchedUserSkills[] = $userSkillsName;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $score = 0;
        $mentoringMatchedSkills = array();
        if (isset($taskSkillsData)) {

            $parsedSkillsData = array();
            foreach ($taskSkillsData as $taskSkillsDatum) {
                foreach ($taskSkillsDatum as $item) {
                    if (!in_array($item->name, $parsedSkillsData)) {
                        $parsedSkillsData[] = $item->name;
                    }
                }
            }

            $matchedUserSkills = array_unique($matchedUserSkills);

            $mentoringSkillsValue = count($parsedSkillsData);

            $matchedValue = 0;

            foreach ($parsedSkillsData as $parsedSkillsDatum) {
                foreach ($matchedUserSkills as $matchedUserSkill) {
                    if ($matchedUserSkill === $parsedSkillsDatum) {
                        $mentoringMatchedSkills[] = $parsedSkillsDatum;
                        $matchedValue++;
                    }
                }
            }

            $score = (int)(($matchedValue / $mentoringSkillsValue) * 100);
        }

        ?>
        <div class="title">
            <?php _e('Matched Area of Expertise', 'purpozed'); ?>
        </div>
        <?php $matchedSkills = array_unique($areasOfExpertises); ?>
        <?php if (!empty($matchedSkills)): ?>
            <div class="single-skills">
                <?php $matchedAmount = count($matchedSkills); ?>
                <?php $howManyMore = 0; ?>
                <?php if ($matchedAmount > 2) {
                    $howManyMore = $matchedAmount - 2;
                }
                ?>
                <?php $i = 1; ?>
                <?php $elseSkills = array(); ?>
                <?php foreach ($matchedSkills as $skill): ?>
                    <?php if ($i < 3): ?>
                        <div class="single-skill"><?php echo $skill->name; ?></div>
                        <?php $i++; ?>
                    <?php else: ?>
                        <?php $elseSkills[] = $skill; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!empty($elseSkills)): ?>
                    <span class="show-more-skills">
                        <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                        <div class="tooltip-skills">
                                <?php foreach ($elseSkills as $item): ?>
                                    <div class="single-skill"><?php echo $item->name; ?></div>
                                <?php endforeach; ?>
                        </div>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="title">
            <?php _e('Matched goals', 'purpozed'); ?>
            <!--            --><?php
            //            echo $score;
            //            ?><!-- % matched goals-->
        </div>
        <?php $uniqueGoals = array_unique($mentoringMatchedSkills); ?>
        <?php if (!empty($uniqueGoals)): ?>
            <div class="single-skills">
                <?php $matchedAmount = count($uniqueGoals);
                $howManyMore = 0;
                if ($matchedAmount > 2) {
                    $howManyMore = $matchedAmount - 2;
                }
                ?>
                <?php $i = 1; ?>
                <?php $elseGoals = array(); ?>
                <?php foreach ($uniqueGoals as $goal): ?>
                    <?php if ($i < 3): ?>
                        <div class="single-skill"><?php echo $goal; ?></div>
                        <?php $i++; ?>
                    <?php else: ?>
                        <?php $elseGoals[] = $goal; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!empty($elseGoals)): ?>
                    <span class="show-more-skills">
                        <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                        <div class="tooltip-skills">
                            <?php foreach ($elseGoals as $item): ?>
                                <div class="single-skill"><?php echo $item; ?></div>
                            <?php endforeach; ?>
                        </div>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?

    } elseif ($task_type === 'engagement') {

        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
        $organization = new \Purpozed2\Models\Organization();

        $organizationGoals = $organization->getGoals(get_current_user_id());
        $organizationMainGoalId = get_user_meta(get_current_user_id(), 'main_goal');
        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

        $organizationGoalsNames = array();
        foreach ($organizationGoals as $organizationGoal) {
            $organizationGoalsNames[] = $organizationGoal->name;
        }
        $organizationGoalsNames[] = $organizationMainGoal->name;

        $users = get_users(array('fields' => array('ID')));

        $volunteerGoals[] = array(
            'goals' => $volunteerManager->getCurrentUser($user->user_id)->getGoals()
        );

        $organizationGoalsValue = count($organizationGoalsNames);

        $matchedGoals = array();
        $matchedGoalsValue = 0;
        foreach ($organizationGoals as $organizationGoal) {
            $matchedScore = 0;
            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                foreach ($volunteerGoal as $goal) {
                    foreach ($goal as $item) {
                        if ($organizationGoal->name === $item->name) {
                            $matchedGoals[] = $item->name;
                            $matchedGoalsValue++;
                        }
                    }
                }
            }
        } ?>

        <div class="title">
            Matched goals
            <!--            --><?php
            //            echo (int)(($matchedGoalsValue / $organizationGoalsValue) * 100);
            //            ?><!-- % matched goals-->
        </div>
        <?php $uniqueGoals = array_unique($matchedGoals); ?>
        <?php if (!empty($uniqueGoals)): ?>
            <div class="single-skills">
                <?php $matchedAmount = count($uniqueGoals);
                $howManyMore = 0;
                if ($matchedAmount > 2) {
                    $howManyMore = $matchedAmount - 2;
                }
                ?>
                <?php $i = 1; ?>
                <?php $elseGoals = array(); ?>
                <?php foreach ($uniqueGoals as $goal): ?>
                    <?php if ($i < 3): ?>
                        <div class="single-skill"><?php echo $goal; ?></div>
                        <?php $i++; ?>
                    <?php else: ?>
                        <?php $elseGoals[] = $goal; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!empty($elseGoals)): ?>
                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                <?php endif; ?>
            </div>
        <?php endif; ?><?
    }
    ?>
</div>