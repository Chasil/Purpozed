<form method="post" action="">
    <div class="login-form">
        <div class="reset-text"><?php _e('Enter your email to get new password', 'purpozed'); ?></div>
        <div class="login-form-input login">
            <label><?php _e('Enter E-mail', 'purpozed'); ?> <input type="email" name="email"
                                                                   placeholder="E-mail"></label>
        </div>
        <div class="login-form-input email">
            <input type="submit" name="submit" value="<?php _e('Restore', 'purpozed'); ?>">
        </div>
        <div class="login-form-input email">
            <div>
                <a href="/register"><?php _e('Not registered yet? Create an account!', 'purpozed'); ?></a>
            </div>
        </div>
    </div>
</form>

<div class="dashboard-menu footer">
    <?php $signInFooter = get_option('purpozed_sign_in_footer'); ?>
    <div class="menu-bar footer">
        <?php if ($signInFooter): ?>
            <?php wp_nav_menu(array('menu' => $signInFooter)); ?>
        <?php else: ?>
            <div class="info-box"><?php _e('Menu for this section is not setup.', 'purpozed'); ?></div>
        <?php endif; ?>
    </div>
</div>