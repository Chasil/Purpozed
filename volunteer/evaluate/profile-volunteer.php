<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>

<div class="dashboard organization-dashboard evaluation">
    <div class="posted" id="posted">
        <div class="volunteer-box">
            <?php if ($task_type === 'engagement'): ?>
                <?php $volunteerData = $volunteersManager->getCurrentUser($userWhoCompletedOpportunity)->getDetails(); ?>
                <?php $userEmail = get_user_by('id', $userWhoCompletedOpportunity); ?>
            <?php else: ?>
                <?php $volunteerData = $volunteersManager->getCurrentUser($userWhoCompletedOpportunity[0]->user_id)->getDetails(); ?>
                <?php $userEmail = get_user_by('id', $userWhoCompletedOpportunity[0]->user_id); ?>

            <?php endif; ?>
            <div class="single-volunteer colleagues">
                <div class="data profiles-data">
                    <div class="picture"><img
                                src="<?php echo wp_get_attachment_image_src($volunteerData['image'][0], 'medium')[0]; ?>">
                    </div>
                    <div class="details colleagues-details profiles">
                        <div class="name"><?php echo $volunteerData['first_name'][0] . ' '; ?><?php echo $volunteerData['last_name'][0]; ?></div>
                        <div class="job_title"><?php echo $volunteerData['title'][0]; ?></div>
                        <?php $company = new \Purpozed2\Models\Company(); ?>
                        <?php $companyDetails = (($volunteerData['company_id'][0])) ? $company->getDetails($volunteerData['company_id'][0]) : 0; ?>

                        <div class="corporation">
                            <?php if ($companyDetails): ?>
                                <?php echo $companyDetails['first_name'][0]; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                    <?php if ($dashboard_type === 'organization'): ?>
                        <div class="profiles-buttons">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="email"
                                    class="modal-email-button-5 profiles-button"><?php _e('CONTACT', 'purpozed'); ?></button>
                            <a href="<?php echo $language; ?>/volunteer-profile-preview/?id=<?php echo $userId; ?>">
                                <div class="profiles-button"><?php _e('VIEW PROFILE', 'purpozed'); ?></div>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal email-5">
    <div class="modal-overlay modal-apply-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('This is the contact person for this particular opportunity', 'purpozed'); ?>
                !</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <P><?php echo $volunteerData['first_name'][0] . ' ' . $volunteerData['last_name'][0]; ?></P>
                <P><?php _e('Telephone', 'purpozed'); ?>: <?php echo $volunteerData['phone'][0]; ?></P>
                <P><?php _e('Email', 'purpozed'); ?>: <?php echo $userEmail->user_email; ?></P>
                <button class="modal-edit"><a
                            href="mailto:<?php echo $userEmail->user_email; ?>"
                            target="_blank"><?php _e('WRITE AN EMAIL', 'purpozed'); ?></a>
                </button>
                <button class="modal-close modal-edit"><?php _e('CLOSE', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>