<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/header.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>

<div class="edit-profie">
    <div class="edit-header"><?php _e('Volunteer Profile', 'purpozed'); ?></div>
    <div class="columns">
        <div class="single-column first">
            <div class="volunteer-box-right">
                <div class="picture"><img src="<?php echo wp_get_attachment_image_src($details['image'][0])[0]; ?>">
                </div>
                <div class="data-together">
                    <div class="name"><?php echo $details['first_name'][0] . ' ' . $details['last_name'][0]; ?></div>
                    <div class="job_title v-title"><?php echo $details['title'][0]; ?></div>
                    <div class="corporation v-title"><?php echo $organizationName; ?></div>
                </div>
                <div class="data-together">
                    <div class="succeded v-title">
                        <div><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/trophy.svg"></div>
                        <div><?php echo $succeededOpportunties . ' '; ?><?php _e('succeeded opportunities', 'purpozed'); ?></div>
                    </div>
                    <div class="hours v-title">
                        <div><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/hands.svg"></div>
                        <div><?php echo $helpedHours . ' '; ?><?php _e('hours helped', 'purpozed'); ?></div>
                    </div>
                    <div class="status v-title">
                        <div> <?php
                            if ($details['ready_for_request'][0] === 'on') { ?>
                                <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/wifi.svg">
                                <?php
                            } else { ?>
                                <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/no_wifi.svg">
                                <?php
                            }
                            ?>
                        </div>
                        <div>
                            Status: <?php if (isset($details['ready_for_request'][0])) {
                                if ($details['ready_for_request'][0] === 'on') {
                                    _e('Ready for requests');
                                } else {
                                    _e('Not ready for requests', 'purpozed');
                                }
                            } else {
                                _e('Not ready for requests', 'purpozed');
                            } ?> </div>
                    </div>
                </div>
                <div class="buttons">
                    <div class="profile same">
                        <button>
                            <a href="<?php echo $language; ?>/volunteer-settings/"><?php _e('Edit profile', 'purpozed'); ?></a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-column second">
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('Skills', 'purpozed'); ?></div>
                    <div class="link"><a
                                href="<?php echo $language; ?>/volunteer-settings/"><?php _e('EDIT', 'purpozed'); ?></a>
                    </div>
                </div>
                <div class="skills">
                    <?php foreach ($skills as $skill): ?>
                        <div class="single-skill"><?php echo $skill->name; ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('Goals', 'purpozed'); ?></div>
                    <div class="link"><a
                                href="<?php echo $language; ?>/volunteer-settings/"><?php _e('EDIT', 'purpozed'); ?></a>
                    </div>
                </div>
                <div class="skills">
                    <?php foreach ($goals as $goal): ?>
                        <div class="single-skill"><?php echo $goal->name; ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('About me', 'purpozed'); ?></div>
                    <div class="link"><a
                                href="<?php echo $language; ?>/volunteer-settings/"><?php _e('EDIT', 'purpozed'); ?></a>
                    </div>
                </div>
                <div class="text-2">
                    <?php echo (isset($details['about'][0])) ? $details['about'][0] : ''; ?>
                </div>
            </div>
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('Experience', 'purpozed'); ?></div>
                    <div class="link"><a
                                href="<?php echo $language; ?>/volunteer-settings/"><?php _e('EDIT', 'purpozed'); ?></a>
                    </div>
                </div>
                <div class="text-2">
                    <?php foreach ($experiences as $experience): ?>
                        <div class="link"><?php echo $experience->text; ?></a></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('Links', 'purpozed'); ?></div>
                    <div class="link"><a
                                href="<?php echo $language; ?>/volunteer-settings/"><?php _e('EDIT', 'purpozed'); ?></a>
                    </div>
                </div>
                <div class="text-2">
                    <?php foreach ($links as $link): ?>
                        <div class="link"><a href="<?php echo $link->url; ?>"
                                             target="_blank"><?php echo $link->name; ?></a></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!--            <div class="items-box">-->
            <!--                <div class="items-box-buttons">-->
            <!--                    <div class="link straight"><a href="/volunteer-settings/">-->
            <?php //_e('My Website', 'purpozed'); ?><!--</a></div>-->
            <!--                </div>-->
            <!--            </div>-->
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