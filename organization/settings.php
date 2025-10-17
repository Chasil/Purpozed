<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/header.php');
?>

    <form action="" method="post" ENCTYPE="multipart/form-data" class="form-save-organization-settings">
        <div class="edit-profie organization-profile">
            <div class="edit-header"><?php _e('Organization Settings', 'purpozed'); ?></div>
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
                            <div class="item" id="account"><?php _e('Account', 'purpozed'); ?></div>
                        </div>
                    </div>
                    <div class="items button">
                        <div class="">
                            <button class="diff-butt save-organization-settings"
                                    type="button"><?php _e('SAVE', 'purpozed'); ?></button>
                        </div>
                    </div>
                </div>
                <div class="single-column third section" id="profile_info_section">
                    <div class="left-side">
                        <div class="column inputs">
                            <div class="register-item">
                                <label><span><?php _e('NAME OF THE ORGANIZATION WITH LEGAL FORM', 'purpozed'); ?></span><input
                                            type="text" name="organization_name"
                                            value="<?php echo $details['organization_name'][0]; ?>">
                                </label>
                            </div>
                            <div class="register-item">
                                <label><span><?php _e('STREET, NUMBER', 'purpozed'); ?></span><input type="text"
                                                                                                     name="street"
                                                                                                     value="<?php echo (isset($details['street'][0])) ? $details['street'][0] : ''; ?>"
                                                                                                     data-validation="street">
                                    <div class="error-box"><?php _e('Street must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
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
                            <div class="register-item">
                                <label><span><?php _e('WEBSITE URL', 'purpozed'); ?></span><input type="text"
                                                                                                  name="website"
                                                                                                  value="<?php echo (isset($details['website'][0])) ? $details['website'][0] : ''; ?>"
                                                                                                  data-validation="website">
                                    <div class="error-box"><?php _e('Website link seems incorrect', 'purpozed'); ?></div>
                                </label>
                            </div>
                        </div>
                        <div class="column inputs">
                            <div class="text-1"><?php _e('About', 'purpozed'); ?></div>
                            <div class="register-item about textarea-items">
                                <label class="text"><textarea class="short-textarea" name="description"
                                                              data-validation="about"><?php echo (isset($details['about'][0])) ? $details['about'][0] : ''; ?></textarea>
                                    <div class="small-text left"><?php _e('Max. 500 characters', 'purpozed'); ?></div>
                                </label>
                            </div>
                        </div>
                        <div class="column inputs">
                            <div class="text-1"><?php _e('Profile image', 'purpozed'); ?></div>
                            <div class="current-user-image"><img
                                        src="<?php echo wp_get_attachment_image_src($details['logo'][0])[0]; ?>"></div>
                            <div class="upload-image-box">
                                <div id="thumb-output"></div>
                                <div class="uploaded-image"></div>
                                <div class="image-input-box">
                                    <label for="file-input"><input name="image" type="file" id="file-input"
                                                                   multiple/><?php _e('LOGO UPLOAD', 'purpozed'); ?>
                                    </label>
                                    <div class="small-text"></div>
                                </div>
                            </div>
                        </div>
                        <div class="column inputs social_media">
                            <div class="text-1"><?php _e('Social Media Links', 'purpozed'); ?></div>
                            <?php $count = 0; ?>
                            <?php foreach ($links as $link): ?>
                                <div class="register-item">
                                    <label class="text">
                                        <span><?php _e('URL', 'purpozed'); ?></span>
                                        <div class="input_and_button">
                                            <input type="text" name="links[<?php echo $count; ?>][url]"
                                                   value="<?php echo $link->url; ?>" data-link="<?php echo $count; ?>">
                                            <div class="remove_social_media_button delete_social_media_link">
                                                <span>-</span>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="text">
                                        <span><?php _e('SOCIAL NETWORK', 'purpozed'); ?></span>
                                        <div class="input_and_button">
                                            <input type="text" name="links[<?php echo $count; ?>][name]"
                                                   value="<?php echo $link->name; ?>" data-link="<?php echo $count; ?>">
                                            <div class="remove_social_media_button delete_social_media_link">
                                                <span>-</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <?php $count++; ?>
                            <?php endforeach; ?>
                            <div class="add_rounded_button add_social_media"><span>+</span></div>
                        </div>
                        <div class="column inputs">
                            <div class="row">
                                <span class="topic-2"><?php _e('Sustainable Development Goals', 'purpozed'); ?></span>
                            </div>
                            <div class="row row-item">
                                <?php $i = 0; ?>
                                <?php foreach ($all_goals as $goal): ?>
                                    <div class="goal-row">
                                        <div class="goal-item main-goal">
                                            <div class="column-header"><?php echo ($i === 0) ? _e('Choose one main Goal', 'purpozed') : ''; ?></div>
                                            <input type="radio" name="main_goal" value="<?php echo $goal['id']; ?>"
                                                   id="main_<?php echo $goal['id']; ?>"
                                                   class="main-goal" <?php echo ($main_goal === $goal['id']) ? 'checked="checked"' : 'disabled="disabled"'; ?>>
                                            <label for="main_<?php echo $goal['id']; ?>"></label>
                                        </div>
                                        <div class="goal-item register-checkbox">
                                            <div class="column-header"><?php echo ($i === 0) ? _e('Choose one goal', 'purpozed') : ''; ?></div>
                                            <input type="checkbox" id="goal_<?php echo $goal['id']; ?>"
                                                   name="goals[<?php echo $goal['id']; ?>] data-id="<?php echo $goal['id']; ?>
                                            ""
                                            class="some-goals" <?php foreach ($goals as $singleGoal) {
                                                echo ($singleGoal->id === $goal['id']) ? 'checked="checked"' : '';
                                            } ?>>
                                            <label for="goal_<?php echo $goal['id']; ?>"> <?php echo $goal['name']; ?></label>
                                        </div>
                                    </div>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                                <div class="error-box extra main-goal-error"><?php _e('Please check at least 1 Main Goal', 'purpozed'); ?></div>
                                <div class="error-box extra goal-error"><?php _e('Please check at least 3 Goals', 'purpozed'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-column third hidden section" id="account_section">
                    <div class="left-side">
                        <div class="column inputs">
                            <div class="register-item">
                                <label><span><?php _e('YOUR FORENAME', 'purpozed'); ?></span><input type="text"
                                                                                                    name="forename"
                                                                                                    value="<?php echo $userMeta['first_name'][0]; ?>"
                                                                                                    data-validation="forename">
                                    <div class="error-box"><?php _e('Forename must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                                </label>
                            </div>
                            <div class="register-item">
                                <label><span><?php _e('YOUR SURNAME', 'purpozed'); ?></span><input type="text"
                                                                                                   name="surname"
                                                                                                   value="<?php echo $userMeta['last_name'][0]; ?>"
                                                                                                   data-validation="surname">
                                    <div class="error-box"><?php _e('Surname must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                                </label>
                            </div>
                            <div class="register-item">
                                <label><span><?php _e('YOUR JOB TITLE WITHIN THE ORGANIZATION', 'purpozed'); ?></span><input
                                            type="text" name="title"
                                            value="<?php echo $userMeta['title'][0]; ?>"
                                            data-validation="title">
                                    <div class="error-box"><?php _e('Title must contain letters only (min: 2, max: 20)', 'purpozed'); ?></div>
                                </label>
                            </div>
                            <div class="register-item">
                                <label><span>E-MAIL</span><input type="text" name="email" value="<?php echo $email; ?>"
                                                                 data-validation="email">
                                    <div class="error-box"><?php _e('Title must contain letters only (min: 2, max: 20)', 'purpozed'); ?></div>
                                </label>
                                <!--                            <div class="row row-item">-->
                                <!--                                <div class="add-button">-->
                                <?php //_e('CONFIRM EMAIL', 'purpozed'); ?><!--</div>-->
                                <!--                            </div>-->
                            </div>
                            <div class="register-item">
                                <label><span><?php _e('PHONE NUMBER PROFFESSIONAL', 'purpozed'); ?></span><input
                                            type="text"
                                            name="phone"
                                            value="<?php echo (isset($details['phone'][0])) ? $details['phone'][0] : ''; ?>"
                                            data-validation="phone">
                                    <div class="error-box"><?php _e('Phone number must contain only numbers and + sign (min: 8, max: 15 chars)', 'purpozed'); ?></div>
                                </label>
                            </div>
                        </div>
                        <div class="text-1 two"><?php _e('Change password', 'purpozed'); ?></div>
                        <div class="column inputs">
                            <div class="register-item">
                                <label><span><?php _e('OLD PASSWORD', 'purpozed'); ?></span><input type="password"
                                                                                                   name="old_password"
                                                                                                   data-validation="password"
                                                                                                   autocomplete="off">
                                    <div class="error-box"><?php _e('Password must have from 8 to 16 characters', 'purpozed'); ?></div>
                                </label>
                            </div>
                            <div class="register-item">
                                <label><span><?php _e('NEW PASSWORD', 'purpozed'); ?></span><input type="password"
                                                                                                   name="password"
                                                                                                   value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ''; ?>"
                                                                                                   data-validation="password"
                                                                                                   autocomplete="off">
                                    <div class="error-box"><?php _e('Password must have from 8 to 16 characters', 'purpozed'); ?></div>
                                </label>
                            </div>
                            <div class="register-item">
                                <label><span><?php _e('REPEAT NEW PASSWORD', 'purpozed'); ?></span><input
                                            type="password"
                                            name="repeat_password"
                                            value="<?php echo (isset($_POST['repeat_password'])) ? $_POST['repeat_password'] : ''; ?>"
                                            data-validation="passwords_match" autocomplete="off">
                                    <div class="error-box"><?php _e('Passwords missmatch', 'purpozed'); ?></div>
                                </label>
                            </div>
                            <div class="register-item">
                                <label><span><?php _e('DELETE ACCOUNT', 'purpozed'); ?></span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/footer.php');
?>