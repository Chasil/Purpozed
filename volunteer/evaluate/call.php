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

$taskSkills = $opportunities->getCallSkillsByCall($opportunity->o_id);
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

<div class="section preview single-opportunity register evaluation">
    <div class="columns">

        <div class="column evaluate preview">

            <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/textareas.php'); ?>

            <div class="show-more-evaluation-button medium-header prev-header"><?php _e('ABOUT THE OPPORTUNITY', 'purpozed'); ?>
                <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/arrow_down.svg"></div>
            <div class="show-more-evaluation-content">

                <div class="medium-header prev-header">
                    <?php foreach ($focus as $item): ?>
                        <?php echo $item->name; ?>
                    <?php endforeach; ?>
                    <?php echo ' ' . $topic->name; ?>
                </div>

                <?php if (isset($opportunity->image)): ?>
                    <img src="<?php echo wp_get_attachment_image_src($opportunity->image, 'large')[0]; ?>">
                <?php endif; ?>

                <div class="text"><?php _e('Posted', 'purpozed'); ?><?php echo ' ' . str_replace('-', '/', substr($opportunity->posted, 0, -9)); ?></div>
                <div class="small-header"><?php _e('Duration & Time Frame', 'purpozed'); ?></div>
                <div class="text prev-duration"><?php _e('Approx 1h', 'purpozed'); ?>
                </div>
                <div class="small-header"><?php _e('Main focus of the Call', 'purpozed'); ?></div>
                <div class="text prev-goal">
                    <?php foreach ($focus as $item): ?>
                        <div><?php echo $item->name; ?></div>
                    <?php endforeach; ?>
                </div>
                <div class="small-header">
                    <?php _e('Goal of the call', 'purpozed'); ?>
                </div>
                <div class="text prev-process"><?php echo $opportunity->goal; ?></div>
                <div class="small-header">
                    <?php _e('Call process', 'purpozed'); ?>
                </div>
                <div class="text prev-extra">
                    <?php echo $call_focuses; ?>
                </div>
                <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/evaluate/organziation-info.php'); ?>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-menu footer">
    <?php $signInFooter = get_option('purpozed_vol_compa_footer'); ?>
    <div class="menu-bar footer">
        <?php global $wp_filter; ?>
        <?php unset($wp_filter['wp_nav_menu_args']); ?>
        <?php if ($signInFooter): ?>
            <?php wp_nav_menu(array('menu' => $signInFooter)); ?>
        <?php else: ?>
            <div class="info-box"><?php _e('Menu for this section is not setup.', 'purpozed'); ?></div>
        <?php endif; ?>
    </div>
    <div class="wpml-ls-statics-footer wpml-ls wpml-ls-legacy-list-horizontal">
        <ul>
            <li class="wpml-ls-slot-footer wpml-ls-item wpml-ls-item-de wpml-ls-current-language wpml-ls-item-legacy-list-horizontal">
                <a href="https://portal.purpozed.org" class="wpml-ls-link">
                    <img class="wpml-ls-flag"
                         src="https://portal.purpozed.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/de.png"
                         alt="Deutsch" width="18" height="12"></a>
            </li>
            <li class="wpml-ls-slot-footer wpml-ls-item wpml-ls-item-en wpml-ls-first-item wpml-ls-item-legacy-list-horizontal">
                <a href="https://portal.purpozed.org/en/" class="wpml-ls-link">
                    <img class="wpml-ls-flag"
                         src="https://portal.purpozed.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                         alt="Englisch" width="18" height="12"></a>
            </li>
        </ul>
    </div>
</div>