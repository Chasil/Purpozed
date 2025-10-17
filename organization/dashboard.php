<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/header.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');

get_header();

$SingleOpportunity = new \Purpozed2\Models\Opportunity();
$opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
$organization = new \Purpozed2\Models\Organization();

$totalApplied = $organization->totalAppliedVolunteers();
$totalSucceededNotCommentedActive = $organization->countVolunteersWhoWaitForEngagementComment(get_current_user_id());
$totalSucceededNotCommentedInactive = $organization->countVolunteersWhoWaitForComment(get_current_user_id());

?>

    <div class="dashboard organization-dashboard">
    <div class="row dashboard-sub-menu menu-items">
        <div class="sub-menu-item item active" id="active"><?php _e('Active', 'purpozed'); ?></div>
        <div class="sub-menu-item item" id="inactive"><?php _e('Inactive', 'purpozed'); ?></div>
    </div>

    <div class="section" id="active_section">
<?php if ($totalApplied): ?>
    <div class="vol-top-info-bar spaces">
        <?php
        $amount = count($totalApplied);
        $plural = ($amount > 1) ? 's' : '';
        ?>
        <div class="succeeded"><?php printf(__('There are %s pending application%s for your open opportunities in total. Please manage them as close as possible.', 'purpozed'), $amount, $plural); ?></div>
    </div>
<?php endif; ?>

<?php if ($totalSucceededNotCommentedActive > 0): ?>
    <div class="vol-top-info-bar spaces">
        <?php
        $plural = ($amount > 1) ? 's' : '';
        ?>
        <div class="succeeded"><?php printf(__('There are %s volunteer%s who have either succeeded or canceled an engagement. Please write a comment about the collaboration.', 'purpozed'), $totalSucceededNotCommentedActive, $plural); ?></div>
    </div>
