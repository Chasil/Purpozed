<h1>SETTINGS</h1>

<?php $allMenus = wp_get_nav_menus(); ?>
<?php $volunteersMenu = get_option('purpozed_volunteers_menu'); ?>
<?php $organizationMenu = get_option('purpozed_organization_menu'); ?>
<?php $companyMenu = get_option('purpozed_company_menu'); ?>
<?php $signInFooter = get_option('purpozed_sign_in_footer'); ?>
<?php $organizationFooter = get_option('purpozed_organization_footer'); ?>
<?php $volCompaFooter = get_option('purpozed_vol_compa_footer'); ?>

<form action="" method="post">
    <div><span>Volunteers Menu</span>
        <select name="volunteers_menu">
            <option value="">Choose menu</option>
            <?php foreach ($allMenus as $menu): ?>
                <option value="<?php echo $menu->term_id; ?>" <?php echo ($menu->term_id === (int)$volunteersMenu) ? ' selected="selected"' : ''; ?>><?php echo $menu->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>Organization Menu
        <select name="organization_menu">
            <option value="">Choose menu</option>
            <?php foreach ($allMenus as $menu): ?>
                <option value="<?php echo $menu->term_id; ?>" <?php echo ($menu->term_id === (int)$organizationMenu) ? ' selected="selected"' : ''; ?>><?php echo $menu->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>Company Menu
        <select name="company_menu">
            <option value="">Choose menu</option>
            <?php foreach ($allMenus as $menu): ?>
                <option value="<?php echo $menu->term_id; ?>" <?php echo ($menu->term_id === (int)$companyMenu) ? ' selected="selected"' : ''; ?>><?php echo $menu->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="submit" value="Save" name="save_menus" class="button button-primary">
</form>

<form action="" method="post">
    <div><span>Signin Footer</span>
        <select name="sign_in_footer">
            <option value="">Choose menu</option>
            <?php foreach ($allMenus as $menu): ?>
                <option value="<?php echo $menu->term_id; ?>" <?php echo ($menu->term_id === (int)$signInFooter) ? ' selected="selected"' : ''; ?>><?php echo $menu->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>Organization Footer
        <select name="organization_footer">
            <option value="">Choose menu</option>
            <?php foreach ($allMenus as $menu): ?>
                <option value="<?php echo $menu->term_id; ?>" <?php echo ($menu->term_id === (int)$organizationFooter) ? ' selected="selected"' : ''; ?>><?php echo $menu->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>Volunteer + Company Footer
        <select name="vol_compa_footer">
            <option value="">Choose menu</option>
            <?php foreach ($allMenus as $menu): ?>
                <option value="<?php echo $menu->term_id; ?>" <?php echo ($menu->term_id === (int)$volCompaFooter) ? ' selected="selected"' : ''; ?>><?php echo $menu->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="submit" value="Save" name="save_footers" class="button button-primary">
</form>