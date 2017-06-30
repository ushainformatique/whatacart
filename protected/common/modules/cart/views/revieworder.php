<?php
use common\utils\ApplicationUtil;
use usni\UsniAdaptor;
use frontend\widgets\ActiveForm;
use cart\widgets\ConfirmCartSubView;

/* @var $this \frontend\web\View */
/* @var $reviewDTO \cart\dto\ReviewDTO */

$cart   = ApplicationUtil::getCart();
$this->params['breadcrumbs'][]  = [
                                    'label' => UsniAdaptor::t('cart', 'Shopping Cart'),
                                    'url'   => UsniAdaptor::createUrl('cart/default/view')
                                  ];
$this->title    = $this->params['breadcrumbs'][] = UsniAdaptor::t('cart', 'Confirm Order');
$order          = ApplicationUtil::getCheckoutFormModel('order');
?>
<?php $form = ActiveForm::begin([
                                    'id'     => 'reviewview', 
                                    'layout' => 'horizontal',
                                    'caption'=> $this->title,
                                    'action' => '#'
                               ]); ?>

        <div class="row">
            <div class="col-sm-3">
                <legend><?php echo UsniAdaptor::t('customer', 'Billing Address');?></legend>
                <?php echo $reviewDTO->getBillingContent();?>
            </div>
            <?php
            if($cart->isShippingRequired())
            {
            ?>
                <div class="col-sm-3">
                    <legend><?php echo UsniAdaptor::t('customer', 'Shipping Address');?></legend>
                    <?php echo $reviewDTO->getShippingContent();?>
                </div>
                <div class="col-sm-3">
                    <legend><?php echo UsniAdaptor::t('shipping', 'Shipping Method');?></legend>
                    <?php echo $reviewDTO->getShippingName();?>
                </div>
            <?php
            }
            ?>
            <div class="col-sm-3">
                <legend><?php echo UsniAdaptor::t('payment', 'Payment Method');?></legend>
                <?php echo $reviewDTO->getPaymentMethodName();?>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <?php echo ConfirmCartSubView::widget();?>
            </div>
        </div>
<?php ActiveForm::end();
echo $reviewDTO->getPaymentFormContent();