<div class="expertises-list">
    <?php foreach($items as $item): ?>
        <div class="row expertises">
            <div class="name"><?php echo $item->name; ?></div>
            <div class="edit"><button data-id="<?php echo $item->id; ?>" data-task="edit" class="modal-edit-button"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/edit.svg"></button></div>
            <div class="delete"><button data-id="<?php echo $item->id; ?>" data-task="delete" class="modal-delete-button"><img src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/delete.svg"></button></div>
        </div>
    <?php endforeach; ?>
</div>
