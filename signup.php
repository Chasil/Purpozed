<div class="login">
    <div class="header">
        <span><?php _e('Signup', 'purpozed'); ?></span>
    </div>
    <div class="login-form">
        <div class="login-form-row register">
            <a href="/signup/volunteer"><?php _e('SIGNUP AS A VOLUNTEER', 'purpozed'); ?></a>
        </div>
        <div class="login-form-row register">
            <a href="/signup/organization"><?php _e('SIGNUP AS AN ORGANIZATION', 'purpozed'); ?></a>
        </div>
        <div class="login-form-row links">
            <div>
                <a href="/"><?php _e('Login', 'purpozed'); ?></a>
            </div>
            <div>
                <a href="/password-reset/"><?php _e('Forgot your password?', 'purpozed'); ?></a>
            </div>
            <div>
                <a href="/confirmation"><?php _e('Please send me the confirmation email again', 'purpozed'); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="dashboard-menu footer">
    <?php $signInFooter = get_option('purpozed_sign_in_footer'); ?>
    <div class="menu-bar footer">
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