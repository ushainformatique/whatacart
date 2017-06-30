<?php
use usni\UsniAdaptor;
use yii\helpers\Url;

/* @var $this \frontend\web\View */
$loggedInUser = UsniAdaptor::app()->user->getId();
$this->title = $this->params['breadcrumbs'][] = UsniAdaptor::t('order', 'Complete Order');
?>
<div class="well">
    <p><?php echo UsniAdaptor::t('cart', "Thank you for placing order with us. In case of any query, please contact us back");?> 
        <?php
        if($loggedInUser != null)
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
