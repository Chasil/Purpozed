<div class="section preview single-opportunity register evaluation">
    <div class="columns">
        <div class="column evaluate preview">

            <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/textareas.php'); ?>

            <div class="show-more-evaluation-button medium-header prev-header"><?php _e('ABOUT THE OPPORTUNITY', 'purpozed'); ?>
                <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/arrow_down.svg"></div>
            <div class="show-more-evaluation-content">

                <div class="medium-header prev-header"><?php echo $opportunity->aoe_name; ?></div>

                <?php if (isset($opportunity->image)): ?>
                    <img src="<?php echo wp_get_attachment_image_src($opportunity->image, 'large')[0]; ?>">
                <?php endif; ?>
                <div class="text"><?php _e('Posted', 'purpozed'); ?><?php echo ' ' . str_replace('-', '/', substr($opportunity->posted, 0, -9)); ?></div>
                <div class="small-header"><?php _e('Needed Expertise', 'purpozed'); ?></div>
                <div class="skills prev-skills">
                    <div class="single-skill"><?php echo $opportunity->aoe_name; ?></div>
                </div>
                <div class="small-header"><?php _e('Expectations', 'purpozed'); ?></div>
                <div class="text prev-duration">
                    <?php echo stripslashes($opportunity->expectations); ?>
                </div>
                <div class="small-header"><?php _e('Duration & Time Frame', 'purpozed'); ?></div>
                <div class="text prev-duration">
                    <div class="prev-medium-header-smaller"><?php _e('Time requirement at least', 'purpozed'); ?><?php echo $duration_overall; ?><?php _e('hours', 'purpozed'); ?></div>
                    <div class="text prev-frequency"><?php _e('Meeting Frequency', 'purpozed'); ?>
                        : <?php echo $frequency; ?></div>
                    <div class="text prev-duration"><?php _e('Duration per Meeting', 'purpozed'); ?>
                        : <?php echo $opportunity->duration; ?> <?php echo ($opportunity->duration === '1') ? ' hour' : 'hours'; ?></div>
                    <div class="text prev-time-frame"><?php _e('Time frame at least', 'purpozed'); ?>
                        : <?php echo $time_frame; ?></div>
                </div>
                <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/organziation-info.php'); ?>

            </div>
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