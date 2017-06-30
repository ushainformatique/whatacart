<?php
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use common\modules\order\widgets\AdminCartFormButtons;
use common\modules\order\widgets\AdminCartSubView;
use common\modules\order\utils\OrderScriptUtil;
use products\utils\ProductScriptUtil;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \common\modules\order\dto\AdminCheckoutDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$this->title = UsniAdaptor::t('order', 'View Cart');
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('order', 'Orders'),
        'url' => ['/order/default/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'View Cart')
    ]
];

$order = $formDTO->getCheckout()->order;
if($order->id == null)
{
    $previousUrl = UsniAdaptor::createUrl('order/default/create');
}
else
{
    $previousUrl = UsniAdaptor::createUrl('order/default/update', ['id' => $order->id]);
}
$model = $formDTO->getCheckout()->orderProductForm;

$form = ActiveForm::begin([
        'id' => 'orderproducteditview',
        'layout' => 'horizontal',
        'caption' => $this->title,
    ]);
?>
<div id="order-cart-products">
    <?php
    echo AdminCartSubView::widget();
    ?>
</div>
<?php
echo $form->field($model, 'product_id')->select2Input($formDTO->getProducts());
echo $form->field($model, 'quantity', ['inputOptions' => ['value' => 1]])->textInput();
?>
<div id="order-product-options">
    
</div>
<?= AdminCartFormButtons::widget(['cancelUrl' => $previousUrl,
                                  'cancelLinkLabel' => UsniAdaptor::t('order', 'Previous'),
                                  'submitButtonLabel' => UsniAdaptor::t('application', 'Continue')]);?>
<?php ActiveForm::end();

$script             = OrderScriptUtil::renderOptionFieldsScript();
$this->registerJs($script);
//Add Product to cart
$addScript          = OrderScriptUtil::addOrderProductScript();
$this->registerJs($addScript);
$this->registerJs(ProductScriptUtil::renderOptionErrorsScript());
$this->registerJs(OrderScriptUtil::registerRemoveFromCartScript());

