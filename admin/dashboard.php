<div class="admin-dashboard">

    <div class="dashboard-menu">
        <div class="logo">
            <a href="/"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/purpozed_logo.svg"></a>
        </div>
        <div class="title">
            <span>Admin panel</span>
        </div>

        <div class="menu-bar">
            <div class="menu-item">
                <a href="/wp-admin/admin.php?page=dashboard"
                   class="<?php echo ($_GET['page'] === 'dashboard') ? 'active' : ''; ?>">Dashboard</a>
            </div>
            <div class="menu-item">
                <a href="/wp-admin/admin.php?page=users-volunteers"
                   class="<?php echo ($_GET['page'] === 'users-volunteers') ? 'active' : ''; ?>">Users</a>
            </div>
            <div class="menu-item">
                <a href="/wp-admin/admin.php?page=opportunities"
                   class="<?php echo ($_GET['page'] === 'opportunities') ? 'active' : ''; ?>">Opportunities</a>
            </div>
            <div class="menu-item">
                <?php $mappingItems = array('areas-of-expertise', 'project-tasks', 'call-focuses', 'skills', 'goals', 'project-task', 'project-call'); ?>
                <?php $getTtem = $_GET['page']; ?>
                <a href="/wp-admin/admin.php?page=areas-of-expertise"
                   class="<?php echo (in_array($getTtem, $mappingItems)) ? 'active' : ''; ?>">Mapping</a>
            </div>
            <div class="menu-item">
                <a href="/wp-admin/admin.php?page=main-settings"
                   class="<?php echo ($_GET['page'] === 'purpozed-settings') ? 'active' : ''; ?>">Settings</a>
            </div>
        </div>
    </div>
</div>

