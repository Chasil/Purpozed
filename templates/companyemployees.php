<?php
/*
Template Name: Company Employees
*/
?>
<?php get_header();

if(!$dashboard_type) {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/login-form.php');
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/company/company-employees.php');
}

get_footer();