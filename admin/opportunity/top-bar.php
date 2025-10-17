<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/admin/dashboard.php');
?>

<div class="operation-box">
    <?php if (isset($taskSave)): ?>
        <?php if ($taskSave): ?>
            <div class="success"><?php _e('Thank you for editing this opportunity', 'purpozed'); ?>!</div>
            <div class="success-three success">
                <div class="step-button"><a href="/"><?php _e('GO TO DASHBOARD', 'purpozed'); ?></a></div>
            </div>
        <?php else: ?>
            <div class="fail"><?php _e('Opportunity not saved. Database error.', 'purpozed'); ?></div>
        <?php endif; ?>
    <?php endif; ?>
</div>
