<?php
require(dirname(__FILE__) . '/dashboard.php');
$opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
?>

<div class="opportunities-section">
    <div class="" id="corporate_knowledge">
        <h2><?php _e('Corporate Knowledge', 'purpozed'); ?></h2>
        <div class="corporate_knowledge">
            <div class="employees">
                <table class="employee">
                    <thead>
                    <tr>
                        <th><?php _e('Skill', 'purpozed'); ?></th>
                        <th><?php _e('number of volunteers with this skill', 'purpozed'); ?></th>
                        <th><?php _e('% of volunteers with this skill', 'purpozed'); ?></th>
                        <th><?php _e('number of opportunities (only calls, projects) with the staus OPEN where this skill is needed', 'purpozed'); ?></th>
                        <th><?php _e('% of opportunities (only calls, projects) with the staus OPEN where this skill is needed for', 'purpozed'); ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($parsedSkills as $skill): ?>
                        <tr>
                            <td class="short_column">
                                <?php echo $skill['name']; ?>
                            </td>
                            <td class="short_column"><?php echo $skill['volunteers_using']; ?></td>
                            <td class="shorter_column"><?php echo $skill['percentage']; ?>%</td>
                            <td class="short_column"><?php echo $skill['opportunities']; ?></td>
                            <td class="short_column"><?php echo $skill['opportunities_percentage']; ?>%</td>
                            <!--                            <td class="max_column">-->
                            <!--                                <div class="knowledge_range" style="width: -->
                            <?php //echo $skill['percentage']; ?><!--"></div>-->
                            <!--                            </td>-->
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
