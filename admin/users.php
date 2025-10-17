<?php
require(dirname(__FILE__) . '/dashboard.php');
?>

<div class="opportunities-section">
    <form method="get" action="">
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
                    <div class="search-select"><?php _e('Goals', 'purpozed'); ?></div>
                    <div class="options-select">
                        <?php foreach ($goals as $goal): ?>
                            <div class="single-option">
                                <input type="checkbox" name="goals[]" value="<?php echo $goal->id; ?>"
                                       id="goal_<?php echo $goal->id; ?>">
                                <label for="goal_<?php echo $goal->id; ?>"><?php echo $goal->name; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="search-item skills">
                <div name="skills">
                    <div class="search-select"><?php _e('Goals', 'purpozed'); ?>Skills</div>
                    <div class="options-select">
                        <?php foreach ($skills as $skill): ?>
                            <div class="single-option">
                                <input type="checkbox" name="skills[]" value="<?php echo $skill->id; ?>"
                                       id="skill_<?php echo $skill->id; ?>">
                                <label for="skill_<?php echo $skill->id; ?>"><?php echo $skill->name; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="search-item skills">
                <div name="skills">
                    <div class="search-select"><?php _e('Company', 'purpozed'); ?></div>
                    <div class="options-select">
                        <?php foreach ($companies as $company): ?>
                            <div class="single-option">
                                <input type="checkbox" name="companies[]" value="<?php echo $company['id']; ?>"
                                       id="company_<?php echo $company['id']; ?>">
                                <label for="company_<?php echo $company['id']; ?>"><?php echo $company['name']; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="search-item duration">
                <div name="format">
                    <div class="search-select">Right</div>
                    <div class="options-select">
                        <div class="single-option">
                            <input type="checkbox" name=rights[]" value="1" id="right_1">
                            <label for="right_1">Admin rights</label>
                        </div>
                        <div class="single-option">
                            <input type="checkbox" name="rights[]" value="2" id="right_2">
                            <label for="right_2">Management/Company Rights</label>
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
                <div class=""><?php echo $currentVolunteersNumber; ?> of <?php echo $allVolunteersNumber; ?> Users</div>
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
                <th>Name Organization</th>
                <th>Status since</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($volunteers as $volunteer): ?>
                <tr>
                    <td>
                        <div class="posted" id="posted">
                            <div class="volunteer-box">
                                <div class="single-volunteer colleagues">
                                    <div class="data">
                                        <div class="picture"><img
                                                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/profile_picture.png">
                                        </div>
                                        <div class="details">
                                            <div class="name"><?php echo $volunteer['first_name']; ?><?php echo $volunteer['last_name']; ?></div>
                                            <div class="job_title"><?php echo $volunteer['title']; ?></div>
                                            <div class="corporation"><?php echo $volunteer['organization']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                    <td><a href="/wp-admin/admin.php?page=edit-volunteer&id=<?php echo $volunteer['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
