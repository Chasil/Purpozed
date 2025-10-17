<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>

<div class="operation-box">
    <?php if (isset($taskSave)): ?>
        <?php if ($taskSave): ?>
            <?php if ($status === 'review'): ?>
                <div class="success"><?php _e('Thank you for posting this opportunity', 'purpozed'); ?>!</div>
                <div class="success-two success">
                    <div><?php _e('We will check your opportunity within the next 24 hours and make it public or - in case of possible inquiries - get in touch with you respectively. After publishing you will find this opportunity on your dashboard in the table "Posted opportunities". There you will also find appropriate volunteers you can get in contact', 'purpozed'); ?>
                        .
                    </div>
                </div>
                <div class="success-three success">
                    <div class="step-button"><a
                                href="/<?php echo $language; ?>"><?php _e('GO TO DASHBOARD', 'purpozed'); ?></a></div>
                </div>
            <?php elseif ($status === 'prepared'): ?>
                <div class="success"><?php _e('You saved this posting successfully', 'purpozed'); ?>!</div>
                <div class="success-two success">
                    <div><?php _e('You find this opportunity from now onwards on your dashboard in the table "Saved opportunities". From there you can open it again, edit and post it.', 'purpozed'); ?>
                        .
                    </div>
                </div>
                <div class="success-three success">
                    <div class="step-button"><a
                                href="/<?php echo $language; ?>"><?php _e('GO TO DASHBOARD', 'purpozed'); ?></a></div>
                </div>
            <?php else: ?>
                <div class="fail"><?php _e('Opportunity not saved. Database error.', 'purpozed'); ?></div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
