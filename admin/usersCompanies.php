<?php
require(dirname(__FILE__) . '/dashboard.php');
?>

<div class="opportunities-section">
    <form method="post" action="">
        <div class="row types">
            <div class=""><a href="/wp-admin/admin.php?page=users-volunteers" class="<?php echo ($_GET['page'] === 'users-volunteers') ? 'active' : ''; ?>">Volunteers</a></div>
            <div class=""><a href="/wp-admin/admin.php?page=users-organizations" class="<?php echo ($_GET['page'] === 'users-organizations') ? 'active' : ''; ?>">Organizations</a></div>
            <div class=""><a href="/wp-admin/admin.php?page=users-companies" class="<?php echo ($_GET['page'] === 'users-companies') ? 'active' : ''; ?>">Companies</a></div>
        </div>
    </form>

    <div class="row buttons">
        <a href="/wp-admin/admin.php?page=edit-company"><div class="add-mapping add-expertise"></div></a>
    </div>

    <div class="row filters-controlls">
        <div class="save-clear">
        </div>
        <div class="amount">
            <div class=""><?php echo $currentCompaniesNumber; ?> of <?php echo $allCompaniesNumber; ?> Organizations</div>
        </div>
        <div class="look">
        </div>
    </div>

    <div class="dashboard">
        <table class="opportunities-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Signup Date</th>
                <th>Active Employees</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($companies as $company): ?>
                <tr>
                    <td>
                    <div class="posted" id="posted">
                        <div class="volunteer-box">
                            <div class="single-volunteer colleagues">
                                <div class="data">
                                    <div class="picture"><img src="<?php echo wp_get_attachment_image_src( $company['logo'], 'medium' )[0]; ?>"></div>
                                    <div class="details">
                                        <div class="name"><?php echo $company['first_name']; ?></div>
                                        <div class="job_title"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </td>
                    <td><?php echo $company['registered']; ?></td>
                    <td><?php echo (isset($companyUsers[$company['id']])) ? count($companyUsers[$company['id']]) : '0'; ?></td>
                    <td><a href="/wp-admin/admin.php?page=edit-company&id=<?php echo $company['id']; ?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
