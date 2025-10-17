<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/organization/header.php');
?>

<div class="edit-profie">
    <div class="edit-header"><?php _e('Volunteer Profile', 'purpozed'); ?></div>
    <div class="columns">
        <div class="single-column first">
            <div class="volunteer-box-right">
                <div class="picture"><img src="<?php echo wp_get_attachment_image_src($details['image'][0])[0]; ?>">
                </div>
                <div class="data-together">
                    <div class="name"><?php echo $details['first_name'][0] . ' ' . $details['last_name'][0]; ?></div>
                    <div class="job_title v-title"><?php echo $details['title'][0]; ?></div>
                    <div class="corporation v-title"><?php echo $organizationName; ?></div>
                </div>
                <div class="data-together">
                    <div class="succeded v-title"><?php echo $succeededOpportunties . ' '; ?><?php _e('succeeded opportunities', 'purpozed'); ?></div>
                    <div class="hours v-title"><?php echo $helpedHours . ' '; ?><?php _e('hours helped', 'purpozed'); ?></div>
                    <div class="status v-title">Status: <?php if (isset($details['ready_for_request'][0])) {
                            if ($details['ready_for_request'][0] === 'on') {
                                _e('Ready for requests');
                            } else {
                                _e('Not ready for requests', 'purpozed');
                            }
                        } else {
                            _e('Not ready for requests', 'purpozed');
                        } ?> </div>
                </div>
                <div class="buttons">
                    <div class="profile same">
                        <button class="modal-email-button step-button"><?php _e('CONTACT', 'purpozed'); ?></button>
                    </div>
                    <div class="modal email">
                        <div class="modal-overlay modal-apply-button"></div>
                        <div class="modal-wrapper modal-transition">
                            <div class="modal-header">
                                <h2 class="modal-heading"><?php _e('This is the contact information of the volunteer', 'purpozed'); ?>
                                    !</h2>
                            </div>
                            <div class="modal-body">
                                <div class="modal-content">
                                    <P><?php echo $details['first_name'][0] . ' ' . $details['last_name'][0]; ?></P>
                                    <P><?php _e('Telephone', 'purpozed'); ?>
                                        : <?php echo $details['phone'][0]; ?></P>
                                    <P><?php _e('Email', 'purpozed'); ?>: <?php echo $userData->user_email; ?></P>
                                    <button class="modal-edit"><a
                                                href="mailto:<?php echo $userData->user_email; ?>"
                                                target="_blank"><?php _e('WRITE AN EMAIL', 'purpozed'); ?></a>
                                    </button>
                                    <button class="modal-close modal-edit"><?php _e('CLOSE', 'purpozed'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-column second">
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('Skills', 'purpozed'); ?></div>
                </div>
                <div class="skills">
                    <?php foreach ($skills as $skill): ?>
                        <div class="single-skill"><?php echo $skill->name; ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('Goals', 'purpozed'); ?></div>
                </div>
                <div class="skills">
                    <?php foreach ($goals as $goal): ?>
                        <div class="single-skill"><?php echo $goal->name; ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('About me', 'purpozed'); ?></div>
                </div>
                <div class="text-2">
                    <?php echo (isset($details['about'][0])) ? $details['about'][0] : ''; ?>
                </div>
            </div>
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('Experience', 'purpozed'); ?></div>
                </div>
                <div class="text-2">
                    <?php foreach ($experiences as $experience): ?>
                        <div class="link"><?php echo $experience->text; ?></a></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="items-box">
                <div class="items-box-buttons">
                    <div class="text"><?php _e('Links', 'purpozed'); ?></div>
                </div>
                <div class="text-2">
                    <?php foreach ($links as $link): ?>
                        <div class="link"><a href="<?php echo $link->url; ?>"
                                             target="_blank"><?php echo $link->name; ?></a></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

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