<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>

<div class="dashboard organization-dashboard evaluation">
    <div class="posted" id="posted">
        <div class="volunteer-box">
            <?php $organizationData = $singleOrganization->getDetailsById($organziationId); ?>
            <?php $organizationName = $singleOrganization->getName($organizationId); ?>
            <?php $mainGoalId = $organizationData['main_goal'][0]; ?>
            <?php $mainGoal = $singleOrganization->getMainGoal($mainGoalId); ?>
            <div class="single-volunteer colleagues">
                <div class="data profiles-data">
                    <div class="picture"><img
                                src="<?php echo wp_get_attachment_image_src($organizationData['logo'][0], 'medium')[0]; ?>">
                    </div>
                    <div class="details colleagues-details profiles">
                        <div class="name"><?php echo $organizationData['title'][0]; ?></div>
                        <div class="job_title"><?php echo $organizationName; ?></div>
                        <div class="corporation"><?php _e('Main goal', 'purpozed'); ?>
                            :<?php echo ' ' . $mainGoal->name; ?></div>
                    </div>
                    <?php if ($dashboard_type === 'volunteer'): ?>
                        <div class="profiles-buttons">
                            <button data-id="<?php echo $opportunityId; ?>" data-task="email"
                                    class="modal-email-button-4 profiles-button"><?php _e('CONTACT', 'purpozed'); ?></button>
                            <a href="<?php echo $language; ?>/organization-profile-preview/?id=<?php echo $organziationId; ?>">
                                <div class="profiles-button"><?php _e('VIEW PROFILE', 'purpozed'); ?></div>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

$opportunityManager = new \Purpozed2\Models\OpportunitiesManager();

if ($task_type === 'call') {
    $opportunity = $opportunityManager->getSingleCall($opportunityId);
} elseif ($task_type === 'project') {
    $opportunity = $opportunityManager->getSingleProject($opportunityId);
} elseif ($task_type === 'mentoring') {
    $opportunity = $opportunityManager->getSingleMentoring($opportunityId);
} else {
    $opportunity = $opportunityManager->getSingleEngagement($opportunityId);
}

?>

<div class="modal email-4">
    <div class="modal-overlay modal-apply-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading"><?php _e('This is the contact person for this particular opportunity', 'purpozed'); ?>
                !</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <P><?php echo $opportunity->contact_name . ' ' . $opportunity->contact_surname; ?></P>
                <P><?php _e('Telephone', 'purpozed'); ?>: <?php echo $opportunity->contact_phone; ?></P>
                <P><?php _e('Email', 'purpozed'); ?>: <?php echo $opportunity->contact_email; ?></P>
                <button class="modal-edit"><a
                            href="mailto:<?php echo $opportunity->contact_email; ?>"
                            target="_blank"><?php _e('WRITE AN EMAIL', 'purpozed'); ?></a>
                </button>
                <button class="modal-close modal-edit"><?php _e('CLOSE', 'purpozed'); ?></button>
            </div>
        </div>
    </div>
</div>