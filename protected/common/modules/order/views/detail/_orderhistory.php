<?php
use usni\UsniAdaptor;
use usni\library\utils\DateTimeUtil;
use common\modules\localization\modules\orderstatus\widgets\StatusLabel;
use common\modules\order\models\OrderHistory;

/* @var $detailViewDTO \common\modules\order\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$rows = $detailViewDTO->getHistoryRecords();
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
            if (!empty($rows))
            {
                ?>
                <tbody>
                    <?php
                    foreach ($rows as $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo StatusLabel::widget(['model' => $row]);?></td>
                            <td><?php echo DateTimeUtil::getFormattedDateTime($row['created_datetime']) ?></td>
                            <td><?php echo $row['comment'] ?></td>
                            <td><?php echo (bool) $row['notify_customer'] == true ? UsniAdaptor::t('application', 'Yes') : UsniAdaptor::t('application', 'No') ?></td>
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
                    <tr><td colspan="6"><?php echo \Yii::t('yii', 'No results found.'); ?></td></tr>
                </tbody>
                <?php
            }
            ?>
        </table>
    </div>
</div>
<br/>
<?php
echo $this->render('/detail/_orderhistoryedit', ['model' => new OrderHistory(['scenario' => 'create']),
                                            'detailViewDTO' => $detailViewDTO]);