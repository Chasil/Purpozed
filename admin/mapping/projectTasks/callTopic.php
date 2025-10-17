<?php
require(dirname(__DIR__, 2) . '/mapping.php');
?>

<div class="add-project">

    <?php if (isset($status)): ?>
        <?php if ($status): ?>
            <div class="success"><?php _e('Task successfully saved!', 'purpozed'); ?></div>
        <?php else: ?>
            <div class="fail"><?php _e('Adding to database error!', 'purpozed'); ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <div>
        <form action="" method="post">
            <div class="row buttons">
                <div class="header">Call Topic</div>
                <div class="save-button save-task">
                    <button type="submit" name="submit">SAVE CHANGES</button>
                </div>
                <div class="delete-button delete-task">DELETE</div>
            </div>
            <div class="row form">
                <div class="name-box">
                    <label>Name of the task
                        <div><input class="name" type="text" name="name"
                                    value="<?php echo (isset($taskData)) ? $taskData[$_GET['id']]->name : ''; ?>"></div>
                    </label>
                    <div class="error-box extra">Name can not be empty</div>
                </div>
                <div class="">
                    <label>Brief description
                        <div><textarea
                                    name="description"><?php echo (isset($taskData)) ? $taskData[$_GET['id']]->description : ''; ?></textarea>
                        </div>
                    </label>
                </div>
                <label>Duration (every call where one discuss a topic lasts one hour)</label>
                <div class="select">
                    <div>
                        <select name="days_duration">
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div>
                        <select name="hours_duration">
                            <option value="1">hour</option>
                        </select>
                    </div>
                </div>
                <div class="aoe">
                    <label class="">Area of exprtise</label>
                    <div class="">
                        <button type="button" class="modal-expertises">SELECT AREA OF EXPERTISE</button>
                    </div>
                    <div class="error-box extra">Check at least one Area of Expertise</div>
                </div>
                <div class="">
                    <label class="">Needed Skills (Mapping)</label>
                    <div class="checkboxes">
                        <?php foreach ($skills as $skill): ?>
                            <div class="single-checkbox">
                                <input class="skill-checkbox" type="checkbox" name="skills[<?php echo $skill->id; ?>]"
                                       id="skill_<?php echo $skill->id; ?>" <?php if (isset($taskData)) {
                                    foreach ($taskData[$_GET['id']]->skills as $getSkill) {
                                        if ($getSkill['skill_id'] === $skill->id) {
                                            echo 'checked="checked"';
                                        }
                                    }
                                } ?>>
                                <label for="skill_<?php echo $skill->id; ?>"><?php echo $skill->name; ?></label>
                            </div>
                        <?php endforeach; ?>
                        <div class="error-box extra"><?php _e('Check at least one skill', 'purpozed'); ?></div>
                    </div>
                </div>

                <div class="modal expertises">
                    <div class="modal-overlay modal-expertises"></div>
                    <div class="modal-wrapper modal-transition">
                        <div class="modal-header">
                            <h2 class="modal-heading"><?php _e('Choose area of expertise', 'purpozed'); ?></h2>
                        </div>

                        <div class="modal-body">
                            <div class="modal-content">
                                <?php foreach ($expertises as $expertise): ?>
                                    <div class="single-aoe">
                                        <input class="aoe_radio" type="radio" name="area_of_expertise"
                                               value="<?php echo $expertise->id; ?>"
                                               id="aoe_<?php echo $expertise->id; ?>" <?php echo (isset($taskData) && $taskData[$_GET['id']]->area_of_expertise === $expertise->id) ? 'checked="checked"' : ''; ?>>
                                        <label for="aoe_<?php echo $expertise->id; ?>"><?php echo $expertise->name; ?></label>
                                    </div>
                                <?php endforeach; ?>
                                <button type="button" class="modal-close modal-edit save">SAVE</button>
                                <button class="modal-close modal-edit"><?php _e('CANCEL', 'purpozed'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($_GET['id'])): ?>
                <input type="hidden" name="edit">
                <input type="hidden" name="task_id" value="<?php echo $_GET['id']; ?>">
            <?php endif; ?>
        </form>
    </div>
</div>