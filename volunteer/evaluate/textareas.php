<?php
$singleOpportunity = new \Purpozed2\Models\Opportunity();
$volunteersManager = new \Purpozed2\Models\VolunteersManager();
$singleOrganization = new \Purpozed2\Models\Organization();

$userId = get_current_user_id();

if (isset($_GET['user'])) {
    $userId = $_GET['user'];
}

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


$isEngagementInProgress = false;
if ($task_type === 'engagement') {
    $isEngagementInProgress = $singleOpportunity->engagementInProgress($opportunityId, $userId);
    $isEvaluatedEngagement = $singleOpportunity->isEvaluatedEngagement($opportunityId, $userId);
    if ($isEvaluatedEngagement) {
        $engagementEvaluationData = $singleOpportunity->getCompletedEngagementFully($opportunityId, $userId);
    }
}

$boldStart = '<strong>';
$boldEnd = '</strong>'
?>

<div class="small-header">

    <?php if ($opportunity_status !== 'in_progress'): ?>
        <?php if ($task_type === 'engagement'): ?>
            <?php $userWhoCompletedOpportunity = $userId; ?>
        <?php else: ?>
            <?php $userWhoCompletedOpportunity = $singleOpportunity->getVolunteersWhoComplete($opportunityId); ?>
        <?php endif; ?>
    <?php else: ?>
        <?php $userWhoCompletedOpportunity = $singleOpportunity->getInProgress($opportunityId); ?>
    <?php endif; ?>
    <?php $organziationId = $singleOpportunity->getOrganization($opportunityId); ?>

    <!--    CANCELED-->
    <?php if (isset($_GET['c'])): ?>

        <?php if ($task_type !== 'engagement'): ?>

            <?php if (isset($_GET['c'])): ?>

                <?php if ($dashboard_type === 'organization'): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Cancel prematurely and comment', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php _e('This collaboaration was not successful and I want to cancel it prematurely. Please comment on the collaboration with the volunteer!', 'purpozed'); ?>
                        </div>
                        <div class="evaluation-checkboxes">
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="confirm_canelation"> <?php _e('Yes, I have tried to talk with the organization about this cancelation and clarified things (if necessary)', 'purpozed'); ?>
                                </label>
                                <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                            </div>
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="complain_cancelation"> <?php _e('I want to send a complaint about the organization to the support team', 'purpozed'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="evaluation-small-info">
                            <?php _e('If you check this box we will get a message about your complaint after you have canceled the collaboration. After this we will get in touch with the organization and try to clear things up.', 'purpozed'); ?>
                        </div>
                        <div class="textarea-style"><textarea
                                    class="evaluation-textarea"
                                    placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
                        </div>
                        <div class="evaluation-error">
                            <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
                        </div>
                    </div>

                    <div class="evaluation-buttons">
                        <div class="edit">
                            <button class="step-button back"><a
                                        href="/opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                            </button>
                        </div>

                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                    data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                                    data-user="<?php echo $engagedUserId; ?>"
                                    class="modal-cancel-prematurely-button step-button cancel"><?php _e('SAVE AND CANCEL PREMATURELY', 'purpozed'); ?></button>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                <?php endif; ?>

                <?php if ($dashboard_type === 'volunteer'): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Cancel prematurely and comment', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php _e('This collaboaration was not successful and I want to cancel it prematurely. Please comment on the collaboration with the organization!', 'purpozed'); ?>
                        </div>
                        <div class="evaluation-checkboxes">
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="confirm_canelation"> <?php _e('Yes, I have tried to talk with the volunteer about this cancelation and clarified things (if necessary)', 'purpozed'); ?>
                                </label>
                                <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                            </div>
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="complain_cancelation"> <?php _e('I want to send a complaint about the volunteer to the support team', 'purpozed'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="evaluation-small-info">
                            <?php _e('If you check this box we will get a message about your complaint after you have canceled the collaboration. After this we will get in touch with the volunteer and try to clear things up.', 'purpozed'); ?>
                        </div>
                    </div>
                    <div class="textarea-style"><textarea
                                class="evaluation-textarea"
                                placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
                    </div>
                    <div class="evaluation-error">
                        <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-buttons">
                        <div class="edit">
                            <button class="step-button back"><a
                                        href="/manage-opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                            </button>
                        </div>

                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                    data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                                    data-user="<?php echo $engagedUserId; ?>"
                                    class="modal-cancel-prematurely-button step-button cancel"><?php _e('SAVE AND CANCEL PREMATURELY', 'purpozed'); ?></button>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                <?php endif; ?>

            <?php endif; ?>

        <?php else: ?>

            <?php if ($dashboard_type === 'volunteer' && !$isEvaluatedEngagement): ?>

                <div class="medium-header prev-header evaluation">
                    <?php _e('Cancel prematurely and comment', 'purpozed'); ?>
                </div>

                <div class="evaluation-information">
                    <div class="information-text cancel">
                        <?php _e('This collaboaration was not successful and I want to cancel it prematurely. Please comment on the collaboration with the organization!', 'purpozed'); ?>
                    </div>
                    <div class="evaluation-checkboxes">
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="confirm_canelation"> <?php _e('Yes, I have tried to talk with the organization about this cancelation and clarified things (if necessary)', 'purpozed'); ?>
                            </label>
                            <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                        </div>
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="complain_cancelation"> <?php _e('I want to send a complaint about the organization to the support team', 'purpozed'); ?>
                            </label>
                        </div>
                    </div>

                    <div class="evaluation-small-info">
                        <?php _e('If you check this box we will get a message about your complaint after you have canceled the collaboration. After this we will get in touch with the organization and try to clear things up.', 'purpozed'); ?>
                    </div>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea"
                                placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
                    </div>
                    <div class="evaluation-error">
                        <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-buttons">
                        <div class="edit">
                            <button class="step-button back"><a
                                        href="/opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                            </button>
                        </div>

                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                    data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                                    data-user="<?php echo $engagedUserId; ?>"
                                    class="modal-cancel-prematurely-button step-button cancel"><?php _e('SAVE AND CANCEL PREMATURELY', 'purpozed'); ?></button>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                </div>
            <?php endif; ?>

            <?php if ($dashboard_type === 'organization' && !$isEvaluatedEngagement): ?>

                <div class="medium-header prev-header evaluation">
                    <?php _e('Cancel prematurely and comment', 'purpozed'); ?>
                </div>

                <div class="evaluation-information">
                    <div class="information-text cancel">
                        <?php _e('This collaboaration was not successful and I want to cancel it prematurely. Please comment on the collaboration with the volunteer!', 'purpozed'); ?>
                    </div>
                    <div class="evaluation-checkboxes">
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="confirm_canelation"> <?php _e('Yes, I have tried to talk with the volunteer about this cancelation and clarified things (if necessary)', 'purpozed'); ?>
                            </label>
                            <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                        </div>
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="complain_cancelation"> <?php _e('I want to send a complaint about the volunteer to the support team', 'purpozed'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="evaluation-small-info">
                        <?php _e('If you check this box we will get a message about your complaint after you have canceled the collaboration. After this we will get in touch with the volunteer and try to clear things up.', 'purpozed'); ?>
                    </div>
                    <div class="textarea-style"><textarea
                                class="evaluation-textarea"
                                placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
                    </div>
                    <div class="evaluation-error">
                        <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-buttons">
                        <div class="edit">
                            <button class="step-button back"><a
                                        href="/manage-opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                            </button>
                        </div>

                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                    data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                                    data-user="<?php echo $engagedUserId; ?>"
                                    class="modal-cancel-prematurely-button step-button cancel"><?php _e('SAVE AND CANCEL PREMATURELY', 'purpozed'); ?></button>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                </div>
            <?php endif; ?>

        <?php endif; ?>
    <?php endif; ?>

    <!--  END OF CANCELED-->

    <!--    ENGAGEMENT-->

    <?php if (($task_type === 'engagement') && (isset($_GET['c']))): ?>

        <?php if ($dashboard_type === 'organization' && !$isEvaluatedEngagement && !isset($_GET['c'])): ?>
            <div class="evaluation-information">
                <div class="information-text">
                    <?php _e('This collaboaration was successful and I want to complete it. Please comment on the collaboration with the volunteer!', 'purpozed'); ?>
                </div>
                <div class="evaluation-checkboxes">
                    <div class="evaluation-checkbox">
                        <label><input type="checkbox"
                                      name="confirm_canelation"> <?php _e('Yes, I have tried to talk with the organization about this cancelation and clarified things (if necessary)', 'purpozed'); ?>
                        </label>
                    </div>
                </div>
                <div class="helping_hours">
                    <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                        <input type="number" name="helping_hours" value="0">
                    </label>
                </div>
            </div>
            <div class="evaluation-small-info">
                <?php _e('We need the number of helping hours in order to track the total volunteering hours of the volunteer\'s company.', 'purpozed'); ?>
            </div>
            <div class="evaluation-small-info">
                <?php _e('If your are not sure about the number of helping hours, please talk to the volunteer before completing this collaboaration. After you have completed the collaboaration, we ask the volunteer to confirm this approximate number of helping hours.', 'purpozed'); ?>
            </div>

        <?php elseif ($dashboard_type === 'organization' && $isEvaluatedEngagement): ?>
            <div class="evaluation-information">
                <?php if (empty($engagementEvaluationData->evaluation_organization) && empty($engagementEvaluationData->canceled_by)): ?>
                    <div class="information-text">
                        <?php printf(__('The volunteer marked this collaboration as %s successfully completed %s. The volunteer stated approx %s %s helping hours %s. Please comment on the collaboration with the volunteer!', 'purpozed'), $boldStart, $boldEnd, $boldStart, $engagementEvaluationData->hours, $boldEnd); ?>
                    </div>
                    <div class="evaluation-checkboxes">
                        <div class="evaluation-text"><?php _e('I disagree on the statements:', 'purpozed'); ?></div>
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="collaboration_disagree"> <?php _e('The collaboration with the volunteer was not successful', 'purpozed'); ?>
                            </label>
                        </div>
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="hours_disagree"> <?php _e('The number of helping hours stated by the volunteer is way to low/high', 'purpozed'); ?>
                            </label>
                        </div>
                    </div>
                <?php elseif (empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->canceled_by)): ?>
                    <div class="information-text cancel">
                        <?php _e('The volunteer marked this collaboration as canceled prematurely. Please comment on the collaboration with the volunteer!', 'purpozed'); ?>
                    </div>
                    <?php if (!empty($engagementEvaluationData->canceled_by) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>

                        <div class="evaluation-checkboxes">
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="collaboration_disagree"> <?php _e('I disagree, the collaboration with the volunteer was successful', 'purpozed'); ?>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php elseif ((empty($engagementEvaluationData->evaluation_volunteer) && !empty($engagementEvaluationData->evaluation_organization)) && (empty($engagementEvaluationData->canceled_by))): ?>
                    <div class="information-text">
                        <?php _e('You have completed this collaboration successfully and commented it but the volunteer did not comment it yet.', 'purpozed'); ?>
                    </div>

                <?php elseif ((!empty($engagementEvaluationData->evaluation_volunteer) && !empty($engagementEvaluationData->evaluation_organization)) && (empty($engagementEvaluationData->canceled_by))): ?>
                    <div class="information-text">
                        <?php _e('This collaboration was completed successfully and commented by you and the volunteer.', 'purpozed'); ?>
                    </div>

                <?php elseif ((!empty($engagementEvaluationData->evaluation_organization) && empty($engagementEvaluationData->evaluation_volunteer)) && (!empty($engagementEvaluationData->canceled_by))): ?>
                    <div class="information-text cancel">
                        <?php _e('You have canceled this collaboration prematurely and commented it but the organization/volunteer did not comment it yet.', 'purpozed'); ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif (empty($engagementEvaluationData->evaluation_volunteer)): ?>

            <?php if ($dashboard_type === 'volunteer' && $isEvaluatedEngagement): ?>
                <div class="evaluation-information">
                    <?php if (empty($engagementEvaluationData->evaluation_volunteer)): ?>
                        <div class="information-text">
                            <?php printf(__('The organization marked this collaboration as %ssuccessfully completed%s. The organization stated approx %s %s helping hours%s. Please comment on the collaboration with the organization!', 'purpozed'), $boldStart, $boldEnd, $boldStart, $engagementEvaluationData->hours, $boldEnd); ?>
                        </div>
                        <div class="evaluation-checkboxes">
                            <div class="evaluation-text"><?php _e('I disagree on the statements:', 'purpozed'); ?></div>
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="collaboration_disagree"> <?php _e('The collaboration with the organization was not successful', 'purpozed'); ?>
                                </label>
                            </div>
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="hours_disagree"> <?php _e('The number of helping hours stated by the organization is way to low/high', 'purpozed'); ?>
                                </label>
                            </div>
                        </div>
                    <?php elseif (!empty($engagementEvaluationData->evaluation_volunteer) && !empty($engagementEvaluationData->evaluation_organization)): ?>
                        <div class="information-text">
                            <?php _e('This collaboration was completed successfully and commented by you and the organization.', 'purpozed'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php _e('Please drop a line about your work and the collaboration with the organization:', 'purpozed'); ?>
            <?php endif; ?>

        <?php endif; ?>
    <?php endif; ?>

    <!--  END OF ENGAGEMENT-->

    <!--  VOLUNTEER -->

    <?php $isAdmin = (get_user_meta(get_current_user_id(), 'is_admin')) ? get_user_meta(get_current_user_id(), 'is_admin')[0] : ''; ?>
    <?php if ($dashboard_type === 'volunteer'): ?>

    <?php if ($task_type === 'engagement'): ?>

        <?php if (!$isEvaluatedEngagement && (!isset($_GET['c']))): ?>

            <div class="medium-header prev-header evaluation">
                <?php _e('Complete successfully and comment', 'purpozed'); ?>
            </div>

            <div class="evaluation-information">
                <div class="information-text">
                    <?php _e('This collaboaration was successful and I want to complete it. Please comment on the collaboration with the organization!', 'purpozed'); ?>
                </div>
            </div>

            <div class="evaluation-checkboxes">
                <div class="evaluation-checkbox">
                    <label><input type="checkbox"
                                  name="confirm_canelation"> <?php _e('Yes, I talked with the organization about this completion and clarified things (if necessary)', 'purpozed'); ?>
                    </label>
                    <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                </div>
            </div>

            <div class="evaluation-checkboxes">
                <?php if (!isset($_GET['c']) && !$isEvaluatedEngagement): ?>
                    <div class="helping_hours">
                        <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                            <input type="number" name="helping_hours" value="0">
                        </label>
                        <div class="error-box extra"><?php _e('Please enter the number of helping hours (approximately)', 'purpozed'); ?></div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="evaluation-small-info">
                <?php _e('We need the number of helping hours in order to track the total volunteering hours of the volunteer\'s company.', 'purpozed'); ?>
            </div>
            <div class="evaluation-small-info">
                <?php _e('If your are not sure about the number of helping hours, please talk to the organization before completing this collaboaration. After you have completed the collaboaration, we ask the organization to confirm this approximate number of helping hours.', 'purpozed'); ?>
            </div>

            <div class="textarea-style"><textarea
                        class="evaluation-textarea"
                        placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
            </div>
            <div class="evaluation-error">
                <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
            </div>

            <div class="evaluation-buttons">
                <div class="edit">
                    <button class="step-button back"><a
                                href="/opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                    </button>
                </div>

                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>"
                            class="modal-evaluate-button step-button save">
                        <?php _e('SAVE AND COMPLETE SUCCESSFULLY', 'purpozed'); ?></button>
                </div>
            </div>

            <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

        <?php else: ?>

            <?php if (empty($engagementEvaluationData->canceled_by)): ?>
                <?php if (empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Completed successfully', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text">
                            <?php printf(__('You have completed this collaboration %ssuccessfully%s and commented it but the organization did not comment it yet.', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                    <?php if (!empty($engagementEvaluationData->evaluation_volunteer_date)): ?>
                        <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_volunteer_date); ?>
                        <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                        <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                    <?php endif; ?>

                    <div class="textarea-style">
                            <textarea
                                    class="evaluation-textarea evaluated"
                                    readonly="readonly"><?php echo $engagementEvaluationData->evaluation_volunteer; ?></textarea>
                    </div>
                    <div class="helping_hours">
                        <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                            <span><?php echo ': ' . $engagementEvaluationData->hours; ?>
                        </label>
                    </div>
                    <div class="period-of-collaboration">
                        <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                        <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                        <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                        <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                        <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                <?php elseif ((!empty($engagementEvaluationData->evaluation_organization)) && (empty($engagementEvaluationData->evaluation_volunteer))): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Comment and confirm successful completion', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text">
                            <?php printf(__('The organization marked this collaboration as %s successfully completed%s. The organization stated approx %s %s helping hours%s. Please comment on the collaboration with the organization!', 'purpozed'), $boldStart, $boldEnd, $boldStart, $engagementEvaluationData->hours, $boldEnd); ?>
                        </div>
                    </div>

                    <div class="evaluation-checkboxes">
                        <div class="evaluation-text"><?php _e('I disagree on the statements:', 'purpozed'); ?></div>
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="collaboration_disagree"> <?php _e('The collaboration with the organization was not successful', 'purpozed'); ?>
                            </label>
                        </div>
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="hours_disagree"> <?php _e('The number of helping hours stated by the organization is way to low/high', 'purpozed'); ?>
                            </label>
                            <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                        </div>
                    </div>
                    <div class="evaluation-small-info">
                        <?php _e('If you check one of these boxes and click the save button, we will get a message about your complaint, get in touch with the organization and try to clear things up.', 'purpozed'); ?>
                    </div>
                    <div class="textarea-style"><textarea
                                class="evaluation-textarea"
                                placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
                    </div>
                    <div class="evaluation-error">
                        <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-buttons">
                        <div class="edit">
                            <button class="step-button back"><a
                                        href="/"><?php _e('BACK', 'purpozed'); ?></a>
                            </button>
                        </div>

                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>"
                                    class="modal-evaluate-button step-button save"><?php _e('SAVE COMMENT', 'purpozed'); ?></button>
                        </div>
                    </div>

                <?php elseif ((!empty($engagementEvaluationData->evaluation_organization)) && (!empty($engagementEvaluationData->evaluation_volunteer))): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Completed successfully', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text">
                            <?php printf(__('This collaboration was %scompleted successfully%s and commented by you and the organization.', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                    <?php if (!empty($engagementEvaluationData->evaluation_volunteer_date)): ?>
                        <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_volunteer_date); ?>
                        <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                        <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                    <?php endif; ?>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated"
                                readonly="readonly"><?php echo $engagementEvaluationData->evaluation_volunteer; ?></textarea>
                    </div>
                    <div class="helping_hours">
                        <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                            <span><?php echo ': ' . $engagementEvaluationData->hours; ?>
                        </label>
                    </div>
                    <div class="period-of-collaboration">
                        <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                        <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                        <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                        <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                        <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                    </div>

                <?php endif; ?>

            <?php elseif (!empty($engagementEvaluationData->canceled_by)): ?>

                <?php if (!empty($engagementEvaluationData->evaluation_organization) && (empty($engagementEvaluationData->evaluation_volunteer))): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Comment and confirm premature cancelation', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php printf(__('The organization marked this collaboration as %scanceled prematurely%s. Please comment on the collaboration with the organization!', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                        <div class="evaluation-checkboxes">
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="collaboration_disagree"> <?php _e('I disagree, the collaboration with the organization was successful', 'purpozed'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="evaluation-small-info">
                            <?php _e('If you check this box and click the save button, we will get a message about your complaint, get in touch with the organization and try to clear things up.', 'purpozed'); ?>
                        </div>
                        <div class="textarea-style"><textarea
                                    class="evaluation-textarea"
                                    placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
                        </div>
                        <div class="evaluation-error">
                            <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
                        </div>
                    </div>

                    <div class="evaluation-buttons">
                        <div class="edit">
                            <button class="step-button back"><a
                                        href="/opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                            </button>
                        </div>

                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                    data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                                    data-user="<?php echo $engagedUserId; ?>"
                                    data-cancel="1"
                                    class="modal-cancel-prematurely-button step-button save"><?php _e('SAVE COMMENT', 'purpozed'); ?></button>
                        </div>
                    </div>

                <?php elseif (empty($engagementEvaluationData->evaluation_organization) && (!empty($engagementEvaluationData->evaluation_volunteer))): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Canceled prematurely', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php printf(__('You have %scanceled this collaboration prematurely%s and commented it but the organization did not comment it yet.', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>

                        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                        <?php if (!empty($engagementEvaluationData->evaluation_volunteer_date)): ?>
                            <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_volunteer_date); ?>
                            <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                            <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                        <?php endif; ?>

                        <div class="textarea-style"><textarea
                                    class="evaluation-textarea evaluated"
                                    readonly="readonly"><?php echo $engagementEvaluationData->evaluation_volunteer; ?></textarea>
                        </div>
                        <div class="period-of-collaboration">
                            <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                            <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                            <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                            <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                            <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                        </div>

                        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                    </div>
                <?php elseif ((!empty($engagementEvaluationData->evaluation_organization)) && (!empty($engagementEvaluationData->evaluation_volunteer))): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Canceled prematurely', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php printf(__('This collaboration was %scanceled prematurely%s and commented by you and the organization.', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>

                        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                        <?php if (!empty($engagementEvaluationData->evaluation_volunteer_date)): ?>
                            <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_volunteer_date); ?>
                            <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                            <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                        <?php endif; ?>

                        <div class="textarea-style"><textarea
                                    class="evaluation-textarea evaluated"
                                    readonly="readonly"><?php echo $engagementEvaluationData->evaluation_volunteer; ?></textarea>
                        </div>
                        <div class="period-of-collaboration">
                            <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                            <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                            <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                            <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                            <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                        </div>

                    </div>
                <?php endif; ?>

            <?php endif; ?>

        <?php endif; ?>

        <?php if ($isAdmin): ?>
            <?php $userWhoCompleted = $singleOpportunity->getVolunteersWhoCompleteEngagement($_GET['id']); ?>
            <?php
            if (!empty($userWhoCompleted)): ?>
                <?php $areCommentsVisible = (get_user_meta($userWhoCompleted[0]->user_id, 'comments_visible')) ? get_user_meta($userWhoCompleted[0]->user_id, 'comments_visible')[0] : ''; ?>
                <?php if ($areCommentsVisible === 'on'): ?>
                    <?php if (!empty($engagementEvaluationData->evaluation_organization)): ?>

                        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                        <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_organization_date); ?>
                        <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                        <div class="comment-text"><?php printf(__('Organization\'s comment from %s: ', 'purpozed'), $finalDate); ?></div>

                        <div class="textarea-style"><textarea
                                    class="evaluation-textarea evaluated"
                                    readonly="readonly"><?php echo $engagementEvaluationData->evaluation_organization; ?></textarea>
                        </div>

                    <?php endif; ?>
                <?php else: ?>
                    <?php if (isset($volunteer_evaluation_organization_text)): ?>
                        <?php _e('A Volunteer turned off possiblity to see organizations comments', 'purpozed'); ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

    <?php else: ?>

    <!--  VOLUNTEER NOT ENGAGEMENT -->

    <?php if (!isset($volunteer_evaluation_text) && (!(isset($volunteer_evaluation_organization_text))) && !isset($_GET['c'])): ?>

        <div class="medium-header prev-header evaluation">
            <?php _e('Complete successfully and comment', 'purpozed'); ?>
        </div>

        <div class="evaluation-information">
            <div class="information-text">
                <?php _e('This collaboaration was successful and I want to complete it. Please comment on the collaboration with the organization!', 'purpozed'); ?>
            </div>
            <div class="evaluation-checkboxes">
                <div class="evaluation-checkbox">
                    <label><input type="checkbox"
                                  name="confirm_canelation"> <?php _e('Yes, I talked with the organization about this completion and clarified things (if necessary)', 'purpozed'); ?>
                    </label>
                    <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                </div>
            </div>
        </div>

        <?php if ($task_type === 'mentoring'): ?>

            <div class="evaluation-checkboxes">
                <div class="helping_hours">
                    <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                        <input type="number" name="helping_hours" value="0">
                    </label>
                    <div class="error-box extra"><?php _e('Please enter the number of helping hours (approximately)', 'purpozed'); ?></div>
                </div>
            </div>

        <?php endif; ?>

        <div class="textarea-style"><textarea
                    class="evaluation-textarea"
                    placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
        </div>
        <div class="evaluation-error">
            <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
        </div>

        <div class="evaluation-buttons">
            <div class="edit">
                <button class="step-button back"><a
                            href="/opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                </button>
            </div>

            <div class="edit">
                <button data-id="<?php echo $opportunityId; ?>"
                        class="modal-evaluate-button step-button save"><?php _e('SAVE AND COMPLETE SUCCESSFULLY', 'purpozed'); ?></button>
            </div>
        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

    <?php elseif ($opportunity_status === 'succeeded'): ?>

    <?php if (!isset($volunteer_evaluation_organization_text) && (isset($volunteer_evaluation_text))): ?>

        <div class="medium-header prev-header evaluation">
            <?php _e('Completed successfully', 'purpozed'); ?>
        </div>

        <div class="evaluation-information">
            <div class="information-text">
                <?php printf(__('You have completed this collaboration %ssuccessfully%s and commented it but the organization did not comment it yet.', 'purpozed'), $boldStart, $boldEnd); ?>
            </div>
        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

        <?php if (!empty($volunteer_evaluation_date)): ?>
            <?php $evalDate = explode('-', $volunteer_evaluation_date); ?>
            <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
            <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
        <?php endif; ?>

        <div class="textarea-style"><textarea
                    class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_text)) ? $volunteer_evaluation_text : ''; ?></textarea>
        </div>
        <?php if ($task_type === 'mentoring'): ?>

            <div class="helping_hours">
                <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>

                    <?php if (isset($userWhoCompletedOpportunity[0]->mentoring_hours)): ?>
                        <span><?php echo ': ' . $userWhoCompletedOpportunity[0]->mentoring_hours; ?></span>
                    <?php else: ?>
                        <input type="number" name="helping_hours" value="0">
                    <?php endif; ?>

                </label>
            </div>

        <?php endif; ?>

        <div class="period-of-collaboration">
            <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
            <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
            <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
            <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
            <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

    <?php elseif (isset($volunteer_evaluation_organization_text) && (!isset($volunteer_evaluation_text))): ?>

        <div class="medium-header prev-header evaluation">
            <?php _e('Comment and confirm successful completion', 'purpozed'); ?>
        </div>

        <div class="evaluation-information">
            <div class="information-text">
                <?php printf(__('The organization marked this collaboration as %ssuccessfully completed%s. Please comment on the collaboration with the organization!', 'purpozed'), $boldStart, $boldEnd); ?>
            </div>
        </div>
        <div class="evaluation-checkboxes">
            <div class="evaluation-checkbox">
                <label><input type="checkbox"
                              name="collaboration_disagree"> <?php _e('I disagree, the collaboration with the organization wasn’t successful', 'purpozed'); ?>
                </label>
            </div>
        </div>

        <div class="evaluation-small-info">
            <?php _e('If you check this box and click the save button, we will get a message about your complaint, get in touch with the organization and try to clear things up.', 'purpozed'); ?>
        </div>

        <div class="textarea-style"><textarea
                    class="evaluation-textarea"
                    placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
        </div>
        <div class="evaluation-error">
            <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
        </div>


        <div class="evaluation-buttons">
            <div class="edit">
                <button class="step-button back"><a
                            href="/opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                </button>
            </div>

            <div class="edit">
                <button data-id="<?php echo $opportunityId; ?>"
                        class="modal-evaluate-button step-button save"><?php _e('SAVE AND COMPLETE SUCCESSFULLY', 'purpozed'); ?></button>
            </div>
        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

    <?php else: ?>

    <div class="medium-header prev-header evaluation">
        <?php _e('Completed successfully', 'purpozed'); ?>
    </div>

    <div class="evaluation-information">
        <div class="information-text">
            <?php printf(__('This collaboration was %scompleted successfully%s and commented by you and the organization.', 'purpozed'), $boldStart, $boldEnd); ?>
        </div>
    </div>

    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

    <?php if (!empty($volunteer_evaluation_organization_date)): ?>
        <?php $evalDate = explode('-', $volunteer_evaluation_organization_date); ?>
        <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
        <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
    <?php endif; ?>

    <div class="textarea-style"><textarea
                class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_text)) ? $volunteer_evaluation_text : ''; ?></textarea>
    </div>

    <?php if ($task_type === 'mentoring'): ?>

        <div class="helping_hours">
            <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                <span><?php echo ': ' . $userWhoCompletedOpportunity[0]->mentoring_hours; ?></span>w
            </label>
        </div>

    <?php endif; ?>

    <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
    <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
    <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
    <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
    <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

    <div class="comment-text"><?php printf(__('Organization comment from %s:', 'purpozed'), $volunteer_evaluation_date); ?></div>

    <div class="textarea-style"><textarea
                class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_organization_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_organization_text)) ? $volunteer_evaluation_organization_text : ''; ?></textarea>
    </div>

