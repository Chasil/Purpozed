<?php
/*
Template Name: Regenerate confirmation
*/
?>
<?php get_header(); ?>

    <div class="login-bar">
        <a href="/"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo.svg"></a>
    </div>

    <div class="thank-you">
    <div class="header"><?php _e('Regenerate confirmation email', 'purpozed'); ?></div>

<?php if(isset($info)): ?>

    <?php if($info === 20): ?>
        <div class="confirmation success error-box-on"><label><?php _e('An email has been sent. Check your inbox.', 'purpozed'); ?> <a href="/"><?php _e("here to login", 'purpozed'); ?></a></label></div>
    <?php elseif($info === 10): ?>
        <div class="confirmation error-box error-box-on"><label><?php _e('You have already confirmed your email! Click', 'purpozed'); ?> <a href="/"><?php _e("here to login", 'purpozed'); ?></a></label></div>
    <?php elseif($info === 30): ?>
        <div class="confirmation error-box error-box-on"><label><?php _e('Something gone wrong. Check your email or register again', 'purpozed'); ?>.</div>
    <?php elseif($info === 40): ?>
        <div class="confirmation error-box error-box-on"><label><?php _e('There is no such email in our database', 'purpozed'); ?>.&nbsp<a href="/"><?php _e("Go back to homepage", 'purpozed'); ?></a></label></div>
    <?php endif; ?>

    </div>

<?php else: ?>

    <form method="post" action="">
        <div class="login-form">
            <div class="reset-text"><?php _e('Enter your email to get activation link', 'purpozed'); ?></div>
            <div class="login-form-input email">
                <input type="email" name="email" placeholder="E-mail">
            </div>
            <div class="login-form-input submit">
                <input type="submit" name="submit" value="<?php _e('Resend', 'purpozed'); ?>">
            </div>
        </div>
    </form>
<?php endif; ?>

<?php get_footer();
