<div class="login">
    <div class="dashboard-menu no-background">
        <div class="logo">
            <a href="/"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo.svg"></a>
        </div>
    </div>
    <div class="header">
        <span><?php _e('Login', 'purpozed'); ?></span>
    </div>
    <form method="post" action="">
        <div class="login-form">
            <div class="login-form-row">
                <label><?php _e('E-MAIL ADDRESS', 'purpozed'); ?> <input type="text" name="login" required></label>
            </div>
            <div class="login-form-row email">
                <label><?php _e('ENTER PASSWORD', 'purpozed'); ?> <input type="password" name="password"
                                                                         required></label>
            </div>
            <?php if (isset($errors)): ?>
                <div class="errors">
                    <?php echo $errors; ?>
                </div>
            <?php endif; ?>
            <?php if (isset($login_errors)): ?>
                <?php foreach ($login_errors as $login_error): ?>
                    <div class="errors">
                        <?php echo $login_error[0]; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (isset($deactivated)): ?>
                <div class="errors">
                    <?php _e("Your account is currently deactivated. To activate it again please contact Administrator", "purpozed"); ?>
                    <a href="mailto:support@purpozed.org" target="_blank">support@purpozed.org</a>
                </div>
            <?php elseif (isset($not_register)): ?>
                <div class="errors">
                    <?php _e("Your account hasn't beed confirmed yet. Check you email and confirm registration", "purpozed"); ?>
                </div>
            <?php endif; ?>
            <div class="login-form-row checkbox new">
                <input type="checkbox" name="logged-in" id="stay">
                <label for="stay"></label>
                <div><?php _e('Stay logged in', 'purpozed'); ?></div>
            </div>
            <div class="login-form-row submit">
                <input type="submit" name="submit" value="<?php _e('Login', 'purpozed'); ?>">
            </div>
            <div class="login-form-row links">
                <div>
                    <a href="/signup"><?php _e('Not registered yet? Create an account!', 'purpozed'); ?></a>
                </div>
                <div>
                    <a href="/password-reset/"><?php _e('Forgot your password?', 'purpozed'); ?></a>
                </div>
                <div>
                    <a href="/confirmation"><?php _e('Please send me the confirmation email again', 'purpozed'); ?></a>
                </div>
            </div>
        </div>
    </form>
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