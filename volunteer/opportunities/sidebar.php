<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>


<div class="row buttons-box">

    <?php

    $opportunityObject = new \Purpozed2\Models\Opportunity();
    $interested = $opportunityObject->interested($opportunityId);
    $requestedUsers = $opportunityObject->getRequested($opportunityId);
    $is_mine = $opportunityObject->isMine($opportunityId);

    $finalInterested = 0;
    if (!empty($interested)) {
        foreach ($interested as $user) {
            if ((int)$user->user_id !== get_current_user_id()) {
                $finalInterested++;
            }
        }
    }

    $finalRequested = 0;
    if (!empty($requestedUsers)) {
        foreach ($requestedUsers as $user) {
            if ((int)$user->user_id !== get_current_user_id()) {
                $finalRequested++;
            }
        }
    }

    $requested = false;
    foreach ($requestedUsers as $requestedUser) {
        if ((int)$requestedUser->user_id === get_current_user_id()) {
            $requested = true;
        }
    }

    $isEngagementInProgress = false;
    if ($task_type === 'engagement') {
        $isEngagementInProgress = $opportunityObject->engagementInProgress($opportunityId, get_current_user_id());
    }

    ?>

    <?php if ((($opportunity_status === 'in_progress') && empty($signToOther)) || (($opportunity_status === 'retracted') && empty($signToOther)) || (($opportunity_status === 'expired') && empty($signToOther)) || $isRejected): ?>
        <?php if ($isRejected): ?>
            <?php if ($task_type !== 'engagement'): ?>
                <div class='matched-opportunity-box'>
                    <p><?php _e('The organization has rejected your application. This is maybe because you have too little skills for this', 'purpozed'); ?> <?php echo $task_type; ?>
                        .</p>

                </div>
            <?php else: ?>
                <div class='matched-opportunity-box'>
                    <p><?php _e('The organization has rejected your application. This should only happen if you and the
                        organization have found out in a conversation that this is not the right engagement for you.
                        Please contact us if such a conversation didn\'t have occured.', 'purpozed'); ?></p>
                </div>
            <?php endif; ?>
        <?php elseif ($requested): ?>
            <div class='matched-opportunity-box'>
                <?php if ($opportunity_status === 'expired'): ?>
                    <p><?php _e('You were requested for this', 'purpozed'); ?> <?php echo $task_type; ?>.</p>
                    <p><?php _e('Meanwhile it has unfortunately been expired. You will find other exciting opportunities!', 'purpozed'); ?></p>
                <?php else: ?>
                    <p>
                        <?php printf(__('You were requested for this %s but you waited too long. Now it has
                        unfortunately been assigned to an other volunteer.', 'purpozed'), $task_type); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class='matched-opportunity-box'>
                <p>
                    <?php printf(__('This is a %s you have applied for', 'purpozed'), $task_type); ?>
                </p>
                <p><?php
                    if ($opportunity_status === 'retracted') {
                        _e('Meanwhile it has unfortunately been retracted by the organization. You will find other exciting
                    opportunities!', 'purpozed');

                    } elseif ($opportunity_status === 'expired') {
                        _e('Meanwhile it has unfortunately been expired. You will find other exciting
                    opportunities!', 'purpozed');
                    } else {
                        _e('Meanwhile it has unfortunately been assigned to another volunteer. You will find other exciting
                    opportunities!', 'purpozed');
                    }
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <div class="edit">
            <button data-id="<?php echo $opportunityId; ?>"
                    class="modal-remove-button step-button"><?php _e('REMOVE FROM DASHBOARD', 'purpozed'); ?></button>
        </div>


    <?php elseif (($opportunity_status === 'in_progress') && (int)$is_mine === get_current_user_id() || $isEngagementInProgress): ?>

        <div class="edit">
            <button data-id="<?php echo $opportunityId; ?>"
                    class="modal-complete-opportunity-button step-button"><?php _e('COMPLETE SUCCESSFULLY', 'purpozed'); ?></button>
        </div>
        <div class="edit">
            <button data-id="<?php echo $opportunityId; ?>"
                    class="modal-cancel-opportunity-button step-button"><?php _e('CANCEL PREMATURELY', 'purpozed'); ?></button>
        </div>

    <?php elseif (($opportunity_status === 'in_progress')): ?>

        <div class="already_bookmarked"><?php _e('Opportunity already in progress', 'purpozed'); ?>.</div>

    <?php else: ?>
        <?php if (isset($_GET['a']) && !$requested && empty($interested)): ?>
            <div class='matched-opportunity-box'>
                <?php
                $skillsOrGoals = ($task_type !== 'engagement') ? 'skills' : 'goals';
                ?>
                <p><?php _e('This opportunity fits to your skills and/or goals', 'purpozed'); ?>.</p>

                <?php if ($finalInterested === 0): ?>
                    <p><?php _e('Apply now if you want to take it over!', 'purpozed'); ?></p>
                <?php else: ?>
                    <?php $plural = ($finalInterested > 1) ? 's are' : ' is'; ?>
                    <p><?php printf(__('%s volunteer%s already showing interest for
                        this %s', 'purpozed'), $finalInterested, $plural, $task_type); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        if ($requested) { ?>
            <div class='matched-opportunity-box'>
                <p><?php printf(__('An organization requested you to take over this %s. Start right away if you
                    want.', 'purpozed'), $task_type); ?></p>
                <?php $linkStart = '<a href=" ' . $language . ' /volunteer-settings">'; ?>
                <?php $linkEnd = '</a>'; ?>
                <p><?php printf(__('You can deactivate these     requests in your %sSettings%s', 'purpozed'), $linkStart, $linkEnd); ?></p>
                <?php if ($finalRequested > 0): ?>
                    <?php $plural = ($finalRequested > 1) ? 's are' : ' is'; ?>
                    <p><?php printf(__('Hurry up, %s other volunteer%s requested by the organization.', 'purpozed'), $finalRequested, $plural); ?></p>
                <?php endif; ?>
            </div>
            <?
        } elseif ((!isset($_GET['a'])) && (empty($appliedUsers)) && ($opportunity_status === 'open') && empty($interested)) {
            ?>
            <div class='matched-opportunity-box'>
                <?php
                $skillsOrGoals = ($task_type !== 'engagement') ? 'skills' : 'goals';
                ?>
                <p><?php _e('This opportunity fits to your skills and/or goals', 'purpozed'); ?></p>

                <?php if ($finalInterested === 0): ?>
                    <p><?php _e('Apply now if you want to take it over!', 'purpozed'); ?>!</p>
                <?php else: ?>
                    <?php $plural = ($finalRequested > 1) ? 's are' : ' is'; ?>
                    <p><?php echo $finalInterested; ?> volunteer<?php echo ($finalInterested > 1) ? 's are' : ' is'; ?>
                        already showing interest for
                        this <?php echo $task_type; ?></p>
                    <p><?php printf(__('%s volunteer%s already showing interest for this %s', 'purpozed'), $finalInterested, $plural, $task_type); ?></p>
                <?php endif; ?>
            </div>
            <?php
        }
        ?>

        <?php if ($opportunity_status === 'succeeded'): ?>
            <div class="already_bookmarked"><?php _e('Opportunity succeeded', 'purpozed'); ?>.</div>
        <?php elseif ($opportunity_status === 'canceled'): ?>

            <div class='matched-opportunity-box'>
                <p><?php printf(__('You have canceled and commented this %s', 'purpozed'), $task_type); ?></p>
                <?php if (!$volunteer_evaluation_organization_text): ?>
                    <p><?php _e('but the organization did not comment it yet', 'purpozed'); ?></p>
                <?php endif; ?>
            </div>
            <?php if (!$volunteer_evaluation_organization_text): ?>
                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                            class="modal-send-reminder-button step-button"><?php _e('SEND A REMINDER', 'purpozed'); ?></button>
                </div>
            <?php endif; ?>
        <?php elseif ($opportunity_status === 'retracted'): ?>
            <div class="already_bookmarked"><?php _e('Opportunity retracted', 'purpozed'); ?>.</div>
        <?php elseif ($opportunity_status === 'expired'): ?>
            <div class="already_bookmarked"><?php _e('Opportunity expired', 'purpozed'); ?>.</div>
            <div class="edit">
                <button data-id="<?php echo $opportunityId; ?>"
                        class="modal-remove-button step-button"><?php _e('REMOVE FROM DASHBOARD', 'purpozed'); ?></button>
            </div>
        <?php else: ?>
            <?php if ($requested): ?>
                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                            class="modal-take-over-button step-button"><?php _e('TAKE OVER', 'purpozed'); ?></button>
                </div>
                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>"
                            class="modal-remove-button step-button"><?php _e('REJECT AND REMOVE', 'purpozed'); ?></button>
                </div>
            <?php endif; ?>
            <?php if ($has_applied === '1'): ?>
                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>"
                            class="modal-retract-application-button step-button"><?php _e('RETRACT APPLICATION', 'purpozed'); ?></button>
                </div>
            <?php elseif ($has_applied === '0' && $requested === false): ?>
                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                            class="modal-apply-button step-button"><?php _e('APPLY NOW', 'purpozed'); ?></button>
                </div>
            <?php endif; ?>
            <div class="edit">
                <button data-id="<?php echo $opportunityId; ?>" data-task="email"
                        class="modal-email-button step-button"><?php _e('ASK A QUESTION', 'purpozed'); ?></button>
            </div>
            <?php if ($is_bookmarked === '1'): ?>
                <div class="already_bookmarked"><?php _e('This Opportunity is already bookmarked', 'purpozed'); ?>.
                </div>
            <?php else: ?>
                <div class="bookmark">
                    <button data-id="<?php echo $opportunityId; ?>" data-task="bookmark"
                            class="modal-bookmark-button step-button"><?php _e('BOOKMARK', 'purpozed'); ?></div>
            <?php endif; ?>

        <?php endif; ?>
    <?php endif; ?>
</div>