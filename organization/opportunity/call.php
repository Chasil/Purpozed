<?php require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/opportunity/top-bar.php'); ?>
<form class="register-call" method="post" action="" id="post-opportunity">
    <div class="register">
        <div class="register-header"><img
                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/call.svg"><?php _e('Post a call', 'purpozed'); ?>
        </div>
        <div class="row steps">
            <div class="step step-point <?php echo ($status === 'review' || $status === 'prepared') ? '' : 'active'; ?>">
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
            <div class="step step-point <?php echo ($status === 'review' || $status === 'prepared') ? 'active' : ''; ?>">
                <div class="step-text"><?php _e('Preview', 'purpozed'); ?></div>
            </div>
        </div>
        <div class="section <?php echo ($status === 'review' || $status === 'prepared') ? 'not-first' : ''; ?>">
            <div class="row row-item">
                <div class="post-item topic">
                    <div class="row">
                        <div class="medium-header"><?php _e('Please select the Topic of your Call', 'purpozed'); ?></div>
                    </div>
                    <div class="row aoe-items">
                        <div class="expertises">
                            <?php foreach ($areas_of_expertise as $area): ?>
                                <div class="single-expertise call <?php echo ($areas_of_expertise[0]->id === $area->id) ? 'active' : ''; ?>"
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
                    <div class="row column row-inline">
                        <div class="text">
                            <?php _e("Didn't find your topic above? Please contact Administrator", 'purpozed'); ?>
                        </div>
                        <div>
                            <button type="button" data-task="email"
                                    class="modal-email-button step-button"><?php _e('Click here', 'purpozed'); ?></button>
                        </div>
                    </div>
                    <div class="row column textarea-items">
                        <div class="text"><?php _e('Brief description', 'purpozed'); ?></div>
                        <div class="opportunity-textarea"><textarea id="brief-description"
                                                                    disabled="disabled"><?php echo (isset($description)) ? $description[0]->call_description : ''; ?></textarea>
                        </div>
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
                    <?php foreach ($focuses as $currentFocus): ?>
                        <div class="single-item" data-focus="<?php echo $currentFocus->id; ?>">
                            <input type="radio" id="focus_<?php echo $currentFocus->id; ?>" name="focus[]"
                                   value="<?php echo $currentFocus->id; ?>"
                                   data-focus="<?php echo $currentFocus->name; ?>" <?php echo ($focusId === $currentFocus->id) ? 'checked="checked"' : ''; ?> >
                            <label for="focus_<?php echo $currentFocus->id; ?>"><?php echo $currentFocus->name; ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="error-box extra"><?php _e('You have to choose one Focus', 'purpozed'); ?></div>
                </div>
            </div>
            <div class="row column textarea-items">
                <div class="text"><?php _e('In short: What is the main goal of your call', 'purpozed'); ?>?</div>
                <div class="opportunity-textarea"><textarea class="charNum" data-max="600"
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
        <div class="section <?php echo ($status === 'review' || $status === 'prepared') ? '' : 'not-first'; ?> preview">
            <div class="columns">
                <div class="column">
                    <input type="hidden" name="task_type" value="call">
                    <input type="hidden" name="organization_id" value="1">
                    <input type="hidden" name="opportunity_id" value="<?php echo $editedOpportunityId; ?>">
                    <div class="hidden-data"></div>
                    <div class="row buttons-box">
                        <?php if (!isset($opportunity)): ?>
                            <div class="done-button next skills"><input class="step-button" type="submit" name="post"
                                                                        value="<?php _e('POST THE CALL', 'purpozed'); ?>">
                            </div>
                            <div class="done-button next skills"><input class="step-button" type="submit" name="save"
                                                                        value="<?php _e('SAVE AND POST LATER', 'purpozed'); ?>">
                            </div>
                            <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>

                        <?php elseif ($opportunity->status === 'prepared'): ?>
                            <div class="done-button next skills"><input class="step-button" type="submit" name="post"
                                                                        value="<?php _e('POST THE CALL', 'purpozed'); ?>">
                            </div>
                            <div class="done-button next skills"><input class="step-button" type="submit" name="save"
                                                                        value="<?php _e('SAVE AND POST LATER', 'purpozed'); ?>">
                            </div>
                            <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                        <?php endif; ?>
                        <?php if (isset($opportunity)): ?>
                            <?php if ($opportunity->status === 'prepared' || $opportunity->status === 'review'): ?>
                                <div class="edit">
                                    <button data-id="<?php echo $opportunity->id; ?>" data-task="apply" type="button"
                                            class="modal-delete-opportunity-button step-button"><?php _e('DELETE', 'purpozed'); ?></button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (isset($opportunity)): ?>
                            <?php if ($opportunity->status === 'prepared'): ?>
                                <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (isset($opportunity)): ?>
                            <?php if ($opportunity->status === 'review'): ?>
                                <div class='matched-opportunity-box post'>
                                    <p><?php _e('Under review. You have posted this call and we are about to check and publish it within 24 hours.', 'purpozed'); ?></p>
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
                                            data-id="<?php echo $opportunity->o_id; ?>"><?php _e('DELETE OPPORTUNITY', 'purpozed'); ?></button>
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
                    <div class="medium-header prev-header">
                        <?php if (isset($opportunity)): ?>
                            <?php echo $focus[0]->name; ?>
                            <?php echo ': ' . $topic->name; ?>
                        <?php endif; ?>
                    </div>
                    <div class="image">
                        <?php if (isset($opportunity)): ?>
                            <img src="<?php echo wp_get_attachment_image_src($opportunity->image, 'large')[0]; ?>">
                            <div class="image_caption"><?php echo (isset($opportunity->image_caption)) ? $opportunity->image_caption : ''; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="text"><?php _e('Posted', 'purpozed'); ?><?php echo date('d/m/Y'); ?></div>
                    <div class="small-header"><?php _e('Needed Skills', 'purpozed'); ?></div>
                    <div class="skills prev-skills">
                        <?php if (isset($opportunity)): ?>
                            <?php foreach ($skills as $skill): ?>
                                <div class="single-skill"><?php echo $skill->name; ?></div>
                                <input type="hidden" name="skills[]" value="<?php echo $skill->id; ?>">
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="small-header"><?php _e('Duration & Time Frame', 'purpozed'); ?></div>
                    <div class="text prev-duration"><?php _e('Approx 1 hour', 'purpozed'); ?></div>
                    <div class="text prev-description"></div>
                    <div class="small-header"><?php _e('Main focus of the Call', 'purpozed'); ?>
                    </div>
                    <div class="text prev-focus">
                        <?php if (isset($opportunity)): ?>
                            <?php echo $focus[0]->name; ?>
                        <?php endif; ?>
                    </div>
                    <div class="small-header"><?php _e('Goal of the Call', 'purpozed'); ?></div>
                    <div class="text prev-goal">
                        <?php if (isset($opportunity)): ?>
                            <?php echo $opportunity->goal; ?>
                        <?php endif; ?>
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
    </div>
</form>

<div class="modal email">
    <div class="modal-overlay modal-apply-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('If you would like to add a new Topic to the list kindly contact Administrator. Your request will be verified and if positively, it will soon appear possible to be chosen on the list. You will find the contact information enclosed below.', 'purpozed'); ?>
                !</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <P><?php _e('Email', 'purpozed'); ?>
                    : <?php echo 'support@purpozed.org'; ?></P>
                <button class="modal-edit"><a
                            href="mailto:support@purpozed.org"
                            target="_blank"><?php _e('WRITE AN EMAIL', 'purpozed'); ?></a>
                </button>
                <button class="modal-close modal-edit"><?php _e('CLOSE', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>