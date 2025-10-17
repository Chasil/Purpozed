<?php
require(dirname(__DIR__) . '/mapping.php');
?>

<?php if (isset($status)): ?>
    <?php if ($status): ?>
        <div class="success">Goal successfully saved!</div>
    <?php else: ?>
        <div class="fail">Adding to database error!</div>
    <?php endif; ?>
<?php endif; ?>

<?php if (isset($imageStatus)): ?>
    <?php if ($imageStatus): ?>
        <div class="success">Image updated successfully</div>
    <?php else: ?>
        <div class="fail">Image updated fail!</div>
    <?php endif; ?>
<?php endif; ?>

<form action="" method="post">
    <div class="row buttons">
        <div class="add-mapping add-expertise"></div>
        <div class="expertise-input"><input type="text" name="item_name" placeholder="Add Goal"><input type="hidden"
                                                                                                       name="table_name"
                                                                                                       value="goals">
        </div>
        <div class="save-button large-button">
            <input type="submit" name="submit" value="<?php _e('SAVE', 'purpozed'); ?>">
        </div>
    </div>
</form>

<div class="row">
    <div class="title">
        <span>Sustainable Develepment Goals</span>
    </div>
</div>
<div class="expertises-list">
    <?php foreach ($items as $item): ?>
        <div class="row expertises goals full-width">
            <div class="name"><?php echo $item->name; ?></div>
            <div class="edit">
                <button data-id="<?php echo $item->id; ?>" data-task="edit" class="modal-edit-button"><img
                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/edit.svg"></button>
            </div>
            <div class="delete">
                <button data-id="<?php echo $item->id; ?>" data-task="delete" class="modal-delete-button"><img
                            src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/delete.svg"></button>
            </div>
            <div class="upload-image">
                <form action="" method="post">
                    <input type="hidden" value="<?php echo $item->id; ?>" name="goal_id" max="" min="1" step="1">
                    <input type="hidden" value="" name="image_id" max="" min="1" step="1">
                    <button class="set_custom_images">PICTURE UPLOAD</button>
                    <button type="submit" class="" name="save_image">SAVE PICTURE</button>
                </form>
            </div>
            <?php if ($image = wp_get_attachment_image_url($item->image_id)): ?>
                <div class="uploaded-image"><img src="<?php echo $image; ?>"></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal edit">
    <div class="modal-overlay modal-edit-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading">Rename goal</h2>
        </div>

        <div class="modal-body">
            <div class="modal-content">
                <p><input type="text" name="item-name" data-name="" value=""></p>
                <button class="modal-edit save-edit" data-table="goals" data-id="" data-task="">SAVE CHANGES</button>
                <button class="modal-close modal-edit">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<div class="modal delete">
    <div class="modal-overlay modal-delete-button"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h2 class="modal-heading">Delete goal</h2>
        </div>

        <div class="modal-body">
            <div class="modal-content">
                <h3>Warning: Are you really sure you want to delete this goal?</h3>
                <button class="modal-delete delete-edit" data-table="goals" data-id="" data-task="">DELETE</button>
                <button class="modal-close modal-edit">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<?php require(dirname(__FILE__) . '/modals.php'); ?>
