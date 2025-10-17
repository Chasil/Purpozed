<?php
if ($dashboard_type === 'volunteer') {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/header.php');
} elseif ($dashboard_type === 'organization') {
    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/header.php');
}
?>

<?php if (!$hasId): ?>

    <div><?php _e('No Opportunity or id is missing!', 'purpozed'); ?></div>

<?php else: ?>

    <?php
    if ($task_type === 'call') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/call.php');
    } elseif ($task_type === 'project') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/project.php');
    } elseif ($task_type === 'mentoring') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/mentoring.php');
    } elseif ($task_type === 'engagement') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/engagement.php');
    }

endif; ?>