<?php

$opportunities = new \Purpozed2\Models\OpportunitiesManager();
$volunteerManager = new \Purpozed2\Models\VolunteersManager();
$organization = new \Purpozed2\Models\Organization();
$singleOpportunity = new \Purpozed2\Models\Opportunity();

$organizationDetails = $singleOpportunity->getOrganization($opportunity->task_id);
$organizationGoals = $organization->getGoals($organizationDetails);
$organizationMainGoalId = get_user_meta($organizationDetails, 'main_goal');
$organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

$organizationGoalsNames = array();
foreach ($organizationGoals as $organizationGoal) {
    $organizationGoalsNames[] = $organizationGoal->name;
}
$organizationGoalsNames[] = $organizationMainGoal->name;

$volunteerGoals[] = array(
    'goals' => $volunteerManager->getCurrentUser(get_current_user_id())->getGoals()
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
$matchedGoals = array_unique($matchedGoals);

$isEngagementInProgress = $singleOpportunity->engagementInProgress($opportunity->task_id, get_current_user_id());
$isEvaluatedEngagement = $singleOpportunity->isEvaluatedEngagement($opportunity->task_id, $userId);
?>

<?php if ($isEvaluatedEngagement): ?>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/engagement.php'); ?>
<?php else: ?>
    <div class="section preview single-opportunity register">
        <div class="columns">
            <div class="column">
                <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/opportunities/sidebar.php'); ?>
            </div>
            <div class="column preview">
                <div class="image">
                    <img src="<?php echo wp_get_attachment_image_src($opportunity->image, 'large')[0]; ?>">
                    <div class="image_caption">
                        <?php echo (isset($opportunity->image_caption)) ? $opportunity->image_caption : ''; ?>
                    </div>
                    <div class="statuses">
                        <div class="preview-header-box"><?php _e('ENGAGEMENT', 'purpozed'); ?></div>
                        <?php if ($isEngagementInProgress): ?>
                            <div class="preview-header-status fc-status in_progress"><?php _e('in progress', 'purpozed'); ?></div>
                        <?php else: ?>
                            <div class="preview-header-status fc-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="medium-header prev-header"><?php echo $opportunity->title; ?></div>
                    <div class="small-header"><?php _e('Matched Goals', 'purpozed'); ?></div>
                    <div class="skills prev-skills">
                        <?php foreach ($matchedGoals as $goal): ?>
                            <div class="single-skill"><?php echo $goal; ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="small-header"><?php _e('The Why', 'purpozed'); ?></div>
                    <div class="text">
                        <?php echo stripslashes($opportunity->why); ?>
                    </div>
                    <div class="small-header"><?php _e('The Task', 'purpozed'); ?></div>
                    <div class="text">
                        <?php echo stripslashes($opportunity->task); ?>
                    </div>
                    <div class="small-header"><?php _e('Requirements', 'purpozed'); ?></div>
                    <div class="text">
                        <?php echo stripslashes($opportunity->requirements); ?>
                    </div>
                    <div class="small-header"><?php _e('Duration & Time Frame', 'purpozed'); ?></div>
                    <div class="text prev-duration">
                        <div class="prev-medium-header-smaller"><?php _e('Time requirement at least', 'purpozed'); ?><?php echo ': ' . $duration_overall . ' '; ?><?php _e('hours', 'purpozed'); ?></div>
                        <div class="text prev-frequency"><?php _e('Engagement Frequency', 'purpozed'); ?>
                            : <?php echo $frequency; ?></div>
                        <div class="text prev-duration"><?php _e('Duration per Engagement', 'purpozed'); ?>
                            : <?php echo $opportunity->duration; ?> <?php echo ($opportunity->duration === '1') ? _e(' hour', 'purpozed') : _e(' hours', 'purpozed'); ?></div>
                        <div class="text prev-time-frame"><?php _e('Time frame at least', 'purpozed'); ?>
                            : <?php echo $time_frame; ?></div>
                        <div class="text prev-duration-of-training"><?php _e('Duration of training', 'purpozed'); ?>:
                            <span><?php echo ($training_duration === 0) ? 'Not needed' : $training_duration; ?></span>
                        </div>
                    </div>
                    <div class="small-header"><?php _e('Number of volunteers needed', 'purpozed'); ?></div>
                    <div class="text">
                        <?php echo $opportunity->volunteers_needed; ?>
                    </div>
                    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/opportunities/organziation-info.php'); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
