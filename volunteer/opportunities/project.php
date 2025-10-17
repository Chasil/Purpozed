<?php

$opportunities = new \Purpozed2\Models\OpportunitiesManager();
$volunteerManager = new \Purpozed2\Models\VolunteersManager();
$organization = new \Purpozed2\Models\Organization();
$singleOpportunity = new \Purpozed2\Models\Opportunity();

$organizationDetails = $singleOpportunity->getOrganization($opportunity->o_id);
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
sort($matchedGoals, SORT_NUMERIC);

$taskSkills = $opportunities->getProjectSkillsByTask($opportunity->o_id);
$userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

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


?>


<?php if ($opportunity_status === 'succeeded'): ?>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/project.php'); ?>
<?php else: ?>
    <div class="section preview single-opportunity register">
        <div class="columns">
            <div class="column">
                <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/opportunities/sidebar.php'); ?>
            </div>
            <div class="column preview">
                <div class="statuses">
                    <div class="preview-header-box"><?php _e('PROJECT', 'purpozed'); ?></div>
                    <div class="preview-header-status fc-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
                </div>
                <div class="medium-header prev-header"><?php echo $topic->name; ?></div>

                <div class="image"><img
                            src="<?php echo wp_get_attachment_image_src($opportunity->image, 'large')[0]; ?>">
                    <div class="image_caption"><?php echo (isset($opportunity->image_caption)) ? $opportunity->image_caption : ''; ?></div>

                    <!--                    <div class="text">--><?php //_e('Posted', 'purpozed'); ?><!---->
                    <?php //echo ' ' . str_replace('-', '/', substr($opportunity->posted, 0, -9)); ?><!--</div>-->
                    <div class="small-header"><?php _e('Matched Skills', 'purpozed'); ?></div>
                    <div class="skills prev-skills">
                        <?php foreach ($matchedSkills as $skill): ?>
                            <div class="single-skill"><?php echo $skill; ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="small-header"><?php _e('Matched Goals', 'purpozed'); ?></div>
                    <div class="skills prev-skills">
                        <?php foreach ($matchedGoals as $goal): ?>
                            <div class="single-skill"><?php echo $goal; ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="small-header"><?php _e('Duration & Time Frame', 'purpozed'); ?></div>
                    <div class="text prev-duration">
                        <?php foreach ($taskData

                        as $task): ?>
                        <?php echo $task->hours_duration . ' '; ?><?php echo ($task->hours_duration === '1') ? _e('hour', 'purpozed') : _e('hours', 'purpozed'); ?></div>
                    <?php endforeach; ?>
                </div>
                <div class="small-header"><?php _e('Brief Description', 'purpozed'); ?></div>
                <div class="text prev-goal">
                    <?php foreach ($taskData as $task): ?>
                        <?php echo stripslashes($task->description); ?>
                    <?php endforeach; ?>
                </div>
                <div class="small-header"><?php _e('Expected deliverables and Benefits', 'purpozed'); ?></div>
                <div class="text prev-process"><?php echo stripslashes($opportunity->benefits); ?></div>
                <div class="small-header"><?php _e('Additional Details', 'purpozed'); ?></div>
                <div class="text prev-extra"><?php echo stripslashes($opportunity->details); ?></div>
                <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/opportunities/organziation-info.php'); ?>
            </div>
        </div>
    </div>
    </div>
<?php endif; ?>
