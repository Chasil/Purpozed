<?php if ($opportunityStatus === 'review'): ?>
    <div class="edit">
        <button type="button" data-id="<?php echo $opportunityId; ?>"
                class="modal-activate-button step-button"><?php _e('ACTIVATE OPPORTUNITY', 'purpozed'); ?></button>
    </div>
<?php endif; ?>
<div class="done-button next skills"><input class="step-button" type="submit" name="save"
                                            value="<?php _e('SAVE CHANGES', 'purpozed'); ?>"></div>
<div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
<?php if ($opportunityStatus === 'review'): ?>
    <div class="edit">
        <button type="button" data-id="<?php echo $opportunityId; ?>"
                class="modal-delete-button step-button"><?php _e('DELETE FROM THE PLATFORM', 'purpozed'); ?></button>
    </div>
<?php endif; ?>

<div class="modal activate-ask">
    <div class="modal-overlay modal-activate-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">

        </div>
        <div class="modal-body">
            <div class="modal-content">
                <h3><?php _e('If you activate an opportunity it changes in the Status "OPEN". Therefore volunteers can see it and apply for it. The organization who posted this opportunity can see matching volunteers and request them taking over this opportunity.', 'purpozed'); ?>
                    !</h3>
                <button type="button" class="modal-edit activate-confirm"
                        data-id="<?php echo $opportunityId; ?>"><?php _e('ACTIVATE NOW', 'purpozed'); ?></button>
                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal delete-ask">
    <div class="modal-overlay modal-delete-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h1><?php _e('Delete Opportunity', 'purpozed'); ?></h1>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <h3><?php _e('Warning: Are you really sure you want to delete this opportunity? All possible current engagements of volunteers and the organization with this opportunity will be stopped irreversibly.', 'purpozed'); ?></h3>
                <button type="button" class="modal-edit delete-confirm"
                        data-id="<?php echo $opportunityId; ?>"><?php _e('DELETE', 'purpozed'); ?></button>
                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>