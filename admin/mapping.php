<?php
 require(dirname(__FILE__) . '/dashboard.php');
 ?>

<div class="mapping-menu">
  <div class="item <?php echo ($_GET['page'] === 'areas-of-expertise') ? 'active' : ''; ?>">
      <a href="/wp-admin/admin.php?page=areas-of-expertise">Areas of expertise</a>
  </div>
  <div class="item <?php echo ($_GET['page'] === 'project-tasks' || $_GET['page'] === 'project-task' || $_GET['page'] === 'call-topic') ? 'active' : ''; ?>">
      <a href="/wp-admin/admin.php?page=project-tasks">Project Tasks & Call Topics</a>
  </div>
  <div class="item <?php echo ($_GET['page'] === 'skills') ? 'active' : ''; ?>">
      <a href="/wp-admin/admin.php?page=skills">Skills</a>
  </div>
  <div class="item <?php echo ($_GET['page'] === 'call-focuses') ? 'active' : ''; ?>">
      <a href="/wp-admin/admin.php?page=call-focuses">Call Focuses</a>
  </div>
<div class="item <?php echo ($_GET['page'] === 'goals') ? 'active' : ''; ?>">
    <a href="/wp-admin/admin.php?page=goals">Goals</a>
</div>
</div>
