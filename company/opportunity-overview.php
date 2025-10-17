<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/company/header.php');
$opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
?>

<div class="find-opportunity">
    <form method="get" action="">
        <div class="row filters to-left">
            <div class="search-item goals">
                <div name="statuses">
                    <div class="search-select"><?php _e('Statuses', 'purpozed'); ?></div>
                    <div class="options-select">
                        <?php foreach ($statuses as $status): ?>
                            <div class="single-option">
                                <input type="checkbox" name="statuses[]" value="<?php echo $status; ?>"
                                       id="status_<?php echo $status; ?>" <?php if (isset($_GET['statuses'])) {
                                    foreach ($_GET['statuses'] as $searched => $value) {
                                        if ($value === $status) {
                                            echo "checked='checked'";
                                        }
                                    }
                                } ?>>
                                <label for="status_<?php echo $status; ?>"><?php echo $status; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="search-item goals">
                <div name="goals">
                    <div class="search-select"><?php _e('Goals', 'purpozed'); ?></div>
                    <div class="options-select">
                        <?php foreach ($goals as $goal): ?>
                            <div class="single-option">
                                <input type="checkbox" name="goals[]" value="<?php echo $goal->id; ?>"
                                       id="goal_<?php echo $goal->id; ?>" <?php if (isset($_GET['goals'])) {
                                    foreach ($_GET['goals'] as $searched => $value) {
                                        if ($value === $goal->id) {
                                            echo "checked='checked'";
                                        }
                                    }
                                } ?>>
                                <label for="goal_<?php echo $goal->id; ?>"><?php echo $goal->name; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="search-item skills">
                <div name="skills">
                    <div class="search-select"><?php _e('Skills', 'purpozed'); ?></div>
                    <div class="options-select">
                        <?php foreach ($skills as $skill): ?>
                            <div class="single-option">
                                <input type="checkbox" name="skills[]" value="<?php echo $skill->id; ?>"
                                       id="skill_<?php echo $skill->id; ?>" <?php if (isset($_GET['skills'])) {
                                    foreach ($_GET['skills'] as $searched => $value) {
                                        if ($value === $skill->id) {
                                            echo "checked='checked'";
                                        }
                                    }
                                } ?>>
                                <label for="skill_<?php echo $skill->id; ?>"><?php echo $skill->name; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="search-item format">
                <div name="format">
                    <div class="search-select"><?php _e('Format', 'purpozed'); ?></div>
                    <div class="options-select">
                        <div class="single-option">
                            <input type="checkbox" name="formats[]" value="call"
                                   id="format_call" <?php if (isset($_GET['formats'])) {
                                foreach ($_GET['formats'] as $searched => $value) {
                                    if ($value === "call") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="format_call"><?php _e('1h Call', 'purpozed'); ?></label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="formats[]" value="project"
                                   id="format_project" <?php if (isset($_GET['formats'])) {
                                foreach ($_GET['formats'] as $searched => $value) {
                                    if ($value === "project") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="format_project"><?php _e('Project', 'purpozed'); ?></label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="formats[]" value="mentoring"
                                   id="format_mentoring" <?php if (isset($_GET['formats'])) {
                                foreach ($_GET['formats'] as $searched => $value) {
                                    if ($value === "mentoring") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="format_mentoring"><?php _e('Mentoring', 'purpozed'); ?></label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="formats[]" value="engagement"
                                   id="format_engagement" <?php if (isset($_GET['formats'])) {
                                foreach ($_GET['formats'] as $searched => $value) {
                                    if ($value === "engagement") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="format_engagement"><?php _e('Engagement', 'purpozed'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-item duration">
                <div name="format">
                    <div class="search-select"><?php _e('Duration', 'purpozed'); ?></div>
                    <div class="options-select">
                        <div class="single-option">
                            <input type="checkbox" name=durations[]" value="1"
                                   id="duration_1" <?php if (isset($_GET['durations'])) {
                                foreach ($_GET['durations'] as $searched => $value) {
                                    if ($value === "1") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="duration_1"><?php _e('1 hour', 'purpozed'); ?></label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="duratios[]" value="2"
                                   id="duration_2" <?php if (isset($_GET['durations'])) {
                                foreach ($_GET['durations'] as $searched => $value) {
                                    if ($value === "2") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="duration_2"><?php _e('1 days max', 'purpozed'); ?></label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="durations[]" value="3"
                                   id="duration_3" <?php if (isset($_GET['durations'])) {
                                foreach ($_GET['durations'] as $searched => $value) {
                                    if ($value === "3") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="duration_3"><?php _e('1-3 days', 'purpozed'); ?></label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="durations[]" value="4"
                                   id="duration_4" <?php if (isset($_GET['durations'])) {
                                foreach ($_GET['durations'] as $searched => $value) {
                                    if ($value === "4") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="duration_4"><?php _e('3 days or longer', 'purpozed'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <div class="search-item search"><input type="text" placeholder="Search"></div>-->
        </div>
        <div class="row filters-controlls">
            <div class="save-clear">
                <div class="filters-item clear"><?php _e('Clear filter', 'purpozed'); ?></div>
            </div>
            <div class="amount">
                <div class=""><?php echo $currentOpportunitiesNumber; ?> of <?php echo $allOpportunitiesNumber; ?>
                    Opportunities
                </div>
            </div>
            <div class="look">
                <div class="filter-item search"><input type="submit" value="<?php _e('Search', 'purpozed'); ?>"></div>
            </div>
        </div>
    </form>
    <div class="row list">
        <?php $organization = new \Purpozed2\Models\Organization(); ?>
        <?php $singleOpportunity = new \Purpozed2\Models\Opportunity(); ?>
        <?php foreach ($opportunities as $opportunity): ?>
            <?php $organizationId = $singleOpportunity->getOrganization($opportunity->id); ?>
            <?php $organizationDetails = $organization->getDetailsById($organizationId); ?>
            <div class="single-opportunity">
                <a href="/opportunity/?id=<?php echo $opportunity->id; ?>">
                    <div class="top">
                        <div class="status fc-status list-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
                    </div>
                    <div class="bottom">
                        <div class="type">
                            <?php _e($opportunity->task_type, 'purpozed'); ?>
                        </div>
                        <div class="name">
                            <?php echo $organizationDetails['organization_name'][0]; ?>
                        </div>
                        <div class="opportunity">
                            <?php
                            if ($opportunity->task_type === 'call') {
                                $currentOpportunity = $opportunityManager->getSingleCall($opportunity->id);
                                $topic = $opportunityManager->getTopic($currentOpportunity->topic);
                                $focus = $opportunityManager->getFocuses($currentOpportunity->id);

                                foreach ($focus as $item):
                                    echo $item->name . ' ';
                                endforeach;

                                echo ' ' . $topic->name;

                            } elseif ($opportunity->task_type === 'project') {
                                $currentOpportunity = $opportunityManager->getSingleProject($opportunity->id);
                                $topic = $opportunityManager->getTopic($currentOpportunity->topic);

                                echo $topic->name . ' ';

                            } elseif ($opportunity->task_type === 'mentoring') {

                                $currentOpportunity = $opportunityManager->getSingleMentoring($opportunity->id);

                                echo $currentOpportunity->aoe_name . ' ';

                            } elseif ($opportunity->task_type === 'engagement') {
                                $currentOpportunity = $opportunityManager->getSingleEngagement($opportunity->id);

                                echo $currentOpportunity->title . ' ';
                            }
                            ?>
                        </div>
                        <div class="duration">
                            <?php $singularPlural = ($opportunity->duration_overall > 1) ? 'hours' : 'hour'; ?>
                            <?php ($opportunity->task_type === 'call') ? printf(__('%s hour', 'purpozed'), '1') : printf(__('%s %s', 'purpozed'), $opportunity->duration_overall, $singularPlural); ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="row more">
        <div class="more-button">
            MORE
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