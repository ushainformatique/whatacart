<?php
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use dosamigos\datepicker\DatePicker;

/* @var $this \usni\library\web\AdminView */
/* @var $form \usni\library\bootstrap\ActiveForm */
/* @var $formDTO \common\modules\payment\dto\TransactionFormDTO */

$model = $formDTO->getModel();
$this->params['breadcrumbs'] = [
                                    [
                                        'label' => UsniAdaptor::t('order', 'Manage Orders'),
                                        'url'   => UsniAdaptor::createUrl('order/default/index')
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('payment', 'Add Payment')
                                    ]
                                ];
$form = ActiveForm::begin([
        'id' => 'orderaddpaymentview',
        'layout' => 'horizontal',
        'caption' => $this->title,
    ]);
$order          = $formDTO->getOrder();
$currencySymbol = UsniAdaptor::app()->currencyManager->getCurrencySymbol($order['currency_code']);
$inputTemplate      = '<div class="input-group"><span class="input-group-addon">' . $currencySymbol . '</span>{input}</div>';
$amountFieldOptions = ['inputOptions' => ['readonly' => true], 'inputTemplate' => $inputTemplate];
?>
<?= $form->field($model, 'totalAmount', $amountFieldOptions)->textInput();?>
<?= $form->field($model, 'alreadyPaidAmount',$amountFieldOptions)->textInput();?>
<?= $form->field($model, 'pendingAmount', $amountFieldOptions)->textInput();?>
<?= $form->field($model, 'amount')->textInput();?>
<?= $form->field($model, 'received_date')->widget(DatePicker::className(), [
                                                                                'clientOptions' => [
                                                                                                        'autoclose' => true,
                                                                                                        'format'    => 'yyyy-mm-dd',
                                                                                                   ],
                                                                                'options'   => ['class' => 'form-control']
                                                                           ]
    );?>
<?= $form->field($model, 'transaction_id')->textInput();?>
<?= $form->field($model, 'transaction_fee')->textInput();?>
<?php
echo FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('order/default/index')]);?>
<?php ActiveForm::end();