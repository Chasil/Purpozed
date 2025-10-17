<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
$volunteerManager = new \Purpozed2\Models\VolunteersManager();
$organizationDetails = $volunteerManager->getCurrentUser()->getDetails();
?>
<div class="over-dashboard">
    <div class="dashboard-menu justify">
        <div class="title">
            <a href="<?php echo $language; ?>/"><img
                        src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo_claim_white.svg"></a>
        </div>

        <div class="menu-bar">
            <?php global $wp_filter; ?>
            <?php unset($wp_filter['wp_nav_menu_args']); ?>
            <?php if ($organizationMenu): ?>
                <?php wp_nav_menu(array('menu' => $organizationMenu)); ?>
            <?php else: ?>
                <div class="info-box"><?php _e('Menu for this section is not setup.', 'purpozed'); ?></div>
            <?php endif; ?>
        </div>
        <div class="select-option">
            <div class="select-menu">
                <div class="first-option"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                <div class="options">
                    <div class="single-option option-1"><a
                                href="<?php echo $language; ?>/organization-profile"><?php _e('My Profile', 'purpozed'); ?></a>
                    </div>
                    <div class="single-option option-1"><a
                                href="<?php echo $language; ?>/organization-settings"><?php _e('My Settings', 'purpozed'); ?></a>
                    </div>
                    <div class="single-option option-1"><a
                                href="<?php echo wp_logout_url(home_url()); ?>"><?php _e('Logout', 'purpozed'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>