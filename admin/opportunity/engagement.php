<?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/admin/opportunity/top-bar.php'); ?>

<form class="register-engagement" method="post" action="" id="post-opportunity">
    <div class="register">
        <div class="register-header"><img
                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/engagement.svg"><?php _e('Post an Engagement', 'purpozed'); ?>
        </div>
        <div class="row steps">
            <div class="step step-point active">
                <div class="step-text"><?php _e('Task', 'purpozed'); ?></div>
            </div>
            <div class="step step-line">
                <div></div>
            </div>
            <div class="step step-point">
                <div class="step-text"><?php _e('Time', 'purpozed'); ?></div>
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
            <div class="step step-point">
                <div class="step-text"><?php _e('Preview', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section not-first">
            <div class="row row-item">
                <div class="post-item topic">
                    <div class="text"><?php _e('The Title', 'purpozed'); ?>:</div>
                    <div class="opportunity-input">
                        <input type="text" name="title" data-validation="title" class="charNum" data-max="30"
                               maxlength="30"
                               value="<?php echo (isset($opportunity->title)) ? $opportunity->title : ''; ?>">
                        <div class="error-box extra"><?php _e('Max 30 characters', 'purpozed'); ?></div>
                    </div>
                    <div class="small-text"><?php _e('Please fill this field', 'purpozed'); ?></div>
                    <div class="small-text counter">0/30</div>
                    <div class="row column textarea-items">
                        <div class="text"><?php _e('The why', 'purpozed'); ?></div>
                        <div class="opportunity-textarea"><textarea name="why" class="charNum" data-max="600"
                                                                    maxlength="600"
                                                                    data-validation="why"><?php echo (isset($opportunity->why)) ? $opportunity->why : ''; ?></textarea>
                            <div class="error-box"><?php _e('This field must have max 600 characters', 'purpozed'); ?></div>
                        </div>
                        <div class="small-text"><?php _e('Please fill this field', 'purpozed'); ?></div>
                        <div class="small-text counter">0/600</div>
                    </div>
                    <div class="row column textarea-items">
                        <div class="text"><?php _e('The Task', 'purpozed'); ?></div>
                        <div class="opportunity-textarea"><textarea name="task" class="charNum" data-max="600"
                                                                    maxlength="600"
                                                                    data-validation="task"><?php echo (isset($opportunity->task)) ? $opportunity->task : ''; ?></textarea>
                            <div class="error-box"><?php _e('This field must have max 600 characters', 'purpozed'); ?></div>
                        </div>
                        <div class="small-text"><?php _e('Please fill this field', 'purpozed'); ?></div>
                        <div class="small-text counter">0/600</div>
                    </div>
                    <div class="row column textarea-items">
                        <div class="text"><?php _e('Requirements', 'purpozed'); ?></div>
                        <div class="opportunity-textarea"><textarea name="requirements"
                                                                    data-validation="requirements"><?php echo (isset($opportunity->requirements)) ? $opportunity->requirements : ''; ?></textarea>
                            <div class="error-box"><?php _e('This field must have max 200 characters', 'purpozed'); ?></div>
                        </div>
                        <div class="small-text"><?php _e('Please fill this field', 'purpozed'); ?></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="step-button next engagement-task"><?php _e('NEXT', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section not-first">
            <div class="row post-item">
                <div class="medium-header"><?php _e('Please type in information concerning frequency, duration and time frame of the engagement', 'purpozed'); ?></div>
            </div>
            <div class="row time-row">
                <div class="time-column">
                    <div class="row project-task">
                        <div class="select-header"><?php _e('Engagement Frequency', 'purpozed'); ?></div>
                        <div class="search search-engagement">
                            <select name="frequency" class="">
                                <option value="1.00" <?php echo (isset($opportunity->frequency) && $opportunity->frequency === '1.00') ? 'selected="selected"' : ';' ?>><?php _e('Every week', 'purpozed'); ?></option>
                                <option value="0.50" <?php echo (isset($opportunity->frequency) && $opportunity->frequency === '0.50') ? 'selected="selected"' : ';' ?>><?php _e('Every two weeks', 'purpozed'); ?></option>
                                <option value="0.25" <?php echo (isset($opportunity->frequency) && $opportunity->frequency === '0.25') ? 'selected="selected"' : ';' ?>><?php _e('Every month', 'purpozed'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="time-column">
                    <div class="row project-task">
                        <div class="select-header"><?php _e('Duration per Engagement', 'purpozed'); ?></div>
                        <div class="search search-engagement">
                            <select name="duration" class="">
                                <option value="1" <?php echo (isset($opportunity->duration) && $opportunity->duration === '1') ? 'selected="selected"' : ';' ?>><?php _e('1 hour', 'purpozed'); ?></option>
                                <option value="2" <?php echo (isset($opportunity->duration) && $opportunity->duration === '2') ? 'selected="selected"' : ';' ?>><?php _e('2 hours', 'purpozed'); ?></option>
                                <option value="3" <?php echo (isset($opportunity->duration) && $opportunity->duration === '3') ? 'selected="selected"' : ';' ?>><?php _e('3 hours', 'purpozed'); ?></option>
                                <option value="4" <?php echo (isset($opportunity->duration) && $opportunity->duration === '4') ? 'selected="selected"' : ';' ?>><?php _e('4 hours', 'purpozed'); ?></option>
                                <option value="5" <?php echo (isset($opportunity->duration) && $opportunity->duration === '5') ? 'selected="selected"' : ';' ?>><?php _e('5 hours', 'purpozed'); ?></option>
                                <option value="6" <?php echo (isset($opportunity->duration) && $opportunity->duration === '6') ? 'selected="selected"' : ';' ?>><?php _e('6 hours', 'purpozed'); ?></option>
                                <option value="7" <?php echo (isset($opportunity->duration) && $opportunity->duration === '7') ? 'selected="selected"' : ';' ?>><?php _e('7 hours', 'purpozed'); ?></option>
                                <option value="8" <?php echo (isset($opportunity->duration) && $opportunity->duration === '8') ? 'selected="selected"' : ';' ?>><?php _e('8 hours', 'purpozed'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="time-column">
                    <div class="row project-task">
                        <div class="select-header"><?php _e('Time frame at least', 'purpozed'); ?></div>
                        <div class="search search-engagement">
                            <select name="time_frame" class="">
                                <option value="1" <?php echo (isset($opportunity->time_frame) && $opportunity->time_frame === '1') ? 'selected="selected"' : ';' ?>><?php _e('1 week', 'purpozed'); ?></option>
                                <option value="12" <?php echo (isset($opportunity->time_frame) && $opportunity->time_frame === '12') ? 'selected="selected"' : ';' ?>><?php _e('12 weeks', 'purpozed'); ?></option>
                                <option value="24" <?php echo (isset($opportunity->time_frame) && $opportunity->time_frame === '24') ? 'selected="selected"' : ';' ?>><?php _e('24 weeks', 'purpozed'); ?></option>
                                <option value="48" <?php echo (isset($opportunity->time_frame) && $opportunity->time_frame === '48') ? 'selected="selected"' : ';' ?>><?php _e('48 week', 'purpozed'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row post-item training">
                <div class="text"><?php _e('Do Volunteers Need a Training in Advance', 'purpozed'); ?>?
                    <div class="single-topic-2">
                        <div class="button-on two">
                            <input type="checkbox" name="need_training"
                                   id="request" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration !== '0') ? 'checked="checked"' : ''; ?>>
                            <label for="request">AUS</label>
                        </div>
                    </div>
                </div>
                <div class="text dot
                <?php if (!isset($opportunity->training_duration)) {
                    echo 'duration-of-training';
                } elseif (isset($opportunity->training_duration)) {
                    if ($opportunity->training_duration === '0') {
                        echo 'duration-of-training';
                    }
                } ?>">
                    <div class=" select-header
                "><?php _e('Duration of training', 'purpozed'); ?></div>
                    <div class="search search-engagement">
                        <select name="training_duration" class="">
                            <option value="0" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration === '0') ? 'selected="selected"' : ';' ?>><?php _e('Not needed', 'purpozed'); ?></option>
                            <option value="1" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration === '1') ? 'selected="selected"' : ';' ?>><?php _e('1 hour', 'purpozed'); ?></option>
                            <option value="2" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration === '2') ? 'selected="selected"' : ';' ?>><?php _e('2 hours', 'purpozed'); ?></option>
                            <option value="3" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration === '3') ? 'selected="selected"' : ';' ?>><?php _e('3 hours', 'purpozed'); ?></option>
                            <option value="4" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration === '4') ? 'selected="selected"' : ';' ?>><?php _e('4 hours', 'purpozed'); ?></option>
                            <option value="5" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration === '5') ? 'selected="selected"' : ';' ?>><?php _e('5 hours', 'purpozed'); ?></option>
                            <option value="6" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration === '6') ? 'selected="selected"' : ';' ?>><?php _e('6 hours', 'purpozed'); ?></option>
                            <option value="7" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration === '7') ? 'selected="selected"' : ';' ?>><?php _e('7 hours', 'purpozed'); ?></option>
                            <option value="8" <?php echo (isset($opportunity->training_duration) && $opportunity->training_duration === '8') ? 'selected="selected"' : ';' ?>><?php _e('8 hours', 'purpozed'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row post-item unusual-header">
                <div class="medium-header"><?php _e('Total time requirement at least', 'purpozed'); ?>
                    <div class="header"><span id="curr_hours">1</span> <span><?php _e('hour', 'purpozed'); ?></span>
                    </div>
                </div>
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
                <div class="medium-header"><?php _e('How many volunteers can take over this engagement', 'purpozed'); ?>
                    ?
                </div>
                <div class="small-header inline"><?php _e('At the moment we would appreciate the following number of volunteers', 'purpozed'); ?>
                    :
                    <div class="number"><input type="number" name="volunteers_needed"
                                               value="<?php echo $opportunity->volunteers_needed; ?>"></div>
                </div>
            </div>
            <div class="row">
                <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                <div class="step-button next engagement-time"><?php _e('NEXT', 'purpozed'); ?></div>
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
                <div class="step-button next engagement contact"><?php _e('PREVIEW', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section preview">
            <div class="columns">
                <div class="column">
                    <input type="hidden" name="task_type" value="engagement">
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
                            <input type="hidden" value="<?php echo $opportunity->task_id; ?>" name="opportunity_id"
                                   max=""
                                   min="1" step="1">
                            <input type="hidden" value="" name="image_id" max="" min="1" step="1">
                            <button class="set_custom_opportunity_image">PICTURE UPLOAD</button>
                            <button type="submit" class="" name="save_image">SAVE PICTURE</button>
                        </form>
                    </div>
                    <div class="text"><?php _e('Posted', 'purpozed'); ?><?php echo date('d/m/Y'); ?></div>
                    <div class="small-header"><?php _e('The why', 'purpozed'); ?></div>
                    <div class="text prev-why">
                        <?php echo $opportunity->why; ?>
                    </div>
                    <div class="small-header"><?php _e('The task', 'purpozed'); ?></div>
                    <div class="text prev-task">
                        <?php echo $opportunity->task; ?>
                    </div>
                    <div class="small-header"><?php _e('Requirements', 'purpozed'); ?></div>
                    <div class="text prev-requirements">
                        <?php echo $opportunity->requirements; ?>
                    </div>
                    <div class="small-header"><?php _e('Duration & Time Frame', 'purpozed'); ?></div>
                    <div class="text">
                        <div class="prev-medium-header"><?php _e('Time requirement at least', 'purpozed'); ?><?php echo ': ' . $duration_overall . ' '; ?><?php _e('hours', 'purpozed'); ?></div>
                        <div class="text prev-frequency"><?php _e('Engagement Frequency', 'purpozed'); ?>:
                            <span><?php echo $frequency; ?></span>
                        </div>
                        <div class="text prev-duration"><?php _e('Duration per Engagement', 'purpozed'); ?>:
                            <span><?php echo $opportunity->duration; ?><?php echo ($opportunity->duration === '1') ? ' hour' : 'hours'; ?></span>
                        </div>
                        <div class="text prev-time-frame"><?php _e('Time frame at least', 'purpozed'); ?>:
                            <span><?php echo $time_frame; ?><?php ($time_frame > 1) ? _e('hours', 'purpozed') : _e('hour', 'purpozed'); ?></span>
                        </div>
                        <div class="text prev-duration-of-training"><?php _e('Duration of training', 'purpozed'); ?>:
                            <span><?php echo ($training_duration === 0) ? 'Not needed' : $training_duration; ?></span>
                        </div>
                    </div>
                    <div class="small-header"><?php _e('Number of volunteers needed', 'purpozed'); ?> <span></span>
                    </div>
                    <div class="text prev-volunteers">
                        <?php echo $opportunity->volunteers_needed; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
