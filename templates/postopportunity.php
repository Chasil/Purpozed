<?php
/*
Template Name: Login
*/
?>
<?php get_header();

if(!$dashboard_type) {
    header('Location: /');
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/post-opportunity.php');

    if($taskType === 'call') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/opportunity/call.php');
    } elseif($taskType === 'project') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/opportunity/project.php');
    } elseif($taskType === 'mentoring') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/opportunity/mentoring.php');
    } elseif($taskType === 'engagement') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/opportunity/engagement.php');
    } else {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/opportunity/dashboard.php');
    }
}

get_footer();