<?php
use usni\library\utils\Html;
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \common\modules\order\dto\AdminCheckoutDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$model = $formDTO->getCheckout()->customerForm;

$form = ActiveForm::begin([
        'id' => 'ordereditview',
        'layout' => 'horizontal',
        'caption' => $caption,
    ]);
echo $form->field($model, 'customerId')->select2Input($formDTO->getCustomers());
echo Html::activeHiddenInput($model, 'storeId', ['value' => UsniAdaptor::app()->storeManager->selectedStoreId]);
echo $form->field($model, 'currencyCode')->dropDownList(UsniAdaptor::app()->currencyManager->currencyCodes);
?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('order/default/index'),
                         'submitButtonLabel' => UsniAdaptor::t('application', 'Continue')]);?>
<?php ActiveForm::end(); ?>