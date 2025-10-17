<?php
require(dirname(__DIR__) . '/mapping.php');
?>

<?php if (isset($status)): ?>
    <?php if ($status): ?>
        <div class="success">Focus successfully saved!</div>
    <?php else: ?>
        <div class="fail">Focus can not be empty!</div>
    <?php endif; ?>
<?php endif; ?>

    <form action="" method="post">
        <div class="row buttons">
            <div class="add-mapping add-expertise"></div>
            <div class="expertise-input"><input type="text" name="item_name" placeholder="Add Focus"><input
                        type="hidden" name="table_name" value="focuses"></div>
            <div class="save-button large-button">
                <input type="submit" name="submit" value="SAVE">
            </div>
        </div>
    </form>

    <div class="row">
        <div class="title">
            <span>Focuses</span>
        </div>
    </div>

    <form action="" method="post">
        <div class="row buttons">
            <div class="">
                <textarea name="call_focus"><?php echo $currentCallFocus; ?></textarea>
            </div>
            <div class="save-button large-button">
                <input type="submit" name="save_focus" value="SAVE">
            </div>
        </div>
    </form>

<?php require(dirname(__FILE__) . '/itemsLoop.php'); ?>

    <div class="modal edit">
        <div class="modal-overlay modal-edit-button"></div>
        <div class="modal-wrapper modal-transition">
            <div class="modal-header">
                <h2 class="modal-heading">Rename focus</h2>
            </div>

            <div class="modal-body">
                <div class="modal-content">
                    <p><input type="text" name="item-name" data-name="" value=""></p>
                    <button class="modal-edit save-edit" data-table="focuses" data-id="" data-task="">SAVE CHANGES
                    </button>
                    <button class="modal-close modal-edit">CANCEL</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal delete">
        <div class="modal-overlay modal-delete-button"></div>
        <div class="modal-wrapper modal-transition">
            <div class="modal-header">
                <h2 class="modal-heading">Delete Call Focus</h2>
            </div>

            <div class="modal-body">
                <div class="modal-content">
                    <h3>Warning: Are you really sure you want to delete this Call Focus?</h3>
                    <button class="modal-delete delete-edit" data-table="focuses" data-id="" data-task="">DELETE
                    </button>
                    <button class="modal-close modal-edit">CANCEL</button>
                </div>
            </div>
        </div>
    </div>

<?php require(dirname(__FILE__) . '/modals.php'); ?>