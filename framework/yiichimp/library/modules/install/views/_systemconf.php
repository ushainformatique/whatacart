<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
?>
<div class="row">
    <table class="table table-hover">
        <thead>
            <tr>
                <th><?php echo UsniAdaptor::t('install', 'Name'); ?></th>
                <th><?php echo UsniAdaptor::t('install', 'Result'); ?></th>
                <th><?php echo UsniAdaptor::t('install', 'Required By'); ?></th>
                <th><?php echo UsniAdaptor::t('install', 'Memo'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($requirements as $requirement)
            {
                ?>
                <tr class="<?php echo $requirement['condition'] ? 'success' : ($requirement['mandatory'] ? 'danger' : 'warning') ?>">
                    <td>
                    <?php echo $requirement['name'] ?>
                    </td>
                    <td>
                    <span class="result"><?php echo $requirement['condition'] ? 'Passed' : ($requirement['mandatory'] ? 'Failed' : 'Warning') ?></span>
                    </td>
                    <td>
                    <?php echo $requirement['by'] ?>
                    </td>
                    <td>
                    <?php echo $requirement['memo'] ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>