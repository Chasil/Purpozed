<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/header.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');

$company = new \Purpozed2\Models\Company();
$opoprtunitiesManager = new \Purpozed2\Models\OpportunitiesManager();

$rejected = $singleOpportunity->getRejected($opportunityId);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$rejectedIDs = array();
foreach ($rejected as $reject) {
    $rejectedIDs[] = $reject->user_id;
}

$applied = $singleOpportunity->getApplied($opportunityId);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$appliedIDs = array();
foreach ($applied as $apply) {
    $appliedIDs[] = $apply->user_id;
}

$requested = $singleOpportunity->getRequested($opportunityId);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$requestedIDs = array();
foreach ($requested as $request) {
    $requestedIDs[] = $request->user_id;
}

$currentUsers = $singleOpportunity->getInProgress($opportunityId);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$currentIDs = array();
foreach ($currentUsers as $currentUser) {
    $currentIDs[] = $currentUser->user_id;
}

$completedUsers = $singleOpportunity->getCompletedEngagement($opportunityId);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$completedIDs = array();
foreach ($completedUsers as $completedUser) {
    $completedIDs[] = $completedUser->user_id;
}

/*
* Wykluczenie applied z fitted
*/
foreach ($matchedUsers as $userId => $user) {
    foreach ($rejectedIDs as $rejectedID) {
        if ($userId == $rejectedID) {
            unset($matchedUsers[$userId]);
        }
    }
}

foreach ($matchedUsers as $userId => $user) {
    foreach ($requestedIDs as $requestedID) {
        if ($userId == $requestedID) {
            unset($matchedUsers[$userId]);
        }
    }
}

foreach ($matchedUsers as $userId => $user) {
    foreach ($appliedIDs as $appliedID) {
        if ($userId == $appliedID) {
            unset($matchedUsers[$userId]);
        }
    }
}

foreach ($matchedUsers as $userId => $user) {
    foreach ($currentIDs as $currentID) {
        if ($userId == $currentID) {
            unset($matchedUsers[$userId]);
        }
    }
}

foreach ($matchedUsers as $userId => $user) {
    foreach ($completedIDs as $completedID) {
        if ($userId == $completedID) {
            unset($matchedUsers[$userId]);
        }
    }
}

$engaged = $singleOpportunity->getInProgress($opportunityId);
$completed = $singleOpportunity->getVolunteersWhoComplete($opportunityId);
$completedEngagement = $singleOpportunity->getVolunteersWhoCompleteEngagement($opportunityId);

if ($task_type === 'engagement') {
    $oppManager = new \Purpozed2\Models\OpportunitiesManager();
    $currentEngagement = $oppManager->getSingleEngagement($opportunityId);
}
?>

<?php if (!$hasId): ?>

    <div><?php _e('No Opportunity or id is missing!', 'purpozed'); ?></div>

