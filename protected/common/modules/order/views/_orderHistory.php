<?php
use usni\UsniAdaptor;
use usni\library\utils\DateTimeUtil;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
?>
<div id="order-history">
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo UsniAdaptor::t('customer', 'Status'); ?></th>
                <th><?php echo UsniAdaptor::t('customer', 'Date Added'); ?></th>
                <th><?php echo UsniAdaptor::t('application', 'Comment'); ?></th>
                <th><?php echo UsniAdaptor::t('customer', 'Customer Notified'); ?></th>
            </tr>
        </thead>
        <?php
        if($rows != null)
        {
        ?>
            <tbody>
            <?php
            foreach ($rows as $row)
            {
            ?>
            <tr>
            <td><?php echo OrderStatusUtil::renderLabel($row)?></td>
            <td><?php echo DateTimeUtil::getFormattedDateTime($row['created_datetime'])?></td>
            <td><?php echo $row['comment']?></td>
            <td><?php echo (bool)$row['notify_customer'] == true ? UsniAdaptor::t('application', 'Yes'):UsniAdaptor::t('application', 'No')?></td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        <?php
        }
        else
        {
        ?>
            <tbody>
                <tr><td colspan="6"><?php echo \Yii::t('yii', 'No results found.');?></td></tr>
            </tbody>
        <?php
        }
        ?>
    </table>
</div>
</div>

