<?php
/*
Template Name: Confirm registration
*/
?>
<?php get_header(); ?>

    <div class="login-bar">
        <a href="/"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo.svg"></a>
    </div>

<?php if (isset($info['success'])): ?>

    <div class="thank-you">
        <div class="header"><?php _e('An email has been sent. Check your inbox.', 'purpozed'); ?></div>
        <div class="confirmation">
            <label>
                <a href="/"><?php _e('Login here', 'purpozed'); ?></a>
            </label>
        </div>
    </div>

<?php elseif (isset($info['email-fail']) || isset($info['no-email']) || !$info): ?>

    <?php echo (isset($info['email-fail'])) ? '<div class="restore-fail">' . printf(__('%s', 'purpozed'), $info['email-fail']) . '</div>' : ''; ?>
    <?php echo (isset($info['no-email'])) ? '<div class="restore-fail">' . printf(__('%s', 'purpozed'), $info['no-email']) . '</div>' : ''; ?>

    <form method="post" action="">
        <div class="login-form">
            <div class="reset-text"><?php _e('Enter your email to get new password', 'purpozed'); ?></div>
            <div class="login-form-input email">
                <input type="email" name="email" placeholder="E-mail">
            </div>
            <div class="login-form-input submit">
                <input type="submit" name="submit" value="<?php _e('Restore', 'purpozed'); ?>">
            </div>
        </div>
    </form>
<?php endif; ?>

<?php get_footer();