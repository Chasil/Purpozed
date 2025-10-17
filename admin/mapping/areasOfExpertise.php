<?php
require(dirname(__DIR__) . '/mapping.php');
?>

<?php if(isset($status)): ?>
    <?php if($status): ?>
        <div class="success">Expertise successfully saved!</div>
    <?php else: ?>
        <div class="fail">Area of experience can not be empty!</div>
    <?php endif; ?>
<?php endif; ?>

<form action="" method="post">
    <div class="row buttons">
        <div class="add-mapping add-expertise"></div>
        <div class="expertise-input"><input type="text" name="item_name" placeholder="Add Area of Expertise"><input type="hidden" name="table_name" value="areas_of_expertise"></div>
        <div class="save-button large-button">
            <input type="submit" name="submit" value="SAVE">
        </div>
    </div>
</form>

<div class="row">
    <div class="title">
        <span>Areas of expertise</span>
    </div>
</div>

<?php require(dirname(__FILE__) . '/itemsLoop.php'); ?>

<div class="modal edit">
    <div class="modal-overlay modal-edit-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading">Rename area of expertise</h2>
        </div>

        <div class="modal-body">
            <div class="modal-content">
                <p><input type="text" name="item-name" data-name="" value=""></p>
                <button class="modal-edit save-edit" data-table="areas_of_expertise" data-id="" data-task="">SAVE CHANGES</button>
                <button class="modal-close modal-edit">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<div class="modal delete">
    <div class="modal-overlay modal-delete-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading">Delete area of expertise</h2>
        </div>

        <div class="modal-body">
            <div class="modal-content">
                <h3>Warning: Are you really sure you want to delete this area of expertise?</h3>
                <p>As a consaquence this area of Expertise will be disappear from:</p>
                <p>- the selection of areas of expertises within the opportunity Posting process</p>
                <p>- the corresponding project Task and call topics</p>
                <p>- in the skill sleection within the signup process</p>
                <p>- in evey opportunity Posting entered by an organization</p>
                <p>- in the tasks/topics which are mapped to this skill</p>
                <button class="modal-delete delete-edit" data-table="areas_of_expertise" data-id="" data-task="">DELETE</button>
                <button class="modal-close modal-edit">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<?php require(dirname(__FILE__) . '/modals.php'); ?>