<?php endif; ?>
<?php elseif ($opportunity_status === 'canceled'): ?>

    <?php if (($volunteer_evaluation_organization_text === NULL) && ($volunteer_evaluation_text !== NULL)): ?>

        <div class="medium-header prev-header evaluation">
            <?php _e('Canceled prematurely', 'purpozed'); ?>
        </div>

        <div class="evaluation-information">
            <div class="information-text cancel">
                <?php printf(__('You have %scanceled this collaboration prematurely%s and commented it but the organization did not comment it yet.', 'purpozed'), $boldStart, $boldEnd); ?>
            </div>
        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

        <?php if (!empty($volunteer_evaluation_date)): ?>
            <?php $evalDate = explode('-', $volunteer_evaluation_date); ?>
            <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
            <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
        <?php endif; ?>

        <div class="textarea-style"><textarea
                    class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_text)) ? $volunteer_evaluation_text : ''; ?></textarea>
        </div>
        <div class="period-of-collaboration">
            <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
            <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
            <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
            <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
            <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

    <?php elseif (($volunteer_evaluation_organization_text !== NULL) && ($volunteer_evaluation_text === NULL)): ?>

        <div class="medium-header prev-header evaluation">
            <?php _e('Comment and confirm premature cancelation', 'purpozed'); ?>
        </div>

        <div class="evaluation-information">
            <div class="information-text cancel">
                <?php printf(__('The organization marked this collaboration as %scanceled prematurely%s. Please comment on the collaboration with the organization!', 'purpozed'), $boldStart, $boldEnd); ?>
            </div>
            <div class="evaluation-checkboxes">
                <div class="evaluation-checkbox">
                    <label><input type="checkbox"
                                  name="collaboration_disagree"> <?php _e('I disagree, the collaboration with the organization wasn’t successful', 'purpozed'); ?>
                    </label>
                </div>
            </div>
            <div class="evaluation-small-info">
                <?php _e('If you check this box and click the save button, we will get a message about your complaint, get in touch with the organization and try to clear things up.', 'purpozed'); ?>
            </div>
        </div>
        <div class="textarea-style"><textarea
                    class="evaluation-textarea"
                    placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
        </div>
        <div class="evaluation-error">
            <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
        </div>

        <div class="evaluation-buttons">
            <div class="edit">
                <button class="step-button back"><a
                            href="/opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                </button>
            </div>

            <div class="edit">
                <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                        data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                        data-user="<?php echo $engagedUserId; ?>"
                        data-cancel="1"
                        class="modal-cancel-prematurely-button step-button save"><?php _e('SAVE COMMENT', 'purpozed'); ?></button>
            </div>
        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

    <?php else: ?>

        <div class="medium-header prev-header evaluation">
            <?php _e('Canceled prematurely', 'purpozed'); ?>
        </div>

        <div class="evaluation-information">
            <div class="information-text cancel">
                <?php printf(__('This collaboration was %scanceled prematurely%s and commented by you and the organization', 'purpozed'), $boldStart, $boldEnd); ?>
            </div>
        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

        <?php if (!empty($volunteer_evaluation_date)): ?>
            <?php $evalDate = explode('-', $volunteer_evaluation_date); ?>
            <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
            <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
        <?php endif; ?>

        <div class="textarea-style"><textarea
                    class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_text)) ? $volunteer_evaluation_text : ''; ?></textarea>
        </div>

        <div class="period-of-collaboration">
            <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
            <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
            <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
            <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
            <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

        <div class="comment-text"><?php printf(__('Organization comment from %s:', 'purpozed'), $volunteer_evaluation_organization_date); ?></div>
        <div class="textarea-style"><textarea
                    class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_organization_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_organization_text)) ? $volunteer_evaluation_organization_text : ''; ?></textarea>
        </div>

    <?php endif; ?>

