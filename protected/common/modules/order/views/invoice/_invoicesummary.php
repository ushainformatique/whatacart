<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
?>

<?php echo Html::tag('strong', UsniAdaptor::t('order', 'Invoice Number:')) .  ' ' . $invoiceNo?><br/>
<?php echo Html::tag('strong', UsniAdaptor::t('order', 'Order Number:')) . ' ' . $orderNo?><br/>
<?php echo Html::tag('strong', UsniAdaptor::t('order', 'Issue Date:')) . ' ' . $issueDate?><br/>
<?php echo Html::tag('strong', UsniAdaptor::t('order', 'Payment Method:')) . ' ' . $paymentMethod?><br/>
