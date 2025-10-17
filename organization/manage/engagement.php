<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>

<div class="preview single-opportunity register">
    <div class="columns">
        <div class="column preview">
            <div class="statuses">
                <div class="preview-header-box"><?php _e('ENGAGEMENT', 'purpozed'); ?></div>
                <div class="preview-header-status fc-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
            </div>
            <div class="medium-header prev-header"><?php echo $opportunity->title; ?></div>
            <div class="image"><img src="<?php echo wp_get_attachment_image_src($opportunity->image, 'large')[0]; ?>">
                <div class="image_caption"><?php echo (isset($opportunity->image_caption)) ? $opportunity->image_caption : ''; ?></div>
            </div>
            <div class="text"><?php _e('Posted', 'purpozed'); ?><?php echo ' ' . str_replace('-', '/', substr($opportunity->posted, 0, -9)); ?></div>
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
                    : <?php echo $opportunity->duration; ?> <?php echo ($opportunity->duration === '1') ? ' hour' : 'hours'; ?></div>
                <div class="text prev-time-frame"><?php _e('Time frame at least', 'purpozed'); ?>
                    : <?php echo $time_frame; ?></div>
                <div class="text prev-duration-of-training"><?php _e('Duration of training', 'purpozed'); ?>:
                    <?php echo $training_duration; ?>
                </div>
            </div>
            <div class="small-header"><?php _e('Number of volunteers needed', 'purpozed'); ?></div>
            <div class="text">
                <?php echo $opportunity->volunteers_needed; ?>
            </div>

            <div class="small-header"><?php _e('About the organization', 'purpozed'); ?></div>
            <div class="text"><?php echo $organizationDetails['description'][0]; ?>
            </div>
            <div class="volunteer-box-right">
                <div class="picture orgs"><img
                            src="<?php echo wp_get_attachment_image_src($organizationDetails['logo'][0], 'medium')[0]; ?>">
                </div>
                <div class="data-together">
                    <div class="name"><?php echo $organizationDetails['organization_name'][0]; ?></div>
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
                            <a href="<?php echo $language; ?>/organization-profile/"><?php _e('VIEW PROFILE', 'purpozed'); ?></a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>