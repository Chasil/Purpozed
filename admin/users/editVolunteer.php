<?php
require(dirname(__DIR__) . '/dashboard.php');
?>
<?php if($userError): ?>
    <div class="fail">No id or id false!</div>
<?php endif; ?>

<form action="" method="post">
    <label>Admin rights <input type="checkbox" name="admin_rights" <?php echo ($isAdmin === '1') ? 'checked="checked"' : ''; ?>></label>
    <label>Invited <input type="checkbox" name="invited" <?php echo ($invited === '1') ? 'checked="checked"' : ''; ?>></label>
    <input type="submit" name="submit" value="Zapisz">
</form>