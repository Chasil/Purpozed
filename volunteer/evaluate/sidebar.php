<?php

if ($task_type === 'engagement') {
    if (isset($_GET['user'])) {
        $engagedUserId = ($dashboard_type === 'organization') ? $_GET['user'] : get_current_user_id();
    } else {
        $engagedUserId = get_current_user_id();
    }
} else {
    if (isset($in_progress_users)) {
        $engagedUserId = ($dashboard_type === 'organization') ? $in_progress_users[0]->user_id : get_current_user_id();
    } else {
        $engagedUserId = get_current_user_id();
    }
}

$opportunityObject = new \Purpozed2\Models\Opportunity();

$isEngagementInProgress = false;
if ($task_type === 'engagement') {
    $userId = get_current_user_id();
    $isEngagementInProgress = $opportunityObject->engagementInProgress($opportunityId, $userId);
    $isEvaluatedEngagement = $opportunityObject->isEvaluatedEngagement($opportunityId, $userId);
    if ($isEvaluatedEngagement) {
        $engagementEvaluationData = $opportunityObject->getCompletedEngagementFully($opportunityId, $userId);
    }
}

?>

<div class="row buttons-box">

    <?php if (isset($_GET['c'])): ?>

        <?php if ($task_type === 'engagement'): ?>
            <?php if (!$isEvaluatedEngagement): ?>

                <div class='matched-opportunity-box'>
                    <p><?php _e('You want to cancel this opportunity prematurely? Please comment about the reason!', 'purpozed'); ?></p>
                </div>
                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                            data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                            data-user="<?php echo $engagedUserId; ?>"
                            class="modal-cancel-prematurely-button step-button"><?php _e('SAVE AND CANCEL PREMATURELY', 'purpozed'); ?></button>
                </div>

            <?php endif; ?>
        <?php elseif ($task_type !== 'engagement'): ?>

            <?php if ($dashboard_type === 'organization'): ?>

                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                            data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                            data-user="<?php echo $engagedUserId; ?>"
                            class="modal-cancel-prematurely-button step-button"><?php _e('SAVE AND CANCEL PREMATURELY', 'purpozed'); ?></button>
                </div>

            <?php endif; ?>

            <?php if ($dashboard_type === 'volunteer'): ?>

                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                            data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                            data-user="<?php echo $engagedUserId; ?>"
                            class="modal-cancel-prematurely-button step-button"><?php _e('SAVE AND CANCEL PREMATURELY', 'purpozed'); ?></button>
                </div>

            <?php endif; ?>
        <?php endif; ?>

        <div class="edit">
            <button class="step-button"><a
                        href="/opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
            </button>
        </div>

    <?php else: ?>

        <?php if ($dashboard_type === 'volunteer'): ?>

            <?php if ($task_type === 'engagement'): ?>

                <?php if (!$isEvaluatedEngagement): ?>
                    <div class='matched-opportunity-box'>
                        <p><?php _e('You want to successfully complete this opportunity?', 'purpozed'); ?></p>
                        <p><?php _e('Please comment on your work and the collaboration with the organization!', 'purpozed'); ?></p>
                    </div>
                    <div class="edit">
                        <button data-id="<?php echo $opportunityId; ?>"
                                class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                    </div>
                <?php else: ?>
                    <?php if (empty($engagementEvaluationData->canceled_by)): ?>
                        <?php if (empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('You have succeeded this opportunity but the organization did not comment it yet.', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                        data-type="organization"
                                        class="modal-send-reminder-button step-button"><?php _e('SEND A REMINDER', 'purpozed'); ?></button>
                            </div>
                        <?php elseif ((!empty($engagementEvaluationData->evaluation_organization)) && (empty($engagementEvaluationData->evaluation_volunteer))): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('The organization has succeeded the opportunity and already commented it.', 'purpozed'); ?></p>
                                <p><?php _e('Please evaluate the opportunity.', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>"
                                        class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                            </div>
                        <?php elseif ((!empty($engagementEvaluationData->evaluation_organization)) && (!empty($engagementEvaluationData->evaluation_volunteer))): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('This opportunity is succeeded and commented by you and the organization.', 'purpozed'); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php elseif (!empty($engagementEvaluationData->canceled_by)): ?>
                        <?php if (!empty($engagementEvaluationData->evaluation_organization) && (empty($engagementEvaluationData->evaluation_volunteer))): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('The organization has canceled the opportunity prematurely and commented
                                it.', 'purpozed'); ?></p>
                                <p><?php _e('Please comment the cancelation!', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                        data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                                        data-user="<?php echo $engagedUserId; ?>"
                                        data-cancel="1"
                                        class="modal-cancel-prematurely-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                            </div>
                        <?php elseif (empty($engagementEvaluationData->evaluation_organization) && (!empty($engagementEvaluationData->evaluation_volunteer))): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('You have canceled and commented this opportunity but the organization did not comment it yet.', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                        data-type="organization"
                                        class="modal-send-reminder-button step-button"><?php _e('SEND A REMINDER', 'purpozed'); ?></button>
                            </div>
                        <?php elseif ((!empty($engagementEvaluationData->evaluation_organization)) && (!empty($engagementEvaluationData->evaluation_volunteer))): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('This opportunity is canceled and commented by you and the organization.', 'purpozed'); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="edit">
                        <button class="step-button"><a
                                    href="/"><?php _e('BACK', 'purpozed'); ?></a>
                        </button>
                    </div>

                <?php endif; ?>

                <!--            KONIEC ENGAGEMENT-->

            <?php else: ?>
                <?php if (!(isset($volunteer_evaluation_text)) && (!(isset($volunteer_evaluation_organization_text)))): ?>
                    <div class='matched-opportunity-box'>
                        <p><?php _e('You want to successfully complete this opportunity?', 'purpozed'); ?></p>
                        <p><?php _e('Please comment on your work and the collaboration with the organization!', 'purpozed'); ?></p>
                    </div>
                    <div class="edit">
                        <button data-id="<?php echo $opportunityId; ?>"
                                class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                    </div>
                <?php else: ?>
                    <?php if ($opportunity_status === 'succeeded'): ?>
                        <?php if (!isset($volunteer_evaluation_organization_text) && (isset($volunteer_evaluation_text))): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('You have succeeded this opportunity but the organization did not comment it yet.', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                        data-type="organization"
                                        class="modal-send-reminder-button step-button"><?php _e('SEND A REMINDER', 'purpozed'); ?></button>
                            </div>
                        <?php elseif (isset($volunteer_evaluation_organization_text) && (!isset($volunteer_evaluation_text))): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('The organization has succeeded the opportunity and already commented it.', 'purpozed'); ?></p>
                                <p><?php _e('Please evaluate the opportunity.', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>"
                                        class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                            </div>
                        <?php else: ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('This opportunity is succeeded and commented by you and the organization.', 'purpozed'); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php elseif ($opportunity_status === 'canceled'): ?>
                        <?php if (isset($volunteer_evaluation_organization_text) && (!isset($volunteer_evaluation_text))): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('The organization has canceled the opportunity prematurely and commented
                                it.', 'purpozed'); ?></p>
                                <p><?php _e('Please comment the cancelation!', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                        data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                                        data-user="<?php echo $engagedUserId; ?>"
                                        data-cancel="1"
                                        class="modal-cancel-prematurely-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                            </div>
                        <?php elseif (!isset($volunteer_evaluation_organization_text) && (isset($volunteer_evaluation_text))): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('You have canceled and commented this opportunity but the organization did not comment it yet.', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                        data-type="organization"
                                        class="modal-send-reminder-button step-button"><?php _e('SEND A REMINDER', 'purpozed'); ?></button>
                            </div>
                        <?php else: ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('This opportunity is canceled and commented by you and the organization.', 'purpozed'); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="edit">
                        <button class="step-button"><a
                                    href="/"><?php _e('BACK', 'purpozed'); ?></a>
                        </button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        <?php elseif ($dashboard_type === 'organization'): ?>

            <?php if ($task_type === 'engagement'): ?>

                <?php if (empty($engagementEvaluationData->evaluation_volunteer) && empty($engagementEvaluationData->evaluation_organization)): ?>
                    <div class='matched-opportunity-box'>
                        <p><?php _e('You want to successfully complete this opportunity?', 'purpozed'); ?></p>
                        <p><?php _e('Please comment on your work and the collaboration with volunteer!', 'purpozed'); ?></p>
                    </div>
                    <div class="edit">
                        <button data-id="<?php echo $opportunityId; ?>"
                                class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                    </div>
                <?php else: ?>

                    <?php if (empty($engagementEvaluationData->canceled_by)): ?>
                        <?php if (!empty($engagementEvaluationData->evaluation_organization) && empty($engagementEvaluationData->evaluation_volunteer)): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('The organization has succeeded this opportunity but the volunteer did not comment it yet.', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>" data-task="apply" data-type="volunteer"
                                        class="modal-send-reminder-button step-button"><?php _e('SEND A REMINDER', 'purpozed'); ?></button>
                            </div>
                        <?php elseif (empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('This opportunity is succeeded and commented by the volunteer.', 'purpozed'); ?></p>
                                <p><?php _e('Please evaluate the opportunity.', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>"
                                        class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                            </div>
                        <?php else: ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('This opportunity is succeeded and commented by you and the organization.', 'purpozed'); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php elseif (!empty($engagementEvaluationData->canceled_by)): ?>
                        <?php if (empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('The volunteer has canceled the opportunity prematurely and commented
                                it.', 'purpozed'); ?></p>
                                <p><?php _e('Please comment the cancelation!', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                        data-type="<?php echo 'volunteer'; ?>"
                                        data-user="<?php echo $engagedUserId; ?>"
                                        data-cancel="1"
                                        class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                            </div>
                        <?php elseif (!empty($engagementEvaluationData->evaluation_organization) && empty($engagementEvaluationData->evaluation_volunteer)): ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('The organization have canceled this opportunity but the volunteer did not comment it yet.', 'purpozed'); ?></p>
                            </div>
                            <div class="edit">
                                <button data-id="<?php echo $opportunityId; ?>" data-task="apply" data-type="volunteer"
                                        class="modal-send-reminder-button step-button"><?php _e('SEND A REMINDER', 'purpozed'); ?></button>
                            </div>
                        <?php else: ?>
                            <div class='matched-opportunity-box'>
                                <p><?php _e('This opportunity is canceled and commented by you and the organization.', 'purpozed'); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="edit">
                        <button class="step-button"><a
                                    href="/"><?php _e('BACK', 'purpozed'); ?></a>
                        </button>
                    </div>
                <?php endif; ?>

            <?php else: ?>

                <?php if ($opportunity_status === 'succeeded'): ?>
                    <?php if (isset($volunteer_evaluation_organization_text) && (!isset($volunteer_evaluation_text))): ?>
                        <div class='matched-opportunity-box'>
                            <p><?php _e('The organization has succeeded this opportunity but the volunteer did not comment it yet.', 'purpozed'); ?></p>
                        </div>
                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="apply" data-type="volunteer"
                                    class="modal-send-reminder-button step-button"><?php _e('SEND A REMINDER', 'purpozed'); ?></button>
                        </div>
                    <?php elseif (!isset($volunteer_evaluation_organization_text) && (isset($volunteer_evaluation_text))): ?>
                        <div class='matched-opportunity-box'>
                            <p><?php _e('This opportunity is succeeded and commented by the volunteer.', 'purpozed'); ?></p>
                            <p><?php _e('Please evaluate the opportunity.', 'purpozed'); ?></p>
                        </div>
                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>"
                                    class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                        </div>
                    <?php else: ?>
                        <div class='matched-opportunity-box'>
                            <p><?php _e('This opportunity is succeeded and commented by you and the organization.', 'purpozed'); ?></p>
                        </div>
                    <?php endif; ?>
                <?php elseif ($opportunity_status === 'canceled'): ?>
                    <?php if (!isset($volunteer_evaluation_organization_text) && (isset($volunteer_evaluation_text))): ?>
                        <div class='matched-opportunity-box'>
                            <p><?php _e('The volunteer has canceled the opportunity prematurely and commented
                                it.', 'purpozed'); ?></p>
                            <p><?php _e('Please comment the cancelation!', 'purpozed'); ?></p>
                        </div>
                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                    data-type="<?php echo 'volunteer'; ?>"
                                    data-user="<?php echo $engagedUserId; ?>"
                                    data-cancel="1"
                                    class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                        </div>
                    <?php elseif (isset($volunteer_evaluation_organization_text) && (!isset($volunteer_evaluation_text))): ?>
                        <div class='matched-opportunity-box'>
                            <p><?php _e('The organization have canceled this opportunity but the volunteer did not comment it yet.', 'purpozed'); ?></p>
                        </div>
                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="apply" data-type="volunteer"
                                    class="modal-send-reminder-button step-button"><?php _e('SEND A REMINDER', 'purpozed'); ?></button>
                        </div>
                    <?php else: ?>
                        <div class='matched-opportunity-box'>
                            <p><?php _e('This opportunity is canceled and commented by you and the organization.', 'purpozed'); ?></p>
                        </div>
                    <?php endif; ?>
                <?php elseif ($opportunity_status === 'in_progress'): ?>
                    <div class="edit">
                        <button data-id="<?php echo $opportunityId; ?>"
                                class="modal-evaluate-button step-button"><?php _e('SAVE YOUR EVALUATION', 'purpozed'); ?></button>
                    </div>
                <?php endif; ?>
                <div class="edit">
                    <button class="step-button"><a
                                href="/"><?php _e('BACK', 'purpozed'); ?></a>
                    </button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>
</div>

<div class="modal evaluate-ask">
    <div class="modal-overlay modal-evaluate-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading">
                <?php _e('Are you sure you want to evaluate this opportunity?', 'purpozed'); ?></h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button class="modal-edit evaluate-confirm"
                    <?php var_dump($opportunity_status); ?>
                        data-id="<?php echo $opportunityId; ?>"
                        data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                        data-alreadycanceled="<?php echo ($opportunity_status === 'canceled') ? 'true' : ''; ?>"
                        data-user="<?php echo $engagedUserId; ?>"><?php _e('YES, I WANT TO EVALUATE', 'purpozed'); ?></button>
                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal evaluate">
    <div class="modal-overlay modal-evaluate-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('Thank you for evaluation of this opportunity', 'purpozed'); ?>!</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button class="modal-edit modal-edit reload-page"><?php _e('CLOSE', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal cancel-prematurely">
    <div class="modal-overlay modal-cancel-prematurely-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('You canceled this opportunity successfully!', 'purpozed'); ?>!</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <button class="modal-edit modal-edit go-dashboard"><?php _e('CLOSE', 'purpozed'); ?></button>
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