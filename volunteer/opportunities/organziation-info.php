<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>

<div class="small-header"><?php _e('About the organization', 'purpozed'); ?></div>
<div class="text"><?php echo $orgDet['description'][0]; ?>
</div>
<div class="volunteer-box-right">
    <div class="picture orga"><img
                src="<?php echo wp_get_attachment_image_src($orgDet['logo'][0], 'medium')[0]; ?>">
    </div>
    <div class="data-together">
        <div class="org_name"><?php echo $orgDet['organization_name'][0]; ?></div>
        <div class="goal">
            <div class="main-goal"><?php _e('Main goal', 'purpozed'); ?>:</div>
            <span class="single-skill"><?php echo $mainGoalName->name; ?></span></div>
    </div>
    <div class="data-together">
        <div class="succeded v-title"><?php echo $openOpportunities . ' '; ?><?php _e('open opportunities', 'purpozed'); ?></div>
        <div class="hours v-title"><?php echo $succeededOpportunities . ' '; ?><?php _e('succeeded opportunities', 'purpozed'); ?></div>
    </div>
    <div class="buttons">
        <div class="profile same">
            <button>
                <a href="<?php echo $language; ?>/organization-profile-preview/?id=<?php echo $organizationId; ?>"><?php _e('VIEW PROFILE', 'purpozed'); ?></a>
            </button>
        </div>
    </div>
</div>