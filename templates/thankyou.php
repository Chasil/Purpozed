<?php
/*
Template Name: Thank you
*/
?>

<?php get_header(); ?>

    <div class="login-bar">
        <a href="/"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo.svg"></a>
    </div>
    <div class="thank-you">
        <div class="header"><?php _e('Almost done', 'purpozed'); ?></div>
        <div class="done-topic">
            <?php _e('Please confirm your signup by clicking the link in the email we just send to your email address', 'purpozed'); ?>
        </div>
        <div class="confirmation">
            <label>
                <a href="/confirmation"><?php _e('Please send me the confirmation email again', 'purpozed'); ?></a>
            </label>
        </div>
    </div>

<?php get_footer();