<?php else: ?>

    <div class="dashboard manage-opportunity edit-profie organization-profile validate-it">
        <?php if ($task_type === 'engagement') : ?>
            <?php if ($currentEngagement->closed === '1'): ?>
                <div class="vol-top-info-bar">
                    <div class="succeeded">
                        <?php _e('You have closed this opportunity for new volunteers. Therefore it is not longer visible for interested
                volunteers and volunteers can\'t apply for it anymore. Additionally you can\'t request fitting volunteers.
                Please note that pending applications from volunteers and pending requests from you are not affected by
                closing the opportunity. Therefore you still can select volunteers who have already applied and
                volunteers
                you have already requested still can take over the opportunity. If you want to reopen this engagement
                for
                new volunteers again, please click the button OPEN FOR NEW VOLUNTEERS', 'purpozed'); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="columns">
            <div class="single-column first menu">
                <div class="items">
                    <div class="menu-items">
                        <div class="item active" id="profile_info"><?php _e('Opportunity details', 'purpozed'); ?></div>
                        <div class="item <?php echo (count($applied) < 1) ? 'inactive-tab' : ''; ?>"
                             id="pending_applications"><?php _e('Pending applications', 'purpozed'); ?><?php echo ' (' . count($applied) . ')'; ?>
                        </div>
                        <div class="item <?php echo (count($requested) < 1) ? 'inactive-tab' : ''; ?>"
                             id="pending_requests"><?php _e('Pending requests for you', 'purpozed'); ?><?php echo ' (' . count($requested) . ')'; ?></div>
                        <div class="item <?php echo (count($matchedUsers) < 1 || ($task_type !== 'engagement' && $status === 'in_progress') || ($task_type !== 'engagement' && $status === 'completed') || ($task_type !== 'engagement' && $status === 'canceled')) ? 'inactive-tab' : ''; ?>"
                             id="fitting_volunteers"><?php _e('Fitting volunteers you can request', 'purpozed'); ?><?php echo ' (' . count($matchedUsers) . ')'; ?></div>
                        <div class="item <?php echo (count($engaged) < 1) ? 'inactive-tab' : ''; ?>"
                             id="engaged_volunteers"><?php _e('Currently engaged volunteers', 'purpozed'); ?><?php echo ' (' . count($engaged) . ')'; ?>
                        </div>
                        <div class="item <?php if ($task_type === 'engagement'): ?>
                                <?php echo (count($completedEngagement) < 1) ? 'inactive-tab' : ''; ?>
                            <?php else: ?>
                                <?php echo (count($completed) < 1) ? 'inactive-tab' : ''; ?>
                            <?php endif; ?>"
                             id="completed"><?php _e('Completed', 'purpozed'); ?>
                            <?php if ($task_type === 'engagement'): ?>
                                <?php echo ' (' . count($completedEngagement) . ')'; ?>
                            <?php else: ?>
                                <?php echo ' (' . count($completed) . ')'; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="items button">
                    <?php if ($status === 'prepared'): ?>
                        <div class="retract dashboard">
                            <BUTTON>
                                <a class="step-button"
                                   href="<?php echo $language; ?>/post-opportunity/?id=<?php echo $opportunityId; ?>&task=<?php echo $task_type; ?>"><?php _e('EDIT', 'purpozed'); ?></a>
                            </BUTTON>
                        </div>
                    <?php endif; ?>
                    <?php if ($status === 'review'): ?>
                        <div class='matched-opportunity-box manage'>
                            <p><?php printf(__('Under review. You have posted this %s and we are about to check and publish it within 24 hours.', 'purpozed'), $task_type); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($status === 'open'): ?>

                        <?php if (empty($engaged)): ?>

                            <div class="single-option profile retract dashboard diff-butt">
                                <button data-id="<?php echo $opportunity_id; ?>"
                                        class="modal-delete-opportunity-single-button step-button light"><?php _e('DELETE', 'purpozed'); ?></button>
                            </div>

                            <div class="modal delete-opportunity-single-ask">
                                <div class="modal-overlay modal-apply-button"></div>
                                <div class="modal-wrapper modal-transition">
                                    <div class="modal-header">
                                        <h2 class="modal-heading"><?php _e('Delete opportunity', 'purpozed'); ?>
                                            ?</h2>
                                    </div>
                                    <div class="modal-body">
                                        <div class="modal-content">
                                            <P><?php _e('You want to delete this opportunity', 'purpozed'); ?>?</P>
                                            <button class="modal-edit delete-opportunity-single-confirm diff-butt"
                                                    data-id="<?php echo $opportunity_id; ?>"><?php _e('DELETE OPPORTUNITY', 'purpozed'); ?></button>
                                            <button class="modal-close modal-edit diff-butt"><?php _e('CANCEL', 'purpozed'); ?></button>
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
                                            <button class="modal-edit modal-edit go-dashboard diff-butt"><?php _e('CLOSE', 'purpozed'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php else: ?>

                            <div class="retract dashboard diff-butt">
                                <button data-id="<?php echo $opportunityId; ?>"
                                        class="modal-retract-button-single step-button"><?php _e('RETRACT OPPORTUNITY', 'purpozed'); ?></button>
                            </div>

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
                                            <button class="modal-edit diff-butt retract-confirm-single"
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

                        <?php endif; ?>

                        <?php if ($task_type === 'engagement'): ?>

                            <div class="retract dashboard diff-butt">
                                <button data-id="<?php echo $opportunityId; ?>"
                                        class="modal-close-button-single step-button light"><?php ($currentEngagement->closed === '0') ? _e('CLOSE OPPORTUNITY FOR NEW VOLUNTEERS', 'purpozed') : _e('OPEN FOR NEW VOLUNTEERS', 'purpozed'); ?></button>
                            </div>

                            <div class="modal close-ask-single">
                                <div class="modal-overlay modal-close-button"></div>
                                <div class="modal-wrapper modal-transition">
                                    <div class="modal-header">
                                        <h2 class="modal-heading"><?php ($currentEngagement->closed === '0') ? _e('Close opportunity for new volunteers', 'purpozed') : _e('Open opportunity for new volunteers', 'purpozed'); ?>
                                            ?</h2>
                                    </div>
                                    <div class="modal-body">
                                        <div class="modal-content">
                                            <?php if ($currentEngagement->closed === '0'): ?>
                                                <P><?php _e('You want to close this opportunity for new volunteers?', 'purpozed'); ?>
                                                    .</P>
                                                <P><?php _e('If you close this opportunity for new volunteers, it is not longer visible for interested volunteers and volunteers can\'t apply for it anymore. Additionally you can\'t request fitting volunteers.', 'purpozed'); ?>
                                                    .</P>
                                                <P><?php _e('Please note that pending applications from volunteers and pending requests from you are not affected by closing the opportunity. Therefore you still can select volunteers who have already applied and volunteers you have already requested still can take over the opportunity.', 'purpozed'); ?>
                                                    .</P>
                                                <P><?php _e('After closing the opportunity you can reopen it again anytime.', 'purpozed'); ?>
                                                    .</P>
                                            <?php else: ?>
                                                <P><?php _e('You want to open this opportunity for new volunteers again?', 'purpozed'); ?>
                                                    .</P>
                                                <P><?php _e('If you open this opportunity for new volunteers, it is visible for interested volunteers again and volunteers can apply for it. Additionally you can request fitting volunteers again.', 'purpozed'); ?>
                                                    .</P>
                                                <P><?php _e('After opening the opportunity again you can close it again anytime.', 'purpozed'); ?>
                                                    .</P>
                                            <?php endif; ?>
                                            <button class="modal-edit diff-butt close-confirm-single"
                                                    data-id="<?php echo $opportunity->task_id; ?>"
                                                    data-status="<?php echo ($currentEngagement->closed === '0') ? 'open' : 'closed'; ?>">
                                                <?php ($currentEngagement->closed === '0') ? _e('CLOSE OPPORTUNITY FOR NEW VOLUNTEERS', 'purpozed') : _e('OPEN FOR NEW VOLUNTEERS', 'purpozed'); ?></button>
                                            <button class="modal-close modal-edit diff-butt"><?php _e('CANCEL', 'purpozed'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                    <?php elseif ($status === 'in_progress'): ?>
                        <!--                        <div class="retract dashboard">-->
                        <!--                            <button>-->
                        <!--                                <a class="step-button"-->
                        <!--                                   href="/evaluate/?id=--><?php //echo $opportunityId; ?><!--">--><?php //_e('COMPLETE', 'purpozed'); ?><!--</a>-->
                        <!--                            </button>-->
                        <!--                        </div>-->
                        <!--                        <div class="retract dashboard">-->
                        <!--                            <button>-->
                        <!--                                <a class="step-button"-->
                        <!--                                   href="/evaluate/?id=--><?php //echo $opportunityId; ?><!--&c=1">--><?php //_e('CANCEL', 'purpozed'); ?><!--</a>-->
                        <!--                            </button>-->
                        <!--                        </div>-->

                    <?php elseif (($status === 'succeeded') || ($status === 'canceled')): ?>
                        <div class="retract dashboard">
                            <button>
                                <a class="step-button"
                                   href="<?php echo $language; ?>/evaluate/?id=<?php echo $opportunityId; ?>"><?php _e('EVALUATION', 'purpozed'); ?></a>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="single-column third section" id="profile_info_section">
                <div class="left-side">
                    <?php
                    if ($task_type === 'call') {
                        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage/call.php');
                    } elseif ($task_type === 'project') {
                        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage/project.php');
                    } elseif ($task_type === 'mentoring') {
                        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage/mentoring.php');
                    } elseif ($task_type === 'engagement') {
                        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage/engagement.php');
                    }
                    ?>
                </div>
            </div>
            <div class="single-column third hidden section" id="pending_applications_section">
                <?php
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage/oportunity-details-top.php');
                ?>
                <div class="left-side posted">
                    <div class="volunteer-box">
                        <div class="title"><?php _e('These volunteers have applied for this opportunity and are currently waiting for your approval', 'purpozed'); ?></div>
                        <?php if (!empty($applied)): ?>
                            <?php foreach ($applied as $user): ?>
                                <?php $companyId = (get_user_meta($user->user_id, 'company_id')) ? get_user_meta($user->user_id, 'company_id')[0] : ''; ?>
                                <div class="applied-time">
                                    <?php
                                    $postedDateTimestamp = strtotime($singleOpportunity->appliedDaysAgo($opportunityId, $user->user_id,));
                                    $difference = time() - $postedDateTimestamp;

                                    $set = false;
                                    if ($difference >= 60 * 60 * 12) {
                                        $set = true;
                                        $dtF = new \DateTime('@0');
                                        $dtT = new \DateTime("@" . $difference . "");
                                        $timeText = $dtF->diff($dtT)->days;
                                    }

                                    ?>
                                    <div class="top">
                                        <?php _e('Posted', 'purpozed'); ?>
                                        <?php if ($set) {
                                            printf(__('%s days ago', 'purpozed'), $timeText);
                                        } else {
                                            _e('today', 'purpozed');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="single-volunteer">
                                    <div class="data">
                                        <div class="picture">
                                            <img
                                                    src="<?php echo wp_get_attachment_image_src(get_user_meta($user->user_id, 'image')[0], 'thumbnail')[0]; ?>">
                                            <div class="image_caption"></div>
                                        </div>
                                        <div class="details">
                                            <div class="name"><?php echo get_user_meta($user->user_id, 'first_name')[0] . ' ' . get_user_meta($user->user_id, 'last_name')[0]; ?></div>
                                            <div class="job_title"><?php echo get_user_meta($user->user_id, 'title')[0]; ?></div>
                                            <div class="corporation">
                                                <?php if (!empty($companyId)): ?>
                                                    <?php $companyData = $company->getDetailsById($companyId);
                                                    echo $companyData->display_name; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage-opportunity-matching.php');
                                    ?>
                                    <div class="options">
                                        <?php if (($status !== 'succeeded') && ($status !== 'canceled') && ($status !== 'in_progress')): ?>
                                            <div class="edit">
                                                <button type="button"
                                                        class="select-button modal-select-button"><?php _e('SELECT', 'purpozed'); ?></button>
                                            </div>
                                            <div class="edit">
                                                <button type="button"
                                                        class="select-button modal-reject-button"><?php _e('REJECT', 'purpozed'); ?></button>

                                                <div class="modal reject-volunteer-ask">
                                                    <div class="modal-overlay modal-retract-volunteer-button"></div>
                                                    <div class="modal-wrapper modal-transition">
                                                        <div class="modal-header">
                                                            <h2 class="modal-heading"><?php _e('Reject volunteers application', 'purpozed'); ?></h2>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="modal-content">
                                                                <?php if ($task_type === 'engagement'): ?>
                                                                    <p><?php _e('Please reject the volunteers application only if you found out in a conversation with the volunteer that he or she is not the right for the job to be done', 'purpozed'); ?></p>
                                                                    <p><?php _e('If you dont need volunteers for this engagement anymore then please retract the engagement in order to avoid more applications from volunteers', 'purpozed'); ?></p>
                                                                <?php else: ?>
                                                                    <p><?php _e('Please reject the volunteers application only if you are sure that he or she is not the right for the job to be done', 'purpozed'); ?></p>
                                                                    <p><?php _e('If you want to select an other specyfic volunteer for this opportunity then you dont have to reject pending applications from this and other volunteers. If you select a volunteer then other volunteers will receive a friendly refusal automatically', 'purpozed'); ?></p>
                                                                <?php endif; ?>
                                                                <button type="button"
                                                                        class="modal-edit reject-volunteer-confirm"
                                                                        data-id="<?php echo $opportunityId; ?>"
                                                                        data-user="<?php echo $user->user_id; ?>"><?php _e('REJECT VOLUNTEER', 'purpozed'); ?></button>
                                                                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal reject-volunteer">
                                                    <div class="modal-overlay modal-retract-volunteer-button"></div>
                                                    <div class="modal-wrapper modal-transition">
                                                        <div class="modal-header">
                                                            <h2 class="modal-heading"><?php _e('You rejected the volunteers application successfully', 'purpozed'); ?>
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
                                        <?php endif; ?>
                                        <div class="single-option profile"><a
                                                    href="<?php echo $language; ?>/volunteer-profile-preview/?id=<?php echo $user->user_id; ?>"><?php _e('VIEW PROFILE', 'purpozed'); ?></a>
                                        </div>
                                    </div>
                                    <div class="modal select-ask">
                                        <div class="modal-overlay modal-select-button"></div>
                                        <div class="modal-wrapper modal-transition">
                                            <div class="modal-header">
                                                <h2 class="modal-heading"><?php _e('Select volunteer for opportunity', 'purpozed'); ?></h2>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-content">
                                                    <P><?php _e('Great that you found the right volunteer for your opportunity', 'purpozed'); ?>
                                                        !</P>
                                                    <P><?php _e('By clicking on "Select volunteer" the volunteer will receive a notification that it\'s opportunity has just started. After this you and the volunteer should make contact in order to talk about the upcoming steps.', 'purpozed'); ?></P>
                                                    <button type="button" class="modal-edit select-confirm"
                                                            data-id="<?php echo $opportunityId; ?>"
                                                            data-user="<?php echo $user->user_id; ?>"
                                                            data-accept="1"><?php _e('SELECT VOLUNTEER', 'purpozed'); ?></button>
                                                    <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal select-opportunity">
                                        <div class="modal-overlay modal-select-button"></div>
                                        <div class="modal-wrapper modal-transition">
                                            <div class="modal-header">
                                                <h2 class="modal-heading"><?php _e('Congratulation, You have selected the volunteer successfully!', 'purpozed'); ?>
                                                    !</h2>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-content">
                                                    <P><?php _e('Please try to make contact with the volunteer in the next 24 hours via email or telephone and talk about the next steps.', 'purpozed'); ?></P>
                                                    <P><?php _e('You find the contact data of the volunteer in the opportunity section "Currently engaged volunteers".', 'purpozed'); ?></P>
                                                    <P><?php _e('You find this opportunitiy from now onwards in the dashboard section "In Progress".', 'purpozed'); ?></P>
                                                    <P><?php _e('We wish you success', 'purpozed'); ?>!</P>
                                                    <button class="modal-edit modal-edit reload-page"><?php _e('CLOSE', 'purpozed'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="job_title"><?php _e('Currently there are no volunteers applied for this opportunity', 'purpozed'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="single-column third hidden section" id="pending_requests_section">
                <?php
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage/oportunity-details-top.php');
                ?>
                <div class="left-side posted">
                    <div class="volunteer-box">
                        <div class="title"><?php _e('These volunteers were requested by you but did not took over yet', 'purpozed'); ?></div>

                        <?php if (!empty($requested)): ?>
                            <?php foreach ($requested as $user): ?>
                                <?php $companyId = get_user_meta($user->user_id, 'company_id')[0]; ?>
                                <div class="single-volunteer">
                                    <div class="data">
                                        <div class="picture"><img
                                                    src="<?php echo wp_get_attachment_image_src(get_user_meta($user->user_id, 'image')[0], 'thumbnail')[0]; ?>">
                                        </div>
                                        <div class="details">
                                            <div class="name"><?php echo get_user_meta($user->user_id, 'first_name')[0] . ' ' . get_user_meta($user->user_id, 'last_name')[0]; ?></div>
                                            <div class="job_title"><?php echo get_user_meta($user->user_id, 'title')[0]; ?></div>
                                            <div class="corporation"><?php $companyData = $company->getDetailsById($companyId);
                                                echo $companyData->display_name; ?></div>
                                        </div>
                                    </div>
                                    <?php
                                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage-opportunity-matching.php');
                                    ?>
                                    <div class="options">
                                        <?php if (($status !== 'succeeded') && ($status !== 'canceled')): ?>
                                            <div class="edit">
                                                <button type="button"
                                                        class="select-button modal-retract-volunteer-button"
                                                        data-id="<?php echo $opportunityId; ?>"
                                                        data-user="<?php echo $user->user_id; ?>"><?php _e('RETRACT REQUEST', 'purpozed'); ?></button>
                                            </div>
                                        <?php endif; ?>
                                        <div class="single-option profile"><a
                                                    href="<?php echo $language; ?>/volunteer-profile-preview/?id=<?php echo $user->user_id; ?>">VIEW
                                                PROFILE</a></div>
                                    </div>
                                    <div class="modal retract-volunteer-ask">
                                        <div class="modal-overlay modal-retract-volunteer-button"></div>
                                        <div class="modal-wrapper modal-transition">
                                            <div class="modal-header">
                                                <h2 class="modal-heading"><?php _e('Retract the request you sent to the volunteer', 'purpozed'); ?></h2>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-content">
                                                    <P><?php _e('Please retract the request you sent to a volunteer only when you found out in a conversation with the volunteer that he or she is not the right for the job to be done.', 'purpozed'); ?>
                                                        !</P>
                                                    <button type="button" class="modal-edit retract-volunteer-confirm"
                                                            data-id="<?php echo $opportunityId; ?>"
                                                            data-user="<?php echo $user->user_id; ?>"><?php _e('RETRACT REQUEST', 'purpozed'); ?></button>
                                                    <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal retract-volunteer">
                                        <div class="modal-overlay modal-retract-volunteer-button"></div>
                                        <div class="modal-wrapper modal-transition">
                                            <div class="modal-header">
                                                <h2 class="modal-heading"><?php _e('You Retract the request you sent to the volunteer successfully', 'purpozed'); ?>
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
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="job_title"><?php _e('Currently there are no volunteers requested for this opportunity', 'purpozed'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="single-column third hidden section" id="fitting_volunteers_section">
                <?php
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage/oportunity-details-top.php');
                ?>
                <div class="left-side posted">
                    <div class="volunteer-box">
                        <div class="title"><?php _e('These volunteers have fitting skills and you can send them a request', 'purpozed'); ?></div>

                        <?php if (!empty($matchedUsers)): ?>
                            <?php foreach ($matchedUsers as $userId => $user): ?>
                                <?php $companyId = get_user_meta($userId, 'company_id')[0]; ?>
                                <?php $currentUserId = $userId; ?>
                                <div class="single-volunteer">
                                    <div class="data">
                                        <div class="picture"><img
                                                    src="<?php echo wp_get_attachment_image_src(get_user_meta($userId, 'image')[0], 'thumbnail')[0]; ?>">
                                        </div>
                                        <div class="details">
                                            <div class="name"><?php echo get_user_meta($userId, 'first_name')[0] . ' ' . get_user_meta($userId, 'last_name')[0]; ?></div>
                                            <div class="job_title"><?php echo get_user_meta($userId, 'title')[0]; ?></div>
                                            <div class="corporation"><?php $companyData = $company->getDetailsById($companyId);
                                                echo $companyData->first_name; ?></div>
                                        </div>
                                    </div>
                                    <div class="skills">
                                        <?php

                                        if ($task_type === 'call') {
                                            $taskSkills = $opoprtunitiesManager->getCallSkillsByCall($_GET['id']);
                                            $userSkills = $volunteerManager->getCurrentUser($userId)->getSkills();

                                            $totalTaskSkills = count($taskSkills);

                                            $userSkillsNames = array();
                                            foreach ($userSkills as $skill) {
                                                $userSkillsNames[] = $skill->name;
                                            }

                                            $matchedSkillsValue = 0;
                                            $matchedSkills = array();
                                            foreach ($taskSkills as $taskSkill) {
                                                foreach ($userSkillsNames as $userSkillsName) {
                                                    if ($taskSkill->name === $userSkillsName) {
                                                        $matchedSkillsValue++;
                                                        $matchedSkills[] = $userSkillsName;
                                                    }
                                                }
                                            }

                                            $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                                            $organization = new \Purpozed2\Models\Organization();

                                            $organizationGoals = $organization->getGoals(get_current_user_id());
                                            $organizationMainGoalId = get_user_meta(get_current_user_id(), 'main_goal');
                                            $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

                                            $organizationGoalsNames = array();
                                            foreach ($organizationGoals as $organizationGoal) {
                                                $organizationGoalsNames[] = $organizationGoal->name;
                                            }
                                            $organizationGoalsNames[] = $organizationMainGoal->name;

                                            $users = get_users(array('fields' => array('ID')));

                                            $volunteerGoals[] = array(
                                                'goals' => $volunteerManager->getCurrentUser($userId)->getGoals()
                                            );

                                            $organizationGoalsValue = count($organizationGoalsNames);

                                            $matchedGoals = array();
                                            $matchedGoalsValue = 0;
                                            foreach ($organizationGoals as $organizationGoal) {
                                                $matchedScore = 0;
                                                foreach ($volunteerGoals as $userId => $volunteerGoal) {
                                                    foreach ($volunteerGoal as $goal) {
                                                        foreach ($goal as $item) {
                                                            if ($organizationGoal->name === $item->name) {
                                                                $matchedGoals[] = $item->name;
                                                                $matchedGoalsValue++;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <div class="title">
                                                <?php _e('Matched skills', 'purpozed'); ?>
                                                <!--                                                --><?php
                                                //                                                echo (int)(($matchedSkillsValue / $totalTaskSkills) * 100);
                                                //                                                ?><!-- % matched skills-->
                                            </div>
                                            <?php if (!empty($matchedSkills)): ?>
                                                <div class="single-skills">
                                                    <?php $matchedAmount = count($matchedSkills); ?>
                                                    <?php $howManyMore = 0; ?>
                                                    <?php if ($matchedAmount > 2) {
                                                        $howManyMore = $matchedAmount - 2;
                                                    }
                                                    ?>
                                                    <?php $i = 1; ?>
                                                    <?php $elseSkills = array(); ?>
                                                    <?php foreach ($matchedSkills as $skill): ?>
                                                        <?php if ($i < 3): ?>
                                                            <div class="single-skill"><?php echo $skill; ?></div>
                                                            <?php $i++; ?>
                                                        <?php else: ?>
                                                            <?php $elseSkills[] = $skill; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (!empty($elseSkills)): ?>
                                                        <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="title">
                                                <?php _e('Matched goals', 'purpozed'); ?>
                                                <!--                                                --><?php
                                                //                                                echo (int)(($matchedSkillsValue / $totalTaskSkills) * 100);
                                                //                                                ?><!-- % matched skills-->
                                            </div>
                                            <?php $uniqueGoals = array_unique($matchedGoals); ?>
                                            <?php if (!empty($uniqueGoals)): ?>
                                                <div class="single-skills">
                                                    <?php $matchedAmount = count($uniqueGoals);
                                                    $howManyMore = 0;
                                                    if ($matchedAmount > 2) {
                                                        $howManyMore = $matchedAmount - 2;
                                                    }
                                                    ?>
                                                    <?php $i = 1; ?>
                                                    <?php $elseGoals = array(); ?>
                                                    <?php foreach ($uniqueGoals as $goal): ?>
                                                        <?php if ($i < 3): ?>
                                                            <div class="single-skill"><?php echo $goal; ?></div>
                                                            <?php $i++; ?>
                                                        <?php else: ?>
                                                            <?php $elseGoals[] = $goal; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (!empty($elseGoals)): ?>
                                                        <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php
                                        } elseif ($task_type === 'project') {
                                            $taskSkills = $opoprtunitiesManager->getProjectSkillsByTask($_GET['id']);
                                            $userSkills = $volunteerManager->getCurrentUser($userId)->getSkills();

                                            $totalTaskSkills = count($taskSkills);

                                            $userSkillsNames = array();
                                            foreach ($userSkills as $skill) {
                                                $userSkillsNames[] = $skill->name;
                                            }

                                            $matchedSkillsValue = 0;
                                            $matchedSkills = array();
                                            foreach ($taskSkills as $taskSkill) {
                                                foreach ($userSkillsNames as $userSkillsName) {
                                                    if ($taskSkill->name === $userSkillsName) {
                                                        $matchedSkillsValue++;
                                                        $matchedSkills[] = $userSkillsName;
                                                    }
                                                }
                                            }
                                            $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                                            $organization = new \Purpozed2\Models\Organization();

                                            $organizationGoals = $organization->getGoals(get_current_user_id());
                                            $organizationMainGoalId = get_user_meta(get_current_user_id(), 'main_goal');
                                            $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

                                            $organizationGoalsNames = array();
                                            foreach ($organizationGoals as $organizationGoal) {
                                                $organizationGoalsNames[] = $organizationGoal->name;
                                            }
                                            $organizationGoalsNames[] = $organizationMainGoal->name;

                                            $users = get_users(array('fields' => array('ID')));

                                            $volunteerGoals[] = array(
                                                'goals' => $volunteerManager->getCurrentUser($userId)->getGoals()
                                            );

                                            $organizationGoalsValue = count($organizationGoalsNames);

                                            $matchedGoals = array();
                                            $matchedGoalsValue = 0;
                                            foreach ($organizationGoals as $organizationGoal) {
                                                $matchedScore = 0;
                                                foreach ($volunteerGoals as $userId => $volunteerGoal) {
                                                    foreach ($volunteerGoal as $goal) {
                                                        foreach ($goal as $item) {
                                                            if ($organizationGoal->name === $item->name) {
                                                                $matchedGoals[] = $item->name;
                                                                $matchedGoalsValue++;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <div class="title">
                                                <?php _e('Matched skills', 'purpozed'); ?>
                                                <!--                                                --><?php
                                                //                                                echo (int)(($matchedSkillsValue / $totalTaskSkills) * 100);
                                                //                                                ?><!-- % matched skills-->
                                            </div>
                                            <?php if (!empty($matchedSkills)): ?>
                                                <div class="single-skills">
                                                    <?php $matchedAmount = count($matchedSkills); ?>
                                                    <?php $howManyMore = 0; ?>
                                                    <?php if ($matchedAmount > 2) {
                                                        $howManyMore = $matchedAmount - 2;
                                                    }
                                                    ?>
                                                    <?php $i = 1; ?>
                                                    <?php $elseSkills = array(); ?>
                                                    <?php foreach ($matchedSkills as $skill): ?>
                                                        <?php if ($i < 3): ?>
                                                            <div class="single-skill"><?php echo $skill; ?></div>
                                                            <?php $i++; ?>
                                                        <?php else: ?>
                                                            <?php $elseSkills[] = $skill; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (!empty($elseSkills)): ?>
                                                        <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="title">
                                                <?php _e('Matched goals', 'purpozed'); ?>
                                                <!--                                                --><?php
                                                //                                                echo (int)(($matchedSkillsValue / $totalTaskSkills) * 100);
                                                //                                                ?><!-- % matched skills-->
                                            </div>
                                            <?php $uniqueGoals = array_unique($matchedGoals); ?>
                                            <?php if (!empty($uniqueGoals)): ?>
                                                <div class="single-skills">
                                                    <?php $matchedAmount = count($uniqueGoals);
                                                    $howManyMore = 0;
                                                    if ($matchedAmount > 2) {
                                                        $howManyMore = $matchedAmount - 2;
                                                    }
                                                    ?>
                                                    <?php $i = 1; ?>
                                                    <?php $elseGoals = array(); ?>
                                                    <?php foreach ($uniqueGoals as $goal): ?>
                                                        <?php if ($i < 3): ?>
                                                            <div class="single-skill"><?php echo $goal; ?></div>
                                                            <?php $i++; ?>
                                                        <?php else: ?>
                                                            <?php $elseGoals[] = $goal; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (!empty($elseGoals)): ?>
                                                        <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php
                                        } elseif ($task_type === 'mentoring') {

                                            $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                                            $taskManager = new \Purpozed2\Models\TaskManager();
                                            $opportunityObject = new \Purpozed2\Models\Opportunity();

                                            $matchedUserSkills = array();
                                            $areasOfExpertises = $opportunityObject->getAreaOfExpertise($_GET['id']);
                                            $mentoringSkills = array();
                                            foreach ($areasOfExpertises as $areasOfExpertise) {
                                                $tasksIDs = $taskManager->getTaskSkillsByAreaOfExpertise($areasOfExpertise->id);
                                                foreach ($tasksIDs as $tasksID) {
                                                    $taskSkillsData[] = $taskManager->getSkills($tasksID->id);
                                                    foreach ($taskSkillsData as $taskSkillsDatum) {
                                                        foreach ($taskSkillsDatum as $item) {

                                                            $userData = get_user_by('ID', $userId);
                                                            if (in_array('volunteer', $userData->roles)) {

                                                                $userSkills = $volunteerManager->getCurrentUser($userId)->getSkills();

                                                                $userSkillsNames = array();
                                                                foreach ($userSkills as $skill) {
                                                                    $userSkillsNames[] = $skill->name;
                                                                }
                                                                foreach ($userSkillsNames as $userSkillsName) {
                                                                    if ($item->name === $userSkillsName) {
                                                                        if (!in_array($userSkillsName, $matchedUserSkills)) {
                                                                            $matchedUserSkills[] = $userSkillsName;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            $parsedSkillsData = array();
                                            foreach ($taskSkillsData as $taskSkillsDatum) {
                                                foreach ($taskSkillsDatum as $item) {
                                                    if (!in_array($item->name, $parsedSkillsData)) {
                                                        $parsedSkillsData[] = $item->name;
                                                    }
                                                }
                                            }

                                            $matchedUserSkills = array_unique($matchedUserSkills);

                                            $mentoringSkillsValue = count($parsedSkillsData);

                                            $matchedValue = 0;
                                            $mentoringMatchedSkills = array();
                                            foreach ($parsedSkillsData as $parsedSkillsDatum) {
                                                foreach ($matchedUserSkills as $matchedUserSkill) {
                                                    if ($matchedUserSkill === $parsedSkillsDatum) {
                                                        $mentoringMatchedSkills[] = $parsedSkillsDatum;
                                                        $matchedValue++;
                                                    }
                                                }
                                            } ?>

                                            <div class="title">
                                                <?php _e('Matched Area of Expertise', 'purpozed'); ?>
                                            </div>
                                            <div class="single-skills">
                                                <?php foreach ($areasOfExpertises as $areasOfExpertise): ?>
                                                    <div class="single-skill"><?php echo $areasOfExpertise->name; ?></div>
                                                <? endforeach; ?>
                                            </div>
                                            <div class="title">
                                                <?php _e('Matched goals', 'purpozed'); ?>
                                                <!--                                                --><?php
                                                //                                                echo (int)(($matchedValue / $mentoringSkillsValue) * 100);
                                                //                                                ?><!-- % matched goals-->
                                            </div>
                                            <?php $uniqueGoals = array_unique($mentoringMatchedSkills); ?>
                                            <?php if (!empty($uniqueGoals)): ?>
                                                <div class="single-skills">
                                                    <?php $matchedAmount = count($uniqueGoals);
                                                    $howManyMore = 0;
                                                    if ($matchedAmount > 2) {
                                                        $howManyMore = $matchedAmount - 2;
                                                    }
                                                    ?>
                                                    <?php $i = 1; ?>
                                                    <?php $elseGoals = array(); ?>
                                                    <?php foreach ($uniqueGoals as $goal): ?>
                                                        <?php if ($i < 3): ?>
                                                            <div class="single-skill"><?php echo $goal; ?></div>
                                                            <?php $i++; ?>
                                                        <?php else: ?>
                                                            <?php $elseGoals[] = $goal; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (!empty($elseGoals)): ?>
                                                        <span class="show-more-skills">
                                                            <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                            <div class="tooltip-skills">
                                                                <?php foreach ($elseGoals as $item): ?>
                                                                    <div class="single-skill"><?php echo $item; ?></div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?


                                        } elseif ($task_type === 'engagement') {

                                            $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                                            $organization = new \Purpozed2\Models\Organization();

                                            $organizationGoals = $organization->getGoals(get_current_user_id());
                                            $organizationMainGoalId = get_user_meta(get_current_user_id(), 'main_goal');
                                            $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);


                                            $organizationGoalsNames = array();
                                            foreach ($organizationGoals as $organizationGoal) {
                                                $organizationGoalsNames[] = $organizationGoal->name;
                                            }
                                            $organizationGoalsNames[] = $organizationMainGoal->name;

                                            $users = get_users(array('fields' => array('ID')));

                                            $volunteerGoals = array();
                                            $volunteerGoals[] = array(
                                                'goals' => $volunteerManager->getCurrentUser($userId)->getGoals()
                                            );

                                            $organizationGoalsValue = count($organizationGoalsNames);


                                            $matchedGoals = array();
                                            $matchedGoalsValue = 0;
                                            foreach ($organizationGoals as $organizationGoal) {
                                                $matchedScore = 0;
                                                foreach ($volunteerGoals as $userId => $volunteerGoal) {
                                                    foreach ($volunteerGoal as $goal) {
                                                        foreach ($goal as $item) {
                                                            if ($organizationGoal->name === $item->name) {
                                                                if (!in_array($item->name, $matchedGoals)) {
                                                                    $matchedGoals[] = $item->name;
                                                                    $matchedGoalsValue++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            } ?>

                                            <div class="title">
                                                <?php _e('Matched goals', 'purpozed'); ?>
                                                <!--                                                --><?php
                                                //                                                echo (int)(($matchedGoalsValue / $organizationGoalsValue) * 100);
                                                //                                                ?><!-- % matched goals-->
                                            </div>
                                            <?php $uniqueGoals = array_unique($matchedGoals); ?>
                                            <?php if (!empty($uniqueGoals)): ?>
                                                <div class="single-skills">
                                                    <?php $matchedAmount = count($uniqueGoals);
                                                    $howManyMore = 0;
                                                    if ($matchedAmount > 2) {
                                                        $howManyMore = $matchedAmount - 2;
                                                    }
                                                    ?>
                                                    <?php $i = 1; ?>
                                                    <?php $elseGoals = array(); ?>
                                                    <?php foreach ($uniqueGoals as $goal): ?>
                                                        <?php if ($i < 3): ?>
                                                            <div class="single-skill"><?php echo $goal; ?></div>
                                                            <?php $i++; ?>
                                                        <?php else: ?>
                                                            <?php $elseGoals[] = $goal; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (!empty($elseGoals)): ?>
                                                        <span class="show-more-skills">
                                                            <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                            <div class="tooltip-skills">
                                                                <?php foreach ($elseGoals as $item): ?>
                                                                    <div class="single-skill"><?php echo $item; ?></div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?
                                        }
                                        ?>
                                    </div>
                                    <div class="options">
                                        <?php if (($status !== 'succeeded') && ($status !== 'canceled') && ($status !== 'in_progress')): ?>
                                            <div class="edit">
                                                <button type="button"
                                                        class="select-button modal-volunteer-invitation-button"><?php _e('REQUEST', 'purpozed'); ?></button>
                                            </div>
                                        <?php endif; ?>
                                        <div class="single-option profile"><a
                                                    href="<?php echo $language; ?>/volunteer-profile-preview/?id=<?php echo $currentUserId; ?>"><?php _e('VIEW
                                                PROFILE', 'purpozed'); ?></a></div>
                                    </div>
                                    <div class="modal volunteer-invitation-ask">
                                        <div class="modal-overlay modal-volunteer-invitation-button"></div>
                                        <div class="modal-wrapper modal-transition">
                                            <div class="modal-header">
                                                <h2 class="modal-heading"><?php _e('Request volunteer for taking over this opportunity', 'purpozed'); ?></h2>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-content">
                                                    <P><?php _e('Great that you found the right volunteer for your opportunity', 'purpozed'); ?>
                                                        !</P>
                                                    <P><?php _e('By clicking on "Request" the volunteer will get a notification about your request and will asked to either taking over the opportunity or rejecting your request. After this you will get informed about the volunteer\'s decision.', 'purpozed'); ?></P>
                                                    <button type="button"
                                                            class="modal-edit volunteer-invitation-confirm"
                                                            data-id="<?php echo $opportunityId; ?>"
                                                            data-user="<?php echo $currentUserId; ?>"><?php _e('REQUEST', 'purpozed'); ?></button>
                                                    <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal volunteer-invitation">
                                        <div class="modal-overlay modal-volunteer-invitation-button"></div>
                                        <div class="modal-wrapper modal-transition">
                                            <div class="modal-header">
                                                <h2 class="modal-heading"><?php _e('You requested the volunteer successfully!', 'purpozed'); ?></h2>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-content">
                                                    <button class="modal-edit modal-volunteer-invitation reload-page"><?php _e('CLOSE', 'purpozed'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="job_title"><?php _e('Currently there are no volunteers applied for this opportunity', 'purpozed'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="single-column third hidden section" id="engaged_volunteers_section">
                <?php
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage/oportunity-details-top.php');
                ?>
                <div class="left-side posted">
                    <div class="volunteer-box">
                        <div class="title"><?php _e('These volunteers are currently working on this opportunity', 'purpozed'); ?></div>
                        <?php if (!empty($engaged)): ?>
                            <?php foreach ($engaged as $user): ?>
                                <?php $companyId = get_user_meta($user->user_id, 'company_id')[0]; ?>
                                <div class="single-volunteer">
                                    <div class="data">
                                        <div class="picture"><img
                                                    src="<?php echo wp_get_attachment_image_src(get_user_meta($user->user_id, 'image')[0], 'thumbnail')[0]; ?>">
                                        </div>
                                        <div class="details">
                                            <div class="name"><?php echo get_user_meta($user->user_id, 'first_name')[0] . ' ' . get_user_meta($user->user_id, 'last_name')[0]; ?></div>
                                            <div class="job_title"><?php echo get_user_meta($user->user_id, 'title')[0]; ?></div>
                                            <div class="corporation"><?php $companyData = $company->getDetailsById($companyId);
                                                echo $companyData->display_name; ?></div>
                                        </div>
                                    </div>
                                    <div class="options">
                                        <div class="edit">
                                            <button class="select-button">
                                                <a class="step-button"
                                                   href="<?php echo $language; ?>/evaluate/?id=<?php echo $opportunityId; ?>&user=<?php echo $user->user_id; ?>"><?php _e('COMPLETE SUCCESSFULLY', 'purpozed'); ?></a>
                                            </button>
                                        </div>
                                        <div class="edit">
                                            <button class="select-button">
                                                <a class="step-button"
                                                   href="<?php echo $language; ?>/evaluate/?id=<?php echo $opportunityId; ?>&c=1&user=<?php echo $user->user_id; ?>"><?php _e('CANCEL PREMATURELY', 'purpozed'); ?></a>
                                            </button>
                                        </div>
                                        <div class="single-option profile">
                                            <a href="<?php echo $language; ?>/volunteer-profile-preview/?id=<?php echo $user->user_id; ?>">
                                                <?php _e('VIEW PROFILE', 'purpozed'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="job_title"><?php _e('Currently there are no volunteers requested for this opportunity', 'purpozed'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="single-column third hidden section" id="completed_section">
                <?php
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage/oportunity-details-top.php');
                ?>
                <div class="left-side posted">
                    <div class="volunteer-box">
                        <div class="title"><?php _e('Volunteers that were either succeeded or canceled prematurely', 'purpozed'); ?></div>
                        <?php if ($task_type === 'engagement'): ?>
                            <?php if (!empty($completedEngagement)): ?>
                                <?php foreach ($completedEngagement as $user): ?>
                                    <?php $companyId = get_user_meta($user->user_id, 'company_id')[0]; ?>

                                    <?php $engagementEvaluationData = $singleOpportunity->getCompletedEngagementFully($opportunityId, $user->user_id); ?>

                                    <div class="completed-info <?php echo (empty($engagementEvaluationData->canceled_by)) ? '' : 'canceled'; ?>">
                                        <?php if (empty($engagementEvaluationData->canceled_by)): ?>
                                            <?php if (!empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>
                                                <span class="i-icon">i</span> <?php printf(__('This %s is succeeded and commented by you and the volunteer'), $task_type); ?>
                                            <?php elseif (empty($engagementEvaluationData->evaluation_organization)): ?>
                                                <span class="i-icon">i</span> <?php printf(__('The volunteer has succeeded the %s and already commented it.
                                        Please comment the %s!'), $task_type, $task_type); ?>
                                            <?php elseif (!empty($engagementEvaluationData->evaluation_organization)): ?>
                                                <span class="i-icon">i</span> <?php printf(__('You have succeeded and commented the %s but the volunteer did not comment it yet.'), $task_type); ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if (!empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>
                                                <span class="i-icon">i</span> <?php printf(__('This %s is canceled and commented by you and the volunteer'), $task_type); ?>
                                            <?php elseif (empty($engagementEvaluationData->evaluation_organization)): ?>
                                                <span class="i-icon">i</span> <?php printf(__('The volunteer has canceld the %s prematurely and commented it. Please comment the cancelation!'), $task_type); ?>
                                            <?php elseif (!empty($engagementEvaluationData->evaluation_organization)): ?>
                                                <span class="i-icon">i</span> <?php printf(__('You have canceled and commented this %s. The volunteer did not comment the cancelation yet.'), $task_type); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="single-volunteer">
                                        <div class="data">
                                            <div class="picture"><img
                                                        src="<?php echo wp_get_attachment_image_src(get_user_meta($user->user_id, 'image')[0], 'thumbnail')[0]; ?>">
                                            </div>
                                            <div class="details">
                                                <div class="name"><?php echo get_user_meta($user->user_id, 'first_name')[0] . ' ' . get_user_meta($user->user_id, 'last_name')[0]; ?></div>
                                                <div class="job_title"><?php echo get_user_meta($user->user_id, 'title')[0]; ?></div>
                                                <div class="corporation"><?php $companyData = $company->getDetailsById($companyId);
                                                    echo $companyData->display_name; ?></div>
                                            </div>
                                        </div>
                                        <?php if ($task_type === 'engagement'): ?>
                                            <?php
                                            $isEngagementInProgress = false;
                                            if ($task_type === 'engagement') {
                                                $isEngagementInProgress = $singleOpportunity->engagementInProgress($opportunityId, $user->user_id);
                                                $isEvaluatedEngagement = $singleOpportunity->isEvaluatedEngagement($opportunityId, $user->user_id);
                                                if ($isEvaluatedEngagement) {
                                                    $engagementEvaluationData = $singleOpportunity->getCompletedEngagementFully($opportunityId, $user->user_id);
                                                }
                                            }
                                            ?>
                                            <div class="options">
                                                <div class="single-option select <?php echo (empty($engagementEvaluationData->canceled_by)) ? '' : 'canceled'; ?>">
                                                    <a
                                                            href="<?php echo $language; ?>/evaluate/?id=<?php echo $opportunityId; ?>&user=<?php echo $user->user_id; ?>">
                                                        <?php if (!empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>
                                                            <?php _e('SHOW COMMENTS', 'purpozed'); ?>
                                                        <?php elseif (empty($engagementEvaluationData->evaluation_organization)): ?>
                                                            <?php _e('COMMENT', 'purpozed'); ?>
                                                        <?php elseif (!empty($engagementEvaluationData->evaluation_organization)): ?>
                                                            <?php _e('SHOW MY COMMENT', 'purpozed'); ?>
                                                        <?php endif; ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="options">
                                                <?php if (($status !== 'succeeded') && ($status !== 'canceled')): ?>
                                                    <div class="single-option select"><a
                                                                href="<?php echo $language; ?>/evaluate/?id=<?php echo $opportunityId; ?>&user=<?php echo $user->user_id; ?>"><?php _e('COMMENT', 'purpozed'); ?></a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="job_title"><?php _e('Currently there are no volunteers requested for this opportunity', 'purpozed'); ?></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if (!empty($completed)): ?>
                                <?php foreach ($completed as $user): ?>
                                    <?php $companyId = get_user_meta($user->user_id, 'company_id')[0]; ?>
                                    <div class="single-volunteer">
                                        <div class="data">
                                            <div class="picture"><img
                                                        src="<?php echo wp_get_attachment_image_src(get_user_meta($user->user_id, 'image')[0], 'thumbnail')[0]; ?>">
                                            </div>
                                            <div class="details">
                                                <div class="name"><?php echo get_user_meta($user->user_id, 'first_name')[0] . ' ' . get_user_meta($user->user_id, 'last_name')[0]; ?></div>
                                                <div class="job_title"><?php echo get_user_meta($user->user_id, 'title')[0]; ?></div>
                                                <div class="corporation"><?php $companyData = $company->getDetailsById($companyId);
                                                    echo $companyData->display_name; ?></div>
                                            </div>
                                        </div>
                                        <?php
                                        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/manage-opportunity-matching.php');
                                        ?>
                                        <div class="options">
                                            <?php if (($status !== 'succeeded') && ($status !== 'canceled')): ?>
                                                <div class="single-option select"><a href="#">SELECT THIS VOLUNTEER</a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="single-option profile"><a
                                                        href="<?php echo $language; ?>/volunteer-profile-preview/?id=<?php echo $user->user_id; ?>"><?php _e('VIEW
                                                PROFILE', 'purpozed'); ?></a></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="job_title"><?php _e('Currently there are no volunteers requested for this opportunity', 'purpozed'); ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/footer.php');
?>
