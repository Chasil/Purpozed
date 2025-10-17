<?php
/*
Template Name: Login
*/
?>
<?php get_header();

if ($dashboard_type === 'guest') {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/login-form.php');
} elseif ($dashboard_type === 'volunteer') {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/dashboard.php');
} elseif ($dashboard_type === 'organization') {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/dashboard.php');
} elseif ($dashboard_type === 'company') {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/company/dashboard.php');
} else {

}

get_footer();