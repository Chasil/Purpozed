<?php
/*
Template Name: Confirm registration
*/
?>
<?php get_header(); ?>

<div class="login-bar">
    <a href="/"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo.svg"></a>
</div>

<div class="thank-you">
    <div class="header"><?php _e('Email confirmation', 'purpozed'); ?></div>

    <?php
    $link1 = "<a href='/'>";
    $linkEnd = "</a>";
    ?>
    <?php if (isset($info)): ?>
        <?php if ($info === 10): ?>
            <div class="confirmation">
                <label>
                    <?php printf(__('Thank you for confirm! Your account is now active. Click %s here to login %s', 'purpozed'), $link1, $linkEnd); ?>
                </label>
            </div>
        <?php elseif ($info === 20): ?>
            <div class="confirmation">
                <label>
                    <?php printf(__('You have already confirmed your email! Click %s here to login %s', 'purpozed'), $link1, $linkEnd); ?>
                </label></div>
        <?php elseif ($info === 30): ?>
            <div class="confirmation">
                <label><?php _e('Something gone wrong. Check your email or register again', 'purpozed'); ?></div>
        <?php elseif ($info === 40): ?>
            <div class="confirmation">
                <label>
                    <?php printf(__('Key or id missing. %s Go back to homepage %s', 'purpozed'), $link1, $linkEnd); ?>
                </label>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
