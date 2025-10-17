<?php
require(dirname(__FILE__) . '/dashboard.php');
$opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
?>

<div class="opportunities-section">
    <form method="get" action="">
        <input type="hidden" name="page" value="opportunities">
        <div class="row filters">
            <div class="search-item goals">
                <div name="statuses">
                    <div class="search-select">Statuses</div>
                    <div class="options-select">
                        <?php foreach ($statuses as $status): ?>
                            <div class="single-option">
                                <input type="checkbox" name="statuses[]" value="<?php echo $status->status; ?>"
                                       id="status_<?php echo $status->status; ?>" <?php if (isset($_GET['statuses'])) {
                                    foreach ($_GET['statuses'] as $searched => $value) {
                                        if ($value === $status->status) {
                                            echo "checked='checked'";
                                        }
                                    }
                                } ?>>
                                <label for="status_<?php echo $status->status; ?>"><?php echo $status->status; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="search-item goals">
                <div name="goals">
                    <div class="search-select">Goals</div>
                    <div class="options-select">
                        <?php foreach ($goals as $goal): ?>
                            <div class="single-option">
                                <input type="checkbox" name="goals[]" value="<?php echo $goal->id; ?>"
                                       id="goal_<?php echo $goal->id; ?>" <?php if (isset($_GET['goals'])) {
                                    foreach ($_GET['goals'] as $searched => $value) {
                                        if ($value === $goal->id) {
                                            echo "checked='checked'";
                                        }
                                    }
                                } ?>>
                                <label for="goal_<?php echo $goal->id; ?>"><?php echo $goal->name; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="search-item skills">
                <div name="skills">
                    <div class="search-select">Skills</div>
                    <div class="options-select">
                        <?php foreach ($skills as $skill): ?>
                            <div class="single-option">
                                <input type="checkbox" name="skills[]" value="<?php echo $skill->id; ?>"
                                       id="skill_<?php echo $skill->id; ?>" <?php if (isset($_GET['skills'])) {
                                    foreach ($_GET['skills'] as $searched => $value) {
                                        if ($value === $skill->id) {
                                            echo "checked='checked'";
                                        }
                                    }
                                } ?>>
                                <label for="skill_<?php echo $skill->id; ?>"><?php echo $skill->name; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="search-item format">
                <div name="format">
                    <div class="search-select">Format</div>
                    <div class="options-select">
                        <div class="single-option">
                            <input type="checkbox" name="formats[]" value="call"
                                   id="format_call" <?php if (isset($_GET['formats'])) {
                                foreach ($_GET['formats'] as $searched => $value) {
                                    if ($value === "call") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="format_call">1h Call</label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="formats[]" value="project"
                                   id="format_project" <?php if (isset($_GET['formats'])) {
                                foreach ($_GET['formats'] as $searched => $value) {
                                    if ($value === "project") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="format_project">Project</label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="formats[]" value="mentoring"
                                   id="format_mentoring" <?php if (isset($_GET['formats'])) {
                                foreach ($_GET['formats'] as $searched => $value) {
                                    if ($value === "mentoring") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="format_mentoring">Mentoring</label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="formats[]" value="engagement"
                                   id="format_engagement" <?php if (isset($_GET['formats'])) {
                                foreach ($_GET['formats'] as $searched => $value) {
                                    if ($value === "engagement") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="format_engagement">Engagement</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-item duration">
                <div name="format">
                    <div class="search-select">Duration</div>
                    <div class="options-select">
                        <div class="single-option">
                            <input type="checkbox" name=durations[]" value="1"
                                   id="duration_1" <?php if (isset($_GET['durations'])) {
                                foreach ($_GET['durations'] as $searched => $value) {
                                    if ($value === "1") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="duration_1">1 hour</label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="durations[]" value="2"
                                   id="duration_2" <?php if (isset($_GET['durations'])) {
                                foreach ($_GET['durations'] as $searched => $value) {
                                    if ($value === "2") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="duration_2">1 day max</label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="durations[]" value="3"
                                   id="duration_3" <?php if (isset($_GET['durations'])) {
                                foreach ($_GET['durations'] as $searched => $value) {
                                    if ($value === "3") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="duration_3">1-3 days</label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="durations[]" value="4"
                                   id="duration_4" <?php if (isset($_GET['durations'])) {
                                foreach ($_GET['durations'] as $searched => $value) {
                                    if ($value === "4") {
                                        echo "checked='checked'";
                                    }
                                }
                            } ?>>
                            <label for="duration_4">3 days or longer</label>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <div class="search-item search"><input type="text" placeholder="Search"></div>-->
        </div>
        <div class="row filters-controlls">
            <div class="save-clear">
                <div class="filters-item clear">Clear filter</div>
            </div>
            <div class="amount">
                <div class=""><?php echo $currentOpportunitiesNumber; ?> of <?php echo $allOpportunitiesNumber; ?>
                    Opportunities
                </div>
            </div>
            <div class="look">
                <div class="filter-item search"><input type="submit" value="Search" name="search_all"></div>
            </div>
        </div>
    </form>

    <div class="opportunities-list">
        <table class="opportunities-table">
            <thead>
            <tr>
                <th>Opportunities</th>
                <th>Name Organization</th>
                <th>Status since (days)</th>
                <th>Due since (days)</th>
                <th>Expire in</th>
                <th>Duration</th>
                <th>Applied</th>
                <th>Applied 3+</th>
                <th>Requests</th>
                <th>Requested 3+</th>
                <th>Potential</th>
            </tr>
            </thead>
            <tbody>
            <?php $organization = new \Purpozed2\Models\Organization(); ?>
            <?php $singleOpportunity = new \Purpozed2\Models\Opportunity(); ?>
            <?php foreach ($opportunities as $opportunity): ?>
                <?php $organizationId = $singleOpportunity->getOrganization($opportunity->id); ?>
                <?php $organizationDetails = $organization->getDetailsById($organizationId); ?>
                <tr class="single-opportunity">
                    <td class="first-column">
                        <div class="fc-title"><a
                                    href="/wp-admin/admin.php?page=edit-opportunity&id=<?php echo $opportunity->id; ?>">
                                <?php
                                if ($opportunity->task_type === 'call') {
                                    $currentOpportunity = $opportunityManager->getSingleCall($opportunity->id);
                                    $topic = $opportunityManager->getTopic($currentOpportunity->topic);
                                    $focus = $opportunityManager->getFocuses($currentOpportunity->id);

                                    foreach ($focus as $item):
                                        echo $item->name . ' ';
                                    endforeach;

                                    echo ' ' . $topic->name;
                                } elseif ($opportunity->task_type === 'project') {
                                    $currentOpportunity = $opportunityManager->getSingleProject($opportunity->id);
                                    $topic = $opportunityManager->getTopic($currentOpportunity->topic);

                                    echo $topic->name . ' ';

                                } elseif ($opportunity->task_type === 'mentoring') {

                                    $currentOpportunity = $opportunityManager->getSingleMentoring($opportunity->id);

                                    echo $currentOpportunity->aoe_name . ' ';

                                } elseif ($opportunity->task_type === 'engagement') {
                                    $currentOpportunity = $opportunityManager->getSingleEngagement($opportunity->id);

                                    echo $currentOpportunity->title . ' ';
                                }
                                ?>
                            </a>
                        </div>
                        <div class="fc-items">
                            <div class="fc-status review"><?php echo $opportunity->task_type; ?></div>
                            <div class="fc-status <?php echo (isset($statusesTypes[$opportunity->status])) ? $statusesTypes[$opportunity->status] : ''; ?>"><?php echo $opportunity->status; ?></div>
                        </div>
                    </td>
                    <td>
                        <a href="/wp-admin/user-edit.php?user_id=<?php echo $organizationId; ?>&wp_http_referer=%2Fwp-admin%2Fusers.php"
                           target="_blank"><?php echo (isset($organizationDetails['organization_name'])) ? $organizationDetails['organization_name'][0] : '-'; ?></a>
                    </td>
                    <td><?php
                        if ($opportunity->task_type !== 'engagement') {
                            echo ($opportunity->status_since !== '18946') ? $opportunity->status_since : 'new';
                        } else {
                            echo ($opportunity->engagedSince->status_since) ? $opportunity->engagedSince->status_since : 'n/a';
                        }
                        ?></td>
                    <td><?php if ($opportunity->status === 'in_progress') {
                            echo $opportunity->due_since;
                        } else {
                            echo '-';
                        } ?></td>
                    <td><?php if ($opportunity->expire) {
                            echo $opportunity->expire_in;
                        } else {
                            echo '-';
                        } ?></td>
                    <td><?php echo $opportunity->duration_overall; ?></td>
                    <td></td>
                    <td><?php echo $opportunity->applied3plus->sum; ?></td>
                    <td></td>
                    <td><?php echo $opportunity->requested3plus->sum; ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