<?php endif; ?>

<!--        Ustawienie czy sa widoczne powiadomienia-->

<?php if ($isAdmin): ?>
    <?php $userWhoCompleted = $singleOpportunity->getVolunteersWhoComplete($_GET['id']); ?>
    <?php
    if (!empty($userWhoCompleted)): ?>
        <?php $areCommentsVisible = (get_user_meta($userWhoCompleted[0]->user_id, 'comments_visible')) ? get_user_meta($userWhoCompleted[0]->user_id, 'comments_visible')[0] : ''; ?>
        <?php if ($areCommentsVisible === 'on'): ?>
            <?php if (isset($volunteer_evaluation_organization_text)): ?>

                <?php $evalDate = explode('-', $volunteer_evaluation_organization_date); ?>
                <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                <div class="comment-text"><?php printf(__('Organization\'s comment from %s:', 'purpozed'), $finalDate); ?></div>

                <div class="textarea-style"><textarea
                            class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_organization_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_organization_text)) ? $volunteer_evaluation_organization_text : ''; ?></textarea>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php if (isset($volunteer_evaluation_organization_text)): ?>
                <?php _e('A Volunteer turned off possiblity to see organizations comments', 'purpozed'); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php endif; ?>

<!--  END OF VOLUNTEER -->

<?php else: ?>

    <!--  ORGANIZATION -->

    <?php if ($task_type === 'engagement' && !isset($_GET['c'])): ?>

        <?php if (empty($engagementEvaluationData->evaluation_volunteer) && empty($engagementEvaluationData->evaluation_organization)): ?>

            <div class="medium-header prev-header evaluation">
                <?php _e('Complete successfully and comment', 'purpozed'); ?>
            </div>

            <div class="evaluation-information">
                <div class="information-text">
                    <?php _e('This collaboaration was successful and I want to complete it. Please comment on the collaboration with the volunteer!', 'purpozed'); ?>
                </div>
            </div>

            <div class="evaluation-checkboxes">
                <div class="evaluation-checkbox">
                    <label><input type="checkbox"
                                  name="confirm_canelation"> <?php _e('Yes, I talked with the volunteer about this completion and clarified things (if necessary)', 'purpozed'); ?>
                    </label>
                    <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                </div>
            </div>

            <div class="evaluation-checkboxes">
                <?php if (!isset($_GET['c']) && !$isEvaluatedEngagement): ?>
                    <div class="helping_hours">
                        <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                            <input type="number" name="helping_hours" value="0">
                        </label>
                        <div class="error-box extra"><?php _e('Please enter the number of helping hours (approximately)', 'purpozed'); ?></div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="evaluation-small-info">
                <?php _e('We need the number of helping hours in order to track the total volunteering hours of the volunteer\'s company.', 'purpozed'); ?>
            </div>
            <div class="evaluation-small-info">
                <?php _e('If your are not sure about the number of helping hours, please talk to the volunteer before completing this collaboaration. After you have completed the collaboaration, we ask the volunteer to confirm this approximate number of helping hours.', 'purpozed'); ?>
            </div>

            <div class="textarea-style"><textarea
                        class="evaluation-textarea"
                        placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
            </div>
            <div class="evaluation-error">
                <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
            </div>

            <div class="evaluation-buttons">
                <div class="edit">
                    <button class="step-button back"><a
                                href="/manage-opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                    </button>
                </div>

                <div class="edit">
                    <button data-id="<?php echo $opportunityId; ?>"
                            class="modal-evaluate-button step-button save"><?php _e('SAVE AND COMPLETE SUCCESSFULLY', 'purpozed'); ?></button>
                </div>
            </div>

            <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

        <?php else: ?>

            <?php if (empty($engagementEvaluationData->canceled_by)): ?>

                <?php if (!empty($engagementEvaluationData->evaluation_organization) && empty($engagementEvaluationData->evaluation_volunteer)): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Completed successfully', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text">
                            <?php printf(__('You have completed this collaboration %ssuccessfully%s and commented it but the volunteer did not comment it yet.', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                    <?php if (!empty($engagementEvaluationData->evaluation_organization_date)): ?>
                        <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_organization_date); ?>
                        <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                        <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                    <?php endif; ?>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated"
                                readonly="readonly"><?php echo $engagementEvaluationData->evaluation_organization; ?></textarea>
                    </div>

                    <div class="period-of-collaboration">
                        <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                        <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                        <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                        <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                        <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                    </div>

                    <div class="helping_hours">
                        <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                            <span><?php echo ': ' . $engagementEvaluationData->hours; ?>
                        </label>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                <?php elseif (empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Comment and confirm successful completion', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text">
                            <?php printf(__('The volunteer marked this collaboration as %ssuccessfully completed%s. The volunteer stated approx %s %s helping hours%s. Please comment on the collaboration with the volunteer!', 'purpozed'), $boldStart, $boldEnd, $boldStart, $engagementEvaluationData->hours, $boldEnd); ?>
                        </div>
                    </div>

                    <div class="evaluation-checkboxes">
                        <div class="evaluation-text"><?php _e('I disagree on the statements:', 'purpozed'); ?></div>
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="collaboration_disagree"> <?php _e('The collaboration with the volunteer was not successful', 'purpozed'); ?>
                            </label>
                        </div>
                        <div class="evaluation-checkbox">
                            <label><input type="checkbox"
                                          name="hours_disagree"> <?php _e('The number of helping hours stated by the volunteer is way to low/high', 'purpozed'); ?>
                            </label>
                            <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                        </div>
                    </div>

                    <div class="evaluation-small-info">
                        <?php _e('If you check one of these boxes and click the save button, we will get a message about your complaint, get in touch with the volunteer and try to clear things up.', 'purpozed'); ?>
                    </div>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea"
                                placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
                    </div>
                    <div class="evaluation-error">
                        <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-buttons">
                        <div class="edit">
                            <button class="step-button back"><a
                                        href="/manage-opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                            </button>
                        </div>

                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>"
                                    class="modal-evaluate-button step-button save"><?php _e('SAVE COMMENT', 'purpozed'); ?></button>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                <?php else: ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Completed successfully', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text">
                            <?php printf(__('This collaboration was %scompleted successfully%s and commented by you and the volunteer.', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                    <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_organization_date); ?>
                    <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                    <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated"
                                readonly="readonly"><?php echo $engagementEvaluationData->evaluation_organization; ?></textarea>
                    </div>

                    <div class="period-of-collaboration">
                        <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                        <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                        <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                        <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                        <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                    </div>

                    <div class="helping_hours">
                        <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                            <span><?php echo ': ' . $engagementEvaluationData->hours; ?>
                        </label>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                    <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_volunteer_date); ?>
                    <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                    <div class="comment-text"><?php printf(__('Volunteer\'s comment from %s:', 'purpozed'), $finalDate); ?></div>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated"
                                readonly="readonly"><?php echo $engagementEvaluationData->evaluation_volunteer; ?></textarea>
                    </div>

                <?php endif; ?>

            <?php elseif (!empty($engagementEvaluationData->canceled_by)): ?>

                <?php if (empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Comment and confirm premature cancelation', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php printf(__('The volunteer marked this collaboration as %scanceled prematurely%s. Please comment on the collaboration with the volunteer!', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                        <div class="evaluation-checkboxes">
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="collaboration_disagree"> <?php _e('I disagree, the collaboration with the volunteer was successful', 'purpozed'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="evaluation-small-info">
                            <?php _e('If you check this box and click the save button, we will get a message about your complaint, get in touch with the volunteer and try to clear things up.', 'purpozed'); ?>
                        </div>
                        <div class="textarea-style"><textarea
                                    class="evaluation-textarea"
                                    placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
                        </div>
                        <div class="evaluation-error">
                            <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
                        </div>
                    </div>

                    <div class="evaluation-buttons">
                        <div class="edit">
                            <button class="step-button back"><a
                                        href="/manage-opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                            </button>
                        </div>

                        <div class="edit">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="apply"
                                    data-type="<?php echo 'volunteer'; ?>"
                                    data-user="<?php echo $engagedUserId; ?>"
                                    data-cancel="1"
                                    class="modal-evaluate-button step-button save"><?php _e('SAVE COMMENT', 'purpozed'); ?></button>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                <?php elseif (!empty($engagementEvaluationData->evaluation_organization) && empty($engagementEvaluationData->evaluation_volunteer)): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Canceled prematurely', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php _e('You have canceled this collaboration prematurely and commented it but the volunteer did not comment it yet.', 'purpozed'); ?>
                        </div>

                        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                        <?php if (!empty($engagementEvaluationData->evaluation_organization_date)): ?>
                            <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_organization_date); ?>
                            <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                            <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                        <?php endif; ?>

                        <div class="textarea-style"><textarea
                                    class="evaluation-textarea evaluated"
                                    readonly="readonly"><?php echo $engagementEvaluationData->evaluation_organization; ?></textarea>
                        </div>

                        <div class="period-of-collaboration">
                            <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                            <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                            <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                            <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                            <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                        </div>

                        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                    </div>

                <?php else: ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Canceled prematurely', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php printf(__('This collaboration was %scanceled prematurely%s and commented by you and the volunteeer.', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>

                        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                        <?php if (!empty($engagementEvaluationData->evaluation_organization_date)): ?>
                            <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_organization_date); ?>
                            <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                            <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                        <?php endif; ?>

                        <div class="textarea-style"><textarea
                                    class="evaluation-textarea evaluated"
                                    readonly="readonly"><?php echo $engagementEvaluationData->evaluation_organization; ?></textarea>
                        </div>

                        <div class="period-of-collaboration">
                            <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                            <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                            <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                            <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                            <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                        </div>

                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                    <?php $evalDate = explode('-', $engagementEvaluationData->evaluation_volunteer_date); ?>
                    <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                    <div class="comment-text"><?php printf(__('Volunteer\'s comment from %s:', 'purpozed'), $finalDate); ?></div>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated"
                                readonly="readonly"><?php echo $engagementEvaluationData->evaluation_volunteer; ?></textarea>
                    </div>
                    <?php if ((empty($engagementEvaluationData->evaluation_volunteer) || empty($engagementEvaluationData->evaluation_organization)) && empty($engagementEvaluationData->canceled_by)): ?>
                        <div class="helping_hours">
                            <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                                <span><?php echo $engagementEvaluationData->hours; ?>
                            </label>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <!--        ORGANIZATION NOT ENGAGEMENT-->

    <?php else: ?>

        <?php if (!(isset($volunteer_evaluation_text)) && (!(isset($volunteer_evaluation_organization_text))) && !isset($_GET['c'])): ?>

            <div class="medium-header prev-header evaluation">
                <?php _e('Complete successfully and comment', 'purpozed'); ?>
            </div>

            <div class="evaluation-information">
                <div class="information-text success">
                    <?php _e('This collaboaration was successful and I want to complete it. Please comment on the collaboration with the volunteer!', 'purpozed'); ?>
                </div>
            </div>

            <div class="evaluation-checkboxes">
                <div class="evaluation-checkbox">
                    <label><input type="checkbox"
                                  name="confirm_canelation"> <?php _e('Yes, I talked with the organization about this completion and clarified things (if necessary)', 'purpozed'); ?>
                    </label>
                    <div class="error-box extra"><?php _e('Please confirm', 'purpozed'); ?></div>
                </div>
            </div>

        <?php else: ?>

            <?php if ($opportunity_status === 'succeeded'): ?>

                <?php if (isset($volunteer_evaluation_organization_text) && (!isset($volunteer_evaluation_text))): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Completed successfully', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text">
                            <?php printf(__('You have completed this collaboration %ssuccessfully%s and commented it but the volunteer did not comment it yet.', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>

                        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                        <?php if (!empty($volunteer_evaluation_organization_date)): ?>
                            <?php $evalDate = explode('-', $volunteer_evaluation_organization_date); ?>
                            <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                            <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                        <?php endif; ?>

                        <div class="textarea-style"><textarea
                                    class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_organization_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_organization_text)) ? $volunteer_evaluation_organization_text : ''; ?></textarea>
                        </div>
                    </div>

                    <?php if ($task_type === 'mentoring'): ?>

                        <div class="helping_hours">
                            <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                                <span><?php echo ': ' . $userWhoCompletedOpportunity[0]->mentoring_hours; ?></span>
                            </label>
                        </div>

                    <?php endif; ?>

                    <div class="period-of-collaboration">
                        <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                        <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                        <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                        <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                        <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                <?php elseif (!isset($volunteer_evaluation_organization_text) && (isset($volunteer_evaluation_text))): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Comment and confirm successful completion', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text">
                            <?php printf(__('The volunteer marked this collaboration as %ssuccessfully completed%s. Please comment on the collaboration with the volunteer!', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                        <div class="evaluation-checkboxes">
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="confirm_canelation"> <?php _e('I disagree, the collaboration with the volunteer wasn’t successful', 'purpozed'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="evaluation-small-info">
                            <?php _e('If you check this box and click the save button, we will get a message about your complaint, get in touch with the volunteer and try to clear things up.', 'purpozed'); ?>
                        </div>
                    </div>

                <?php else: ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Completed successfully', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text">
                            <?php printf(__('This collaboration was %ssuccessful%s and commented by you and the volunteer', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                    <?php if (!empty($volunteer_evaluation_organization_date)): ?>
                        <?php $evalDate = explode('-', $volunteer_evaluation_organization_date); ?>
                        <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                        <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                    <?php endif; ?>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_organization_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_organization_text)) ? $volunteer_evaluation_organization_text : ''; ?></textarea>
                    </div>

                    <div class="period-of-collaboration">
                        <?php $start_date_eval = explode('-', substr($start_date, 0, 10)); ?>
                        <?php $end_date_eval = explode('-', substr($end_date, 0, 10)); ?>
                        <?php $finalStartDate = $start_date_eval[2] . '.' . $start_date_eval[1] . '.' . $start_date_eval[0]; ?>
                        <?php $finalEndDate = $end_date_eval[2] . '.' . $end_date_eval[1] . '.' . $end_date_eval[0]; ?>
                        <?php printf(__('Period of collaboration: from %s to %s', 'purpozed'), $finalStartDate, $finalEndDate); ?>
                    </div>

                    <?php if ($task_type === 'mentoring'): ?>

                        <div class="helping_hours">
                            <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>
                                <span><?php echo ': ' . $userWhoCompletedOpportunity[0]->mentoring_hours; ?></span>
                            </label>
                        </div>

                    <?php endif; ?>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                    <?php $evalDate = explode('-', $volunteer_evaluation_date); ?>
                    <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                    <div class="comment-text"><?php printf(__('Volunteer\'s comment from %s:', 'purpozed'), $finalDate); ?></div>
                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_text)) ? 'readonly="readonly""' : ''; ?>><?php echo (isset($volunteer_evaluation_text)) ? $volunteer_evaluation_text : ''; ?></textarea>
                    </div>

                <?php endif; ?>

            <?php elseif ($opportunity_status === 'canceled'): ?>

                <?php if (!isset($volunteer_evaluation_organization_text) && (isset($volunteer_evaluation_text))): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Comment and confirm premature cancelation', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php printf(__('The volunteer marked this collaboration as %scanceled prematurely%s. Please comment on the collaboration with the volunteer!', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                        <div class="evaluation-checkboxes">
                            <div class="evaluation-checkbox">
                                <label><input type="checkbox"
                                              name="collaboration_disagree"> <?php _e('I disagree, the collaboration with the volunteer was successful', 'purpozed'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="evaluation-small-info">
                            <?php _e('If you check this box and click the save button, we will get a message about your complaint, get in touch with the volunteer and try to clear things up.', 'purpozed'); ?>
                        </div>
                    </div>

                <?php elseif (isset($volunteer_evaluation_organization_text) && (!isset($volunteer_evaluation_text))): ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Canceled prematurely', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php printf(__('You have %scanceled this opportunity prematurely%s and commented it, but volunteer did not comment it yet.', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                    <?php if (!empty($volunteer_evaluation_organization_date)): ?>
                        <?php $evalDate = explode('-', $volunteer_evaluation_organization_date); ?>
                        <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                        <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                    <?php endif; ?>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_organization_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_organization_text)) ? $volunteer_evaluation_organization_text : ''; ?></textarea>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                <?php else: ?>

                    <div class="medium-header prev-header evaluation">
                        <?php _e('Canceled prematurely', 'purpozed'); ?>
                    </div>

                    <div class="evaluation-information">
                        <div class="information-text cancel">
                            <?php printf(__('This collaboration was %scanceled prematurely%s and commented by you and the volunteer', 'purpozed'), $boldStart, $boldEnd); ?>
                        </div>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

                    <?php if (!empty($volunteer_evaluation_organization_date)): ?>
                        <?php $evalDate = explode('-', $volunteer_evaluation_organization_date); ?>
                        <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                        <div class="comment-text"><?php printf(__('My comment from %s:', 'purpozed'), $finalDate); ?></div>
                    <?php endif; ?>

                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_organization_text)) ? 'readonly="readonly"' : ''; ?>><?php echo (isset($volunteer_evaluation_organization_text)) ? $volunteer_evaluation_organization_text : ''; ?></textarea>
                    </div>

                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-volunteer.php'); ?>

                    <?php $evalDate = explode('-', $volunteer_evaluation_date); ?>
                    <?php $finalDate = $evalDate[2] . '.' . $evalDate[1] . '.' . $evalDate[0]; ?>
                    <div class="comment-text"><?php printf(__('Volunteer\'s comment from %s:', 'purpozed'), $finalDate); ?></div>
                    <div class="textarea-style"><textarea
                                class="evaluation-textarea evaluated" <?php echo (isset($volunteer_evaluation_text)) ? 'readonly="readonly""' : ''; ?>><?php echo (isset($volunteer_evaluation_text)) ? $volunteer_evaluation_text : ''; ?></textarea>
                    </div>

                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($volunteer_evaluation_text)): ?>

        <?php endif; ?>
        <?php if (!isset($volunteer_evaluation_organization_text) && (!isset($_GET['c']))): ?>

            <div class="evaluation-checkboxes">
                <?php if ($task_type === 'mentoring' && $opportunity_status !== 'canceled'): ?>

                    <div class="helping_hours">
                        <label><?php _e('Number of helping hours (approximately)', 'purpozed'); ?>

                            <?php if (isset($userWhoCompletedOpportunity[0]->mentoring_hours)): ?>
                                <span><?php echo ': ' . $userWhoCompletedOpportunity[0]->mentoring_hours; ?></span>
                            <?php else: ?>
                                <input type="number" name="helping_hours" value="0">
                            <?php endif; ?>

                        </label>
                        <div class="error-box extra"><?php _e('Please enter the number of helping hours (approximately)', 'purpozed'); ?></div>
                    </div>

                <?php endif; ?>
            </div>

            <div class="textarea-style"><textarea
                        class="evaluation-textarea"
                        placeholder="<?php _e('Please comment', 'purpozed'); ?>"></textarea>
            </div>
            <div class="evaluation-error">
                <?php _e('Please write a comment about the collaboration.', 'purpozed'); ?>
            </div>

            <div class="evaluation-buttons">
                <div class="edit">
                    <button class="step-button back"><a
                                href="/manage-opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('BACK', 'purpozed'); ?></a>
                    </button>
                </div>

                <?php if (isset($_GET['c'])): ?>
                    <div class="edit">
                        <button data-id="<?php echo $opportunityId; ?>"
                                class="modal-evaluate-button step-button cancel"><?php _e('SAVE AND COMPLETE PREMATURELY', 'purpozed'); ?></button>
                    </div>
                <? elseif ($opportunity_status === 'canceled'): ?>
                    <div class="edit">
                        <button data-id="<?php echo $opportunityId; ?>"
                                class="modal-evaluate-button step-button save"><?php _e('SAVE COMMENT', 'purpozed'); ?></button>
                    </div>
                <? elseif ($opportunity_status === 'succeeded'): ?>
                    <div class="edit">
                        <button data-id="<?php echo $opportunityId; ?>"
                                class="modal-evaluate-button step-button save"><?php _e('SAVE COMMENT', 'purpozed'); ?></button>
                    </div>
                <? else: ?>
                    <div class="edit">
                        <button data-id="<?php echo $opportunityId; ?>"
                                class="modal-evaluate-button step-button save"><?php _e('SAVE AND COMPLETE SUCCESSFULLY', 'purpozed'); ?></button>
                    </div>
                <?php endif; ?>

            </div>

            <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/profile-organization.php'); ?>

        <?php else: ?>

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
                        data-id="<?php echo $opportunityId; ?>"
                        data-type="<?php echo ($dashboard_type === 'volunteer') ? 'volunteer' : 'organization'; ?>"
                        data-alreadycanceled="<?php echo ($opportunity_status === 'canceled') ? 'true' : ''; ?>"
                        data-user="<?php echo $engagedUserId; ?>"><?php _e('YES, I WANT TO EVALUATE', 'purpozed'); ?></button>
                <button class="modal-close modal-edit"><?php _e('BACK', 'purpozed'); ?></button>
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
                <p class="show_complain hidden"><?php _e('and your complaint has been sent to the support team.', 'purpozed'); ?></p>
                <button class="modal-edit modal-edit reload-page"><?php _e('CLOSE', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal cancel-prematurely">
    <div class="modal-overlay modal-cancel-prematurely-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('You canceled this collaboration succesfully!', 'purpozed'); ?></h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <p class="show_complain hidden"><?php _e('And your complaint has been sent to the support team.', 'purpozed'); ?></p>
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