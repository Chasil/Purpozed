<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>

<div class="operation-box">
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'review'): ?>
            <div class="success"><?php _e('Thank you for posting this opportunity', 'purpozed'); ?>!</div>
            <div class="success-two success">
                <div><?php _e('We will check your opportunity within the next 24 hours and make it public or - in case of possible inquiries - get in touch with you respectively. After publishing you will find this opportunity on your dashboard in the table "Posted opportunities". There you will also find appropriate volunteers you can get in contact', 'purpozed'); ?>
                    .
                </div>
            </div>
            <div class="success-three success">
                <div class="step-button"><a
                            href="/<?php echo $language; ?>"><?php _e('GO TO DASHBOARD', 'purpozed'); ?></a></div>
            </div>
        <?php elseif ($_GET['status'] === 'prepared'): ?>
            <div class="success"><?php _e('You saved this posting successfully', 'purpozed'); ?>!</div>
            <div class="success-two success">
                <div><?php _e('You find this opportunity from now onwards on your dashboard in the table "Saved opportunities". From there you can open it again, edit and post it.', 'purpozed'); ?>
                    .
                </div>
            </div>
            <div class="success-three success">
                <div class="step-button"><a
                            href="/<?php echo $language; ?>"><?php _e('GO TO DASHBOARD', 'purpozed'); ?></a></div>
            </div>
        <?php else: ?>
            <div class="fail"><?php _e('Opportunity not saved. Database error.', 'purpozed'); ?></div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<div class="opportunity-dashboard">
    <div class="row">
        <span class="header"><?php _e('Who are you looking for', 'purpozed'); ?>?</span>
    </div>
    <div class="row boxes">
        <div class="column">
            <div class="row">
                <span class="small-header"><?php _e('An Expert for a', 'purpozed'); ?>:</span>
            </div>
            <div class="row three-items">
                <div class="opportunity-item">
                    <a href="<?php echo $language; ?>/post-opportunity/?task=call">
                        <div class="top">
                            <div class="icon"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/call.svg">
                            </div>
                            <div class="describe"><?php _e('Call', 'purpozed'); ?></div>
                        </div>
                    </a>
                    <div class="bottom">
                        <span><?php _e('You have specific questions you want to ask an expert or need a feedback or an advice on a particular topic.', 'purpozed'); ?></span>
                    </div>
                </div>
                <div class="opportunity-item">
                    <a href="<?php echo $language; ?>/post-opportunity/?task=project">
                        <div class="top">
                            <div class="icon"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/project.svg">
                            </div>
                            <div class="describe"><?php _e('Project', 'purpozed'); ?></div>
                        </div>
                    </a>
                    <div class="bottom">
                        <span><?php _e('You are looking for professionals, who can implement skill-based projects for you.', 'purpozed'); ?></span>
                    </div>
                </div>
                <div class="opportunity-item">
                    <a href="<?php echo $language; ?>/post-opportunity/?task=mentoring">
                        <div class="top">
                            <div class="icon"><img
                                        src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/mentoring.svg"></div>
                            <div class="describe"><?php _e('Mentoring', 'purpozed'); ?></div>
                        </div>
                    </a>
                    <div class="bottom">
                        <span><?php _e('You are looking for experienced experts, who want to accompany you for a specified period of time as a mentor.', 'purpozed'); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <span class="small-header"><?php _e('A Helping Hand for an', 'purpozed'); ?>:</span>
            </div>
            <div class="row">
                <div class="opportunity-item">
                    <a href="<?php echo $language; ?>/post-opportunity/?task=engagement">
                        <div class="top">
                            <div class="icon"><img
                                        src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/engagement.svg"></div>
                            <div class="describe"><?php _e('Engagement', 'purpozed'); ?></div>
                        </div>
                    </a>
                    <div class="bottom">
                        <span><?php _e('You are looking for volunteers who want to engage passionately, but do not need any specific skills for the activities', 'purpozed'); ?></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>