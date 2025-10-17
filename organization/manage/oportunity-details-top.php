<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');
?>

<div class="prepared">
    <div class="single-volunteer two organization" id="<?php echo $opportunityId; ?>">
        <?php if ($opportunity->status === 'review'): ?>
            <div class="review"><?php _e('Under review. You have posted this opportunity and we are about to check and publish it
                within 24 Hours.', 'purpozed'); ?>
            </div>
        <?php elseif ($opportunity->status === 'prepared'): ?>
            <div class="review"><?php _e('Prepared. This opportunity is waiting to be send to review.', 'purpozed'); ?></div>
        <?php endif; ?>
        <div class="all-data">
            <div class="image"><img src="<?php echo wp_get_attachment_image_src($opportunity->image, 'medium')[0]; ?>">
            </div>
            <div class="data two">
                <div class="info">
                    <div class="status fc-status list-status <?php echo (isset($statusesTypesCSS[$opportunity->status])) ? $statusesTypesCSS[$opportunity->status] : ''; ?>"><?php _e($opportunity->status, 'purpozed'); ?></div>
                    <div class="type"><?php echo $task_type; ?></div>
                    <div class="duration">
                        <?php
                        if ($task_type === 'call') {
                            _e('1 HOUR', 'purpozed');
                        } elseif ($task_type === 'project') {
                            $project = $opportunityManager->getProjectWithTask($opportunityId);
                            echo $project->hours_duration . ' ' . _e('HOURS', 'purpozed');
                        } elseif ($task_type === 'mentoring') {
                            $mentoring = $opportunityManager->getMentoring($opportunityId);
                            echo $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . ' ' . _e('HOURS', 'purpozed');
                        } elseif ($task_type === 'engagement') {
                            $engagement = $opportunityManager->getEngagement($opportunityId);
                            echo $engagement->frequency * $engagement->duration * $engagement->time_frame . ' ' . _e('HOURS', 'purpozed');
                        }
                        ?>
                    </div>
                </div>
                <div class="details two">
                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                    <div class="name">
                        <?php

                        if ($task_type === 'call') {

                            foreach ($focus as $item):
                                echo $item->name . ' ';
                            endforeach;

                            echo ' ' . $topic->name;

                        } elseif ($task_type === 'project') {

                            echo $topic->name . ' ';

                        } elseif ($task_type === 'mentoring') {

                            $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);

                            echo $currentOpportunity->aoe_name . ' ';

                        } elseif ($task_type === 'engagement') {
                            $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);

                            echo $currentOpportunity->title . ' ';
                        }
                        ?>
                    </div>
                </div>
                <div class="details three">
                    <?php
                    $postedDateTimestamp = strtotime($singleOpportunity->postedDaysAgo($opportunityId));
                    $difference = time() - $postedDateTimestamp;

                    $set = false;
                    if ($difference >= 60 * 60 * 12) {
                        $set = true;
                        $dtF = new \DateTime('@0');
                        $dtT = new \DateTime("@" . $difference . "");
                        $timeText = $dtF->diff($dtT)->days;
                    }

                    ?>
                    <div class="top">
                        <?php _e('Posted', 'purpozed'); ?>
                        <?php if ($set) {
                            printf(__('%s days ago', 'purpozed'), $timeText);
                        } else {
                            _e('today', 'purpozed');
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="any-volunteers">
            </div>
            <div class="options">
                <div class="single-option select"><a
                            href="/manage-opportunity/?id=<?php echo $opportunityId; ?>"><?php _e('DETAILS', 'purpozed'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>