<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/volunteer/header.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/language-detector.php');

get_header();

$opportunities = new \Purpozed2\Models\OpportunitiesManager();
$singleOpportunity = new \Purpozed2\Models\Opportunity();
$volunteerManager = new \Purpozed2\Models\VolunteersManager();
$organization = new \Purpozed2\Models\Organization();

?>

    <div class="dashboard organization-dashboard vol-dash">
        <div class="row dashboard-sub-menu sticky-menu">
            <div class="sub-menu-item"><a href="#recommendations"><?php _e('Recommendations', 'purpozed'); ?></a></div>
            <div class="sub-menu-item"><a href="#applied"><?php _e('Applied', 'purpozed'); ?></a></div>
            <div class="sub-menu-item"><a href="#requests"><?php _e('Requests', 'purpozed'); ?></a></div>
            <div class="sub-menu-item"><a href="#in_progress"><?php _e('In progress', 'purpozed'); ?></a></div>
            <div class="sub-menu-item"><a href="#completed"><?php _e('Completed', 'purpozed'); ?></a></div>
            <div class="sub-menu-item"><a href="#bookmarked"><?php _e('Bookmarked', 'purpozed'); ?></a></div>
        </div>
        <div class="organization-box">
            <div class="logo"><img src="<?php echo wp_get_attachment_image_src($details['image'][0])[0]; ?>"></div>
            <div class="data vol-dash">
                <div class="name"><?php echo $details['first_name'][0]; ?></div>
                <div class="goal"><?php echo $details['title'][0]; ?></div>
                <div class="goal"><?php echo $organizationName; ?></div>
            </div>
            <div class="edit">
                <button type="button"><a
                            href="<?php echo $language; ?>/volunteer-profile/"><?php _e('EDIT PROFILE', 'purpozed'); ?></a>
                </button>
            </div>
        </div>
        <?php $requested = $opportunities->getRequested(get_current_user_id()); ?>
        <?php if ($requested): ?>
            <?php $amount = count($requested); ?>
        <?php else: ?>
            <?php $amount = 0; ?>
        <?php endif; ?>
        <?php if ($amount > 0): ?>
            <div class="vol-top-info-bar">
                <?php
                $plural = ($amount > 1) ? 'are' : 'is';
                $pluralOrga = ($amount > 1) ? 's' : '';
                $linkStart = '<a href="#requests">';
                $linkEnd = '</a>';
                ?>
                <div class="succeeded"><?php printf(__('There %s %s pending request from an organization%s. Please %smanage them%s as close as possible', 'purpozed'), $plural, $amount, $pluralOrga, $linkStart, $linkEnd); ?></div>
            </div>
        <?php endif; ?>

        <?php $completed = $opportunities->getCompleted(get_current_user_id()); ?>
        <?php if ($completed): ?>
            <?php $amount = $volunteerManager->getCurrentUser()->finishedVolunteersWithNoCommentYet(); ?>
        <?php else: ?>
            <?php $amount = 0; ?>
        <?php endif; ?>
        <?php if ($amount > 0): ?>
            <div class="vol-top-info-bar">
                <?php
                $pluralOrga = ($amount > 1) ? 's' : '';
                $linkStart = '<a href="#completed">';
                $linkEnd = '</a>';
                ?>
                <div class="succeeded"><?php printf(__('There are %s collaboration%s which were either succeeded or canceled by organization. Please %swrite a comment%s about the collaboration%s.', 'purpozed'), $amount, $pluralOrga, $linkStart, $linkEnd, $pluralOrga); ?></div>
            </div>
        <?php endif; ?>

        <div class="prepared section" id="recommendations">
            <div class="volunteer-box">
                <div class="info-title">
                    <div class="info-title-header"><?php _e('Hey, we found some matching opportunities for you', 'purpozed'); ?></div>
                    <div class="info-title-text"><?php _e('These opportunities fit to your skills and/or your goals. Apply now!', 'purpozed'); ?></div>
                </div>
                <?php if (!empty($bestMatchedCall)): ?>
                    <!--                    <div class="row">-->
                    <!--                        --><?php //$interested = $singleOpportunity->interested($bestMatchedCall->id); ?>
                    <!--                        --><?php //$finalInterested = 0; ?>
                    <!--                        --><?php //if (!empty($interested)) {
                    //                            foreach ($interested as $user) {
                    //                                if ((int)$user->user_id !== get_current_user_id()) {
                    //                                    $finalInterested++;
                    //                                }
                    //                            }
                    //                        }
                    //                        ?>
                    <!--                        <div class="review">-->
                    <!--                            --><?php //if ($finalInterested > 0): ?>
                    <!--                                --><?php //echo $finalInterested . ' '; ?><!-- of your colleague-->
                    <?php //echo ($finalInterested > 1) ? 's' : ''; ?><!-- already showing interest for this opportunity-->
                    <!--                            --><?php //else: ?>
                    <!--                                --><?php //_e('Be the first to apply for this opportunity', 'purpozed'); ?>
                    <!--                            --><?php //endif; ?>
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="single-volunteer two organization">
                        <div class="all-data">
                            <div class="image"><img
                                        src="<?php echo wp_get_attachment_image_src($bestMatchedCall->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two">
                                <div class="info">
                                    <div class="type"><?php _e($bestMatchedCall->task_type, 'purpozed'); ?></div>
                                    <div class="duration"><?php _e('1 HOUR', 'purpozed'); ?></div>
                                </div>
                                <div class="details two">
                                    <?php $organizationDetails = $organization->getDetailsById($bestMatchedCall->organization_id); ?>
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php
                                        $opportunity = $opportunities->getSingleCall($bestMatchedCall->id);
                                        $topic = $opportunities->getTopic($opportunity->topic);
                                        $focus = $opportunities->getFocuses($opportunity->id);

                                        foreach ($focus as $item):
                                            echo $item->name . ' ';
                                        endforeach;
                                        echo ' ' . $topic->name;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="skills vol-dash-skills">
                                <div class="single-one">
                                    <div class="title-small-one"><?php _e('Matched skills', 'purpozed'); ?>:</div>
                                    <?php
                                    $taskSkills = $opportunities->getCallSkillsByCall($bestMatchedCall->id);
                                    $userSkills = $volunteerManager->getCurrentUser()->getSkills();
                                    ?>
                                    <?php if (!empty($taskSkills)): ?>
                                        <div class="single-skills">
                                            <?php $matchedAmount = count($taskSkills); ?>
                                            <?php $howManyMore = 0; ?>
                                            <?php if ($matchedAmount > 2) {
                                                $howManyMore = $matchedAmount - 2;
                                            }
                                            ?>
                                            <?php $i = 1; ?>
                                            <?php $elseSkills = array(); ?>
                                            <?php foreach ($taskSkills as $skill): ?>
                                                <?php if ($i < 3): ?>
                                                    <div class="single-skill"><?php echo $skill->name; ?></div>
                                                    <?php $i++; ?>
                                                <?php else: ?>
                                                    <?php $elseSkills[] = $skill; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if (!empty($elseSkills)): ?>
                                                <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item->name; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select">
                                    <a href="<?php echo $language; ?>/opportunity/?id=<?php echo $bestMatchedCall->id; ?>&a=1"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- PROJECT -->
                <?php if (!empty($bestMatchedProject)): ?>
                    <div class="single-volunteer two organization">
                        <!--                        <div class="row">-->
                        <!--                            --><?php //$interested = $singleOpportunity->interested($bestMatchedProject->id); ?>
                        <!--                            --><?php //$finalInterested = 0; ?>
                        <!--                            --><?php //if (!empty($interested)) {
                        //                                foreach ($interested as $user) {
                        //                                    if ((int)$user->user_id !== get_current_user_id()) {
                        //                                        $finalInterested++;
                        //                                    }
                        //                                }
                        //                            }
                        //                            ?>
                        <!--                            <div class="review">-->
                        <!--                                --><?php //if ($finalInterested > 0): ?>
                        <!--                                    --><?php //$plural = ($finalInterested > 1) ? 's' : ''; ?>
                        <!--                                    --><?php //printf(__('%s of your colleague%s already showing interest for this opportunity', 'purpozed'), $finalInterested, $plural); ?>
                        <!--                                --><?php //else: ?>
                        <!--                                    --><?php //_e('Be the first to apply for this opportunity', 'purpozed'); ?>
                        <!--                                --><?php //endif; ?>
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <div class="all-data">
                            <div class="image"><img
                                        src="<?php echo wp_get_attachment_image_src($bestMatchedProject->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two">
                                <div class="info">
                                    <div class="type"><?php _e($bestMatchedProject->task_type, 'purpozed'); ?></div>
                                    <div class="duration">
                                        <?php
                                        $project = $opportunities->getProjectWithTask($bestMatchedProject->id);
                                        echo $project->hours_duration . ' ';
                                        echo ((int)$project->hours_duration > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        ?>
                                    </div>
                                </div>
                                <div class="details two">
                                    <?php $organizationDetails = $organization->getDetailsById($bestMatchedProject->organization_id); ?>
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php
                                        $opportunity = $opportunities->getSingleProject($bestMatchedProject->id);
                                        $topic = $opportunities->getTopic($opportunity->topic);

                                        echo $topic->name . ' ';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="skills vol-dash-skills">
                                <div class="single-one">
                                    <div class="title-small-one"><?php _e('Matched skills', 'purpozed'); ?>:</div>
                                    <?php
                                    $taskSkills = $opportunities->getProjectSkillsByTask($bestMatchedProject->id);
                                    $userSkills = $volunteerManager->getCurrentUser()->getSkills();
                                    ?>
                                    <?php if (!empty($taskSkills)): ?>
                                        <div class="single-skills">
                                            <?php $matchedAmount = count($taskSkills); ?>
                                            <?php $howManyMore = 0; ?>
                                            <?php if ($matchedAmount > 2) {
                                                $howManyMore = $matchedAmount - 2;
                                            }
                                            ?>
                                            <?php $i = 1; ?>
                                            <?php $elseSkills = array(); ?>
                                            <?php foreach ($taskSkills as $skill): ?>
                                                <?php if ($i < 3): ?>
                                                    <div class="single-skill"><?php echo $skill->name; ?></div>
                                                    <?php $i++; ?>
                                                <?php else: ?>
                                                    <?php $elseSkills[] = $skill; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if (!empty($elseSkills)): ?>
                                                <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item->name; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="<?php echo $language; ?>/opportunity/?id=<?php echo $bestMatchedProject->id; ?>&a=1"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- ENGAGEMENT -->
                <?php if (!empty($bestMatchedMentoring)): ?>
                    <div class="single-volunteer two organization">
                        <!--                        --><?php //$interested = $singleOpportunity->interested($bestMatchedMentoring->id); ?>
                        <!--                        --><?php //$finalInterested = 0; ?>
                        <!--                        --><?php //if (!empty($interested)) {
                        //                            foreach ($interested as $user) {
                        //                                if ((int)$user->user_id !== get_current_user_id()) {
                        //                                    $finalInterested++;
                        //                                }
                        //                            }
                        //                        }
                        //                        ?>
                        <!--                        <div class="review">-->
                        <!--                            --><?php //if ($finalInterested > 0): ?>
                        <!--                                --><?php //$plural = ($finalInterested > 1) ? 's' : ''; ?>
                        <!--                                --><?php //printf(__('%s of your colleague%s already showing interest for this opportunity', 'purpozed'), $finalInterested, $plural); ?>
                        <!--                            --><?php //else: ?>
                        <!--                                --><?php //_e('Be the first to apply for this opportunity', 'purpozed'); ?>
                        <!--                            --><?php //endif; ?>
                        <!--                        </div>-->
                        <div class="all-data">
                            <div class="image"><img
                                        src="<?php echo wp_get_attachment_image_src($bestMatchedMentoring->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two">
                                <div class="info">
                                    <div class="type"><?php _e($bestMatchedMentoring->task_type, 'purpozed'); ?></div>
                                    <div class="duration">
                                        <?php
                                        $mentoring = $opportunities->getMentoring($bestMatchedMentoring->id);
                                        echo $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . ' ';
                                        echo ($mentoring->frequency * $mentoring->duration * $mentoring->time_frame > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        ?>
                                    </div>
                                </div>
                                <div class="details two">
                                    <?php $organizationDetails = $organization->getDetailsById($bestMatchedMentoring->organization_id); ?>
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php
                                        $opportunity = $opportunities->getSingleMentoring($bestMatchedMentoring->id);

                                        echo $opportunity->aoe_name . ' ';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="skills vol-dash-skills">
                                <div class="single-one">
                                    <div class="title-small-one"><?php _e('Matched skills', 'purpozed'); ?>:</div>
                                    <?php if (!empty($bestMatchedMentoring->matched_skills)): ?>
                                        <div class="single-skills">
                                            <?php $matchedAmount = count($bestMatchedMentoring->matched_skills); ?>
                                            <?php $howManyMore = 0; ?>
                                            <?php if ($matchedAmount > 2) {
                                                $howManyMore = $matchedAmount - 2;
                                            }
                                            ?>
                                            <?php $i = 1; ?>
                                            <?php $elseSkills = array(); ?>
                                            <?php foreach ($bestMatchedMentoring->matched_skills as $skill): ?>
                                                <?php if ($i < 3): ?>
                                                    <div class="single-skill"><?php echo $skill; ?></div>
                                                    <?php $i++; ?>
                                                <?php else: ?>
                                                    <?php $elseSkills[] = $skill; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if (!empty($elseSkills)): ?>
                                                <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="<?php echo $language; ?>/opportunity/?id=<?php echo $bestMatchedMentoring->id; ?>&a=1"
                                            &m=1><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- ENGAGEMENT -->
                <?php if (!empty($bestMatchedEngagement)): ?>
                    <div class="single-volunteer two organization">
                        <!--                        --><?php //$interested = $singleOpportunity->interested($bestMatchedMentoring->id); ?>
                        <!--                        --><?php //$finalInterested = 0; ?>
                        <!--                        --><?php //if (!empty($interested)) {
                        //                            foreach ($interested as $user) {
                        //                                if ((int)$user->user_id !== get_current_user_id()) {
                        //                                    $finalInterested++;
                        //                                }
                        //                            }
                        //                        }
                        //                        ?>
                        <!--                        <div class="review">-->
                        <!--                            --><?php //if ($finalInterested > 0): ?>
                        <!--                                --><?php //$plural = ($finalInterested > 1) ? 's' : ''; ?>
                        <!--                                --><?php //printf(__('%s of your colleague%s already showing interest for this opportunity', 'purpozed'), $finalInterested, $plural); ?>
                        <!--                            --><?php //else: ?>
                        <!--                                --><?php //_e('Be the first to apply for this opportunity', 'purpozed'); ?>
                        <!--                            --><?php //endif; ?>
                        <!--                        </div>-->
                        <div class="all-data">
                            <div class="image"><img
                                        src="<?php echo wp_get_attachment_image_src($bestMatchedEngagement->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two">
                                <div class="info">
                                    <div class="type"><?php _e($bestMatchedEngagement->task_type, 'purpozed'); ?></div>
                                    <div class="duration">
                                        <?php
                                        $engagement = $opportunities->getEngagement($bestMatchedEngagement->id);
                                        echo ($engagement->frequency * $engagement->duration * $engagement->time_frame > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        ?>
                                    </div>
                                </div>
                                <div class="details two">
                                    <?php $organizationDetails = $organization->getDetailsById($bestMatchedEngagement->organization_id); ?>
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php

                                        $opportunity = $opportunities->getSingleEngagement($bestMatchedEngagement->id);
                                        echo $opportunity->title . ' ';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="skills vol-dash-skills">
                                <div class="single-one">
                                    <div class="title-small-one"><?php _e('Matched goals', 'purpozed'); ?>:</div>
                                    <!--                                    <div class="single-skills">-->
                                    <!--                                        --><?php
                                    //                                        foreach ($organizationGoals as $organizationGoal) {
                                    //                                            foreach ($bestMatchedEngagement->user_goals_names as $user_goals_name) {
                                    //                                                if ($organizationGoal->name === $user_goals_name) {
                                    //                                                    echo '<div class="single-skill">' . $user_goals_name . '</div>';
                                    //                                                }
                                    //                                            }
                                    //                                        }
                                    //                                        ?>
                                    <!--                                    </div>-->
                                    <?php $organizationGoals = $organization->getGoals($bestMatchedEngagement->best_matched_organization_id); ?>
                                    <?php if (!empty($organizationGoals)): ?>
                                        <div class="single-skills">
                                            <?php $matchedAmount = count($organizationGoals);
                                            $howManyMore = 0;
                                            ?>
                                            <?php $i = 1; ?>
                                            <?php $elseGoals = array(); ?>
                                            <?php foreach ($organizationGoals as $organizationGoal): ?>
                                                <?php foreach ($bestMatchedEngagement->user_goals_names as $user_goals_name): ?>
                                                    <?php if ($organizationGoal->name === $user_goals_name): ?>
                                                        <?php if ($i < 3): ?>
                                                            <div class="single-skill"><?php echo $user_goals_name; ?></div>
                                                            <?php $i++; ?>
                                                        <?php else: ?>
                                                            <?php $elseGoals[] = $user_goals_name; ?>
                                                        <?php endif; ?>
                                                        <?php $howManyMore++; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                            <?php
                                            $howManyMore = count($elseGoals);
                                            ?>
                                            <?php if (!empty($elseGoals)): ?>
                                                <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="<?php echo $language; ?>/opportunity/?id=<?php echo $bestMatchedEngagement->id; ?>&a=1"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="explore-all">
                <div class="explore-button">
                    <a href="<?php echo $language; ?>/find-opportunity/?filter-type=2&filters-types=main-types">
                        <div class="icon social-icon">
                            <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_favorite.svg">
                        </div>
                        <div class="text">
                            <?php _e('More Social Activities', 'purpozed'); ?>
                        </div>
                    </a>
                </div>
                <div class="explore-button">
                    <a href="<?php echo $language; ?>/find-opportunity/?filter-type=3&filters-types=main-types">
                        <div class="icon social-icon">
                            <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_build.svg">
                        </div>
                        <div class="text">
                            <?php _e('More Skills-Based Activities', 'purpozed'); ?>
                        </div>
                    </a>
                </div>
                <div class="explore-button">
                    <a href="<?php echo $language; ?>/find-opportunity/">
                        <div class="icon social-icon">
                            <img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/heart.svg">
                        </div>
                        <div class="text">
                            <?php _e('All Activities', 'purpozed'); ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="prepared section" id="applied">
            <div class="volunteer-box">
                <div class="section-title"><?php _e('Applied', 'purpozed'); ?></div>
                <div class="title-small"><?php _e('Applied. These are opportunities you have applied for. Waiting for approval', 'purpozed'); ?></div>
                <?php foreach ($applied

                               as $apply): ?>


                    <?php
                    $isEngagement = 0;
                    if ($apply->task_type === 'engagement') {
                        $oppManager = new \Purpozed2\Models\OpportunitiesManager();
                        $currentEngagement = $oppManager->getSingleEngagement($apply->id);
                        $isEngagement = 1;
                    }
                    ?>

                    <?php $isSignedToOther = ($apply->task_type != 'engagement' && $apply->status === 'in_progress' && empty($singleOpportunity->assignedToOther($apply->id, get_current_user_id()))); ?>
                    <div class="single-volunteer two organization">
                        <div class="review">
                            <?php
                            if ($apply->status === 'retracted') {
                                echo '<span>i</span>';
                                _e('This opportunity unfortunately has been deleted by the organization. You will find other exciting opportunities!', 'purpozed');
                            } elseif ($apply->status === 'expired') {
                                _e('This opportunity unfortunately has expired. You will find other exciting opportunities!', 'purpozed');
                            } elseif ($isSignedToOther) {
                                echo '<div>i</div>';
                                printf(__('This %s unfortunenatly has been assigned to an other volunteer. You will find other exciting opportunities!', 'purpozed'), $apply->task_type);
                            } elseif ($singleOpportunity->isRejected($apply->id, get_current_user_id())) {
                                echo '<div>i</div>';

                                if ($apply->task_type !== 'engagement') {
                                    printf(__('This %s unfortunenatly has been assigned to an other volunteer. You will find other exciting opportunities!', 'purpozed'), $apply->task_type);
                                } else {
                                    _e('The organization has rejected your application. This should only happen if you and the organization have found out in a conversation that this is not the right engagement for you. Please contact us if such a conversation didn\'t have occured . ', 'purpozed');
                                }

                            }
                            ?>
                        </div>
                        <div class="all-data">
                            <div class="image <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                <?php if ($apply->task_type === 'engagement'): ?>
                                    <?php if ($currentEngagement->closed === '1'): ?>
                                        <div class="currently-closed">Currently closed</div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <img
                                        src="<?php echo wp_get_attachment_image_src($apply->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                <div class="info">
                                    <div class="type"><?php _e($apply->task_type, 'purpozed'); ?></div>
                                    <div class="duration">
                                        <?php
                                        if ($apply->task_type === 'call') {
                                            _e('1 hour', 'purpozed');
                                        } elseif ($apply->task_type === 'project') {
                                            $project = $opportunities->getProjectWithTask($apply->id);
                                            echo $project->hours_duration . ' ';
                                            echo ((int)$project->hours_duration > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($apply->task_type === 'mentoring') {
                                            $mentoring = $opportunities->getMentoring($apply->id);
                                            echo $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . ' ';
                                            echo (($mentoring->frequency * $mentoring->duration * $mentoring->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($apply->task_type === 'engagement') {
                                            $engagement = $opportunities->getEngagement($apply->id);
                                            echo $engagement->frequency * $engagement->duration * $engagement->time_frame . ' ';
                                            echo (($engagement->frequency * $engagement->duration * $engagement->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details two <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                    <?php $organizationDetails = $organization->getDetailsById($apply->organization_id); ?>
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">

                                        <?php

                                        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                                        $organization = new \Purpozed2\Models\Organization();

                                        $organizationGoals = $organization->getGoals($apply->organization_id);
                                        $organizationMainGoalId = get_user_meta($apply->organization_id, 'main_goal');
                                        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

                                        $organizationGoalsNames = array();
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $organizationGoalsNames[] = $organizationGoal->name;
                                        }
                                        $organizationGoalsNames[] = $organizationMainGoal->name;

                                        $volunteerGoals[] = array(
                                            'goals' => $volunteerManager->getCurrentUser(get_current_user_id())->getGoals()
                                        );

                                        $organizationGoalsValue = count($organizationGoalsNames);

                                        $matchedGoals = array();
                                        $matchedGoalsValue = 0;
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $matchedScore = 0;
                                            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                                                foreach ($volunteerGoal as $goal) {
                                                    foreach ($goal as $item) {
                                                        if ($organizationGoal->name === $item->name) {
                                                            $matchedGoals[] = $item->name;
                                                            $matchedGoalsValue++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $matchedGoals = array_unique($matchedGoals);

                                        ?>

                                        <?php
                                        if ($apply->task_type === 'call') {
                                            $opportunity = $opportunities->getSingleCall($apply->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);
                                            $focus = $opportunities->getFocuses($opportunity->id);

                                            foreach ($focus as $item):
                                                echo $item->name . ' ';
                                            endforeach;

                                            echo ' ' . $topic->name;

                                        } elseif ($apply->task_type === 'project') {
                                            $opportunity = $opportunities->getSingleProject($apply->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);

                                            echo $topic->name . ' ';

                                        } elseif ($apply->task_type === 'mentoring') {

                                            $opportunity = $opportunities->getSingleMentoring($apply->id);

                                            echo $opportunity->aoe_name . ' ';

                                        } elseif ($apply->task_type === 'engagement') {
                                            $opportunity = $opportunities->getSingleEngagement($apply->id);

                                            echo $opportunity->title . ' ';
                                        }
                                        ?>
                                    </div>
                                    <?php if ($apply->task_type === 'engagement'): ?>
                                        <?php
                                        $currentlyEngaged = count($singleOpportunity->getInProgress($apply->id));
                                        $complishedEngaged = count($singleOpportunity->getCompletedEngagement($apply->id));
                                        ?>
                                        <div class="engagement-details">
                                            <div class="box">
                                                <div><img
                                                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_people_24px.svg">
                                                </div> <?php printf(__('%s volunteers are currently engaged', 'purpozed'), $currentlyEngaged); ?>
                                            </div>
                                            <div class="box">
                                                <div><img
                                                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_check_circle_24px.svg">
                                                </div> <?php printf(__('%s volunteers have successfully completed', 'purpozed'), $complishedEngaged); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($apply->status === 'retracted'): ?>
                                    <div class="extra-status">DELETED</div>
                                <?php elseif ($apply->status === 'expired'): ?>
                                    <div class="extra-status">EXPIRED</div>
                                <?php endif; ?>
                            </div>
                            <div class="skills vol-dash-skills <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                <div class="single-one">

                                    <?php
                                    if ($apply->task_type === 'call') {

                                        $taskSkills = $opportunities->getCallSkillsByCall($apply->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($apply->task_type === 'project') {

                                        $taskSkills = $opportunities->getProjectSkillsByTask($apply->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($apply->task_type === 'mentoring') {
                                        $mentoringData = $opportunities->getSingleMentoring($apply->id);

                                        ?>
                                        <div class="title-small-one">
                                            Area of Expertise
                                        </div>
                                        <div class="single-skills">
                                            <div class="single-skill">
                                                <?php echo $mentoringData->aoe_name; ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($apply->task_type === 'engagement') {
                                        ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="<?php echo $language; ?>/opportunity/?id=<?php echo $apply->id; ?>"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="prepared section" id="requests">
            <div class="volunteer-box">
                <div class="section-title"><?php _e('Requests', 'purpozed'); ?></div>
                <div class="title-small"><?php _e('These are opportunities you are requested for from Organizations. Start right away, if you want!', 'purpozed'); ?></div>
                <?php foreach ($requested as $request): ?>


                    <?php
                    $isEngagement = 0;
                    if ($request->task_type === 'engagement') {
                        $oppManager = new \Purpozed2\Models\OpportunitiesManager();
                        $currentEngagement = $oppManager->getSingleEngagement($request->id);
                        $isEngagement = 1;
                    }
                    ?>

                    <div class="single-volunteer two organization">
                        <div class="review">
                            <?php
                            $isSignedToOther = ($request->task_type != 'engagement' && $request->status === 'in_progress' && empty($singleOpportunity->assignedToOther($request->id, get_current_user_id())));
                            ?>
                            <?php
                            if ($request->status === 'retracted') {
                                echo '<div>i</div>';
                                _e('This opportunity unfortunately has been deleted by the organization. You will find other exciting opportunities!', 'purpozed');
                            } elseif ($request->status === 'expired') {
                                echo '<div>i</div>';
                                _e('This opportunity unfortunately has expired. You will find other exciting opportunities!', 'purpozed');
                            } elseif ($isSignedToOther) {
                                echo '<div>i</div>';
                                printf(__('You waited too long, the %s has unfortunately been assigned to an other volunteer', 'purpozed'), $request->task_type);
                            }
                            ?>
                        </div>
                        <div class="all-data">
                            <div class="image <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                <?php if ($request->task_type === 'engagement'): ?>
                                    <?php if ($currentEngagement->closed === '1'): ?>
                                        <div class="currently-closed">Currently closed</div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <img
                                        src="<?php echo wp_get_attachment_image_src($request->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                <div class="info">
                                    <div class="type"><?php _e($request->task_type, 'purpozed'); ?></div>
                                    <div class="duration">
                                        <?php
                                        if ($request->task_type === 'call') {
                                            _e('1 hour', 'purpozed');
                                        } elseif ($request->task_type === 'project') {
                                            $project = $opportunities->getProjectWithTask($request->id);
                                            echo $project->hours_duration . ' ';
                                            echo ((int)$project->hours_duration > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($request->task_type === 'mentoring') {
                                            $mentoring = $opportunities->getMentoring($request->id);
                                            echo $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . ' ';
                                            echo (($mentoring->frequency * $mentoring->duration * $mentoring->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($request->task_type === 'engagement') {
                                            $engagement = $opportunities->getEngagement($request->id);
                                            echo $engagement->frequency * $engagement->duration * $engagement->time_frame . ' ';
                                            echo (($engagement->frequency * $engagement->duration * $engagement->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details two <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                    <?php $organizationDetails = $organization->getDetailsById($request->organization_id); ?>
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php

                                        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                                        $organization = new \Purpozed2\Models\Organization();

                                        $organizationGoals = $organization->getGoals($request->organization_id);
                                        $organizationMainGoalId = get_user_meta($request->organization_id, 'main_goal');
                                        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

                                        $organizationGoalsNames = array();
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $organizationGoalsNames[] = $organizationGoal->name;
                                        }
                                        $organizationGoalsNames[] = $organizationMainGoal->name;

                                        $volunteerGoals[] = array(
                                            'goals' => $volunteerManager->getCurrentUser(get_current_user_id())->getGoals()
                                        );

                                        $organizationGoalsValue = count($organizationGoalsNames);

                                        $matchedGoals = array();
                                        $matchedGoalsValue = 0;
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $matchedScore = 0;
                                            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                                                foreach ($volunteerGoal as $goal) {
                                                    foreach ($goal as $item) {
                                                        if ($organizationGoal->name === $item->name) {
                                                            $matchedGoals[] = $item->name;
                                                            $matchedGoalsValue++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $matchedGoals = array_unique($matchedGoals);


                                        if ($request->task_type === 'call') {
                                            $opportunity = $opportunities->getSingleCall($request->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);
                                            $focus = $opportunities->getFocuses($opportunity->id);

                                            foreach ($focus as $item):
                                                echo $item->name . ' ';
                                            endforeach;

                                            echo ' ' . $topic->name;

                                        } elseif ($request->task_type === 'project') {
                                            $opportunity = $opportunities->getSingleProject($request->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);

                                            echo $topic->name . ' ';

                                        } elseif ($request->task_type === 'mentoring') {

                                            $opportunity = $opportunities->getSingleMentoring($request->id);

                                            echo $opportunity->aoe_name . ' ';

                                        } elseif ($request->task_type === 'engagement') {
                                            $opportunity = $opportunities->getSingleEngagement($request->id);

                                            echo $opportunity->title . ' ';
                                        }
                                        ?>
                                    </div>
                                    <?php if ($request->task_type === 'engagement'): ?>
                                        <?php
                                        $currentlyEngaged = count($singleOpportunity->getInProgress($request->id));
                                        $complishedEngaged = count($singleOpportunity->getCompletedEngagement($request->id));
                                        ?>
                                        <div class="engagement-details">
                                            <div class="box">
                                                <div><img
                                                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_people_24px.svg">
                                                </div> <?php printf(__('%s volunteers are currently engaged', 'purpozed'), $currentlyEngaged); ?>
                                            </div>
                                            <div class="box">
                                                <div><img
                                                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_check_circle_24px.svg">
                                                </div> <?php printf(__('%s volunteers have successfully completed', 'purpozed'), $complishedEngaged); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($request->status === 'retracted'): ?>
                                    <div class="extra-status">DELETED</div>
                                <?php elseif ($request->status === 'expired'): ?>
                                    <div class="extra-status">EXPIRED</div>
                                <?php endif; ?>
                            </div>
                            <div class="skills vol-dash-skills <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                <div class="single-one">

                                    <?php
                                    if ($request->task_type === 'call') {

                                        $taskSkills = $opportunities->getCallSkillsByCall($request->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($request->task_type === 'project') {

                                        $taskSkills = $opportunities->getProjectSkillsByTask($request->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($request->task_type === 'mentoring') {
                                        $mentoringData = $opportunities->getSingleMentoring($request->id);

                                        ?>
                                        <div class="title-small-one">
                                            <?php _e('Area of Expertise', 'purpozed'); ?>
                                        </div>
                                        <div class="single-skill">
                                            <?php echo $mentoringData->aoe_name; ?>
                                        </div>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($request->task_type === 'engagement') {
                                        ?>

                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="<?php echo $language; ?>/opportunity/?id=<?php echo $request->id; ?>"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="prepared section" id="in_progress">
            <div class="volunteer-box">
                <div class="section-title"><?php _e('In progress', 'purpozed'); ?></div>
                <div class="title-small"><?php _e('My current opportunities I am working on', 'purpozed'); ?></div>
                <?php foreach ($in_progress as $request): ?>
                    <div class="single-volunteer two organization">
                        <div class="review">
                            <?php
                            if ($request->status === 'retracted') {
                                echo '<div>i</div>';
                                _e('This opportunity unfortunately has been deleted by the organization. You will find other exciting opportunities!', 'purpozed');
                            } elseif ($request->status === 'expired') {
                                echo '<div>i</div>';
                                _e('This opportunity unfortunately has expired. You will find other exciting opportunities!', 'purpozed');
                            }
                            ?>
                        </div>
                        <div class="all-data">
                            <div class="image <?php echo ($request->status === 'retracted' || $request->status === 'expired') ? 'grey-out' : ''; ?>">
                                <img
                                        src="<?php echo wp_get_attachment_image_src($request->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two <?php echo ($request->status === 'retracted' || $request->status === 'expired') ? 'grey-out' : ''; ?>">
                                <div class="info">
                                    <div class="type"><?php _e($request->task_type, 'purpozed'); ?></div>
                                    <div class="duration">
                                        <?php
                                        if ($request->task_type === 'call') {
                                            _e('1 hour', 'purpozed');
                                        } elseif ($request->task_type === 'project') {
                                            $project = $opportunities->getProjectWithTask($request->id);
                                            echo $project->hours_duration . ' ';
                                            echo ((int)$project->hours_duration > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($request->task_type === 'mentoring') {
                                            $mentoring = $opportunities->getMentoring($request->id);
                                            echo $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . ' ';
                                            echo (($mentoring->frequency * $mentoring->duration * $mentoring->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($request->task_type === 'engagement') {
                                            $engagement = $opportunities->getEngagement($request->id);
                                            echo $engagement->frequency * $engagement->duration * $engagement->time_frame . ' ';
                                            echo (($engagement->frequency * $engagement->duration * $engagement->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details two <?php echo ($request->status === 'retracted' || $request->status === 'expired') ? 'grey-out' : ''; ?>">
                                    <?php $organizationDetails = $organization->getDetailsById($request->organization_id); ?>
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php

                                        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                                        $organization = new \Purpozed2\Models\Organization();

                                        $organizationGoals = $organization->getGoals($request->organization_id);
                                        $organizationMainGoalId = get_user_meta($request->organization_id, 'main_goal');
                                        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

                                        $organizationGoalsNames = array();
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $organizationGoalsNames[] = $organizationGoal->name;
                                        }
                                        $organizationGoalsNames[] = $organizationMainGoal->name;

                                        $volunteerGoals[] = array(
                                            'goals' => $volunteerManager->getCurrentUser(get_current_user_id())->getGoals()
                                        );

                                        $organizationGoalsValue = count($organizationGoalsNames);

                                        $matchedGoals = array();
                                        $matchedGoalsValue = 0;
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $matchedScore = 0;
                                            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                                                foreach ($volunteerGoal as $goal) {
                                                    foreach ($goal as $item) {
                                                        if ($organizationGoal->name === $item->name) {
                                                            $matchedGoals[] = $item->name;
                                                            $matchedGoalsValue++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $matchedGoals = array_unique($matchedGoals);


                                        if ($request->task_type === 'call') {
                                            $opportunity = $opportunities->getSingleCall($request->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);
                                            $focus = $opportunities->getFocuses($opportunity->id);

                                            foreach ($focus as $item):
                                                echo $item->name . ' ';
                                            endforeach;

                                            echo ' ' . $topic->name;

                                        } elseif ($request->task_type === 'project') {
                                            $opportunity = $opportunities->getSingleProject($request->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);

                                            echo $topic->name . ' ';

                                        } elseif ($request->task_type === 'mentoring') {

                                            $opportunity = $opportunities->getSingleMentoring($request->id);

                                            echo $opportunity->aoe_name . ' ';

                                        } elseif ($request->task_type === 'engagement') {
                                            $opportunity = $opportunities->getSingleEngagement($request->id);

                                            echo $opportunity->title . ' ';
                                        }
                                        ?>
                                    </div>
                                    <?php if ($request->task_type === 'engagement'): ?>
                                        <?php
                                        $currentlyEngaged = count($singleOpportunity->getInProgress($request->id));
                                        $complishedEngaged = count($singleOpportunity->getCompletedEngagement($request->id));
                                        ?>
                                        <div class="engagement-details">
                                            <div class="box">
                                                <div><img
                                                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_people_24px.svg">
                                                </div> <?php printf(__('%s volunteers are currently engaged', 'purpozed'), $currentlyEngaged); ?>
                                            </div>
                                            <div class="box">
                                                <div><img
                                                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_check_circle_24px.svg">
                                                </div> <?php printf(__('%s volunteers have successfully completed', 'purpozed'), $complishedEngaged); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($request->status === 'retracted'): ?>
                                    <div class="extra-status">DELETED</div>
                                <?php elseif ($request->status === 'expired'): ?>
                                    <div class="extra-status">EXPIRED</div>
                                <?php endif; ?>
                            </div>
                            <div class="skills vol-dash-skills <?php echo ($request->status === 'retracted' || $request->status === 'expired') ? 'grey-out' : ''; ?>">
                                <div class="single-one">

                                    <?php
                                    if ($request->task_type === 'call') {

                                        $taskSkills = $opportunities->getCallSkillsByCall($request->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($request->task_type === 'project') {

                                        $taskSkills = $opportunities->getProjectSkillsByTask($request->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($request->task_type === 'mentoring') {
                                        $mentoringData = $opportunities->getSingleMentoring($request->id);

                                        ?>
                                        <div class="title-small-one">
                                            <?php _e('Area of Expertise', 'purpozed'); ?>
                                        </div>
                                        <div class="single-skill">
                                            <?php echo $mentoringData->aoe_name; ?>
                                        </div>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($request->task_type === 'engagement') {
                                        ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="<?php echo $language; ?>/opportunity/?id=<?php echo $request->id; ?>"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="prepared section" id="completed">
            <div class="volunteer-box">
                <div class="section-title"><?php _e('Completed', 'purpozed'); ?></div>
                <div class="title-small"><?php _e('These are the opportunities you have either succeeded at or were canceled prematurely', 'purpozed'); ?>
                    .
                </div>
                <?php foreach ($completed as $done): ?>
                    <div class="single-volunteer two organization">

                        <?php if ($done->task_type === 'engagement'): ?>

                            <?php
                            $isEvaluatedEngagement = $singleOpportunity->isEvaluatedEngagement($done->id, get_current_user_id());
                            if ($isEvaluatedEngagement) {
                                $engagementEvaluationData = $singleOpportunity->getCompletedEngagementFully($done->id, get_current_user_id());
                            }

                            ?>
                        <?php endif; ?>

                        <div class="review <?php echo (($done->task_type === 'engagement' && empty($engagementEvaluationData->canceled_by)) || ($done->task_type !== 'engagement' && $done->status === 'succeeded')) ? '' : 'canceled'; ?>">
                            <?php
                            if ($done->task_type === 'engagement') {

                                if ($done->task_type === 'engagement' && empty($engagementEvaluationData->canceled_by)):

                                    if (!empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)):
                                        echo '<div>i</div>';
                                        printf(__('This %s was completed successfully and commented by you and the organization.', 'purpozed'), $done->task_type);
                                    elseif (empty($engagementEvaluationData->evaluation_organization)):
                                        echo '<div>i</div>';
                                        printf(__('You have completed this %s successfully and commented it but the organization did not comment it yet.', 'purpozed'), $done->task_type);
                                    elseif (!empty($engagementEvaluationData->evaluation_organization)):
                                        echo '<div>i</div>';
                                        printf(__('The organization has completed the %s successfully and already commented. Please comment on the collaboration with the organization!', 'purpozed'), $done->task_type);
                                    endif;

                                else:

                                    if (!empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)):
                                        echo '<div>i</div>';
                                        printf(__('This %s was canceled prematurely and commented by you and the organization.', 'purpozed'), $done->task_type);
                                    elseif (empty($engagementEvaluationData->evaluation_organization)):
                                        echo '<div>i</div>';
                                        printf(__('You have canceled this %s prematurely and commented it but the organization did not comment it yet.', 'purpozed'), $done->task_type);
                                    elseif (!empty($engagementEvaluationData->evaluation_organization)):
                                        echo '<div>i</div>';
                                        printf(__('The organization has canceled the %s prematurely and already commented. Please comment on the collaboration with the organization!', 'purpozed'), $done->task_type);
                                    endif;

                                endif;
                            } else {

                                if (($done->task_type !== 'engagement' && $singleOpportunity->canceledBy($done->id) !== null)):

                                    if (!empty($singleOpportunity->getVolunteerEvaluationText($done->id)) && !empty($singleOpportunity->getOrganizationEvaluationText($done->id))):
                                        echo '<div>i</div>';
                                        printf(__('This %s was completed successfully and commented by you and the organization.', 'purpozed'), $done->task_type);
                                    elseif (empty($singleOpportunity->getOrganizationEvaluationText($done->id))):
                                        echo '<div>i</div>';
                                        printf(__('The organization has completed the %s successfully and already commented. Please comment on the collaboration with the organization!', 'purpozed'), $done->task_type);
                                    elseif (!empty($singleOpportunity->getVolunteerEvaluationText($done->id))):
                                        echo '<div>i</div>';
                                        printf(__('You have completed this %s successfully and commented it but the organization did not comment it yet.', 'purpozed'), $done->task_type);
                                    endif;

                                else:

                                    if (!empty($singleOpportunity->getVolunteerEvaluationText($done->id)) && !empty($singleOpportunity->getOrganizationEvaluationText($done->id))):
                                        echo '<div>i</div>';
                                        printf(__('This %s was canceled prematurely and commented by you and the organization.', 'purpozed'), $done->task_type);
                                    elseif (empty($singleOpportunity->getOrganizationEvaluationText($done->id))):
                                        echo '<div>i</div>';
                                        printf(__('The organization has canceled the %s prematurely and already commented. Please comment on the collaboration with the organization!', 'purpozed'), $done->task_type);
                                    elseif (!empty($singleOpportunity->getVolunteerEvaluationText($done->id))):
                                        echo '<div>i</div>';
                                        printf(__('You have canceled this %s prematurely and commented it but the organization did not comment it yet.', 'purpozed'), $done->task_type);
                                    endif;
                                endif;
                            }
                            ?>
                        </div>
                        <div class="all-data">
                            <div class="image"><img
                                        src="<?php echo wp_get_attachment_image_src($done->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two">
                                <div class="info">
                                    <div class="type"><?php _e($done->task_type, 'purpozed'); ?></div>
                                    <div class="duration">
                                        <?php
                                        if ($done->task_type === 'call') {
                                            _e('1 hour', 'purpozed');
                                        } elseif ($done->task_type === 'project') {
                                            $project = $opportunities->getProjectWithTask($done->id);
                                            echo $project->hours_duration . ' ';
                                            echo ((int)$project->hours_duration > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($done->task_type === 'mentoring') {
                                            $mentoring = $opportunities->getMentoring($done->id);
                                            echo $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . ' ';
                                            echo (($mentoring->frequency * $mentoring->duration * $mentoring->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($done->task_type === 'engagement') {
                                            $engagement = $opportunities->getEngagement($done->id);
                                            echo $engagement->frequency * $engagement->duration * $engagement->time_frame . ' ';
                                            echo (($engagement->frequency * $engagement->duration * $engagement->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details two">
                                    <?php $organizationDetails = $organization->getDetailsById($done->organization_id); ?>
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php

                                        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                                        $organization = new \Purpozed2\Models\Organization();

                                        $organizationGoals = $organization->getGoals($done->organization_id);
                                        $organizationMainGoalId = get_user_meta($done->organization_id, 'main_goal');
                                        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

                                        $organizationGoalsNames = array();
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $organizationGoalsNames[] = $organizationGoal->name;
                                        }
                                        $organizationGoalsNames[] = $organizationMainGoal->name;

                                        $volunteerGoals[] = array(
                                            'goals' => $volunteerManager->getCurrentUser(get_current_user_id())->getGoals()
                                        );

                                        $organizationGoalsValue = count($organizationGoalsNames);

                                        $matchedGoals = array();
                                        $matchedGoalsValue = 0;
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $matchedScore = 0;
                                            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                                                foreach ($volunteerGoal as $goal) {
                                                    foreach ($goal as $item) {
                                                        if ($organizationGoal->name === $item->name) {
                                                            $matchedGoals[] = $item->name;
                                                            $matchedGoalsValue++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $matchedGoals = array_unique($matchedGoals);

                                        if ($done->task_type === 'call') {
                                            $opportunity = $opportunities->getSingleCall($done->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);
                                            $focus = $opportunities->getFocuses($opportunity->id);

                                            foreach ($focus as $item):
                                                echo $item->name . ' ';
                                            endforeach;

                                            echo ' ' . $topic->name;

                                        } elseif ($done->task_type === 'project') {
                                            $opportunity = $opportunities->getSingleProject($done->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);

                                            echo $topic->name . ' ';

                                        } elseif ($done->task_type === 'mentoring') {

                                            $opportunity = $opportunities->getSingleMentoring($done->id);

                                            echo $opportunity->aoe_name . ' ';

                                        } elseif ($done->task_type === 'engagement') {
                                            $opportunity = $opportunities->getSingleEngagement($done->id);

                                            echo $opportunity->title . ' ';
                                        }
                                        ?>
                                    </div>
                                    <div class="completed-status">
                                        <div class="completed-status-text">
                                            <?php if ($done->task_type === 'engagement'): ?>
                                                <?php if (empty($engagementEvaluationData->canceled_by)): ?>
                                                    <span class="positive"><?php _e('COMPLETED SUCCESSFULLY'); ?></span>
                                                <?php else: ?>
                                                    <span class="negative"><?php _e('CANCELED PREMATURELY'); ?></span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($done->status === 'succeeded'): ?>
                                                    <span class="positive"><?php _e('COMPLETED SUCCESSFULLY'); ?></span>
                                                <?php elseif ($done->status === 'canceled'): ?>
                                                    <span class="negative"><?php _e('CANCELED PREMATURELY'); ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="skills vol-dash-skills">
                                <div class="single-one">

                                    <?php
                                    if ($done->task_type === 'call') {

                                        $taskSkills = $opportunities->getCallSkillsByCall($done->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($done->task_type === 'project') {

                                        $taskSkills = $opportunities->getProjectSkillsByTask($done->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($done->task_type === 'mentoring') {
                                        $mentoringData = $opportunities->getSingleMentoring($done->id);

                                        ?>
                                        <div class="title-small-one">
                                            <?php _e('Area of Expertise', 'purpozed'); ?>
                                        </div>
                                        <div class="single-skill">
                                            <?php echo $mentoringData->aoe_name; ?>
                                        </div>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($done->task_type === 'engagement') {
                                        ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select comments-button <?php echo (($done->task_type === 'engagement' && empty($engagementEvaluationData->canceled_by)) || ($done->task_type !== 'engagement' && $done->status === 'succeeded')) ? '' : 'canceled'; ?>">
                                    <a
                                            href="<?php echo $language; ?>/evaluate/?id=<?php echo $done->id; ?>">
                                        <?php if ($done->task_type === 'engagement'): ?>

                                            <?php if (!empty($engagementEvaluationData->evaluation_organization) && !empty($engagementEvaluationData->evaluation_volunteer)): ?>
                                                <?php _e('SHOW COMMENTS', 'purpozed'); ?>
                                            <?php elseif (!empty($engagementEvaluationData->evaluation_organization) && empty($engagementEvaluationData->evaluation_volunteer)): ?>
                                                <?php _e('COMMENT', 'purpozed'); ?>
                                            <?php elseif (!empty($engagementEvaluationData->evaluation_volunteer) && empty($engagementEvaluationData->evaluation_organization)): ?>
                                                <?php _e('SHOW MY COMMENT', 'purpozed'); ?>
                                            <?php endif; ?>

                                        <?php else: ?>
                                            <?php if (($singleOpportunity->getVolunteerEvaluationText($done->id) !== NULL) && ($singleOpportunity->getOrganizationEvaluationText($done->id) !== NULL)): ?>
                                                <?php _e('SHOW COMMENTS', 'purpozed'); ?>
                                            <?php elseif ($singleOpportunity->getOrganizationEvaluationText($done->id) !== NULL && $singleOpportunity->getVolunteerEvaluationText($done->id) === NULL): ?>
                                                <?php _e('COMMENT', 'purpozed'); ?>
                                            <?php elseif ($singleOpportunity->getVolunteerEvaluationText($done->id) !== NULL && $singleOpportunity->getOrganizationEvaluationText($done->id) === NULL): ?>
                                                <?php _e('SHOW MY COMMENT', 'purpozed'); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="prepared section" id="bookmarked">
            <div class="volunteer-box">
                <div class="section-title"><?php _e('Bookmarked', 'purpozed'); ?></div>
                <?php foreach ($bookmarked as $bookmark): ?>
                    <div class="single-volunteer two organization">

                        <?php

                        $isEngagement = 0;
                        if ($bookmark->task_type === 'engagement') {
                            $oppManager = new \Purpozed2\Models\OpportunitiesManager();
                            $currentEngagement = $oppManager->getSingleEngagement($bookmark->id);
                            $isEngagement = 1;
                        }
                        ?>

                        <div class="review">
                            <?php
                            if ($bookmark->status === 'retracted') {
                                _e('This opportunity unfortunately has been assigned to an other volunteer. You will find other exciting opportunities!', 'purpozed');
                            } elseif ($bookmark->status === 'expired') {
                                _e('This opportunity unfortunately has expired. You will find other exciting opportunities!', 'purpozed');
                            }
                            ?>
                        </div>
                        <?php
                        $isSignedToOther = ($bookmark->task_type != 'engagement' && $bookmark->status === 'in_progress' && empty($singleOpportunity->assignedToOther($bookmark->id, get_current_user_id())));
                        ?>
                        <div class="all-data">
                            <div class="image <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                <?php if ($bookmark->task_type === 'engagement'): ?>
                                    <?php if ($currentEngagement->closed === '1'): ?>
                                        <div class="currently-closed">Currently closed</div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <img
                                        src="<?php echo wp_get_attachment_image_src($bookmark->image, 'medium')[0]; ?>">
                            </div>
                            <div class="data two <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                <div class="info">
                                    <div class="type"><?php _e($bookmark->task_type, 'purpozed'); ?></div>
                                    <div class="duration">
                                        <?php
                                        if ($bookmark->task_type === 'call') {
                                            _e('1 hour', 'purpozed');
                                        } elseif ($bookmark->task_type === 'project') {
                                            $project = $opportunities->getProjectWithTask($bookmark->id);
                                            echo $project->hours_duration . ' ';
                                            echo ((int)$project->hours_duration > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($bookmark->task_type === 'mentoring') {
                                            $mentoring = $opportunities->getMentoring($bookmark->id);
                                            echo $mentoring->frequency * $mentoring->duration * $mentoring->time_frame . ' ';
                                            echo (($mentoring->frequency * $mentoring->duration * $mentoring->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        } elseif ($bookmark->task_type === 'engagement') {
                                            $engagement = $opportunities->getEngagement($bookmark->id);
                                            echo $engagement->frequency * $engagement->duration * $engagement->time_frame . ' ';
                                            echo (($engagement->frequency * $engagement->duration * $engagement->time_frame) > 1) ? _e('HOURS', 'purpozed') : _e('HOUR', 'purpozed');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="details two <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                    <?php $organizationDetails = $organization->getDetailsById($bookmark->organization_id); ?>
                                    <div class="job_title"><?php echo $organizationDetails['organization_name'][0]; ?></div>
                                    <div class="name">
                                        <?php

                                        $volunteerManager = new \Purpozed2\Models\VolunteersManager();
                                        $organization = new \Purpozed2\Models\Organization();

                                        $organizationGoals = $organization->getGoals($bookmark->organization_id);
                                        $organizationMainGoalId = get_user_meta($bookmark->organization_id, 'main_goal');
                                        $organizationMainGoal = $organization->getMainGoal($organizationMainGoalId);

                                        $organizationGoalsNames = array();
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $organizationGoalsNames[] = $organizationGoal->name;
                                        }
                                        $organizationGoalsNames[] = $organizationMainGoal->name;

                                        $volunteerGoals[] = array(
                                            'goals' => $volunteerManager->getCurrentUser(get_current_user_id())->getGoals()
                                        );

                                        $organizationGoalsValue = count($organizationGoalsNames);

                                        $matchedGoals = array();
                                        $matchedGoalsValue = 0;
                                        foreach ($organizationGoals as $organizationGoal) {
                                            $matchedScore = 0;
                                            foreach ($volunteerGoals as $userId => $volunteerGoal) {
                                                foreach ($volunteerGoal as $goal) {
                                                    foreach ($goal as $item) {
                                                        if ($organizationGoal->name === $item->name) {
                                                            $matchedGoals[] = $item->name;
                                                            $matchedGoalsValue++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $matchedGoals = array_unique($matchedGoals);

                                        if ($bookmark->task_type === 'call') {
                                            $opportunity = $opportunities->getSingleCall($bookmark->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);
                                            $focus = $opportunities->getFocuses($opportunity->id);

                                            foreach ($focus as $item):
                                                echo $item->name . ' ';
                                            endforeach;

                                            echo ' ' . $topic->name;

                                        } elseif ($bookmark->task_type === 'project') {
                                            $opportunity = $opportunities->getSingleProject($bookmark->id);
                                            $topic = $opportunities->getTopic($opportunity->topic);

                                            echo $topic->name . ' ';

                                        } elseif ($bookmark->task_type === 'mentoring') {

                                            $opportunity = $opportunities->getSingleMentoring($bookmark->id);

                                            echo $opportunity->aoe_name . ' ';

                                        } elseif ($bookmark->task_type === 'engagement') {
                                            $opportunity = $opportunities->getSingleEngagement($bookmark->id);

                                            echo $opportunity->title . ' ';
                                        }
                                        ?>
                                    </div>
                                    <?php if ($bookmark->task_type === 'engagement'): ?>
                                        <?php
                                        $currentlyEngaged = count($singleOpportunity->getInProgress($bookmark->id));
                                        $complishedEngaged = count($singleOpportunity->getCompletedEngagement($bookmark->id));
                                        ?>
                                        <div class="engagement-details">
                                            <div class="box">
                                                <div><img
                                                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_people_24px.svg">
                                                </div> <?php printf(__('%s volunteers are currently engaged', 'purpozed'), $currentlyEngaged); ?>
                                            </div>
                                            <div class="box">
                                                <div><img
                                                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/ic_check_circle_24px.svg">
                                                </div> <?php printf(__('%s volunteers have successfully completed', 'purpozed'), $complishedEngaged); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="skills vol-dash-skills <?php echo ($isSignedToOther || ($isEngagement && $currentEngagement->closed === '1')) ? 'grey-out' : ''; ?>">
                                <div class="single-one">

                                    <?php
                                    if ($bookmark->task_type === 'call') {

                                        $taskSkills = $opportunities->getCallSkillsByCall($bookmark->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($bookmark->task_type === 'project') {

                                        $taskSkills = $opportunities->getProjectSkillsByTask($bookmark->id);
                                        $userSkills = $volunteerManager->getCurrentUser(get_current_user_id())->getSkills();

                                        $totalTaskSkills = count($taskSkills);

                                        $userSkillsNames = array();
                                        foreach ($userSkills as $skill) {
                                            $userSkillsNames[] = $skill->name;
                                        }

                                        $matchedSkillsValue = 0;
                                        $matchedSkills = array();
                                        foreach ($taskSkills as $taskSkill) {
                                            foreach ($userSkillsNames as $userSkillsName) {
                                                if ($taskSkill->name === $userSkillsName) {
                                                    $matchedSkillsValue++;
                                                    $matchedSkills[] = $userSkillsName;
                                                }
                                            }
                                        }

                                        ?>
                                        <?php if (!empty($matchedSkills)): ?>
                                            <div class="title-small-one">
                                                Matched skills
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedSkills); ?>
                                                <?php $howManyMore = 0; ?>
                                                <?php if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseSkills = array(); ?>
                                                <?php foreach ($matchedSkills as $skill): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $skill; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseSkills[] = $skill; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseSkills)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                            <?php foreach ($elseSkills as $item): ?>
                                                                <div class="single-skill"><?php echo $item; ?></div>
                                                            <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($bookmark->task_type === 'mentoring') {
                                        $mentoringData = $opportunities->getSingleMentoring($bookmark->id);

                                        ?>
                                        <div class="title-small-one">
                                            <?php _e('Area of Expertise', 'purpozed'); ?>
                                        </div>
                                        <div class="single-skill">
                                            <?php echo $mentoringData->aoe_name; ?>
                                        </div>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    } elseif ($bookmark->task_type === 'engagement') {
                                        ?>
                                        <?php if (!empty($matchedGoals)): ?>
                                            <div class="title-small-one">
                                                Matched goals
                                            </div>
                                            <div class="single-skills">
                                                <?php $matchedAmount = count($matchedGoals);
                                                $howManyMore = 0;
                                                if ($matchedAmount > 2) {
                                                    $howManyMore = $matchedAmount - 2;
                                                }
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php $elseGoals = array(); ?>
                                                <?php foreach ($matchedGoals as $goal): ?>
                                                    <?php if ($i < 3): ?>
                                                        <div class="single-skill"><?php echo $goal; ?></div>
                                                        <?php $i++; ?>
                                                    <?php else: ?>
                                                        <?php $elseGoals[] = $goal; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!empty($elseGoals)): ?>
                                                    <span class="show-more-skills">
                                                    <?php printf(__(' and %s more', 'purpozed'), $howManyMore); ?>
                                                    <div class="tooltip-skills">
                                                        <?php foreach ($elseGoals as $item): ?>
                                                            <div class="single-skill"><?php echo $item; ?></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="options">
                                <div class="single-option select"><a
                                            href="<?php echo $language; ?>/opportunity/?id=<?php echo $bookmark->id; ?>"><?php _e('MANAGE', 'purpozed'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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

<?php get_footer();
