<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/company/header.php');
?>

<form action="" method="post" ENCTYPE="multipart/form-data">
    <div class="edit-profie organization-profile">
        <div class="edit-header"><?php _e('Company Settings', 'purpozed'); ?></div>
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
                        <div class="item active" id="profile_info"><?php _e('Profile Settings', 'purpozed'); ?></div>
                        <!--                        <div class="item" id="account">-->
                        <?php //_e('Account', 'purpozed'); ?><!--</div>-->
                    </div>
                </div>
                <div class="items button">
                    <div class="">
                        <button type="submit" class="diff-butt"><?php _e('SAVE', 'purpozed'); ?></button>
                    </div>
                </div>
            </div>
            <div class="single-column third section" id="profile_info_section">
                <div class="left-side">
                    <div class="text-1"><?php _e('Profile Image', 'purpozed'); ?></div>
                    <div class="current-user-image"><img
                                src="<?php echo wp_get_attachment_image_src($details['logo'][0])[0]; ?>"></div>
                    <div class="upload-image-box">
                        <div id="thumb-output"></div>
                        <div class="uploaded-image"></div>
                        <div class="image-input-box">
                            <label for="file-input"><input name="image" type="file" id="file-input"
                                                           multiple/><?php _e('LOGO UPLOAD', 'purpozed'); ?></label>
                        </div>
                    </div>
                    <div class="column inputs">
                        <div class="register-item">
                            <label><span><?php _e('COMPANY NAME', 'purpozed'); ?></span><input type="text"
                                                                                               name="first_name"
                                                                                               value="<?php echo $details['first_name'][0]; ?>"
                                                                                               data-validation="forename">
                                <div class="error-box"><?php _e('Forename must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('COMPANY ID', 'purpozed'); ?></span><input type="text"
                                                                                             name="company_id"
                                                                                             value="<?php echo $details['company_id'][0]; ?>"
                                                                                             disabled="disabled">
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
                            <label><span><?php _e('PHONE NUMBER', 'purpozed'); ?></span><input type="text" name="phone"
                                                                                               value="<?php echo (isset($details['phone'][0])) ? $details['phone'][0] : ''; ?>"
                                                                                               data-validation="phone">
                                <div class="error-box"><?php _e('Phone number must contain only numbers and + sign (min: 8, max: 15 chars)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('INVITED VOLUNTEERS', 'purpozed'); ?></span><input type="number"
                                                                                                     name="invited_users"
                                                                                                     value="<?php echo (isset($details['invited_users'][0])) ? $details['invited_users'][0] : '0' ?>">
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
                        <?php $count = 0; ?>
                        <?php foreach ($links as $link): ?>
                            <div class="register-item">
                                <label class="text">
                                    <span><?php _e('URL', 'purpozed'); ?></span>
                                    <div class="input_and_button">
                                        <input type="text" name="links[<?php echo $count; ?>][url]"
                                               value="<?php echo $link->url; ?>">
                                        <div class="remove_social_media_button delete_social_media_link"><span>-</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="text">
                                    <span><?php _e('NAME OF SOCIAL MEDIA PLATFORM', 'purpozed'); ?></span>
                                    <div class="input_and_button">
                                        <input type="text" name="links[<?php echo $count; ?>][name]"
                                               value="<?php echo $link->name; ?>">
                                        <div class="remove_social_media_button delete_social_media_link"><span>-</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                        <div class="add_rounded_button add_social_media"><span>+</span></div>
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