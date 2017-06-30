<?php
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\utils\Html;

/* @var $this \usni\library\web\AdminView */
/* @var $form \usni\library\bootstrap\ActiveForm */
/* @var $formDTO \common\modules\order\dto\PaymentFormDTO */

$this->params['breadcrumbs'] = [
                                    [
                                        'label' => UsniAdaptor::t('order', 'Manage Orders'),
                                        'url'   => UsniAdaptor::createUrl('order/default/index')
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('payment', 'Select Payment Method')
                                    ]
                                ];
$this->title = UsniAdaptor::t('order', 'Select Payment Method');
$form = ActiveForm::begin([
        'id' => 'orderselectpaymentmethodview',
        'layout' => 'horizontal',
        'caption' => $this->title,
    ]);

$paymentMethods = $formDTO->getPaymentMethods();
$model          = $formDTO->getModel();
echo $form->field($model, 'payment_type')->dropDownList($paymentMethods);
echo Html::activeHiddenInput($model, 'orderId', ['value' => $formDTO->getOrder()->id]);
echo FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('order/default/index'),
                          'submitButtonLabel' => UsniAdaptor::t('application', 'Continue')]);?>
<?php ActiveForm::end();