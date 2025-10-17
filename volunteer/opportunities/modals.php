<div class="modal apply-ask">
    <div class="modal-overlay modal-apply-ask-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Are you sure you want to apply for that opportunity', 'purpozed'); ?>
                ?</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button class="modal-edit apply-confirm"
                        data-id="<?php echo $opportunityId; ?>"><?php _e('YES, I WANT TO APPLY', 'purpozed'); ?></button>
                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal apply">
    <div class="modal-overlay modal-apply-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Thank you for your application for this opportunity', 'purpozed'); ?>
                !</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <P><?php _e('We will inform the organization about your application in the coming minutes.', 'purpozed'); ?></P>
                <P><?php _e('You will find this opportunity from now onwards on your dashboard in the table “Applied.', 'purpozed'); ?></P>
                <button class="modal-edit modal-edit reload-page"><?php _e('OK', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal take-over-ask">
    <div class="modal-overlay modal-take-over-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Great that you want to take over this opportunity!', 'purpozed'); ?>
            </h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <p><?php _e('Please remember: If you take over this opportunity, colleagues also interested in it will receive a cancellation. So please only take over if you want to start seriously.', 'purpozed'); ?></p>
                <button class="modal-edit take-over-confirm"
                        data-id="<?php echo $opportunityId; ?>"
                        data-type="<?php echo $task_type; ?>"><?php _e('TAKE OVER OPPORTUNITY', 'purpozed'); ?></button>
                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal take-over">
    <div class="modal-overlay modal-take-over-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Congratulation your opportunity has just started!', 'purpozed'); ?>
                !</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <P><?php _e('Please try to get in contact with the organization in the next 24 hour via email or telephone and talk about the next steps.  ', 'purpozed'); ?></P>
                <P><?php _e('You find the contact data of the organization on the opportunity site. ', 'purpozed'); ?></P>
                <P><?php _e('We will inform other interested volunteers about your choice via email in the coming minutes.', 'purpozed'); ?></P>
                <P><?php _e('You find this opportunitiy from now onwards on your dashboard in the table "In Progress".', 'purpozed'); ?></P>
                <P><?php _e('We wish you success!', 'purpozed'); ?></P>
                <button class="modal-edit modal-edit go-dashboard"><?php _e('GO TO DASHBOARD', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal apply-fail">
    <div class="modal-overlay modal-apply-fail-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Something gone wrong. Please try again.', 'purpozed'); ?>!</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button class="modal-edit modal-edit"><?php _e('CLOSE', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal bookmark">
    <div class="modal-overlay modal-bookmark-buttona"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Are you sure you want to bookmark this opportunity', 'purpozed'); ?>
                ?</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button class="modal-edit save-bookmark"
                        data-id="<?php echo $opportunityId; ?>"><?php _e('BOOKMARK', 'purpozed'); ?></button>
                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal bookmark-added">
    <div class="modal-overlay modal-bookmark-added-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Opportunity has been bookmarked', 'purpozed'); ?>!</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <P><?php _e('This opportuniy has beed added to your bookmarked list.', 'purpozed'); ?></P>
                <P><?php _e('You can find it in your dashboard', 'purpozed'); ?></P>
                <button class="modal-close modal-edit reload-page"><?php _e('CLOSE', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal email">
    <div class="modal-overlay modal-email-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('This is the contact person for this particular opportunity', 'purpozed'); ?>
                !</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <P><?php echo $opportunity->contact_name . ' ' . $opportunity->contact_surname; ?></P>
                <P><?php _e('Telephone', 'purpozed'); ?>: <?php echo $opportunity->contact_phone; ?></P>
                <P><?php _e('Email', 'purpozed'); ?>: <?php echo $opportunity->contact_email; ?></P>
                <button class="modal-edit"><a
                            href="mailto:<?php echo $opportunity->contact_email; ?>"
                            target="_blank"><?php _e('WRITE AN EMAIL', 'purpozed'); ?></a>
                </button>
                <button class="modal-close modal-edit"><?php _e('CLOSE', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal remove-ask">
    <div class="modal-overlay modal-remove-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Are you sure you want to remove this opportunity from the list?', 'purpozed'); ?>
                ?</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button class="modal-edit remove-confirm" data-reject="1"
                        data-id="<?php echo $opportunityId; ?>"><?php _e('REMOVE', 'purpozed'); ?></button>
                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal remove">
    <div class="modal-overlay modal-remove-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('This opportunity has been removed from your list', 'purpozed'); ?>
                !</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button
                        class="modal-edit modal-edit go-dashboard"><?php _e('OK', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal retract-application-ask">
    <div class="modal-overlay modal-retract-application-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Retract application', 'purpozed'); ?>
                ?</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <p><?php _e('You are not interested in this opportunity any longer? No problem! If you retract your application we will inform the organization in the coming minutes via E-Mail.', 'purpozed'); ?></p>
                <button class="modal-edit retract-application-confirm" data-retract="1"
                        data-id="<?php echo $opportunityId; ?>"><?php _e('RETRACT APPLICATION', 'purpozed'); ?></button>
                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal retract-application">
    <div class="modal-overlay modal-retract-application-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Your application has been retracted', 'purpozed'); ?>
                !</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button
                        class="modal-edit modal-edit go-dashboard"><?php _e('OK', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal complete-opportunity-ask">
    <div class="modal-overlay modal--opportunity-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Great that you want to succeed this opportunity', 'purpozed'); ?>
                !</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <P><?php _e('To complete this opportunity, please write a comment about your work and the collaboration with the organization', 'purpozed'); ?>
                    .</P>
                <button class="modal-edit"><a
                            href="<?php echo $language; ?>/evaluate/?id=<?php echo $opportunityId; ?>"><?php _e('EVALUATE NOW', 'purpozed'); ?></a>
                </button>
                <button class="modal-close modal-edit"><?php _e('BACK', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal cancel-opportunity-ask">
    <div class="modal-overlay modal-cancel-opportunity-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('This opportunity is not completed but you want to cancel it prematurely?', 'purpozed'); ?>
            </h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <P><?php _e('No problem. To cancel prematurely please tell us about the reason. If you cancel we will inform the organization in the coming minutes via E-Mail. You are welcome to start another opportunity any time!', 'purpozed'); ?>
                    .</P>
                <P><input type="checkbox"
                          name="agree_it"> <?php _e('Yes, I told the organization about my cancellation and I tried to clarify things if necessary', 'purpozed'); ?>
                    .</P>
                <div class="error-box extra"><?php _e('Checkbox must be checked', 'purpozed'); ?></div>
                <button class="modal-edit"><a
                            href="<?php echo $language; ?>/evaluate/?id=<?php echo $opportunityId; ?>&c=1"
                            class="comment-on-cancelation"><?php _e('COMMENT ON CANCELLATION', 'purpozed'); ?></a>
                </button>
                <button class="modal-close modal-edit"><?php _e('BACK', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal send-reminder">
    <div class="modal-overlay modal-send-reminder-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('The reminder has been send successfully!', 'purpozed'); ?>!</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button class="modal-edit modal-edit go-dashboard"><?php _e('CLOSE', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>