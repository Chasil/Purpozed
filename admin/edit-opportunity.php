<?php if (!$hasId): ?>

    <div>No Opportunity or id is missing!</div>

<?php else: ?>
    <?php

    if ($task_type === 'call') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/admin/opportunity/call.php');
    } elseif ($task_type === 'project') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/admin/opportunity/project.php');
    } elseif ($task_type === 'mentoring') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/admin/opportunity/mentoring.php');
    } elseif ($task_type === 'engagement') {
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/admin/opportunity/engagement.php');
    }

endif; ?>