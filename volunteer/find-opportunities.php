<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/header.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');

$opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager();

?>


<div class="find-opportunity">

    <form method="get" action="" id="filter-types">
        <div class="row types">
            <div class="filter-type">
                <label for="filter1"
                       class="<?php echo ((isset($_GET['filter-type'])) && $_GET['filter-type'] === '1') ? 'active' : ''; ?>"><?php _e('Social & Skills-based Activities', 'purpozed'); ?>
                    <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/heart.svg">
                    <input id="filter1" type="radio" name="filter-type" value="1">
                </label>
            </div>
            <div class="filter-type">
                <label for="filter2"
                       class="<?php echo ((isset($_GET['filter-type'])) && $_GET['filter-type'] === '2') ? 'active' : ''; ?>"><?php _e('Only Social Activities', 'purpozed'); ?>
                    <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_favorite.svg">
                    <input id="filter2" type="radio" name="filter-type" value="2">
                </label>
            </div>
            <div class="filter-type">
                <label for="filter3"
                       class="<?php echo ((isset($_GET['filter-type'])) && $_GET['filter-type'] === '3') ? 'active' : ''; ?>"><?php _e('Only Skills-based Activities', 'purpozed'); ?>
                    <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_build.svg">
                    <input id="filter3" type="radio" name="filter-type" value="3">
                </label>
            </div>
        </div>
        <input type="hidden" name="filters-types" value="main-types">
    </form>


    <form method="get" action="" id="my_activities">
        <div class="row filters-controlls margin-top30">

            <div class="button-on no-text find-opportunities-switcher">
                <input type="checkbox" name="only_my_activities"
                       id="only_my_activities" <?php echo ($myActivities === true) ? ' checked="checked"' : ''; ?>>
                <label for="only_my_activities"
                       class="<?php echo ($myActivities === true) ? 'checked' : ''; ?>"></label>
                <?php
                $linkStart = '<a href="/volunteer-profile/">';
                $linkEnd = '</a>';
                ?>
                <div class="header-5"><?php printf(__('Only Activities that fits to my %sProfile%s', 'purpozed'), $linkStart, $linkEnd); ?></div>
            </div>
        </div>
        <input type="hidden" name="my-activities" value="<?php echo ($myActivities === true) ? 'true' : 'false'; ?>">
    </form>

    <div class="row filters-controlls margin-top30">
        <div class="more-info-header two">
                        <span class="header-6"><?php _e('More Filters', 'purpozed'); ?> <img
                                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/arrow_down.svg"></span>
        </div>
        <div class="more-info-box <?php echo (isset($_GET['goals']) || isset($_GET['skills']) || isset($_GET['durations']) || isset($_GET['distance'])) ? '' : 'hideItem'; ?>">
            <form method="get" action="" id="filtering_form">
                <div class="row filters">
                    <div class="search-item goals">
                        <div name="goals">
                            <div class="search-select mode-1"><?php _e('Goals', 'purpozed'); ?>
                                <span class="filter_counter"><?php echo (isset($_GET['goals']) && count($_GET['goals']) > 0) ? '(' . count($_GET['goals']) . ')' : ''; ?></span>
                            </div>
                            <div class="options-select">
                                <?php foreach ($goals as $goal): ?>
                                    <div class="single-option">
                                        <input type="checkbox" name="goals[]" value="<?php echo $goal['id']; ?>"
                                               id="goal_<?php echo $goal['id']; ?>" <?php if (isset($_GET['goals'])) {
                                            foreach ($_GET['goals'] as $searched => $value) {
                                                if ($value === $goal['id']) {
                                                    echo "checked='checked'";
                                                }
                                            }
                                        } ?>>
                                        <label for="goal_<?php echo $goal['id']; ?>"><?php echo $goal['name']; ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="search-item skills">
                        <div name="skills">
                            <div class="search-select mode-1"><?php _e('Skills', 'purpozed'); ?>
                                <span class="filter_counter"><?php echo (isset($_GET['skills']) && count($_GET['skills']) > 0) ? '(' . count($_GET['skills']) . ')' : ''; ?></span>
                            </div>
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
                    <div class="search-item duration">
                        <div name="format">
                            <div class="search-select mode-1"><?php _e('Duration', 'purpozed'); ?>
                                <span class="filter_counter"><?php echo (isset($_GET['durations']) && count($_GET['durations']) > 0) ? '(' . count($_GET['durations']) . ')' : ''; ?></span>
                            </div>
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
                                    <input type="checkbox" name="durations[]" value="2"
                                           id="duration_2" <?php if (isset($_GET['durations'])) {
                                        foreach ($_GET['durations'] as $searched => $value) {
                                            if ($value === "2") {
                                                echo "checked='checked'";
                                            }
                                        }
                                    } ?>>
                                    <label for="duration_2"><?php _e('1 day max', 'purpozed'); ?></label>
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
                    <div class="search-item distance" id="distance">
                        <div name="format">
                            <div class="search-select mode-1"><?php _e('Distance', 'purpozed'); ?>
                                <span class="filter_counter"><?php echo (isset($_GET['distance']) && count($_GET['distance']) > 0) ? '(' . $_GET['distance'][0] . ' km)' : ''; ?></span>
                            </div>
                            <div class="options-select">
                                <?php if (isset($distancesList)): ?>
                                    <?php foreach ($distancesList as $distance): ?>
                                        <div class="single-option">
                                            <input type="radio" name="distance[]" value="<?php echo $distance; ?>"
                                                   class="distance_radio"
                                                   id="distance_<?php echo $distance; ?>" <?php if (isset($_GET['distance'])) {
                                                foreach ($_GET['distance'] as $value) {
                                                    if ((int)$value === (int)$distance) {
                                                        echo "checked='checked'";
                                                    }
                                                }
                                            } ?>>
                                            <label for="distance_<?php echo $distance; ?>"
                                                   class="radio"><?php echo $distance; ?>
                                                km</label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div id="overlay">
                            <div class="cv-spinner">
                                <span class="spinner"></span>
                            </div>
                        </div>
                    </div>
                    <div class="look">
                        <div class="filter-item search type-2"><input type="submit"
                                                                      value="<?php _e('APPLY FILTER', 'purpozed'); ?>">
                        </div>
                    </div>
                </div>
            </form>
            <div class="save-clear">
                <div class="filters-item clear"><?php _e('Clear filter', 'purpozed'); ?></div>
            </div>
        </div>
    </div>
    <?php if (empty($distancesOrganizations) && (isset($_GET['distance']))): ?>
        <?php $currentOpportunitiesNumber = 0; ?>
    <?php endif; ?>
    <div class="row filters-controlls current-amount <?php echo (isset($_GET['goals']) || isset($_GET['skills']) || isset($_GET['durations']) || isset($_GET['distance'])) ? 'margin-top-100' : ''; ?>">
        <div class="amount">
            <div class=""><?php echo $currentOpportunitiesNumber . ' '; ?><?php _e('of', 'purpozed'); ?><?php echo ' ' . $allOpenOpportunitiesNumber; ?>
                <?php _e('Opportunities', 'purpozed'); ?>
            </div>
        </div>
    </div>


    <div class="row list">
        <?php $count = 0; ?>
        <?php $organization = new \Purpozed2\Models\Organization(); ?>
        <?php $singleOpportunity = new \Purpozed2\Models\Opportunity(); ?>
        <?php if (empty($distancesOrganizations) && isset($_GET['distance'])): ?>

            <div class="row filters-controlls current-amount">
                <div class="amount">
                    <div class="info-box no-opportunities"><?php _e('No opportunities in range 200 km.', 'purpozed'); ?></div>
                </div>
            </div>

        <?php else: ?>

            <?php foreach ($opportunities as $opportunity): ?>
                <?php $organizationId = $singleOpportunity->getOrganization($opportunity->id); ?>
                <?php $organizationDetails = $organization->getDetailsById($organizationId); ?>
                <?php if ($count < 15): ?>
                    <div class="single-opportunity">
                        <a href="<?php echo $language; ?>/opportunity/?id=<?php echo $opportunity->id; ?>">
                            <div class="top"
                                 style="<?php echo (wp_get_attachment_image_src($opportunity->image, 'large')) ? 'background: url(' . wp_get_attachment_image_src($opportunity->image, 'large')[0] . ')' : 'background: #F0F0F0 0% 0% no-repeat padding-box;'; ?>">
                                <div class="status fc-status list-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
                            </div>
                            <div class="bottom">
                                <div class="name">
                                    <?php echo (isset($organizationDetails['organization_name'])) ? $organizationDetails['organization_name'][0] : '-'; ?>
                                </div>
                                <div class="opportunity">
                                    <?php
                                    if ($opportunity->task_type === 'call') {
                                        $currentOpportunity = $opportunitiesManager->getSingleCall($opportunity->id);
                                        $topic = $opportunitiesManager->getTopic($currentOpportunity->topic);
                                        $focus = $opportunitiesManager->getFocuses($currentOpportunity->id);

                                        foreach ($focus as $item):
                                            echo $item->name . ' ';
                                        endforeach;

                                        echo ' ' . $topic->name;

                                    } elseif ($opportunity->task_type === 'project') {
                                        $currentOpportunity = $opportunitiesManager->getSingleProject($opportunity->id);
                                        $topic = $opportunitiesManager->getTopic($currentOpportunity->topic);

                                        echo $topic->name . ' ';

                                    } elseif ($opportunity->task_type === 'mentoring') {

                                        $currentOpportunity = $opportunitiesManager->getSingleMentoring($opportunity->id);

                                        echo $currentOpportunity->aoe_name . ' ';

                                    } elseif ($opportunity->task_type === 'engagement') {
                                        $currentOpportunity = $opportunitiesManager->getSingleEngagement($opportunity->id);

                                        echo $currentOpportunity->title . ' ';
                                    }
                                    ?>
                                </div>
                                <div class="bottom-line">
                                    <div class="duration">
                                        <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/clock.svg">
                                        <?php ($opportunity->duration_overall > 1) ? printf(__('%d hours', 'purpozed'), $opportunity->duration_overall) : printf(__('1 hour', 'purpozed'), '1'); ?>
                                    </div>
                                    <div class="type">
                                        <?php _e($opportunity->task_type, 'purpozed'); ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="single-opportunity hidden">
                        <a href="<?php echo $language; ?>/opportunity/?id=<?php echo $opportunity->id; ?>">
                            <div class="top"
                                 style="<?php echo (wp_get_attachment_image_src($opportunity->image, 'large')) ? 'background: url(' . wp_get_attachment_image_src($opportunity->image, 'large')[0] . ')' : 'background: #F0F0F0 0% 0% no-repeat padding-box;'; ?>">
                                <div class="status fc-status list-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="name">
                                    <?php echo (isset($organizationDetails['organization_name'])) ? $organizationDetails['organization_name'][0] : '-'; ?>
                                </div>
                                <div class="opportunity">
                                    <?php
                                    if ($opportunity->task_type === 'call') {
                                        $currentOpportunity = $opportunitiesManager->getSingleCall($opportunity->id);
                                        $topic = $opportunitiesManager->getTopic($currentOpportunity->topic);
                                        $focus = $opportunitiesManager->getFocuses($currentOpportunity->id);

                                        foreach ($focus as $item):
                                            echo $item->name . ' ';
                                        endforeach;

                                        echo ' ' . $topic->name;

                                    } elseif ($opportunity->task_type === 'project') {
                                        $currentOpportunity = $opportunitiesManager->getSingleProject($opportunity->id);
                                        $topic = $opportunitiesManager->getTopic($currentOpportunity->topic);

                                        echo $topic->name . ' ';

                                    } elseif ($opportunity->task_type === 'mentoring') {

                                        $currentOpportunity = $opportunitiesManager->getSingleMentoring($opportunity->id);

                                        echo $currentOpportunity->aoe_name . ' ';

                                    } elseif ($opportunity->task_type === 'engagement') {
                                        $currentOpportunity = $opportunitiesManager->getSingleEngagement($opportunity->id);

                                        echo $currentOpportunity->title . ' ';
                                    }
                                    ?>
                                </div>
                                <div class="bottom-line">
                                    <div class="duration">
                                        <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/clock.svg">
                                        <?php ($opportunity->duration_overall > 1) ? printf(__('%d hours', 'purpozed'), $opportunity->duration_overall) : printf(__('1 hour', 'purpozed'), '1'); ?>
                                    </div>
                                    <div class="type">
                                        <?php _e($opportunity->task_type, 'purpozed'); ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php $count++; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php if ($currentOpportunitiesNumber > 15): ?>
        <div class="row more">
            <div class="more-button">
                <?php _e('MORE', 'purpozed'); ?>
            </div>
        </div>
    <?php endif; ?>
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