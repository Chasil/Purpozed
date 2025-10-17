<?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/admin/opportunity/top-bar.php'); ?>

<form class="register-call" method="post" action="" id="post-opportunity">
    <div class="register">
        <div class="register-header"><img
                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/call.svg"><?php _e('Post a call', 'purpozed'); ?>
        </div>
        <div class="row steps">
            <div class="step step-point">
                <div class="step-text"><?php _e('Topic', 'purpozed'); ?></div>
            </div>
            <div class="step step-line">
                <div></div>
            </div>
            <div class="step step-point">
                <div class="step-text"><?php _e('Focus & Goal', 'purpozed'); ?></div>
            </div>
            <div class="step step-line">
                <div></div>
            </div>
            <div class="step step-point">
                <div class="step-text"><?php _e('Contact', 'purpozed'); ?></div>
            </div>
            <div class="step step-line">
                <div></div>
            </div>
            <div class="step step-point active">
                <div class="step-text"><?php _e('Preview', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section not-first">
            <div class="row row-item">
                <div class="post-item topic">
                    <div class="row">
                        <div class="medium-header"><?php _e('Please select the Topic of your Call', 'purpozed'); ?></div>
                    </div>
                    <div class="row aoe-items">
                        <div class="expertises">
                            <?php foreach ($areas_of_expertise as $area): ?>
                                <div class="single-expertise call <?php echo ($aoe->id === $area->id) ? 'active' : ''; ?>"
                                     data-aoe="<?php echo $area->id; ?>"><?php echo $area->name; ?></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="topics">
                            <?php $topicId = (isset($topic->id)) ? $topic->id : 0; ?>
                            <?php foreach ($edit_topics as $call_topic): ?>
                                <div class="single-topic">
                                    <input data-validation="" type="radio"
                                           id="topic_<?php echo $call_topic->call_id; ?>" name="topic"
                                           value="<?php echo $call_topic->call_id; ?>"
                                           data-topic="<?php echo $call_topic->call_name; ?>" <?php echo ($topicId === $call_topic->call_id) ? 'checked="checked"' : ''; ?> >
                                    <label for="topic_<?php echo $call_topic->call_id; ?>"><?php echo $call_topic->call_name; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="error-box extra"><?php _e('You have to choose at least one Topic', 'purpozed'); ?></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="step-button next call-topic"><?php _e('NEXT', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section not-first">
            <div class="row post-item">
                <div class="medium-header"><?php _e('What is your main focus', 'purpozed'); ?>?</div>
            </div>
            <div class="row">
                <div class="focus-items">
                    <?php $focusId = (isset($focus[0]->id)) ? $focus[0]->id : 0; ?>
                    <?php foreach ($focuses as $focus): ?>
                        <div class="single-item" data-focus="<?php echo $focus->id; ?>">
                            <input type="radio" id="focus_<?php echo $focus->id; ?>" name="focus[]"
                                   value="<?php echo $focus->id; ?>"
                                   data-focus="<?php echo $focus->name; ?>" <?php echo ($focusId === $focus->id) ? 'checked="checked"' : ''; ?>>
                            <label for="focus_<?php echo $focus->id; ?>"><?php echo $focus->name; ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="error-box extra"><?php _e('You have to choose one Focus', 'purpozed'); ?></div>
                </div>
            </div>
            <div class="row column textarea-items">
                <div class="text"><?php _e('In short: What is the main goal of your call', 'purpozed'); ?>?</div>
                <div class="opportunity-textarea"><textarea class="charNum"
                                                            data-max="600"
                                                            maxlength="600"
                                                            name="goal"><?php echo (isset($opportunity->goal)) ? $opportunity->goal : ''; ?></textarea>
                    <div class="error-box extra"><?php _e('This field can not be empty', 'purpozed'); ?></div>
                </div>
                <div class="error-box"><?php _e('This field must have max 600 characters', 'purpozed'); ?></div>
                <div class="small-text"><?php _e('Max. 600 characters', 'purpozed'); ?></div>
                <div class="small-text counter">0/600</div>
            </div>
            <div class="row">
                <div class="medium-header"><?php _e('Is there an expiration date of this opportunity', 'purpozed'); ?>
                    ?
                </div>
                <div class="small-header inline"><?php _e('Yes, please delete this opportunity on the following date', 'purpozed'); ?>
                    :
                    <div class="date-picker"><input type="text" name="expire" id="datepicker" autocomplete="off"
                                                    value="<?php echo (isset($opportunity) && $opportunity->expire !== '0') ? date('m/d/Y', $opportunity->expire) : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                <div class="step-button next call-goal"><?php _e('NEXT', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section not-first">
            <div class="row post-item">
                <div class="medium-header"><?php _e('Who will participate in the Call', 'purpozed'); ?>?</div>
            </div>
            <div class="row contact">
                <div class="contact-item">
                    <label><?php _e('First name', 'purpozed'); ?>
                        <input type="text" name="contact_name" data-validation="contact_name"
                               value="<?php echo (isset($opportunity->contact_name)) ? $opportunity->contact_name : ''; ?>">
                        <div class="error-box extra"><?php _e('Forename must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                    </label>
                </div>
                <div class="contact-item">
                    <label><?php _e('Second name', 'purpozed'); ?>
                        <input type="text" name="contact_surname" data-validation="contact_surname"
                               value="<?php echo (isset($opportunity->contact_surname)) ? $opportunity->contact_surname : ''; ?>">
                        <div class="error-box extra"><?php _e('Forename must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                    </label>
                </div>
                <div class="contact-item">
                    <label><?php _e('E-mail', 'purpozed'); ?>
                        <input type="email" name="contact_email" data-validation="contact_email"
                               value="<?php echo (isset($opportunity->contact_email)) ? $opportunity->contact_email : ''; ?>">
                        <div class="error-box extra"><?php _e('Invalid email', 'purpozed'); ?></div>
                    </label>
                </div>
                <div class="contact-item">
                    <label><?php _e('Phone no', 'purpozed'); ?>
                        <input type="text" name="contact_phone" data-validation="contact_phone"
                               value="<?php echo (isset($opportunity->contact_phone)) ? $opportunity->contact_phone : ''; ?>">
                        <div class="error-box extra"><?php _e('Phone number must contain only numbers and + sign (min: 8, max: 15 chars)', 'purpozed'); ?></div>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                <div class="step-button next call contact"><?php _e('PREVIEW', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section preview">
            <div class="columns">
                <div class="column">
                    <input type="hidden" name="task_type" value="call">
                    <input type="hidden" name="organization_id" value="1">
                    <div class="hidden-data"></div>
                    <div class="row buttons-box">
                        <?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/admin/opportunity/sidebar.php'); ?>
                    </div>
                </div>
                <div class="column preview">
                    <div class="preview-header-box"><?php _e('Preview', 'purpozed'); ?></div>
                    <div class="medium-header prev-header"></div>
                    <div class="upload-image opportunity-image">
                        <?php $image = (isset($opportunity->image)) ? wp_get_attachment_image_url($opportunity->image, 'full') : ''; ?>
                        <div class="uploaded-image"><img src="<?php echo $image; ?>"></div>
                        <form action="" method="post">
                            <input type="text" name="caption"
                                   value="<?php echo (isset($opportunity->image_caption)) ? $opportunity->image_caption : ''; ?>">
                            <input type="hidden" value="<?php echo $opportunity->o_id; ?>" name="opportunity_id" max=""
                                   min="1" step="1">
                            <input type="hidden" value="" name="image_id" max="" min="1" step="1">
                            <button class="set_custom_opportunity_image">PICTURE UPLOAD</button>
                            <button type="submit" class="" name="save_image">SAVE PICTURE</button>
                        </form>
                    </div>
                    <div class="text"><?php _e('Posted', 'purpozed'); ?><?php echo date('d/m/Y'); ?></div>
                    <div class="small-header"><?php _e('Needed Skills', 'purpozed'); ?></div>
                    <div class="skills prev-skills">
                        <?php foreach ($skills as $skill) : ?>
                            <div class="single-skill"><?php echo $skill->name; ?></div>
                            <input type="hidden" name="skills[]" value="<?php echo $skill->id; ?>">
                        <?php endforeach; ?>
                    </div>
                    <div class="small-header"><?php _e('Duration & Time Frame', 'purpozed'); ?></div>
                    <div class="text prev-duration">1 hour</div>
                    <div class="small-header"><?php _e('Main focus of the Call', 'purpozed'); ?></div>
                    <div class="text prev-focus">
                        <?php echo $focus->name; ?>
                    </div>
                    <div class="small-header"><?php _e('Goal of the Call', 'purpozed'); ?></div>
                    <div class="text prev-goal">
                        <?php echo $opportunity->goal; ?>
                    </div>
                    <div class="small-header"><?php _e('Call Process', 'purpozed'); ?></div>
                    <div class="text prev-process">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                        officia deserunt mollit anim id est eopksio laborum. Sed ut perspiciatis unde omnis istpoe
                        natus
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>