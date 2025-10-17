<?php
require(dirname(__DIR__) . '/dashboard.php');
?>
<h2>Edit company</h2>

<form action="" method="post" ENCTYPE="multipart/form-data">
    <div class="edit-profie organization-profile">
        <div class="edit-header"><?php _e('Company Settings', 'purpozed'); ?></div>
        <?php if (isset($returnData['saved'])): ?>
            <?php if ($returnData['saved']): ?>
                <div class="success"><?php _e('Your changes has been saved', 'purpozed'); ?>.</div>
            <?php else: ?>
                <div class="fail"><?php _e('An error occured. Try again', 'purpozed'); ?></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (isset($returnData['company_id'])): ?>
            <div class="fail"><?php _e('Company ID must contain from 2 to 10 digits only', 'purpozed'); ?></div>
        <?php endif; ?>
        <?php if (isset($returnData['company_id_exists'])): ?>
            <div class="fail"><?php _e('Company ID exists', 'purpozed'); ?></div>
        <?php endif; ?>
        <?php if (isset($returnData['user_exists'])): ?>
            <div class="fail"><?php _e('User name or email exists', 'purpozed'); ?></div>
        <?php endif; ?>
        <?php if (isset($returnData['name_and_email_requested'])): ?>
            <div class="fail"><?php _e('User name and email must be filled', 'purpozed'); ?></div>
        <?php endif; ?>

        <div class="columns">
            <div class="single-column first menu">
                <div class="items">
                    <div class="menu-items">
                        <div class="item active" id="profile_info"><?php _e('Profile Info', 'purpozed'); ?></div>
                        <!--                        <div class="item" id="account">-->
                        <?php //_e('Account', 'purpozed'); ?><!--</div>-->
                    </div>
                </div>
                <div class="items button">
                    <div class="">
                        <button name="submit" type="submit"><?php _e('SAVE', 'purpozed'); ?></button>
                    </div>
                </div>
            </div>
            <div class="single-column third section" id="profile_info_section">
                <div class="left-side">
                    <div class="text-1"><?php _e('Profil photo', 'purpozed'); ?></div>
                    <div class="current-user-image"><img
                                src="<?php echo (isset($details['logo'][0])) ? wp_get_attachment_image_src($details['logo'][0])[0] : ''; ?>">
                    </div>
                    <div class="upload-image-box">
                        <div id="thumb-output"></div>
                        <div class="uploaded-image"></div>
                        <div class="img-box">
                            <label for="file-input"><input name="image" type="file" id="file-input"
                                                           multiple/><?php _e('SELECT PICTURE', 'purpozed'); ?></label>
                        </div>
                    </div>
                    <div class="column inputs">
                        <div class="register-item">
                            <label><span><?php _e('COMPANY NAME', 'purpozed'); ?></span><input type="text"
                                                                                               name="first_name"
                                                                                               value="<?php echo isset($details['first_name'][0]) ? $details['first_name'][0] : ''; ?>"
                                                                                               data-validation="forename">
                                <div class="error-box"><?php _e('Forename must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('COMPANY ID', 'purpozed'); ?></span><input type="text"
                                                                                             name="company_id"
                                                                                             value="<?php echo isset($details['company_id'][0]) ? $details['company_id'][0] : ''; ?>"
                                                                                             data-validation="zip" <?php echo isset($details['company_id'][0]) ? 'disabled="disabled"' : ''; ?>>
                                <div class="error-box"><?php _e('Forename must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
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
                            <label><span><?php _e('WEBSITE URL', 'purpozed'); ?></span><input type="text" name="website"
                                                                                              value="<?php echo (isset($details['website'][0])) ? $details['website'][0] : ''; ?>"
                                                                                              data-validation="website">
                                <div class="error-box"><?php _e('Website link seems incorrect', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('PHONE NUMBER PROFFESSIONAL', 'purpozed'); ?></span><input type="text"
                                                                                                             name="phone"
                                                                                                             value="<?php echo (isset($details['phone'][0])) ? $details['phone'][0] : ''; ?>"
                                                                                                             data-validation="phone">
                                <div class="error-box"><?php _e('Phone number must contain only numbers and + sign (min: 8, max: 15 chars)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('E-MAIL', 'purpozed'); ?></span><input type="text" name="email"
                                                                                         value="<?php echo isset($email) ? $email : ''; ?>"
                                                                                         data-validation="email">
                                <div class="error-box"><?php _e('Title must contain letters only (min: 2, max: 20)', 'purpozed'); ?></div>
                            </label>
                        </div>
                    </div>
                    <div class="column inputs">
                        <div class="text-1"><?php _e('About', 'purpozed'); ?></div>
                        <div class="register-item about textarea-items">
                            <label class="text"><textarea class="short-textarea" name="description"
                                                          data-validation="about"><?php echo (isset($details['description'][0])) ? $details['description'][0] : ''; ?></textarea>
                                <div class="small-text left"><?php _e('Max. 500 characters', 'purpozed'); ?></div>
                            </label>
                        </div>
                    </div>
                    <div class="column inputs social_media">
                        <div class="text-1"><?php _e('Social Media Links', 'purpozed'); ?></div>
                        <?php if (isset($links)): ?>
                            <?php $count = 0; ?>
                            <?php foreach ($links as $link): ?>
                                <div class="register-item">
                                    <label class="text">
                                        <span><?php _e('URL', 'purpozed'); ?></span>
                                        <div class="input_and_button">
                                            <input type="text" name="links[<?php echo $count; ?>][url]"
                                                   value="<?php echo $link->url; ?>">
                                            <div class="remove_social_media_button delete_social_media_link">
                                                <span>-</span></div>
                                        </div>
                                    </label>
                                    <label class="text">
                                        <span><?php _e('TITLE', 'purpozed'); ?></span>
                                        <div class="input_and_button">
                                            <input type="text" name="links[<?php echo $count; ?>][name]"
                                                   value="<?php echo $link->name; ?>">
                                            <div class="remove_social_media_button delete_social_media_link">
                                                <span>-</span></div>
                                        </div>
                                    </label>
                                </div>
                                <?php $count++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div class="add_rounded_button add_social_media"><span>+</span></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>