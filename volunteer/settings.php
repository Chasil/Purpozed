<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/header.php');
?>

<form action="" method="post" ENCTYPE="multipart/form-data" id="volunteers-settings-form">
    <div class="edit-profie">
        <div class="edit-header"><?php _e('Volunteer Settings', 'purpozed'); ?></div>
        <?php if (isset($returnData['email'])): ?>
            <?php if ($returnData['email']): ?>
                <div class="success"><?php _e('An Email has been changed. Check your inbox for details', 'purpozed'); ?>
                    .
                </div>
            <?php else: ?>
                <div class="fail"><?php _e('An error occured. An email has not been changed. Try reset it here', 'purpozed'); ?>
                    <a href="/confirmation/"><?php _e('Send confirmation email again', 'purpozed'); ?>.</a></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (isset($returnData['saved'])): ?>
            <?php if ($returnData['saved']): ?>
                <div class="success"><?php _e('Your changes has been saved', 'purpozed'); ?>.</div>
            <?php else: ?>
                <div class="fail"><?php _e('An error occured. Try again', 'purpozed'); ?></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (isset($returnData['old_password'])): ?>
            <?php if (!$returnData['old_password']): ?>
                <div class="fail"><?php _e('Old password incorrect', 'purpozed'); ?></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (isset($returnData['password_reperat'])): ?>
            <?php if (!$returnData['password_reperat']): ?>
                <div class="fail"><?php _e('Passwords missmath', 'purpozed'); ?></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (isset($returnData['password_enhancement'])): ?>
            <?php if (!$returnData['password_enhancement']): ?>
                <div class="fail"><?php _e('Password must have from 8 to 16 characters', 'purpozed'); ?></div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="columns">
            <div class="single-column first menu">
                <div class="items">
                    <div class="menu-items">
                        <div class="item active" id="profile_info"><?php _e('Profile Info', 'purpozed'); ?></div>
                        <div class="item" id="goals_and_skills"><?php _e('Goals & Skills', 'purpozed'); ?></div>
                        <div class="item" id="experience"><?php _e('Experience', 'purpozed'); ?></div>
                        <div class="item" id="account"><?php _e('Account', 'purpozed'); ?></div>
                    </div>
                </div>
                <div class="items button">
                    <div class="">
                        <button type="button" class="diff-butt"
                                id="save-settings"><?php _e('SAVE', 'purpozed'); ?></button>
                    </div>
                </div>
            </div>
            <div class="single-column third section" id="profile_info_section">
                <div class="left-side">
                    <div class="text-1"><?php _e('Profile image', 'purpozed'); ?></div>
                    <div class="current-user-image"><img
                                src="<?php echo (isset($details['image'])) ? wp_get_attachment_image_src($details['image'][0])[0] : ''; ?>">
                    </div>
                    <div class="upload-image-box">
                        <div id="thumb-output"></div>
                        <div class="uploaded-image"></div>
                        <div>
                            <label for="file-input"><input name="image" type="file" id="file-input"
                                                           multiple/><?php _e('SELECT PICTURE', 'purpozed'); ?></label>
                            <!--                            <div class="small-text">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui-->
                            <!--                                officia deserunT:-->
                            <!--                            </div>-->
                        </div>
                    </div>
                    <div class="column inputs">

                        <div class="register-item">
                            <div class="register-item">
                                <label><span><?php _e('JOB TITLE', 'purpozed'); ?></span><input type="text" name="title"
                                                                                                value="<?php echo (isset($details['title'][0])) ? $details['title'][0] : ''; ?>"
                                                                                                data-validation="title">
                                    <div class="error-box"><?php _e('Phone number must contain only numbers and + sign (min: 8, max: 15 chars)', 'purpozed'); ?></div>
                                </label>
                            </div>
                            <label><span><?php _e('FORENAME', 'purpozed'); ?></span><input type="text" name="first_name"
                                                                                           value="<?php echo $details['first_name'][0]; ?>"
                                                                                           data-validation="forename">
                                <div class="error-box"><?php _e('Forename must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('SURNAME', 'purpozed'); ?></span><input type="text" name="last_name"
                                                                                          value="<?php echo $details['last_name'][0]; ?>"
                                                                                          data-validation="surname">
                                <div class="error-box"><?php _e('Surname must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('COMPANY KEY/ID', 'purpozed'); ?></span><input type="text"
                                                                                                 name="company_id"
                                                                                                 value="<?php echo (isset($details['company_id'][0])) ? $details['company_id'][0] : ''; ?>"
                                >
                                <div class="error-box"><?php _e('Company Key/Id may containt numbers only (min: 8, max: 15 chars)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('ZIP CODE', 'purpozed'); ?></span><input type="text" name="zip"
                                                                                           value="<?php echo (isset($details['zip'][0])) ? $details['zip'][0] : ''; ?>"
                                                                                           data-validation="zip">
                                <div class="error-box"><?php _e('Zip Code can not be empty', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('CITY', 'purpozed'); ?></span><input type="text" name="city"
                                                                                       value="<?php echo (isset($details['city'][0])) ? $details['city'][0] : ''; ?>"
                                                                                       data-validation="city">
                                <div class="error-box"><?php _e('City must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="right-side">
                    <div class="text-1"><?php _e('My Status: Ready for request', 'purpozed'); ?>?</div>
                    <div class="button-on settings"><input type="checkbox" name="ready_for_request"
                                                           id="request" <?php echo ($readyForRequest === 'on') ? ' checked="checked"' : ''; ?>><label
                                for="request"
                                class="<?php echo ($readyForRequest === 'on') ? 'checked' : ''; ?>">AUS</label></div>
                    <div class="
                                text-2"><?php _e('ON: Organization can see your profile when they have opportunities that match with your skills and/or Goals and are able to contact you', 'purpozed'); ?>
                        .
                    </div>
                    <div class="text-2"><?php _e('OFF: You are unvisible for organizations but you can apply for opportunities anytime', 'purpozed'); ?>
                        .
                    </div>
                    <div class="text-1"><?php _e('Comments visible', 'purpozed'); ?></div>
                    <div class="button-on settings"><input type="checkbox" name="comments_visible"
                                                           id="comments" <?php echo ($commentsVisible === 'on') ? ' checked="checked"' : ''; ?>><label
                                for="comments"
                                class="<?php echo ($commentsVisible === 'on') ? 'checked' : ''; ?>">AUS</label></div>
                    <div class="
                                text-2"><?php _e('ON: The management of your company can see the comments posted by organizations concerning the opportunities you have completed for them', 'purpozed'); ?>
                        .
                    </div>
                    <div class="text-2"><?php _e('OFF: The management of your company cannot see any comments posted by organizations', 'purpozed'); ?>
                        .
                    </div>
                    <div class="text-1"><?php _e('About me', 'purpozed'); ?></div>
                    <div class="register-item about textarea-items">
                        <label class="text"><textarea name="about"
                                                      data-validation="about"><?php echo (isset($details['about'][0])) ? $details['about'][0] : ''; ?></textarea>
                            <div class="error-box"><?php _e('About must have max 500 characters and can not be empty', 'purpozed'); ?></div>
                            <div class="small-text"><?php _e('Max. 500 characters', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="text-1"><?php _e('Links', 'purpozed'); ?></div>
                    <div class="column">
                        <?php $count = 0; ?>
                        <?php foreach ($links as $link): ?>
                            <div class="register-item links">
                                <label class="text">
                                    <span><?php _e('URL', 'purpozed'); ?></span>
                                    <div class="input_and_button">
                                        <input type="text" name="links[<?php echo $count; ?>][url]"
                                               value="<?php echo $link->url; ?>" data-validation="url">
                                        <div class="remove_social_media_button delete_social_media_link">
                                        </div>
                                    </div>
                                    <div class="error-box"><?php _e('Invalid link', 'purpozed'); ?></div>
                                </label>
                                <label class="text">
                                    <span><?php _e('TITLE', 'purpozed'); ?></span>
                                    <div class="input_and_button">
                                        <input type="text" name="links[<?php echo $count; ?>][name]"
                                               value="<?php echo $link->name; ?>">
                                    </div>
                                </label>
                            </div>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                        <div class="add_rounded_button add_social_media"><span>+</span></div>
                    </div>
                </div>
            </div>
            <div class="single-column third go-columns hidden section" id="goals_and_skills_section">
                <div class="text-1"><?php _e('These are my skills I can help with', 'purpozed'); ?>:</div>
                <div class="row row-item">
                    <?php foreach ($allSkills as $singleSkill): ?>
                        <div class="goal-item register-checkbox">
                            <input class="skills-checkboxes" type="checkbox" id="skill_<?php echo $singleSkill->id; ?>"
                                   name="skills[<?php echo $singleSkill->id; ?>]" <?php foreach ($skills as $skill) {
                                echo ($skill->id === $singleSkill->id) ? ' checked=checked' : '';
                            } ?>>
                            <label for="skill_<?php echo $singleSkill->id; ?>"> <?php echo $singleSkill->name; ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="error-box extra skills"><?php _e('Please check at least 3 goals', 'purpozed'); ?></div>
                </div>
                <div class="text-1"><?php _e('These are Goals I would like to support', 'purpozed'); ?>:</div>
                <div class="row row-item">
                    <?php foreach ($allGoals as $singleGoal): ?>
                        <div class="goal-item register-checkbox larger">
                            <input class="goals-checkboxes" type="checkbox" id="goal_<?php echo $singleGoal['id']; ?>"
                                   name="goals[<?php echo $singleGoal['id']; ?>]" <?php foreach ($goals as $goal) {
                                echo ($goal->id === $singleGoal['id']) ? ' checked=checked' : '';
                            } ?>>
                            <label for="goal_<?php echo $singleGoal['id']; ?>"> <?php echo $singleGoal['name']; ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="error-box extra goals"><?php _e('Please check at least 3 goals', 'purpozed'); ?></div>
                </div>
            </div>
            <div class="single-column third go-columns hidden section" id="experience_section">
                <div class="text-1"><?php _e('Add experiences manually', 'purpozed'); ?></div>
                <?php foreach ($experiences

                as $experience): ?>
                <div class="register-item about textarea-items">
                    <label class="text"><textarea name="experiences[]"
                                                  data-validation="about"><?php echo $experience->text; ?></textarea>
                        <div class="error-box"><?php _e('About must have max 500 characters and can not be empty', 'purpozed'); ?></div>
                        <div class="small-text"><?php _e('Max. 500 characters', 'purpozed'); ?></div>
                    </label>
                    <div class="add_rounded_button remove delete_experience"
                    "><span>-</span>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="add_rounded_button add_experience"><span>+</span></div>
        </div>
        <div class="single-column third hidden section" id="account_section">
            <div class="left-side">
                <div class="text-1"><?php _e('Communication', 'purpozed'); ?></div>
                <div class="column inputs">
                    <div class="register-item">
                        <label><span><?php _e('E-MAIL ADDRESS (=USERNAME)', 'purpozed'); ?></span><input type="text"
                                                                                                         name="email"
                                                                                                         value="<?php echo $email; ?>"
                                                                                                         data-validation="email">
                            <div class="error-box"><?php _e('Title must contain letters only (min: 2, max: 20)', 'purpozed'); ?></div>
                        </label>
                        <!--                            <div class="row row-item">-->
                        <!--                                <div class="add-button">-->
                        <?php //_e('CONFIRM EMAIL', 'purpozed'); ?><!--</div>-->
                        <!--                            </div>-->
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('PHONE NUMBER', 'purpozed'); ?></span><input type="text" name="phone"
                                                                                           value="<?php echo (isset($details['phone'][0])) ? $details['phone'][0] : ''; ?>"
                                                                                           data-validation="phone">
                            <div class="error-box"><?php _e('Phone number must contain only numbers and + sign (min: 8, max: 15 chars)', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label class="delete-account-button"><span><?php _e('DELETE ACCOUNT', 'purpozed'); ?></span></label>

                        <div class="modal delete-account-ask">
                            <div class="modal-overlay modal-delete-account-button"></div>
                            <div class="modal-wrapper modal-transition">
                                <div class="modal-header">
                                    <h2 class="modal-heading"><?php _e('Delete Account', 'purpozed'); ?>
                                        ?</h2>
                                </div>
                                <div class="modal-body">
                                    <p><?php _e('Are you sure you want to delete your account?', 'purpozed'); ?></p>
                                    <p><?php _e('If you delete your account you', 'purpozed'); ?></p>
                                    <p><?php _e('1. you can\'t login any longer with your login data', 'purpozed'); ?></p>
                                    <p><?php _e('2. you can\'t signup again with your email address', 'purpozed'); ?></p>
                                    <p><?php _e('3. you have to send us a message if you want your account to be active again', 'purpozed'); ?></p>
                                    <div class="modal-content">
                                        <button type="button" class="modal-edit delete-account-confirm"
                                                data-user="<?php echo get_current_user_id(); ?>"><?php _e('DELETE ACCOUNT', 'purpozed'); ?></button>
                                        <button type="button"
                                                class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-side">
                <div class="text-1"><?php _e('Change password', 'purpozed'); ?></div>
                <div class="column inputs">
                    <div class="register-item">
                        <label><span><?php _e('CURRENT PASSWORD', 'purpozed'); ?></span><input type="password"
                                                                                               autocomplete="off"
                                                                                               name="old_password"
                                                                                               data-validation="password"
                                                                                               autocomplete="off">
                            <div class="error-box"><?php _e('Password must have from 8 to 16 characters', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('NEW PASSWORD', 'purpozed'); ?></span><input type="password"
                                                                                           autocomplete="off"
                                                                                           name="password"
                                                                                           value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ''; ?>"
                                                                                           data-validation="password"
                                                                                           autocomplete="off">
                            <div class="error-box"><?php _e('Password must have from 8 to 16 characters', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('REPEAT NEW PASSWORD', 'purpozed'); ?></span><input type="password"
                                                                                                  autocomplete="off"
                                                                                                  name="repeat_password"
                                                                                                  value="<?php echo (isset($_POST['repeat_password'])) ? $_POST['repeat_password'] : ''; ?>"
                                                                                                  data-validation="passwords_match"
                                                                                                  autocomplete="off">
                            <div class="error-box"><?php _e('Passwords missmatch', 'purpozed'); ?></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
<div class="dashboard-menu footer">
    <?php $signInFooter = get_option('purpozed_vol_compa_footer'); ?>
    <div class="menu-bar footer">
        <?php global $wp_filter; ?>
        <?php unset($wp_filter['wp_nav_menu_args']); ?>
        <?php if ($signInFooter): ?>
            <?php wp_nav_menu(array('menu' => $signInFooter)); ?>
        <?php else: ?>
            <div class="info-box"><?php _e('Menu for this section is not setup.', 'purpozed'); ?></div>
        <?php endif; ?>
    </div>
    <div class="wpml-ls-statics-footer wpml-ls wpml-ls-legacy-list-horizontal">
        <ul>
            <li class="wpml-ls-slot-footer wpml-ls-item wpml-ls-item-de wpml-ls-current-language wpml-ls-item-legacy-list-horizontal">
                <a href="https://portal.purpozed.org" class="wpml-ls-link">
                    <img class="wpml-ls-flag"
                         src="https://portal.purpozed.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/de.png"
                         alt="Deutsch" width="18" height="12"></a>
            </li>
            <li class="wpml-ls-slot-footer wpml-ls-item wpml-ls-item-en wpml-ls-first-item wpml-ls-item-legacy-list-horizontal">
                <a href="https://portal.purpozed.org/en/" class="wpml-ls-link">
                    <img class="wpml-ls-flag"
                         src="https://portal.purpozed.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                         alt="Englisch" width="18" height="12"></a>
            </li>
        </ul>
    </div>
</div>