<?php endif; ?>

    <div class="prepared first-one dashboard-tab">
        <div class="header"><?php _e('Active Opportunities', 'purpozed'); ?></div>
        <div class="title"><?php _e('These are opportunities that are either open for new volunteers or currently closed for new volunteers and/or in progress.', 'purpozed'); ?></div>
        <?php if (empty($opportunities)): ?>
            <div class="title"><?php _e('Currently there are no opportunities.', 'purpozed'); ?></div>
        <?php else: ?>
        <?php foreach ($opportunities

        as $opportunity): ?>
        <?php
        if ($opportunity->task_type === 'engagement') {
            $oppManager = new \Purpozed2\Models\OpportunitiesManager();
            $currentEngagement = $oppManager->getSingleEngagement($opportunity->id);
        }
        ?>
        <?php if ($opportunity->task_type === 'engagement'): ?>
        <div class="single-volunteer two organization <?php echo ($currentEngagement->closed === '1') ? 'grey-out-two' : ''; ?>"
             id="<?php echo $opportunity->id; ?>">
            <?php else: ?>
            <div class="single-volunteer two organization"
                 id="<?php echo $opportunity->id; ?>">
                <? endif; ?>
                <?php if ($opportunity->status === 'review'): ?>
                    <div class="review"><?php _e('Under review. You have posted this opportunity and we are about to check
                    and publish it within 24 Hours.', 'purpozed'); ?>
                    </div>
                <?php elseif ($opportunity->status === 'prepared'): ?>
                    <div class="review"><?php _e('Prepared. This opportunity is waiting to be send to review.', 'purpozed'); ?></div>
                <?php endif; ?>
                <div class="all-data">
                    <?php if ($opportunity->task_type === 'engagement'): ?>
                        <div class="image">
                            <?php if ($currentEngagement->closed === '1'): ?>
                                <div class="currently-closed">Currently closed</div>
                            <?php endif; ?>
                            <img class="<?php echo ($currentEngagement->closed === '1') ? 'grey-out' : ''; ?>"
                                 src="<?php echo wp_get_attachment_image_src($opportunity->image, 'medium')[0]; ?>">
                        </div>
                    <?php else: ?>
                        <div class="image">
                            <img src="<?php echo wp_get_attachment_image_src($opportunity->image, 'medium')[0]; ?>">
                        </div>
                    <? endif; ?>
                    <div class="data two">
                        <div class="info">
                            <div class="type">
                                <?php _e($opportunity->task_type, 'purpozed'); ?>
                            </div>
                            <div class="duration">
                                <?php
                                if ($opportunity->task_type === 'call') {
                                    _e('1 HOUR', 'purpozed');
                                } elseif ($opportunity->task_type === 'project') {
                                    $project = $opportunityManager->getProjectWithTask($opportunity->id);
                                    echo '<span>' . $project->hours_duration . '</span> ' . _e(' HOURS', 'purpozed');
                                } elseif ($opportunity->task_type === 'mentoring') {
                                    $mentoring = $opportunityManager->getMentoring($opportunity->id);
                                    echo '<span>' . $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . '</span> ' . _e(' HOURS', 'purpozed');
                                } elseif ($opportunity->task_type === 'engagement') {
                                    $engagement = $opportunityManager->getEngagement($opportunity->id);
                                    echo '<span>' . $engagement->frequency * $engagement->duration * $engagement->time_frame . '</span> ' . _e(' HOURS', 'purpozed');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="details two">
                            <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                            <div class="name">
                                <?php
                                if ($opportunity->task_type === 'call') {
                                    $currentOpportunity = $opportunityManager->getSingleCall($opportunity->id);
                                    $topic = $opportunityManager->getTopic($currentOpportunity->topic);
                                    $focus = $opportunityManager->getFocuses($currentOpportunity->id);

                                    foreach ($focus as $item):
                                        echo $item->name . ' ';
                                    endforeach;

                                    echo ' ' . $topic->name;

                                } elseif ($opportunity->task_type === 'project') {
                                    $currentOpportunity = $opportunityManager->getSingleProject($opportunity->id);
                                    $topic = $opportunityManager->getTopic($currentOpportunity->topic);

                                    echo $topic->name . ' ';

                                } elseif ($opportunity->task_type === 'mentoring') {

                                    $currentOpportunity = $opportunityManager->getSingleMentoring($opportunity->id);

                                    echo $currentOpportunity->aoe_name . ' ';

                                } elseif ($opportunity->task_type === 'engagement') {
                                    $currentOpportunity = $opportunityManager->getSingleEngagement($opportunity->id);

                                    echo $currentOpportunity->title . ' ';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="details three">
                            <?php
                            $postedDateTimestamp = strtotime($SingleOpportunity->postedDaysAgo($opportunity->id));
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
                        <div class="details four">
                            <?php if ($opportunity->task_type === 'engagement'): ?>

                                <div class="status fc-status list-status in_progress">
                                    <?php printf(__('IN PROGRESS (%s)', 'purpozed'), count($SingleOpportunity->getInProgress($opportunity->id))); ?>
                                </div>
                                <div class="status fc-status list-status completed">
                                    <?php printf(__('COMPLETED (%s)', 'purpozed'), count($SingleOpportunity->getCompletedEngagement($opportunity->id))); ?>
                                </div>

                            <?php else: ?>

                                <div class="status fc-status list-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>">
                                    <?php _e($opportunity->status, 'purpozed'); ?>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="any-volunteers">
                        <div class="amount">
                            <div class="number <?php echo (count($singleOpportuity->getApplied($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getApplied($opportunity->id)); ?></div>
                            <div class="text <?php echo (count($singleOpportuity->getApplied($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Pending applications', 'purpozed'); ?></div>
                        </div>
                        <div class="amount">

                            <?php

                            if ($opportunity->task_type === 'call') {
                                $opp = $opportunityManager->getSingleCall($opportunity->id);
                                $matchedUsers = $singleOpportuity->bestMatchedSingleCallVolunteers($opp);
                            } elseif ($opportunity->task_type === 'project') {
                                $opp = $opportunityManager->getSingleProject($opportunity->id);
                                $matchedUsers = $singleOpportuity->bestMatchedSingleProjectVolunteers($opp);
                            } elseif ($opportunity->task_type === 'mentoring') {
                                $opp = $opportunityManager->getSingleMentoring($opportunity->id);
                                $matchedUsers = $singleOpportuity->bestMatchedSingleMentoringVolunteer($opp);
                            } elseif ($opportunity->task_type === 'engagement') {
                                $matchedUsers = $singleOpportuity->bestMatchedEngagementVolunteers();
                            }

                            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/fitting_volunteers_you_can_request.php');

                            ?>

                            <div class="number <?php echo (count($matchedUsers) !== 0) ? 'exists' : ''; ?>"><?php echo count($matchedUsers); ?></div>
                            <div class="text <?php echo (count($matchedUsers) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Fitting volunteers you can request', 'purpozed'); ?></div>
                        </div>
                        <div class="amount">
                            <?php if ($opportunity->task_type === 'engagement'): ?>
                                <div class="number <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)); ?></div>
                            <?php else: ?>
                                <div class="number <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)); ?></div>
                            <?php endif; ?>
                            <?php if ($opportunity->task_type === 'engagement'): ?>
                                <div class="text <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Volunteers waiting for Feedback', 'purpozed'); ?></div>
                            <?php else: ?>
                                <div class="text <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Volunteers waiting for Feedback', 'purpozed'); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="options">
                        <div class="single-option select">
                            <a href="<?php echo $language; ?>/manage-opportunity/?id=<?php echo $opportunity->id; ?>"><?php _e('MANAGE', 'purpozed'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="prepared">
            <!--        <div class="header">--><?php //_e('In progress', 'purpozed'); ?><!--</div>-->
            <!--        <div class="title">-->
            <?php //_e('These are opportunities one or more volunteers currently working on.', 'purpozed'); ?><!--</div>-->
            <?php if (!empty($in_progress)): ?>
                <?php foreach ($in_progress as $opportunity): ?>
                    <div class="single-volunteer two organization" id="<?php echo $opportunity->id; ?>">
                        <?php if ($opportunity->status === 'review'): ?>
                            <div class="review">
                                <?php _e('Under review. You have posted this opportunity and we are about
                                    to check and publish it within 24 Hours.', 'purpozed'); ?>
                            </div>
                        <?php elseif ($opportunity->status === 'prepared'): ?>
                            <div class="review">
                                <?php _e('Prepared. This opportunity is waiting to be send to review.', 'purpozed'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="all-data">
                            <div class="image"><img
                                        src="<?php echo wp_get_attachment_image_src($opportunity->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two">
                                <div class="info">
                                    <div class="type"><?php echo $opportunity->task_type; ?></div>
                                    <div class="duration">
                                        <?php
                                        if ($opportunity->task_type === 'call') {
                                            _e('1 HOUR', 'purpozed');
                                        } elseif ($opportunity->task_type === 'project') {
                                            $project = $opportunityManager->getProjectWithTask($opportunity->id);
                                            echo '<span>' . $project->hours_duration . '</span> ' . _e(' HOURS', 'purpozed');
                                        } elseif ($opportunity->task_type === 'mentoring') {
                                            $mentoring = $opportunityManager->getMentoring($opportunity->id);
                                            echo '<span>' . $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . '</span> ' . _e(' HOURS', 'purpozed');
                                        } elseif ($opportunity->task_type === 'engagement') {
                                            $engagement = $opportunityManager->getEngagement($opportunity->id);
                                            echo '<span>' . $engagement->frequency * $engagement->duration * $engagement->time_frame . '</span> ' . _e(' HOURS', 'purpozed');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details two">
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php
                                        if ($opportunity->task_type === 'call') {
                                            $currentOpportunity = $opportunityManager->getSingleCall($opportunity->id);
                                            $topic = $opportunityManager->getTopic($currentOpportunity->topic);
                                            $focus = $opportunityManager->getFocuses($currentOpportunity->id);

                                            echo $topic->name . ' ';

                                            foreach ($focus as $item):
                                                echo $item->name . ' ';
                                            endforeach;
                                        } elseif ($opportunity->task_type === 'project') {
                                            $currentOpportunity = $opportunityManager->getSingleProject($opportunity->id);
                                            $topic = $opportunityManager->getTopic($currentOpportunity->topic);

                                            echo $topic->name . ' ';

                                        } elseif ($opportunity->task_type === 'mentoring') {

                                            $currentOpportunity = $opportunityManager->getSingleMentoring($opportunity->id);

                                            echo $currentOpportunity->aoe_name . ' ';

                                        } elseif ($opportunity->task_type === 'engagement') {
                                            $currentOpportunity = $opportunityManager->getSingleEngagement($opportunity->id);

                                            echo $currentOpportunity->title . ' ';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details three">
                                    <?php
                                    $postedDateTimestamp = strtotime($SingleOpportunity->postedDaysAgo($opportunity->id));
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
                                <div class="details four">
                                    <?php if ($opportunity->task_type === 'engagement'): ?>
                                        <?php $inProgressEngagement = count($singleOpportuity->getInProgress($opportunity->id)); ?>
                                        <?php $completedEngagement = count($singleOpportuity->getCompletedEngagement($opportunity->id)); ?>
                                        <div class="status fc-status list-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php printf(__('IN PROGRESS (%s)', 'purpozed'), $inProgressEngagement); ?>
                                        </div>
                                        <div class="status fc-status list-status completed"><?php printf(__('COMPLETED (%s)', 'purpozed'), $completedEngagement); ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="status fc-status list-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="any-volunteers">
                                <div class="amount">
                                    <div class="number <?php echo (count($singleOpportuity->getApplied($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getApplied($opportunity->id)); ?></div>
                                    <div class="text <?php echo (count($singleOpportuity->getApplied($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Pending applications', 'purpozed'); ?></div>
                                </div>
                                <div class="amount">

                                    <?php

                                    if ($opportunity->task_type === 'call') {
                                        $opp = $opportunityManager->getSingleCall($opportunity->id);
                                        $matchedUsers = $singleOpportuity->bestMatchedSingleCallVolunteers($opp);
                                    } elseif ($opportunity->task_type === 'project') {
                                        $opp = $opportunityManager->getSingleProject($opportunity->id);
                                        $matchedUsers = $singleOpportuity->bestMatchedSingleProjectVolunteers($opp);
                                    } elseif ($opportunity->task_type === 'mentoring') {
                                        $opp = $opportunityManager->getSingleMentoring($opportunity->id);
                                        $matchedUsers = $singleOpportuity->bestMatchedSingleMentoringVolunteer($opp);
                                    } elseif ($opportunity->task_type === 'engagement') {
                                        $matchedUsers = $singleOpportuity->bestMatchedEngagementVolunteers();
                                    }

                                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/fitting_volunteers_you_can_request.php');

                                    ?>

                                    <div class="number <?php echo (count($matchedUsers) !== 0) ? 'exists' : ''; ?>"><?php echo count($matchedUsers); ?></div>
                                    <div class="text <?php echo (count($matchedUsers) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Fitting volunteers you can request', 'purpozed'); ?></div>
                                </div>
                                <div class="amount">
                                    <?php if ($opportunity->task_type === 'engagement'): ?>
                                        <div class="number <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)); ?></div>
                                    <?php else: ?>
                                        <div class="number <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)); ?></div>
                                    <?php endif; ?>
                                    <?php if ($opportunity->task_type === 'engagement'): ?>
                                        <div class="text <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Volunteers waiting for Feedback', 'purpozed'); ?></div>
                                    <?php else: ?>
                                        <div class="text <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Volunteers waiting for Feedback', 'purpozed'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="/manage-opportunity/?id=<?php echo $opportunity->id; ?>"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>

                                <div class="modal delete-opportunity-ask">
                                    <div class="modal-overlay modal-apply-button"></div>
                                    <div class="modal-wrapper modal-transition">
                                        <div class="modal-header">
                                            <h2 class="modal-heading"><?php _e('Delete opportunity', 'purpozed'); ?>
                                                ?</h2>
                                        </div>
                                        <div class="modal-body">
                                            <div class="modal-content">
                                                <P><?php _e('You want to delete this opportunity', 'purpozed'); ?>
                                                    ?</P>
                                                <button class="modal-edit delete-opportunity-confirm"
                                                        data-id="<?php echo $opportunity->id; ?>"><?php _e('DELETE OPPORTUNITY', 'purpozed'); ?></button>
                                                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal delete-opportunity">
                                    <div class="modal-wrapper modal-transition">
                                        <div class="modal-header">
                                            <h2 class="modal-heading"><?php _e('The Opportunity has beed deleted sucessfully', 'purpozed'); ?>
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
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="job_title"><?php _e('Currently there are no opportunites in progress', 'purpozed'); ?></div>
            <?php endif; ?>
        </div>

    </div>
    <div class="hidden section" id="inactive_section">

        <?php if ($totalSucceededNotCommentedInactive > 0): ?>
            <div class="vol-top-info-bar spaces">
                <?php
                $amount = $totalSucceededNotCommentedInactive;
                $plural = ($amount > 1) ? 's' : '';
                ?>
                <div class="succeeded"><?php printf(__('There are %s projects, mentorings and/or calls which were either succeeded or canceled a collaboration. Please write a comment about the collaboration.', 'purpozed'), $totalSucceededNotCommentedInactive, $plural); ?></div>
            </div>
        <?php endif; ?>

        <div class="prepared">
            <div class="header"><?php _e('Inactive Opportunities', 'purpozed'); ?></div>
            <div class="title"><?php _e('These are opportunities that are either prepared, under review or finished', 'purpozed'); ?></div>
            <?php if (!empty($saved_and_reviewed)): ?>
                <?php foreach ($saved_and_reviewed as $opportunity): ?>
                    <div class="single-volunteer two organization" id="<?php echo $opportunity->id; ?>">
                        <?php if ($opportunity->status === 'review'): ?>
                            <div class="review"><?php _e('Under review. You have posted this opportunity and we are about
                                    to check and publish it within 24 Hours.', 'purpozed'); ?>
                            </div>
                        <?php elseif ($opportunity->status === 'prepared'): ?>
                            <div class="review">
                                <?php _e('Prepared. This opportunity is waiting to be send to review.', 'purpozed'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="all-data">
                            <div class="image"><img
                                        src="<?php echo wp_get_attachment_image_src($opportunity->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two">
                                <div class="info">
                                    <div class="type"><?php echo $opportunity->task_type; ?></div>
                                    <div class="duration">
                                        <?php
                                        if ($opportunity->task_type === 'call') {
                                            _e('1 HOUR', 'purpozed');
                                        } elseif ($opportunity->task_type === 'project') {
                                            $project = $opportunityManager->getProjectWithTask($opportunity->id);
                                            echo '<span>' . $project->hours_duration . '</span> ' . _e(' HOURS', 'purpozed');
                                        } elseif ($opportunity->task_type === 'mentoring') {
                                            $mentoring = $opportunityManager->getMentoring($opportunity->id);
                                            echo '<span>' . $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . '</span> ' . _e(' HOURS', 'purpozed');
                                        } elseif ($opportunity->task_type === 'engagement') {
                                            $engagement = $opportunityManager->getEngagement($opportunity->id);
                                            echo '<span>' . $engagement->frequency * $engagement->duration * $engagement->time_frame . '</span> ' . _e(' HOURS', 'purpozed');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details two">
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php
                                        if ($opportunity->task_type === 'call') {
                                            $currentOpportunity = $opportunityManager->getSingleCall($opportunity->id);
                                            $topic = $opportunityManager->getTopic($currentOpportunity->topic);
                                            $focus = $opportunityManager->getFocuses($currentOpportunity->id);

                                            foreach ($focus as $item):
                                                echo $item->name . ' ';
                                            endforeach;

                                            echo ' ' . $topic->name;

                                        } elseif ($opportunity->task_type === 'project') {
                                            $currentOpportunity = $opportunityManager->getSingleProject($opportunity->id);
                                            $topic = $opportunityManager->getTopic($currentOpportunity->topic);

                                            echo $topic->name . ' ';

                                        } elseif ($opportunity->task_type === 'mentoring') {

                                            $currentOpportunity = $opportunityManager->getSingleMentoring($opportunity->id);

                                            echo $currentOpportunity->aoe_name . ' ';

                                        } elseif ($opportunity->task_type === 'engagement') {
                                            $currentOpportunity = $opportunityManager->getSingleEngagement($opportunity->id);

                                            echo $currentOpportunity->title . ' ';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details three">
                                    <?php
                                    $postedDateTimestamp = strtotime($SingleOpportunity->postedDaysAgo($opportunity->id));
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
                                <div class="details four">
                                    <div class="status fc-status list-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
                                </div>
                            </div>
                            <div class="any-volunteers">
                                <div class="amount">
                                    <div class="number <?php echo (count($singleOpportuity->getApplied($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getApplied($opportunity->id)); ?></div>
                                    <div class="text <?php echo (count($singleOpportuity->getApplied($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Pending applications', 'purpozed'); ?></div>
                                </div>
                                <div class="amount">

                                    <?php

                                    if ($opportunity->task_type === 'call') {
                                        $opp = $opportunityManager->getSingleCall($opportunity->id);
                                        $matchedUsers = $singleOpportuity->bestMatchedSingleCallVolunteers($opp);
                                    } elseif ($opportunity->task_type === 'project') {
                                        $opp = $opportunityManager->getSingleProject($opportunity->id);
                                        $matchedUsers = $singleOpportuity->bestMatchedSingleProjectVolunteers($opp);
                                    } elseif ($opportunity->task_type === 'mentoring') {
                                        $opp = $opportunityManager->getSingleMentoring($opportunity->id);
                                        $matchedUsers = $singleOpportuity->bestMatchedSingleMentoringVolunteer($opp);
                                    } elseif ($opportunity->task_type === 'engagement') {
                                        $matchedUsers = $singleOpportuity->bestMatchedEngagementVolunteers();
                                    }

                                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/fitting_volunteers_you_can_request.php');

                                    ?>

                                    <div class="number <?php echo (count($matchedUsers) !== 0) ? 'exists' : ''; ?>"><?php echo count($matchedUsers); ?></div>
                                    <div class="text <?php echo (count($matchedUsers) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Fitting volunteers you can request', 'purpozed'); ?></div>
                                </div>
                                <div class="amount">
                                    <?php if ($opportunity->task_type === 'engagement'): ?>
                                        <div class="number <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)); ?></div>
                                    <?php else: ?>
                                        <div class="number <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)); ?></div>
                                    <?php endif; ?>
                                    <?php if ($opportunity->task_type === 'engagement'): ?>
                                        <div class="text <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Volunteers waiting for Feedback', 'purpozed'); ?></div>
                                    <?php else: ?>
                                        <div class="text <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Volunteers waiting for Feedback', 'purpozed'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="/post-opportunity/?id=<?php echo $opportunity->id; ?>&task=<?php echo $opportunity->task_type; ?>"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>

                                <div class="modal delete-opportunity-ask">
                                    <div class="modal-overlay modal-apply-button"></div>
                                    <div class="modal-wrapper modal-transition">
                                        <div class="modal-header">
                                            <h2 class="modal-heading"><?php _e('Delete opportunity', 'purpozed'); ?>
                                                ?</h2>
                                        </div>
                                        <div class="modal-body">
                                            <div class="modal-content">
                                                <P><?php _e('You want to delete this opportunity', 'purpozed'); ?>
                                                    ?</P>
                                                <button class="modal-edit delete-opportunity-confirm"
                                                        data-id="<?php echo $opportunity->id; ?>"><?php _e('DELETE OPPORTUNITY', 'purpozed'); ?></button>
                                                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal delete-opportunity">
                                    <div class="modal-wrapper modal-transition">
                                        <div class="modal-header">
                                            <h2 class="modal-heading"><?php _e('The Opportunity has beed deleted sucessfully', 'purpozed'); ?>
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
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="job_title"><?php _e('Currently there are no saved or reviewed opportunites', 'purpozed'); ?></div>
            <?php endif; ?>
        </div>

        <div class="prepared">
            <!--            <div class="header">--><?php //_e('Completed', 'purpozed'); ?><!--</div>-->
            <!--            <div class="title">-->
            <?php //_e('These are opportunities that were either succeeded or canceled prematurely by you or the volunteer.', 'purpozed'); ?><!--</div>-->
            <?php if (!empty($completed)): ?>
                <?php foreach ($completed as $opportunity): ?>
                    <div class="single-volunteer two organization" id="<?php echo $opportunity->id; ?>">
                        <?php if ($opportunity->status === 'review'): ?>
                            <div class="review"><?php _e('Under review. You have posted this opportunity and we are about
                                    to check and publish it within 24 Hours.', 'purpozed'); ?>
                            </div>
                        <?php elseif ($opportunity->status === 'prepared'): ?>
                            <div class="review">
                                <?php _e('Prepared. This opportunity is waiting to be send to review.', 'purpozed'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="all-data">
                            <div class="image"><img
                                        src="<?php echo wp_get_attachment_image_src($opportunity->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two">
                                <div class="info">
                                    <div class="type"><?php echo $opportunity->task_type; ?></div>
                                    <div class="duration">
                                        <?php
                                        if ($opportunity->task_type === 'call') {
                                            _e('1 HOUR', 'purpozed');
                                        } elseif ($opportunity->task_type === 'project') {
                                            $project = $opportunityManager->getProjectWithTask($opportunity->id);
                                            echo '<span>' . $project->hours_duration . '</span> ' . _e(' HOURS', 'purpozed');
                                        } elseif ($opportunity->task_type === 'mentoring') {
                                            $mentoring = $opportunityManager->getMentoring($opportunity->id);
                                            echo '<span>' . $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . '</span> ' . _e(' HOURS', 'purpozed');
                                        } elseif ($opportunity->task_type === 'engagement') {
                                            $engagement = $opportunityManager->getEngagement($opportunity->id);
                                            echo '<span>' . $engagement->frequency * $engagement->duration * $engagement->time_frame . '</span> ' . _e(' HOURS', 'purpozed');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details two">
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php
                                        if ($opportunity->task_type === 'call') {
                                            $currentOpportunity = $opportunityManager->getSingleCall($opportunity->id);
                                            $topic = $opportunityManager->getTopic($currentOpportunity->topic);
                                            $focus = $opportunityManager->getFocuses($currentOpportunity->id);

                                            echo $topic->name . ' ';

                                            foreach ($focus as $item):
                                                echo $item->name . ' ';
                                            endforeach;
                                        } elseif ($opportunity->task_type === 'project') {
                                            $currentOpportunity = $opportunityManager->getSingleProject($opportunity->id);
                                            $topic = $opportunityManager->getTopic($currentOpportunity->topic);

                                            echo $topic->name . ' ';

                                        } elseif ($opportunity->task_type === 'mentoring') {

                                            $currentOpportunity = $opportunityManager->getSingleMentoring($opportunity->id);

                                            echo $currentOpportunity->aoe_name . ' ';

                                        } elseif ($opportunity->task_type === 'engagement') {
                                            $currentOpportunity = $opportunityManager->getSingleEngagement($opportunity->id);

                                            echo $currentOpportunity->title . ' ';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details three">
                                    <?php
                                    $postedDateTimestamp = strtotime($SingleOpportunity->postedDaysAgo($opportunity->id));
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
                                <div class="details four">
                                    <div class="details four">
                                        <?php if ($opportunity->task_type === 'engagement'): ?>
                                            <?php $inProgressEngagement = count($singleOpportuity->getInProgress($opportunity->id)); ?>
                                            <?php $completedEngagement = count($singleOpportuity->getCompletedEngagement($opportunity->id)); ?>
                                            <div class="status fc-status list-status deleted"><?php _e('DELETED'); ?></div>
                                            <div class="status fc-status list-status completed"><?php printf(__('COMPLETED (%s)', 'purpozed'), $completedEngagement); ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="status fc-status list-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                            <div class="any-volunteers">
                                <div class="amount">
                                    <div class="number <?php echo (count($singleOpportuity->getApplied($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getApplied($opportunity->id)); ?></div>
                                    <div class="text <?php echo (count($singleOpportuity->getApplied($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Pending applications', 'purpozed'); ?></div>
                                </div>
                                <div class="amount">

                                    <?php

                                    if ($opportunity->task_type === 'call') {
                                        $opp = $opportunityManager->getSingleCall($opportunity->id);
                                        $matchedUsers = $singleOpportuity->bestMatchedSingleCallVolunteers($opp);
                                    } elseif ($opportunity->task_type === 'project') {
                                        $opp = $opportunityManager->getSingleProject($opportunity->id);
                                        $matchedUsers = $singleOpportuity->bestMatchedSingleProjectVolunteers($opp);
                                    } elseif ($opportunity->task_type === 'mentoring') {
                                        $opp = $opportunityManager->getSingleMentoring($opportunity->id);
                                        $matchedUsers = $singleOpportuity->bestMatchedSingleMentoringVolunteer($opp);
                                    } elseif ($opportunity->task_type === 'engagement') {
                                        $matchedUsers = $singleOpportuity->bestMatchedEngagementVolunteers();
                                    }

                                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/fitting_volunteers_you_can_request.php');

                                    ?>

                                    <div class="number <?php echo (count($matchedUsers) !== 0) ? 'exists' : ''; ?>"><?php echo count($matchedUsers); ?></div>
                                    <div class="text <?php echo (count($matchedUsers) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Fitting volunteers you can request', 'purpozed'); ?></div>
                                </div>
                                <div class="amount">
                                    <?php if ($opportunity->task_type === 'engagement'): ?>
                                        <div class="number <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)); ?></div>
                                    <?php else: ?>
                                        <div class="number <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)) !== 0) ? 'exists' : ''; ?>"><?php echo count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)); ?></div>
                                    <?php endif; ?>
                                    <?php if ($opportunity->task_type === 'engagement'): ?>
                                        <div class="text <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedbackEngagement($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Volunteers waiting for Feedback', 'purpozed'); ?></div>
                                    <?php else: ?>
                                        <div class="text <?php echo (count($singleOpportuity->getVolunteersWaitingForFeedback($opportunity->id)) !== 0) ? 'exists-text' : ''; ?>"><?php _e('Volunteers waiting for Feedback', 'purpozed'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="/manage-opportunity/?id=<?php echo $opportunity->id; ?>"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>

                                <div class="modal delete-opportunity-ask">
                                    <div class="modal-overlay modal-apply-button"></div>
                                    <div class="modal-wrapper modal-transition">
                                        <div class="modal-header">
                                            <h2 class="modal-heading"><?php _e('Delete opportunity', 'purpozed'); ?>
                                                ?</h2>
                                        </div>
                                        <div class="modal-body">
                                            <div class="modal-content">
                                                <P><?php _e('You want to delete this opportunity', 'purpozed'); ?>
                                                    ?</P>
                                                <button class="modal-edit delete-opportunity-confirm"
                                                        data-id="<?php echo $opportunity->id; ?>"><?php _e('DELETE OPPORTUNITY', 'purpozed'); ?></button>
                                                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal delete-opportunity">
                                    <div class="modal-wrapper modal-transition">
                                        <div class="modal-header">
                                            <h2 class="modal-heading"><?php _e('The Opportunity has beed deleted sucessfully', 'purpozed'); ?>
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
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="job_title"><?php _e('Currently there are no completed opportunites', 'purpozed'); ?></div>
            <?php endif; ?>
        </div>
    </div>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/footer.php');
?>

<?php get_footer();