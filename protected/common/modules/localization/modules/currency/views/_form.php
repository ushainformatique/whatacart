<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\utils\StatusUtil;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\dto\FormDTO */

$model              = $formDTO->getModel();
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('currency', 'Currency');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('currency', 'Currency');
}
$form = ActiveForm::begin([
        'id' => 'currencyeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'code')->textInput(); ?>
<?= $form->field($model, 'symbol_left')->textInput(); ?>
<?= $form->field($model, 'symbol_right')->textInput(); ?>
<?= $form->field($model, 'decimal_place')->textInput(); ?>
<?= $form->field($model, 'value')->textInput(); ?>
<?= $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown()); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('localization/currency/default/index')]);?>
<?php ActiveForm::end(); ?>
