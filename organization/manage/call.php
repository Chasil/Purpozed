<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>

<div class="preview single-opportunity register">
    <div class="columns">
        <div class="column preview">
            <div class="statuses">
                <div class="preview-header-box"><?php _e('CALL', 'purpozed'); ?></div>
                <div class="preview-header-status fc-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
            </div>
            <div class="medium-header prev-header">
                <?php foreach ($focus as $item): ?>
                    <?php echo $item->name; ?>
                <?php endforeach; ?>
                <?php echo ': ' . $topic->name; ?>
            </div>
            <div class="image">
                <img src="<?php echo wp_get_attachment_image_src($opportunity->image, 'large')[0]; ?>">
                <div class="image_caption"><?php echo (isset($opportunity->image_caption)) ? $opportunity->image_caption : ''; ?></div>
            </div>
            <div class="text"><?php _e('Posted', 'purpozed'); ?><?php echo ' ' . str_replace('-', '/', substr($opportunity->posted, 0, -9)); ?></div>
            <div class="small-header"><?php _e('Needed Skills', 'purpozed'); ?></div>
            <div class="skills prev-skills">
                <?php foreach ($skills as $skill): ?>
                    <div class="single-skill"><?php echo $skill->name; ?></div>
                <?php endforeach; ?>
            </div>
            <div class="small-header"><?php _e('Duration & Time Frame', 'purpozed'); ?></div>
            <div class="text prev-duration">Approx 1h
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

            <div class="small-header"><?php _e('About the organization', 'purpozed'); ?></div>
            <div class="text"><?php echo $organizationDetails['description'][0]; ?>
            </div>
            <div class="volunteer-box-right">
                <div class="picture orga"><img
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