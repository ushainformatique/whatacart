<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\utils\StatusUtil;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

$model = $formDTO->getModel();
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('country', 'Country');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('country', 'Country');
}

$form = ActiveForm::begin([
        'id' => 'countryeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'iso_code_2')->textInput(); ?>
<?= $form->field($model, 'iso_code_3')->textInput(); ?>
<?= $form->field($model, 'address_format')->textArea(); ?>
<?= $form->field($model, 'postcode_required', ['horizontalCheckboxTemplate' => "<div class=\"checkbox checkbox-admin\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}"])->checkbox(); ?>
<?= $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown()); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('localization/country/default/index')]);?>
<?php ActiveForm::end(); ?>
