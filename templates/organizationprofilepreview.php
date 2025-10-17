<?php
/*
Template Name: Organization profile preview
*/
?>

<?php get_header();

if (!$dashboard_type) {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/login-form.php');
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/organization-profile-preview.php');
}

get_footer();
