<?php
use common\utils\ApplicationUtil;
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use common\modules\order\widgets\AdminConfirmCartSubView;
use common\modules\order\widgets\ConfirmOrderFormButtons;

/* @var $this \frontend\web\View */

$this->params['breadcrumbs'][]  = [
                                    'label' => UsniAdaptor::t('orders', 'Manage Orders'),
                                    'url'   => UsniAdaptor::createUrl('order/default/index')
                                  ];
$this->title    = $this->params['breadcrumbs'][] = UsniAdaptor::t('cart', 'Confirm Order');
$order          = ApplicationUtil::getCheckoutFormModel('order');
$cart           = ApplicationUtil::getCart();

$form   = ActiveForm::begin([
                                'id'     => 'reviewview', 
                                'layout' => 'horizontal',
                                'caption'=> $this->title
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
                <?php echo AdminConfirmCartSubView::widget();?>
            </div>
        </div>
        <?php
            echo $form->field($model, 'comments')->textarea();
            echo $form->field($model, 'status')->select2Input($reviewDTO->getAllStatus());
        ?>
    <?= ConfirmOrderFormButtons::widget(['submitButtonLabel' => UsniAdaptor::t('application', 'Confirm Order'),
                             'cancelUrl' => UsniAdaptor::createUrl('order/default/checkout'),
                             'cancelLinkLabel' => UsniAdaptor::t('cart', 'Back'),
                             'editCartUrl' => UsniAdaptor::createUrl('order/default/add-to-cart')
                             ]);?>
<?php ActiveForm::end();