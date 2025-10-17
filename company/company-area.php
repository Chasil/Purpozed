<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/company/header.php');
?>

<div class="dashboard-scores dashboard vol-dash">
    <div class="row dashboard-sub-menu sticky-menu">
        <div class="sub-menu-item"><a href="#activity"><?php _e('Activity', 'purpozed'); ?></a></div>
        <div class="sub-menu-item"><a href="#goals"><?php _e('Goals', 'purpozed'); ?></a></div>
        <!--        <div class="sub-menu-item"><a href="#employees">-->
        <?php //_e('Employees', 'purpozed'); ?><!--</a></div>-->
        <div class="sub-menu-item"><a href="#corporate_knowledge"><?php _e('Corporate Knowledge', 'purpozed'); ?></a>
        </div>
    </div>
    <div class="section" id="activity">
        <h2><?php _e('Activity', 'purpozed'); ?></h2>
        <div class="activities">
            <div class="single-activity">
                <div class="title"><?php _e('Signed up Employees', 'purpozed'); ?></div>
                <div class="score">
                    <div class="flex-wrapper">
                        <div class="single-chart">
                            <svg viewbox="0 0 36 36" class="circular-chart green">
                                <path class="circle-bg"
                                      d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                      stroke-dasharray="<?php echo $invited; ?>, 100"
                                      d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="20.35" class="percentage"><?php echo (int)$invited; ?>%</text>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="score-one">
                    <div class="invited"></div>
                    <div class="text"><?php _e('Signed up Employees', 'purpozed'); ?></div>
                    <span class="invited-amount"><?php echo $allUsers; ?></span></div>
                <div class="score-one">
                    <div class="signed"></div>
                    <div class="text"><?php _e('Invited Employees', 'purpozed'); ?></div>
                    <span class="invited-amount"><?php echo $invitedUsers; ?></span></div>
            </div>
            <div class="single-activity">
                <div class="title"><?php _e('Active Employees', 'purpozed'); ?></div>
                <div class="score">
                    <div class="flex-wrapper">
                        <div class="single-chart">
                            <svg viewbox="0 0 36 36" class="circular-chart green">
                                <path class="circle-bg"
                                      d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                      stroke-dasharray="<?php echo $active; ?>, 100"
                                      d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="20.35" class="percentage"><?php echo (int)$active; ?>%</text>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="score-one">
                    <div class="invited"></div>
                    <div class="text"><?php _e('Signed up Employees', 'purpozed'); ?></div>
                    <span class="invited-amount"><?php echo $allUsers; ?></span></div>
                <div class="score-one">
                    <div class="signed"></div>
                    <div class="text"><?php _e('Active Employees', 'purpozed'); ?></div>
                    <span class="invited-amount"><?php echo $activeUsers; ?></span></div>
            </div>
            <div class="single-activity">
                <div class="title"><?php _e('Engaged Employees', 'purpozed'); ?></div>
                <div class="score">
                    <div class="flex-wrapper">
                        <div class="single-chart">
                            <svg viewbox="0 0 36 36" class="circular-chart green">
                                <path class="circle-bg"
                                      d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                      stroke-dasharray="<?php echo $engaged; ?>, 100"
                                      d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="20.35" class="percentage"><?php echo (int)$engaged; ?>%</text>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="score-one">
                    <div class="invited"></div>
                    <div class="text"><?php _e('Signed up Employees', 'purpozed'); ?></div>
                    <span class="invited-amount"><?php echo $allUsers; ?></span></div>
                <div class="score-one">
                    <div class="signed"></div>
                    <div class="text"><?php _e('Engaged Employees', 'purpozed'); ?></div>
                    <span class="invited-amount"><?php echo $engagedUsers; ?></span></div>
            </div>
        </div>
        <div class="chart">
            <div class="chart-container" style="position: relative; height:400px; width:100%">
                <canvas id="totalChart" data-currentengagements=
                <?php echo $currentEngagements; ?> data-logins
                = <?php echo $logins; ?>></canvas>
            </div>
        </div>
        <div class="stats">
            <div class="stat successful">
                <div class="title"><?php _e('Successful', 'purpozed'); ?><br><?php _e('opportunities', 'purpozed'); ?>
                </div>
                <div class="number"><?php echo $companiesManager->countSuccessfull(); ?></div>
                <div class="text"><?php _e('Engagements', 'purpozed'); ?><?php echo ' ' . $companiesManager->countSuccessfull('engagement'); ?></div>
                <div class="text"><?php _e('Projects', 'purpozed'); ?><?php echo ' ' . $companiesManager->countSuccessfull('project'); ?></div>
                <div class="text"><?php _e('Mentorings', 'purpozed'); ?><?php echo ' ' . $companiesManager->countSuccessfull('mentoring'); ?></div>
                <div class="text"><?php _e('Calls', 'purpozed'); ?><?php echo ' ' . $companiesManager->countSuccessfull('call'); ?></div>
                <!--                <div class="button"><a-->
                <!--                            href="/opportunity-overview/?statuses%5B%5D=succeeded">-->
                <?php //_e('List', 'purpozed'); ?><!--</a>-->
                <!--                </div>-->
            </div>
            <div class="stat in_progress">
                <div class="title"><?php _e('Opportunities', 'purpozed'); ?><br><?php _e('in progress', 'purpozed'); ?>
                </div>
                <div class="number"><?php echo $companiesManager->countInProgress(); ?></div>
                <div class="text"><?php _e('Engagements', 'purpozed'); ?><?php echo ' ' . $companiesManager->countInProgress('engagement'); ?></div>
                <div class="text"><?php _e('Projects', 'purpozed'); ?><?php echo ' ' . $companiesManager->countInProgress('project'); ?></div>
                <div class="text"><?php _e('Mentorings', 'purpozed'); ?><?php echo ' ' . $companiesManager->countInProgress('mentoring'); ?></div>
                <div class="text"><?php _e('Calls', 'purpozed'); ?><?php echo ' ' . $companiesManager->countInProgress('call'); ?></div>
                <!--                <div class="button"><a-->
                <!--                            href="/opportunity-overview/?statuses%5B%5D=in_progress">-->
                <?php //_e('List', 'purpozed'); ?><!--</a>-->
                <!--                </div>-->
            </div>
            <div class="stat open">
                <div class="title"><?php _e('Open', 'purpozed'); ?><br><?php _e('opportunities', 'purpozed'); ?></div>
                <div class="number"><?php echo $allOpen; ?></div>
                <div class="text"><?php _e('Engagements', 'purpozed'); ?><?php echo ' ' . $openEngagements; ?></div>
                <div class="text"><?php _e('Projects', 'purpozed'); ?><?php echo ' ' . $openProjects; ?></div>
                <div class="text"><?php _e('Mentorings', 'purpozed'); ?><?php echo ' ' . $openMentorings; ?></div>
                <div class="text"><?php _e('Calls', 'purpozed'); ?><?php echo ' ' . $openCalls; ?></div>
                <!--                <div class="button"><a-->
                <!--                            href="/opportunity-overview/?statuses%5B%5D=open">-->
                <?php //_e('List', 'purpozed'); ?><!--</a>-->
                <!--                </div>-->
            </div>
            <div class="stat canceled">
                <div class="title"><?php _e('Canceled', 'purpozed'); ?><br><?php _e('opportunities', 'purpozed'); ?>
                </div>
                <div class="number"><?php echo $allCanceled; ?></div>
                <div class="text"><?php _e('Engagements', 'purpozed'); ?><?php echo ' ' . $canceledEngagements; ?></div>
                <div class="text"><?php _e('Projects', 'purpozed'); ?><?php echo ' ' . $canceledProjects; ?></div>
                <div class="text"><?php _e('Mentorings', 'purpozed'); ?><?php echo ' ' . $canceledMentorings; ?></div>
                <div class="text"><?php _e('Calls', 'purpozed'); ?><?php echo ' ' . $canceledCalls; ?></div>
                <!--                <div class="button"><a-->
                <!--                            href="/opportunity-overview/?statuses%5B%5D=canceled">-->
                <?php //_e('List', 'purpozed'); ?><!--</a>-->
                <!--                </div>-->
            </div>
        </div>
    </div>
    <div class="goals-container section" id="goals">
        <h2><?php _e('Goals', 'purpozed'); ?></h2>
        <div class="goals">
            <?php foreach ($goals as $goal): ?>
                <div class="goal">
                    <div class="logo"><img
                                src="<?php echo wp_get_attachment_image_src($goal['image_id'], 'medium')[0]; ?>"></div>
                    <div class="text"><?php _e('Volunteers', 'purpozed'); ?>: <?php echo $goal['goals_amount']; ?></div>
                    <div class="text"><?php _e('Hours', 'purpozed'); ?>: <?php echo $goal['goals_hours']; ?></div>
                    <div class="link"><a
                                href="/opportunity-overview/?goals%5B%5D=<?php echo $goal['id']; ?>"><?php _e('Opportunites', 'purpozed'); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!--    <div class="employees-container" id="employees">-->
    <!--        <h2>--><?php //_e('Employees', 'purpozed'); ?><!--</h2>-->
    <!--        <div class="employees">-->
    <!--            <table class="employee">-->
    <!--                <thead>-->
    <!--                <tr>-->
    <!--                    <th>--><?php //_e('Name', 'purpozed'); ?><!--</th>-->
    <!--                    <th>--><?php //_e('Job title', 'purpozed'); ?><!--</th>-->
    <!--                    <th>--><?php //_e('Activity Score', 'purpozed'); ?><!--</th>-->
    <!--                    <th>--><?php //_e('Applied', 'purpozed'); ?><!--</th>-->
    <!--                    <th>--><?php //_e('Current Opportunities', 'purpozed'); ?><!--</th>-->
    <!--                    <th>--><?php //_e('Succeeded Opportunities', 'purpozed'); ?><!--</th>-->
    <!--                    <th>--><?php //_e('Hours helped', 'purpozed'); ?><!--</th>-->
    <!--                </tr>-->
    <!--                </thead>-->
    <!--                <tbody>-->
    <!--                --><?php //foreach ($employees as $employee): ?>
    <!--                    <tr>-->
    <!--                        <td class="name"><a-->
    <!--                                    href="#">-->
    <?php //echo $employee['first_name'] . ' ' . $employee['last_name']; ?><!--</a>-->
    <!--                        </td>-->
    <!--                        <td>--><?php //echo $employee['title']; ?><!--</td>-->
    <!--                        <td></td>-->
    <!--                        <td>-->
    <?php //echo $volunteersManager->getCurrentUser($employee['id'])->hasAppliedNumber(); ?><!--</td>-->
    <!--                        <td>-->
    <?php //echo $volunteersManager->getCurrentUser($employee['id'])->currentOpportunities(); ?><!--</td>-->
    <!--                        <td>-->
    <?php //echo $volunteersManager->getCurrentUser($employee['id'])->succeededOpportunities(); ?><!--</td>-->
    <!--                        <td>-->
    <?php //echo $volunteersManager->getCurrentUser($employee['id'])->hoursHelped(); ?><!--</td>-->
    <!--                    </tr>-->
    <!--                --><?php //endforeach; ?>
    <!--                </tbody>-->
    <!--            </table>-->
    <!--        </div>-->
    <!--    </div>-->

    <div class="section" id="corporate_knowledge">
        <h2><?php _e('Corporate Knowledge', 'purpozed'); ?></h2>
        <div class="corporate_knowledge">
            <div class="employees">
                <table class="employee">
                    <thead>
                    <tr>
                        <th><?php _e('Skill', 'purpozed'); ?></th>
                        <th><?php _e('No. Volunteers', 'purpozed'); ?></th>
                        <th><?php _e('%', 'purpozed'); ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($parsedSkills as $skill): ?>
                        <tr>
                            <td class="short_column">
                                <?php echo $skill['name']; ?>
                            </td>
                            <td class="short_column"><?php echo $skill['volunteers_using']; ?></td>
                            <td class="shorter_column"><?php echo $skill['percentage']; ?>%</td>
                            <td class="max_column">
                                <div class="knowledge_range" style="width: <?php echo $skill['percentage']; ?>%"></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <div class="dashboard-menu footer">
        <?php $signInFooter = get_option('purpozed_vol_compa_footer'); ?>
        <div class="menu-bar footer">
            <?php global $wp_filter; ?>
            <?php unset($wp_filter['wp_nav_menu_args']); ?>
            <?php if ($signInFooter): ?>
                <?php wp_nav_menu(array('menu' => $signInFooter)); ?>
            <?php else: ?>
                <div class="info-box"><?php _e('Menu for this section is not setup.', 'purpozed'); ?></div>
            <?php endif; ?>
        </div>
        <div class="wpml-ls-statics-footer wpml-ls wpml-ls-legacy-list-horizontal">
            <ul>
                <li class="wpml-ls-slot-footer wpml-ls-item wpml-ls-item-de wpml-ls-current-language wpml-ls-item-legacy-list-horizontal">
                    <a href="https://portal.purpozed.org" class="wpml-ls-link">
                        <img class="wpml-ls-flag"
                             src="https://portal.purpozed.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/de.png"
                             alt="Deutsch" width="18" height="12"></a>
                </li>
                <li class="wpml-ls-slot-footer wpml-ls-item wpml-ls-item-en wpml-ls-first-item wpml-ls-item-legacy-list-horizontal">
                    <a href="https://portal.purpozed.org/en/" class="wpml-ls-link">
                        <img class="wpml-ls-flag"
                             src="https://portal.purpozed.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                             alt="Englisch" width="18" height="12"></a>
                </li>
            </ul>
        </div>
    </div>