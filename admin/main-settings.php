<h1>SETTINGS</h1>

<?php $allMenus = wp_get_nav_menus(); ?>
<?php $volunteersMenu = get_option('purpozed_volunteers_menu')[0]; ?>
<?php $organizationMenu = get_option('purpozed_organization_menu')[0]; ?>
<?php $companyMenu = get_option('purpozed_company_menu')[0]; ?>

<form action="" method="post">
    <h2>Volunteers</h2>
    <div>
        <p>Max. number of opportunities a volunteer can apply for at the same time (and shown on the volunteer's
            dashboard)</p>
        <input type="number" name="max_number_of_opportunities_a_volunteer_can_apply_same_time"
               value="<?php echo($max_number_of_opportunities_a_volunteer_can_apply_same_time); ?>">
    </div>
    <div>
        <p>Max. number of opportunities a single volunteer can be requested for (and shown on the volunteer's
            dashboard)</p>
        <input type="number" name="max_number_of_opportunities_a_volunteer_can_be_requested"
               value="<?php echo($max_number_of_opportunities_a_volunteer_can_be_requested); ?>">
    </div>

    <div>
        <p>Max. number of opportunities a volunteer can be working on at the same time (and shown on the volunteer's
            dashboard)</p>
        <input type="number" name="max_number_of_opportunities_a_volunteer_can_work_on_same_time"
               value="<?php echo($max_number_of_opportunities_a_volunteer_can_work_on_same_time); ?>">
    </div>
    <h2>Organizations</h2>
    <div>
        <p>Max. number of volunteers a organization can requested at the same time in total</p>
        <input type="number" name="max_number_of_volunteers_a_organization_can_request_same_time_in_total"
               value="<?php echo($max_number_of_volunteers_a_organization_can_request_same_time_in_total); ?>">
    </div>
    <div>
        <p>Max. number of volunteers a organization can requested at the same time for a specific opportunity</p>
        <input type="number"
               name="max_number_of_volunteers_a_organization_can_request_same_time_for_specyfic_opportunity"
               value="<?php echo($max_number_of_volunteers_a_organization_can_request_same_time_for_specyfic_opportunity); ?>">
    </div>

    <div>
        <p>Max. number of open opportunities of an organization</p>
        <input type="number" name="max_number_of_opportunities_of_an_organization"
               value="<?php echo($max_number_of_opportunities_of_an_organization); ?>">
    </div>

    <input type="submit" value="Save" name="save-main-settings">
</form>