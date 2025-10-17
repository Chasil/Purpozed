<?php
require(dirname(__DIR__) . '/mapping.php');
?>

    <div>
        <div class="row buttons more-space">
            <div class="add-mapping add-expertise modal-task-topic add-button"></div>
            <input type="text" name="search" placeholder="Search" class="search-field">
        </div>

        <div class="modal task-topic">
            <div class="modal-overlay modal-task-topic"></div>
            <div class="modal-wrapper modal-transition">
                <div class="modal-header">
                    <h2 class="modal-heading">Add task/topic</h2>
                </div>

                <div class="modal-body">
                    <div class="modal-content">
                        <button class="modal-edit"><a href="/wp-admin/admin.php?page=project-task">ADD PROJECT TASK</a>
                        </button>
                        <button class="modal-edit"><a href="/wp-admin/admin.php?page=call-topic">ADD CALL TOPIC</a>
                        </button>
                        <button class="modal-close modal-edit">CANCEL</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="expertises-list">
            <?php $count = 0; ?>
            <?php foreach ($allProjectTasks as $task): ?>
                <div class="row expertises full-width">
                    <?php if ($count < 1): ?>
                        <div class="row project-task">
                            <div class="header">Project Tasks & Call Topics</div>
                            <div class="search">
                                <form action="" method="post">
                                    <select name="search_type" class="search-type">
                                        <option value="all">All</option>
                                        <option value="project">Project Tasks</option>
                                        <option value="call">Call Topics</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="type"><?php echo ($task->type === 'project') ? 'Project Task' : 'Call Topic'; ?></div>
                    <div class="name"><?php echo $task->name; ?></div>
                    <div class="edit"><a
                                href="/wp-admin/admin.php?page=<?php echo ($task->type === 'project') ? 'project-task' : 'call-topic'; ?>&id=<?php echo $task->id; ?>"
                                class="edit-button"><img
                                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/edit.svg"></a></div>
                    <div class="delete">
                        <button data-id="<?php echo $task->id; ?>" data-task="delete" class="modal-delete-button"><img
                                    src="<?php echo plugins_url(); ?>/purpozed2/assets/gfx/delete.svg"></button>
                    </div>
                    <div class="skills">
                        <?php if ($count < 1): ?>
                            <div class="header">Skills</div>
                        <?php endif; ?>
                        <?php foreach ($task->skills as $skill): ?>
                            <div class="skill"><?php echo $skill['skill_name']; ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="days_duration" style="display: none">
                        <?php echo $task->days_duration; ?>
                    </div>
                    <div class="duration" style="display: none">
                        <?php echo $task->hours_duration; ?>
                    </div>
                    <div class="description" style="display: none">
                        <?php echo $task->description; ?>
                    </div>
                    <div class="more">
                        ...
                    </div>
                    <div class="area-of-expertise">
                        <?php if ($count < 1): ?>
                            <div class="row">
                                <div class="header">Area of Expertise</div>
                                <div class="search">
                                    <form action="" method="post">
                                        <select name="area_of_expertise" class="search-type">
                                            <option value="all">All</option>
                                            <?php foreach ($aoes as $aoe): ?>
                                                <option value="<?php echo $aoe->id; ?>"><?php echo $aoe->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php echo $task->aoe_name; ?>
                    </div>
                </div>
                <?php $count++; ?>
            <?php endforeach; ?>
        </div>


    </div>

    <div class="modal delete">
        <div class="modal-overlay modal-delete-button"></div>
        <div class="modal-wrapper modal-transition">
            <div class="modal-header">
                <h2 class="modal-heading">Delete task</h2>
            </div>

            <div class="modal-body">
                <div class="modal-content">
                    <h3>Warning: Are you really sure you want to delete this task?</h3>
                    <button class="modal-delete delete-edit" data-table="project_tasks" data-id="" data-task="">DELETE
                    </button>
                    <button class="modal-close modal-edit">CANCEL</button>
                </div>
            </div>
        </div>
    </div>

<?php require(dirname(__FILE__) . '/modals.php'); ?>