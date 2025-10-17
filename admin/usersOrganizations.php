<?php
require(dirname(__FILE__) . '/dashboard.php');
?>

<div class="opportunities-section">
    <form method="post" action="">
        <div class="row types">
            <div class=""><a href="/wp-admin/admin.php?page=users-volunteers"
                             class="<?php echo ($_GET['page'] === 'users-volunteers') ? 'active' : ''; ?>">Volunteers</a>
            </div>
            <div class=""><a href="/wp-admin/admin.php?page=users-organizations"
                             class="<?php echo ($_GET['page'] === 'users-organizations') ? 'active' : ''; ?>">Organizations</a>
            </div>
            <div class=""><a href="/wp-admin/admin.php?page=users-companies"
                             class="<?php echo ($_GET['page'] === 'users-companies') ? 'active' : ''; ?>">Companies</a>
            </div>
        </div>
        <div class="row filters">
            <div class="search-item goals">
                <div name="goals">
                    <div class="search-select">Goals</div>
                    <div class="options-select">
                        <?php foreach ($goals as $goal): ?>
                            <div class="single-option">
                                <input type="checkbox" name="goals[]" value="<?php echo $goal->id; ?>"
                                       id="goal_<?php echo $goal->id; ?>" <?php if (isset($_POST['goals'])) {
                                    foreach ($_POST['goals'] as $searched => $value) {
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
            <!--            <div class="search-item search"><input type="text" placeholder="Search"></div>-->
        </div>
        <div class="row filters-controlls">
            <div class="save-clear">
                <div class="filters-item clear">Clear filter</div>
            </div>
            <div class="amount">
                <div class=""><?php echo $currentOrganizationsNumber; ?> of <?php echo $allOrganizationsNumber; ?>
                    Organizations
                </div>
            </div>
            <div class="look">
                <div class="filter-item search"><input type="submit" value="Search" name="search_all"></div>
            </div>
        </div>
    </form>

    <div class="dashboard">
        <table class="opportunities-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Status since</th>
                <th>Posted (all statuses)</th>
                <th>Open</th>
                <th>Succeeded</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php $singleOrganization = new \Purpozed2\Models\Organization(); ?>
            <?php $opportunitiesManager = new \Purpozed2\Models\OpportunitiesManager(); ?>
            <?php $statuses = array('succeeded'); ?>
            <?php $posted = array('prepared', 'review', 'open', 'in_progress', 'canceled', 'succeeded', 'retracted', 'expired'); ?>
            <?php $open = array('open'); ?>
            <?php foreach ($organizations as $organization): ?>
                <?php $mainGoal = $singleOrganization->getMainGoal($organization['main_goal']); ?>
                <tr>
                    <td>
                        <div class="posted" id="posted">
                            <div class="volunteer-box">
                                <div class="single-volunteer colleagues">
                                    <div class="data">
                                        <div class="picture"><img
                                                    src="<?php echo wp_get_attachment_image_src($organization['logo'], 'medium')[0]; ?>">
                                        </div>
                                        <div class="details">
                                            <div class="name"><?php echo $organization['organization_name']; ?></div>
                                            <div class="job_title"></div>
                                            <div class="corporation"><?php _e('Main goal', 'purpozed'); ?>
                                                :<br> <?php echo $mainGoal->name; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $organization['registered']; ?></td>
                    <td><?php echo count($opportunitiesManager->getList($organization['id'], $posted)); ?></td>
                    <td><?php echo count($opportunitiesManager->getList($organization['id'], $open)); ?></td>
                    <td><?php echo count($opportunitiesManager->getList($organization['id'], $statuses)); ?></td>
                    <td>
                        <a href="/wp-admin/admin.php?page=edit-organization&id=<?php echo $organization['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
