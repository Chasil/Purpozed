<?php
/*
Template Name: Register Organization
*/
?>
<?php get_header();
?>

    <div class="login-bar">
        <a href="/"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo.svg"></a>
    </div>

    <form class="register-organization" method="post" action="" ENCTYPE="multipart/form-data">
        <div class="register">
            <div class="register-header main-head"><?php _e('Signup organization', 'purpozed'); ?></div>
            <?php if (!empty($errors)): ?>
                <?php if ($errors[0] = 'email-exists'): ?>
                    <div class="error-box error-box-on extra"><?php _e('Email or login already exists.', 'purpozed'); ?>
                        &nbsp<a href="/password-reset/"><?php _e('Forgot your password?', 'purpozed'); ?></a></div>
                <?php elseif ($errors[0] = 'existing_user_login'): ?>
                    <div class="error-box error-box-on extra"><?php _e('Username already exists', 'purpozed'); ?></a></div>
                <?php else: ?>
                    <div class="error-box extra">
                        <?php foreach ($errors as $error): ?>
                            <div class="error-box error-box-on extra"><?php _e('Creating account error. Please try again or contact us', 'purpozed'); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="row steps">
                <div class="step step-point active">
                    <div class="step-text"><?php _e('Organization', 'purpozed'); ?></div>
                </div>
                <div class="step step-line">
                    <div></div>
                </div>
                <div class="step step-point">
                    <div class="step-text"><?php _e('Goals', 'purpozed'); ?></div>
                </div>
                <div class="step step-line">
                    <div></div>
                </div>
                <div class="step step-point">
                    <div class="step-text"><?php _e('Contact Person', 'purpozed'); ?></div>
                </div>
            </div>
            <div class="section first">
                <div class="row row-item">
                    <div class="register-item">
                        <label><span><?php _e('NAME OF THE ORGANIZATION WITH LEGAL FORM', 'purpozed'); ?></span><input
                                    type="text" name="organization_name"
                                    value="<?php echo (isset($_POST['organization_name'])) ? $_POST['organization_name'] : ''; ?>">
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('STREET, NUMBER', 'purpozed'); ?></span><input type="text" name="street"
                                                                                             value="<?php echo (isset($_POST['street'])) ? $_POST['street'] : ''; ?>"
                                                                                             data-validation="street">
                            <div class="error-box"><?php _e('Street must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('ZIP CODE', 'purpozed'); ?></span><input type="text" name="zip"
                                                                                       value="<?php echo (isset($_POST['zip'])) ? $_POST['zip'] : ''; ?>"
                                                                                       data-validation="zip">
                            <div class="error-box"><?php _e('Zip Code can not be empty', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('CITY', 'purpozed'); ?></span><input type="text" name="city"
                                                                                   value="<?php echo (isset($_POST['city'])) ? $_POST['city'] : ''; ?>"
                                                                                   data-validation="city">
                            <div class="error-box"><?php _e('City must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('WEBSITE URL', 'purpozed'); ?></span><input type="text" name="website"
                                                                                          value="<?php echo (isset($_POST['website'])) ? $_POST['website'] : ''; ?>"
                                                                                          data-validation="website">
                            <div class="error-box"><?php _e('Website link seems incorrect', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item about textarea-items">
                        <label class="text"><?php _e('About', 'purpozed'); ?><textarea name="about"
                                                                                       data-validation="about"><?php echo (isset($_POST['about'])) ? $_POST['about'] : ''; ?></textarea>
                            <div class="error-box"><?php _e('About must have max 500 characters and can not be empty', 'purpozed'); ?></div>
                            <div class="small-text"><?php _e('Max. 500 characters', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item logo">
                        <label class="text"><?php _e('Profile image', 'purpozed'); ?>
                            <div class="upload-image-box">
                                <div id="thumb-output"></div>
                                <div class="uploaded-image"></div>
                                <div>
                                    <label for="file-input"><input name="image" type="file" id="file-input"
                                                                   multiple/><?php _e('LOGO UPLOAD', 'purpozed'); ?>
                                    </label>
                                    <!--                                    <div class="small-text">Excepteur sint occaecat cupidatat non proident, sunt in-->
                                    <!--                                        culpa qui officia deserunT:-->
                                    <!--                                    </div>-->
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="step-button next organization"><?php _e('NEXT', 'purpozed'); ?></div>
                </div>
            </div>
            <div class="section not-first">
                <div class="row">
                    <span class="topic"><?php _e('Please select the sustainable development goals of your organization', 'purpozed'); ?></span>
                </div>
                <div class="row row-item">
                    <?php $i = 0; ?>
                    <?php foreach ($goals as $goal): ?>
                        <div class="goal-row">
                            <div class="goal-item main-goal">
                                <div class="column-header"><?php ($i === 0) ? _e('Choose one main Goal', 'purpozed') : ''; ?></div>
                                <input type="radio" name="main_goal" value="<?php echo $goal['id']; ?>"
                                       id="main_<?php echo $goal['id']; ?>" class="main-goal" disabled="disabled">
                                <label for="main_<?php echo $goal['id']; ?>"></label>
                            </div>
                            <div class="goal-item register-checkbox">
                                <div class="column-header"><?php echo ($i === 0) ? _e('Choose at least one goal', 'purpozed') : ''; ?></div>
                                <input type="checkbox" id="goal_<?php echo $goal['id']; ?>"
                                       name="goals[<?php echo $goal['id']; ?>]" class="some-goals"
                                       data-id="<?php echo $goal['id']; ?>">
                                <label
                                        for="goal_<?php echo $goal['id']; ?>"> <?php echo $goal['name']; ?></label>
                            </div>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                    <div class="error-box extra main-goal-error"><?php _e('Please check at least 1 Main Goal', 'purpozed'); ?></div>
                    <div class="error-box extra goal-error"><?php _e('Please check at least 1 Goal', 'purpozed'); ?></div>
                </div>
                <div class="row">
                    <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                    <div class="step-button next organization-goals"><?php _e('NEXT', 'purpozed'); ?></div>
                </div>
            </div>
            <div class="section contact not-first">
                <div class="row row-item">
                    <div class="register-item">
                        <label><span><?php _e('YOUR FORENAME', 'purpozed'); ?></span><input type="text" name="forename"
                                                                                            value="<?php echo (isset($_POST['forename'])) ? $_POST['forename'] : ''; ?>"
                                                                                            data-validation="forename">
                            <div class="error-box"><?php _e('Forename must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('YOUR SURNAME', 'purpozed'); ?></span><input type="text" name="surname"
                                                                                           value="<?php echo (isset($_POST['surname'])) ? $_POST['surname'] : ''; ?>"
                                                                                           data-validation="surname">
                            <div class="error-box"><?php _e('Surname must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('YOUR JOB TITLE WITHIN THE ORGANIZATION', 'purpozed'); ?></span><input
                                    type="text" name="title"
                                    value="<?php echo (isset($_POST['title'])) ? $_POST['title'] : ''; ?>"
                                    data-validation="title">
                            <div class="error-box"><?php _e('Title must contain letters only (min: 2, max: 30)', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('EMAIL ADDRESS (PROFESSIONAL) = USERNAME', 'purpozed'); ?></span><input
                                    type="email" name="email"
                                    value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>"
                                    data-validation="email">
                            <div class="error-box"><?php _e('Invalid email', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('PHONE NUMBER (PROFESSIONAL)', 'purpozed'); ?></span><input type="text"
                                                                                                          name="phone"
                                                                                                          value="<?php echo (isset($_POST['phone'])) ? $_POST['phone'] : ''; ?>"
                                                                                                          data-validation="phone">
                            <div class="error-box"><?php _e('Phone number must contain only numbers and + sign (min: 8, max: 15 chars)', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('PASSWORD', 'purpozed'); ?></span><input type="password" name="password"
                                                                                       value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ''; ?>"
                                                                                       data-validation="password">
                            <div class="error-box"><?php _e('Password must have from 8 to 16 characters', 'purpozed'); ?></div>
                        </label>
                    </div>
                    <div class="register-item">
                        <label><span><?php _e('REPEAT PASSWORD', 'purpozed'); ?></span><input type="password"
                                                                                              name="repeat_password"
                                                                                              value="<?php echo (isset($_POST['repeat_password'])) ? $_POST['repeat_password'] : ''; ?>"
                                                                                              data-validation="passwords_match">
                            <div class="error-box"><?php _e('Passwords missmatch', 'purpozed'); ?></div>
                        </label>
                    </div>
                </div>
                <div class="terms">
                    <div class="row terms-checkbox">
                        <input type="checkbox" name="contact_me" id="help">
                        <label for="help"><?php _e('Please contact me and explain me how we can make the most of the platform', 'purpozed'); ?></label>
                    </div>
                    <div class="row terms-checkbox">
                        <input type="checkbox" name="terms" id="terms-id">
                        <?php
                        $link1 = "<a href='/agb-organisationen/' target='_blank'>";
                        $link2 = "<a href='/datenschutz/' target='_blank'>";
                        $linkEnd = "</a>";
                        ?>
                        <label for="terms-id"><?php printf(__('I accept the %s terms and conditions %s and the %s private policy %s', 'purpozed'), $link1, $linkEnd, $link2, $linkEnd); ?></label>
                        <div class="error-box"><?php _e('You have to confirm terms and conditions', 'purpozed'); ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                    <div class="done-button next organization-contact"><input class="step-button" type="submit"
                                                                              name="submit" value="SIGNUP"></div>
                </div>
            </div>
        </div>
    </form>

    <div class="dashboard-menu footer">
        <?php $signInFooter = get_option('purpozed_sign_in_footer'); ?>
        <div class="menu-bar footer">
            <?php if ($signInFooter): ?>
                <?php wp_nav_menu(array('menu' => $signInFooter)); ?>
            <?php else: ?>
                <div class="info-box"><?php _e('Menu for this section is not setup.', 'purpozed'); ?></div>
            <?php endif; ?>
        </div>
    </div>

<?php get_footer();