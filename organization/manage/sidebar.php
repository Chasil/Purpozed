<div class="row buttons-box">
    <?php
    $SingleOpportunity = new \Purpozed2\Models\Opportunity();
    $opporunityStatus = $SingleOpportunity->getStatus($opportunity_id);


    if ($opporunityStatus === 'open'):
        ?>
        <div class="retract dashboard">
            <button data-id="<?php echo $opportunity->task_id; ?>"
                    class="modal-retract-button-single step-button"><?php _e('RETRACT OPPORTUNITY', 'purpozed'); ?></button>
        </div>
    <?php elseif ($opporunityStatus === 'retracted'): ?>
        <div class="already_bookmarked"><?php _e('This Opportunity has been retracted', 'purpozed'); ?>.</div>
    <?php elseif ($opporunityStatus === 'prepared' || $opporunityStatus === 'review'): ?>
        <?php if ($opporunityStatus === 'review'): ?>
            <div class="opportunity-review-box">
                <span><?php printf(__('Under review. You have posted this %s and we are about to check and publish it within 24 hours.', 'purpozed'), $opportunity->task_type); ?></span>
            </div>
        <?php endif; ?>
        <?php if ($opporunityStatus === 'prepared'): ?>
            <div class="single-option profile retract dashboard">
                <button data-id="<?php echo $opportunity_id; ?>"
                        class="modal-delete-opportunity-single-button step-button"><?php _e('POST OPPORTUNITY', 'purpozed'); ?></button>
            </div>
            <div class="single-option profile retract dashboard">
                <button data-id="<?php echo $opportunity_id; ?>"
                        class="modal-delete-opportunity-single-button step-button"><?php _e('EDIT/WITHDRAW', 'purpozed'); ?></button>
            </div>
        <?php endif; ?>
        <div class="single-option profile retract dashboard">
            <button data-id="<?php echo $opportunity_id; ?>"
                    class="modal-delete-opportunity-single-button step-button"><?php _e('DELETE', 'purpozed'); ?></button>
        </div>

        <div class="modal delete-opportunity-single-ask">
            <div class="modal-overlay modal-apply-button"></div>
            <div class="modal-wrapper modal-transition">
                <div class="modal-header">
                    <h2 class="modal-heading"><?php _e('Delete opportunity', 'purpozed'); ?>?</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-content">
                        <P><?php _e('You want to delete this opportunity', 'purpozed'); ?>?</P>
                        <button class="modal-edit delete-opportunity-single-confirm"
                                data-id="<?php echo $opportunity_id; ?>"><?php _e('DELETE OPPORTUNITY', 'purpozed'); ?></button>
                        <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal delete-opportunity-single">
            <div class="modal-wrapper modal-transition">
                <div class="modal-header">
                    <h2 class="modal-heading"><?php _e('The Opportunity has beed deleted sucessfully', 'purpozed'); ?>
                        !</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-content">
                        <button class="modal-edit modal-edit go-dashboard"><?php _e('CLOSE', 'purpozed'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>

    <?php endif; ?>
    <div class="modal retract-ask-single">
        <div class="modal-overlay modal-apply-button"></div>
        <div class="modal-wrapper modal-transition">
            <div class="modal-header">
                <h2 class="modal-heading"><?php _e('Retract opportunity', 'purpozed'); ?>?</h2>
            </div>
            <div class="modal-body">
                <div class="modal-content">
                    <P><?php _e('You want to retract this opportunity? Please note that all volunteers requested by you and applied for this oppportunity will be informed automatically about your retraction via email', 'purpozed'); ?>
                        .</P>
                    <button class="modal-edit retract-confirm-single"
                            data-id="<?php echo $opportunity->task_id; ?>"><?php _e('RETRACT OPPORTUNITY', 'purpozed'); ?></button>
                    <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal retract-single">
        <div class="modal-wrapper modal-transition">
            <div class="modal-header">
                <h2 class="modal-heading"><?php _e('The Opportunity has beed retracted sucessfully', 'purpozed'); ?>
                    !</h2>
            </div>
            <div class="modal-body">
                <div class="modal-content">
                    <button class="modal-edit modal-edit reload-page"><?php _e('CLOSE', 'purpozed'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>