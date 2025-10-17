<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/header.php');
?>

    <div class="edit-profie">
        <div class="edit-header"><?php _e('Organization Profile', 'purpozed'); ?></div>
        <div class="columns">
            <div class="single-column first">
                <div class="volunteer-box-right smaller-one">
                    <div class="picture orga"><img
                                src="<?php echo wp_get_attachment_image_src($details['logo'][0], 'medium')[0]; ?>">
                    </div>
                    <div class="data-together">
                        <div class="name"><?php echo $details['organization_name'][0]; ?></div>
                    </div>
                    <div class="main-organization-goal">
                        <div class="title"><?php _e('Main goal', 'purpozed'); ?>:</div>
                        <div class="goal single-skill"><?php echo $main_goal->name; ?></div>
                    </div>
                    <div class="data-together">
                        <div class="hours v-title"><?php echo $openOpportunities . ' '; ?><?php _e('open opportunities', 'purpozed'); ?></div>
                        <div class="succeded v-title"><?php echo $succeeded . ' '; ?><?php _e('succeeded opportunities', 'purpozed'); ?></div>
                    </div>
                </div>
            </div>
            <div class="single-column second">
                <div class="items-box organization-goals">
                    <div class="items-box-buttons">
                        <div class="text"><?php _e('Goals', 'purpozed'); ?></div>
                    </div>
                    <div class="goals">
                        <!--                    <div class="single-goal"><img-->
                        <!--                                src="-->
                        <?php //echo wp_get_attachment_image_src((int)$main_goal->image_id, 'medium')[0]; ?><!--">-->
                        <!--                        <div class="main-goal">-->
                        <?php //_e('Main goal', 'purpozed'); ?><!--</div>-->
                        <!--                    </div>-->
                        <?php foreach ($goals as $goal): ?>
                            <div class="single-goal"><img
                                        src="<?php echo wp_get_attachment_image_src((int)$goal->image_id, 'medium')[0]; ?>">

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="items-box">
                    <div class="items-box-buttons">
                        <div class="text"><?php _e('About', 'purpozed'); ?></div>
                    </div>
                    <div class="text-2">
                        <?php echo $details['about'][0]; ?>
                    </div>
                </div>
                <div class="items-box">
                    <div class="items-box-buttons">
                        <div class="text"><?php _e('Website', 'purpozed'); ?></div>
                    </div>
                    <div class="text-2">
                        <?php if (!empty($details['website'][0])): ?>
                            <?php $hasHTTP = strpos($details['website'][0], 'http'); ?>
                            <a class="blue-link"
                               href="<?php echo (is_int($hasHTTP)) ? '' : '//'; ?><?php echo $details['website'][0]; ?>"
                               target='_blank'><?php _e('Website organization', 'purpozed'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="items-box">
                    <div class="items-box-buttons">
                        <div class="text"><?php _e('Social Media Links', 'purpozed'); ?></div>
                    </div>
                    <div class="text-2">
                        <?php foreach ($links as $link): ?>
                            <div class="link"><a href="<?php echo $link->url; ?>"
                                                 target="_blank"><?php echo $link->name; ?></a></div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/footer.php');
?>