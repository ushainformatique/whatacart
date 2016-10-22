<?php
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
?>

<?php echo UiHtml::tag('strong', UsniAdaptor::t('order', 'Invoice Number:')) . $invoiceNo?><br/>
<?php echo UiHtml::tag('strong', UsniAdaptor::t('order', 'Order Number:')) . $orderNo?><br/>
<?php echo UiHtml::tag('strong', UsniAdaptor::t('order', 'Issue Date:')) . $issueDate?><br/>
<?php echo UiHtml::tag('strong', UsniAdaptor::t('order', 'Payment Method:')) . $paymentMethod?><br/>
