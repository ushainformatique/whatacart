<?php
use usni\UsniAdaptor;
use yii\helpers\Url;
$isLoggedIn = UsniAdaptor::app()->user->getUserModel();
?>
<div class="well">
    <p><?php echo UsniAdaptor::t('cart', "Thank you for placing order with us. In case of any query, please contact us back");?> 
        <?php
        if($isLoggedIn)
        {
            $myOrdersUrl = UsniAdaptor::createUrl('customer/site/order-history');
            echo "Please view your order under <a href='" . $myOrdersUrl . "'>" . UsniAdaptor::t('order', 'My Orders') . "</a> section.";
        }
        ?>
    </p>
    <p>In case you have any questions, please <a href="mailto:someone@example.com?Subject=Query" target="_top">send email</a>.</p>
    <div class="buttons text-right">
        <a href="<?php echo Url::home()?>" class="btn btn-success"><?php echo UsniAdaptor::t('application', 'Continue');?></a>
    </div>
</div>
