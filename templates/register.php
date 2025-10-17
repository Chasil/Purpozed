<?php
/*
Template Name: Register Volunteer
*/
?>
<?php get_header();
?>

    <div class="login-bar">
        <a href="/"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo.svg"></a>
    </div>

    <form class="register" method="post" action="">
        <div class="register">
            <div class="register-header main-head"><?php _e('Signup volunteers', 'purpozed'); ?></div>
            <?php if (!empty($errors)): ?>
                <?php if ($errors[0] === 'email-exists'): ?>
                    <div class="error-box error-box-on extra"><?php _e('Email or Login already exists.', 'purpozed'); ?>
                        &nbsp<a href="/password-reset/"><?php _e('Forgot your password?', 'purpozed'); ?></a></div>
                <?php elseif ($errors[0] === 'existing_user_login'): ?>
                    <div class="error-box error-box-on extra"><?php _e('Username already exists', 'purpozed'); ?></a></div>
                <?php elseif ($errors[0] === 'no-company'): ?>
                    <div class="error-box error-box-on extra"><?php _e('Company ID doesnt exists', 'purpozed'); ?></a></div>
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
                    <div class="step-text"><?php _e('Profile Info', 'purpozed'); ?></div>
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
                    <div class="step-text"><?php _e('Skills', 'purpozed'); ?></div>
                </div>
            </div>
            <div class="section first">
                <div class="row row-item">
                    <div class="col">
                        <div class="register-item">
                            <label><span><?php _e('JOB TITLE', 'purpozed'); ?></span><input type="text"
                                                                                            name="title"
                                                                                            value="<?php echo (isset($_POST['title'])) ? $_POST['title'] : ''; ?>"
                                                                                            data-validation="title">
                                <div class="error-box"><?php _e('Title must contain letters only (min: 2, max: 20)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('FORENAME', 'purpozed'); ?></span><input type="text" name="forename"
                                                                                           value="<?php echo (isset($_POST['forename'])) ? $_POST['forename'] : ''; ?>"
                                                                                           data-validation="forename">
                                <div class="error-box"><?php _e('Forename must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('SURNAME', 'purpozed'); ?></span><input type="text" name="surname"
                                                                                          value="<?php echo (isset($_POST['surname'])) ? $_POST['surname'] : ''; ?>"
                                                                                          data-validation="surname">
                                <div class="error-box"><?php _e('Surname must contain letters only (min: 2, max: 50)', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('PHONE NUMBER', 'purpozed'); ?></span><input type="text" name="phone"
                                                                                               value="<?php echo (isset($_POST['phone'])) ? $_POST['phone'] : ''; ?>"
                                                                                               data-validation="phone">
                                <div class="error-box"><?php _e('Phone number must contain only numbers and + sign (min: 8, max: 15 chars)', 'purpozed'); ?></div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="register-item">
                            <label><span><?php _e('COMPANY KEY/ID (PLEASE ASK YOUR MANAGEMENT)', 'purpozed'); ?></span><input
                                        type="text"
                                        name="company_id"
                                        value="<?php echo (isset($_POST['company_id'])) ? $_POST['company_id'] : ''; ?>"
                                        data-validation="company_id">
                                <div class="error-box"><?php _e('Company ID must contain numbers only', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('EMAIL ADDRESS (= USERNAME)', 'purpozed'); ?></span><input
                                        type="email" name="email"
                                        value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>"
                                        data-validation="email">
                                <div class="error-box"><?php _e('Invalid email', 'purpozed'); ?></div>
                            </label>
                        </div>
                        <div class="register-item">
                            <label><span><?php _e('PASSWORD', 'purpozed'); ?></span><input type="password"
                                                                                           name="password"
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
                </div>
                <div class="row">
                    <div class="step-button next info"><?php _e('NEXT', 'purpozed'); ?></div>
                </div>
            </div>
            <div class="section not-first">
                <div class="row padding-top-50">
                    <span class="header-5"><?php _e('Which sustainability goals do you want to support?', 'purpozed'); ?></span>
                    <span class="header-6"><?php _e('Here you can deselect certain sustainability goals for which you do NOT want to work.', 'purpozed'); ?></span>
                </div>
                <div class="row">
                    <div class="more-info-header">
                        <span class="header-6"><?php _e('More info', 'purpozed'); ?> <img
                                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/arrow_down_light.svg"></span>
                    </div>
                    <div class="more-info-box hideItem">
                        <span class="header-6"><?php _e('At purpozed, we link all volunteering activities to the 17 United Nations Sustainable Development Goals. We take your selection into account when suggesting volunteering activities that match your sustainability goals and skills. You can edit the selection of sustainability goals in your profile at any time.', 'purpozed'); ?></span>
                    </div>
                </div>
                <div class="row row-item">
                    <?php foreach ($goals as $goal): ?>
                        <div class="goal-item register-checkbox">
                            <input type="checkbox" id="goal_<?php echo $goal->id; ?>"
                                   name="goals[<?php echo $goal->id; ?>]" checked="checked">
                            <label for="goal_<?php echo $goal->id; ?>"> <?php echo $goal->name; ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="error-box extra"><?php _e('Please check at least 3 goals', 'purpozed'); ?></div>
                </div>
                <div class="row">
                    <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                    <div class="step-button next goals"><?php _e('NEXT', 'purpozed'); ?></div>
                </div>
            </div>
            <div class="section skills not-first">
                <div class="row padding-top-50">
                    <span class="header-5"><?php _e('Which of your skills could you help with?', 'purpozed'); ?></span>
                    <span class="header-6"><?php _e('Please select your skills that you could use to support non-profit organizations or Sustainable Startups through professional volunteering activities.', 'purpozed'); ?></span>
                </div>
                <div class="row">
                    <div class="more-info-header">
                        <span class="header-6"><?php _e('More info', 'purpozed'); ?> <img
                                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/arrow_down_light.svg"></span>
                    </div>
                    <div class="more-info-box hideItem">
                        <span class="header-6"><?php _e('At purpozed we offer you both social and skills-based volunteering activities. For the skills-based activities you need certain skills. Select your skills here and we can suggest suitable volunteering activities for you. You can edit the selection of skills in your profile at any time.', 'purpozed'); ?></span>
                    </div>
                </div>
                <div class="row row-item">
                    <?php foreach ($skills as $skill): ?>
                        <div class="skill-item register-checkbox">
                            <input class="skills-checkboxes" type="checkbox" id="skill_<?php echo $skill->id; ?>"
                                   name="skills[<?php echo $skill->id; ?>]">
                            <label for="skill_<?php echo $skill->id; ?>"> <?php echo $skill->name; ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="error-box extra"><?php _e('Please check at least 3 skills', 'purpozed'); ?></div>
                </div>
                <div class="terms">
                    <div class="row terms-checkbox">
                        <input type="checkbox" name="contact_me" id="help">
                        <label for="help"><?php _e('Please contact me and explain me how I can make the most of the platform', 'purpozed'); ?></label>
                    </div>
                    <div class="row terms-checkbox">
                        <?php
                        $link1 = "<a href='/nutzungsbedingungen/' target='_blank'>";
                        $link2 = "<a href='/datenschutz/' target='_blank'>";
                        $linkEnd = "</a>";
                        ?>
                        <input type="checkbox" name="terms" id="terms-id">
                        <label for="terms-id"><?php printf(__('I accept the %s terms and conditions %s and the %s private policy %s', 'purpozed'), $link1, $linkEnd, $link2, $linkEnd); ?></label>
                        <div class="error-box"><?php _e('You have to confirm terms and conditions', 'purpozed'); ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="step-button prev"><?php _e('BACK', 'purpozed'); ?></div>
                    <div class="done-button next skills"><input class="step-button" type="submit" name="submit"
                                                                value="<?php _e('SIGNUP', 'purpozed'); ?>"></div>
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