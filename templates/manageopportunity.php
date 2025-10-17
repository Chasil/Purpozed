<?php
/*
Template Name: Manage Opportunity
*/
?>
<?php get_header();


if(!$dashboard_type) {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/login-form.php');
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage-opportunity.php');
}


get_footer();