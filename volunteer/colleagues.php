<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/header.php');
?>

<div class="dashboard organization-dashboard">
    <div class="posted" id="posted">
        <div class="volunteer-box">
            <div class="title"><?php _e('Recently onboarded colleagues', 'purpozed'); ?></div>
            <?php foreach ($colleagues as $colleague): ?>
                <div class="single-volunteer colleagues">
                    <div class="last-seen">
                        <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/star.svg">
                        <div class="time">
                            <?php
                            if ($colleague['last_login_seconds'] === 0) {
                                echo 'Did not login yet';
                            } else {
                                $dtF = new \DateTime('@0');
                                $dtT = new \DateTime("@" . $colleague['last_login_seconds'] . "");
                                echo $dtF->diff($dtT)->format('%a days, %h hours, %i minutes ago');
                            }
                            ?>
                        </div>
                    </div>
                    <div class="data">
                        <div class="picture"><img
                                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/profile_picture.png"></div>
                        <div class="details colleagues-details">
                            <div class="name"><?php echo $colleague['first_name'] . ' '; ?><?php echo $colleague['last_name']; ?></div>
                            <div class="job_title"><?php echo $colleague['title']; ?></div>
                            <div class="corporation"><?php echo $colleague['company']; ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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