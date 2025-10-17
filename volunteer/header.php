<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
$volunteerManager = new \Purpozed2\Models\VolunteersManager();
$volunteerDetails = $volunteerManager->getCurrentUser()->getDetails();
$image = wp_get_attachment_image_url($volunteerDetails['image'][0]);
?>
<div class="over-dashboard">
    <div class="dashboard-menu justify">
        <div class="logo">
            <a href="<?php echo $language; ?>/"><img
                        src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo_claim_white.svg"></a>
        </div>

        <div class="menu-bar">
            <?php global $wp_filter; ?>
            <?php unset($wp_filter['wp_nav_menu_args']); ?>
            <?php if ($volunteersMenuId): ?>
                <?php wp_nav_menu(array('menu' => $volunteersMenuId)); ?>
            <?php else: ?>
                <div class="info-box"><?php _e('Menu for this section is not setup.', 'purpozed'); ?></div>
            <?php endif; ?>
        </div>
        <div class="select-option">
            <div class="select-menu">
                <div class="first-option"><img
                            src="<?php echo $image; ?>"><?php echo $volunteerDetails['first_name'][0]; ?>
                </div>
                <div class="options">
                    <div class="single-option option-1"><a
                                href="<?php echo $language; ?>/volunteer-profile/"><?php _e('My Profile', 'purpozed'); ?></a>
                    </div>
                    <div class="single-option option-1"><a
                                href="<?php echo $language; ?>/volunteer-settings/"><?php _e('My Settings', 'purpozed'); ?></a>
                    </div>
                    <?php if (isset(get_user_meta(get_current_user_id(), 'is_admin')[0])): ?>
                        <?php if (get_user_meta(get_current_user_id(), 'is_admin')[0] === '1'): ?>
                            <div class="single-option option-1"><a
                                        href="<?php echo $language; ?>/company-area/"><?php _e('Company Dashboard   ', 'purpozed'); ?></a>
                            </div>
                            <!--                    <div class="single-option option-1"><a href="/company-profile">Company Profile</a></div>-->
                            <div class="single-option option-1"><a
                                        href="<?php echo $language; ?>/company-settings/"><?php _e('Company Settings', 'purpozed'); ?></a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="single-option option-1"><a
                                href="<?php echo wp_logout_url(home_url()); ?>"><?php _e('Logout', 'purpozed'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>