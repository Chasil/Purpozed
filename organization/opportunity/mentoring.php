<?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/opportunity/top-bar.php'); ?>

<form class="register-mentoring" method="post" action="" id="post-opportunity">
    <div class="register">
        <div class="register-header"><img
                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/mentoring.svg"><?php _e('Post a mentoring', 'purpozed'); ?>
        </div>
        <div class="row steps">
            <div class="step step-point <?php echo ($status === 'review' || $status === 'prepared') ? '' : 'active'; ?>">
                <div class="step-text"><?php _e('Expertise & Goal', 'purpozed'); ?></div>
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
            <div class="step step-point <?php echo ($status === 'review' || $status === 'prepared') ? 'active' : ''; ?>">
                <div class="step-text"><?php _e('Preview', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section <?php echo ($status === 'review' || $status === 'prepared') ? 'not-first' : ''; ?>">
            <div class="row row-item">
                <div class="post-item topic">
                    <div class="row">
                        <div class="medium-header"><?php _e('Which area the Mentor should be an expert of?', 'purpozed'); ?></div>
                    </div>
                    <div class="row aoe-items">
                        <div class="topics">
                            <?php foreach ($areas_of_expertise as $area): ?>
                                <div class="single-topic">
                                    <input data-validation="" type="radio" id="area_<?php echo $area->id; ?>"
                                           name="mentor_area" value="<?php echo $area->id; ?>"
                                           data-aoe="<?php echo $area->name; ?>" <?php echo (isset($opportunity->mentor_area) && $opportunity->mentor_area === $area->id) ? 'checked="checked"' : ''; ?>>
                                    <label for="area_<?php echo $area->id; ?>"><?php echo $area->name; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="error-box extra"><?php _e('You have to choose Area of Expertise', 'purpozed'); ?></div>
                    </div>
                    <div class="row column textarea-items">
                        <div class="text"><?php _e('What do you expect from your coming mentor?', 'purpozed'); ?></div>
                        <div class="text"><?php _e('When will this mentorship be an success for you?', 'purpozed'); ?></div>
                        <div class="opportunity-textarea"><textarea class="charNum"
                                                                    data-max="600"
                                                                    maxlength="600"
                                                                    name="expectations"
                                                                    data-validation="expectations"><?php echo (isset($opportunity->expectations)) ? stripslashes($opportunity->expectations) : ''; ?></textarea>
                            <div class="error-box extra"><?php _e('This field can not be empty and must have max 600 characters', 'purpozed'); ?></div>
                        </div>
                        <div class="small-text"><?php _e('Max. 600 characters', 'purpozed'); ?></div>
                        <div class="small-text counter">0/600</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="step-button next mentoring-aoe"><?php _e('NEXT', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section not-first">
            <div class="row post-item">
                <div class="medium-header"><?php _e('Please type in your expectation concerning frequency, duration and time frame of the mentorship', 'purpozed'); ?></div>
            </div>
            <div class="row time-row">
                <div class="time-column">
                    <div class="row project-task">
                        <div class="select-header"><?php _e('Meeting Frequency', 'purpozed'); ?></div>
                        <div class="search search-mentoring">
                            <select name="frequency" class="search-type">
                                <option value="1" <?php echo (isset($opportunity->frequency) && $opportunity->frequency === '1.00') ? 'selected="selected"' : ''; ?>><?php _e('Every week', 'purpozed'); ?></option>
                                <option value="0.5" <?php echo (isset($opportunity->frequency) && $opportunity->frequency === '0.50') ? 'selected="selected"' : ''; ?>><?php _e('Every two weeks', 'purpozed'); ?></option>
                                <option value="0.25" <?php echo (isset($opportunity->frequency) && $opportunity->frequency === '0.25') ? 'selected="selected"' : ''; ?>><?php _e('Every month', 'purpozed'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="time-column">
                    <div class="row project-task">
                        <div class="select-header"><?php _e('Duration per Meeting', 'purpozed'); ?></div>
                        <div class="search search-mentoring">
                            <select name="duration" class="search-type">
                                <option value="1" <?php echo (isset($opportunity->duration) && $opportunity->duration === '1') ? 'selected="selected"' : ''; ?>><?php _e('1 hour', 'purpozed'); ?></option>
                                <option value="2" <?php echo (isset($opportunity->duration) && $opportunity->duration === '2') ? 'selected="selected"' : ''; ?>><?php _e('2 hours', 'purpozed'); ?></option>
                                <option value="3" <?php echo (isset($opportunity->duration) && $opportunity->duration === '3') ? 'selected="selected"' : ''; ?>><?php _e('3 hours', 'purpozed'); ?></option>
                                <option value="4" <?php echo (isset($opportunity->duration) && $opportunity->duration === '4') ? 'selected="selected"' : ''; ?>><?php _e('4 hours', 'purpozed'); ?></option>
                                <option value="5" <?php echo (isset($opportunity->duration) && $opportunity->duration === '5') ? 'selected="selected"' : ''; ?>><?php _e('5 hours', 'purpozed'); ?></option>
                                <option value="6" <?php echo (isset($opportunity->duration) && $opportunity->duration === '6') ? 'selected="selected"' : ''; ?>><?php _e('6 hours', 'purpozed'); ?></option>
                                <option value="7" <?php echo (isset($opportunity->duration) && $opportunity->duration === '7') ? 'selected="selected"' : ''; ?>><?php _e('7 hours', 'purpozed'); ?></option>
                                <option value="8" <?php echo (isset($opportunity->duration) && $opportunity->duration === '8') ? 'selected="selected"' : ''; ?>><?php _e('8 hours', 'purpozed'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="time-column">
                    <div class="row project-task">
                        <div class="select-header"><?php _e('Time frame at least', 'purpozed'); ?></div>
                        <div class="search search-mentoring">
                            <select name="time_frame" class="search-type">
                                <option value="12" <?php echo (isset($opportunity->time_frame) && $opportunity->time_frame === '12') ? 'selected="selected"' : ''; ?>><?php _e('12 weeks', 'purpozed'); ?></option>
                                <option value="24" <?php echo (isset($opportunity->time_frame) && $opportunity->time_frame === '24') ? 'selected="selected"' : ''; ?>><?php _e('24 weeks', 'purpozed'); ?></option>
                                <option value="48" <?php echo (isset($opportunity->time_frame) && $opportunity->time_frame === '48') ? 'selected="selected"' : ''; ?>><?php _e('48 week', 'purpozed'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row post-item">
                <div class="medium-header">
                    <div><?php _e('Total time requirement at least', 'purpozed'); ?></div>
                    <div class="header"><span id="curr_hours">12</span> <?php _e('hours', 'purpozed'); ?></div>
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
                <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                <div class="step-button next mentoring-time"><?php _e('NEXT', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section not-first">
            <div class="row post-item">
                <div class="medium-header"><?php _e('Who will participate in the Mentoring', 'purpozed'); ?>?</div>
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
                <div class="step-button next mentoring contact"><?php _e('PREVIEW', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section <?php echo ($status === 'review' || $status === 'prepared') ? '' : 'not-first'; ?> preview">
            <div class="columns">
                <div class="column">
                    <input type="hidden" name="task_type" value="mentoring">
                    <input type="hidden" name="organization_id" value="1">
                    <input type="hidden" name="opportunity_id" value="<?php echo $editedOpportunityId; ?>">
                    <div class="hidden-data"></div>
                    <div class="row buttons-box">
                        <?php if (!isset($opportunity)): ?>
                            <div class="done-button next skills"><input class="step-button" type="submit" name="post"
                                                                        value="<?php _e('POST THE MENTORING', 'purpozed'); ?>">
                            </div>
                            <div class="done-button next skills"><input class="step-button" type="submit" name="save"
                                                                        value="<?php _e('SAVE AND POST LATER', 'purpozed'); ?>">
                            </div>
                            <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>

                        <?php elseif ($opportunity->status === 'prepared'): ?>
                            <div class="done-button next skills"><input class="step-button" type="submit" name="post"
                                                                        value="<?php _e('POST THE MENTORING', 'purpozed'); ?>">
                            </div>
                            <div class="done-button next skills"><input class="step-button" type="submit" name="save"
                                                                        value="<?php _e('SAVE AND POST LATER', 'purpozed'); ?>">
                            </div>
                            <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                        <?php endif; ?>
                        <?php if (isset($opportunity)): ?>
                            <?php if ($opportunity->status === 'prepared' || $opportunity->status === 'review'): ?>
                                <div class="edit">
                                    <button data-task="apply" type="button"
                                            class="modal-delete-opportunity-button step-button"><?php _e('DELETE', 'purpozed'); ?></button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (isset($opportunity)): ?>
                            <?php if ($opportunity->status === 'review'): ?>
                                <div class='matched-opportunity-box post'>
                                    <p><?php _e('Under review. You have posted this mentoring and we are about to check and publish it within 24 hours.', 'purpozed'); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="modal delete-opportunity-ask">
                        <div class="modal-overlay modal-apply-button"></div>
                        <div class="modal-wrapper modal-transition">
                            <div class="modal-header">
                                <h2 class="modal-heading"><?php _e('Delete opportunity', 'purpozed'); ?>
                                    ?</h2>
                            </div>
                            <div class="modal-body">
                                <div class="modal-content">
                                    <P><?php _e('You want to delete this opportunity', 'purpozed'); ?>?</P>
                                    <button class="modal-edit delete-opportunity-confirm" type="button"
                                            data-id="<?php echo $opportunity->task_id; ?>"><?php _e('DELETE OPPORTUNITY', 'purpozed'); ?></button>
                                    <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal delete-opportunity">
                        <div class="modal-wrapper modal-transition">
                            <div class="modal-header">
                                <h2 class="modal-heading"><?php _e('The Opportunity has beed deleted sucessfully', 'purpozed'); ?>
                                    !</h2>
                            </div>
                            <div class="modal-body">
                                <div class="modal-content">
                                    <button type="button"
                                            class="modal-edit modal-edit go-dashboard"><?php _e('CLOSE', 'purpozed'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column preview">
                    <?php if (isset($opportunity)): ?>
                        <div class="statuses">
                            <div class="fc-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
                        </div>
                    <?php else: ?>
                        <div class="preview-header-box"><?php _e('Preview', 'purpozed'); ?></div>
                    <?php endif; ?>
                    <div class="medium-header prev-header"><?php _e('Mentoring', 'purpozed'); ?>
                        <?php if (isset($opportunity)): ?>
                            + <?php echo $opportunity->aoe_name; ?>
                        <?php endif; ?>
                        <span></span></div>
                    <div class="image">
                        <?php if (isset($opportunity)): ?>
                            <img src="<?php echo wp_get_attachment_image_src($opportunity->image, 'large')[0]; ?>">
                            <div class="image_caption"><?php echo (isset($opportunity->image_caption)) ? $opportunity->image_caption : ''; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="text"><?php _e('Posted', 'purpozed'); ?><?php echo date('d/m/Y'); ?></div>
                    <div class="small-header"><?php _e('Needed Expertise', 'purpozed'); ?></div>
                    <div class="skills prev-skills">
                        <div class="single-skill">
                            <?php if (isset($opportunity)): ?>
                                <?php echo $opportunity->aoe_name; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="small-header"><?php _e('Expectations', 'purpozed'); ?></div>
                    <div class="text prev-expectations">
                        <?php if (isset($opportunity)): ?>
                            <?php echo $opportunity->expectations; ?>
                        <?php endif; ?>
                    </div>
                    <div class="small-header"><?php _e('Duration & Time Frame', 'purpozed'); ?></div>
                    <div class="text prev-duration-box">
                        <div class="prev-medium-header-smaller prev-at-least"><?php _e('Time requirement at least', 'purpozed'); ?>
                            <span>
                            <?php if (isset($opportunity)): ?>
                                <?php echo ' ' . $duration_overall . ' '; ?><?php _e('hours', 'purpozed'); ?>
                            <?php endif; ?>
                            </span>
                        </div>
                        <div class="text prev-frequency">
                            <?php _e('Meeting Frequency', 'purpozed'); ?>
                            :<span><?php if (isset($opportunity)): ?><?php echo ' ' . $frequency; ?><?php endif; ?></span>
                        </div>
                        <div class="text prev-duration">
                            <?php _e('Duration per Meeting', 'purpozed'); ?>
                            : <span><?php if (isset($opportunity)): ?>

                                    <?php echo $opportunity->duration; ?><?php echo ($opportunity->duration === '1') ? _e(' hour', 'purpozed') : _e(' hours', 'purpozed'); ?>

                                <?php endif; ?>
                                </span>

                        </div>
                        <div class="text prev-time-frame">
                            <?php _e('Time frame at least', 'purpozed'); ?>

                            : <span>
                                <?php if (isset($opportunity)): ?><?php echo $time_frame; ?><?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <div class="small-header"><?php _e('About the organization', 'purpozed'); ?></div>
                    <div class="text"><?php echo $organizationDetails['description'][0]; ?></div>
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
    </div>
</form>
