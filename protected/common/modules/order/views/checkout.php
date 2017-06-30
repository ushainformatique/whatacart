<?php
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \cart\dto\CheckoutDTO */

$isShippingRequired = $formDTO->getCart()->isShippingRequired();

$this->params['breadcrumbs'][] = [
                                    'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                    UsniAdaptor::t('order', 'Orders'),
                                    'url' => ['/order/default/index']
                                ];
$this->title = $this->params['breadcrumbs'][] = UsniAdaptor::t('cart', 'Checkout');

$shippingMethods = $formDTO->getShippingMethods();
$paymentMethods  = $formDTO->getPaymentMethods();
if($isShippingRequired && empty($shippingMethods))
{
?>
    <div class="well">
        <p><?php echo UsniAdaptor::t('cart', "Shipping methods are not enabled. Please contact admin to enable shipping methods.");?></p>
    </div>
<?php
}
elseif(empty($paymentMethods))
{
  ?>
    <div class="well">
        <p><?php echo UsniAdaptor::t('cart', "Payment methods are not enabled. Please contact admin to enable payment methods.");?></p>
    </div>
  <?php
}
else
{
?>
<?php $form = ActiveForm::begin([
                                    'id'          => 'checkoutview',
                                    'caption'     => $this->title,
                                    'fieldConfig' => [ 
                                                        'template' => "{beginLabel}{labelTitle}{endLabel}{beginWrapper}{input}{error}{endWrapper}",
                                                        'horizontalCssClasses' => [
                                                                                        'label'     => '',
                                                                                        'offset'    => '',
                                                                                        'wrapper'   => '',
                                                                                        'error'     => '',
                                                                                        'hint'      => '',
                                                                                   ]
                                                    ]
                               ]); ?>
<div class="row">
    <div class="col-sm-6">
        <legend><span class="badge">1</span> <?php echo UsniAdaptor::t('customer', 'Billing Address');?></legend>
        <?php echo $this->render('@cart/views/_billingedit', ['form' => $form, 'model' => $formDTO->getCheckout()->billingInfoEditForm]);?>
    </div>
    <?php
    if($isShippingRequired)
    {
    ?>
        <div class="col-sm-6">
            <legend><span class="badge">2</span> <?php echo UsniAdaptor::t('customer', 'Shipping Address');?></legend>
            <?php echo $this->render('@cart/views/_shippingedit', ['form' => $form, 'model' => $formDTO->getCheckout()->deliveryInfoEditForm]);?>
        </div>
        <div class="col-sm-6">
            <legend><span class="badge">3</span> <?php echo UsniAdaptor::t('shipping', 'Shipping Method');?></legend>
            <?php echo $this->render('@cart/views/_deliveryoptions', ['form' => $form, 'formDTO' => $formDTO]);?>
        </div>
        <div class="col-sm-6">
            <legend><span class="badge">4</span> <?php echo UsniAdaptor::t('payment', 'Payment Method');?></legend>
            <?php echo $this->render('@cart/views/_paymentoptions', ['form' => $form, 'formDTO' => $formDTO]);?>
        </div>
    <?php
    }
    else
    {
    ?>
        <div class="col-sm-6">
            <legend><span class="badge">2</span> <?php echo UsniAdaptor::t('payment', 'Payment Method');?></legend>
            <?php echo $this->render('@cart/views/_paymentoptions', ['form' => $form, 'formDTO' => $formDTO]);?>
        </div>
    <?php
    }
    ?>
</div>
<?= FormButtons::widget(['submitButtonLabel' => UsniAdaptor::t('application', 'Continue'),
                         'cancelUrl' => UsniAdaptor::createUrl('order/default/add-to-cart'),
                         'cancelLinkLabel' => UsniAdaptor::t('order', 'Previous')
                         ]);?>

<?php ActiveForm::end();
}