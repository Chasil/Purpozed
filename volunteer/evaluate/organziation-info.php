<div class="small-header"><?php _e('About the organization', 'purpozed'); ?></div>
<div class="text"><?php echo $orgDet['about'][0]; ?>
</div>
<div class="volunteer-box-right">
    <div class="picture"><img
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
            <?php
            $user = wp_get_current_user();
            if (in_array('organization', (array)$user->roles)) {
                $link = '/organization-settings/';
            } else {
                $link = '/organization-profile-preview/?id=' . $organizationId;
            }
            ?>

            <button><a href="<?php echo $link; ?>"><?php _e('VIEW PROFILE', 'purpozed'); ?></a></button>
        </div>
    </div>
</div>