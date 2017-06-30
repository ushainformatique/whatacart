<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

$model = $formDTO->getModel();
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('city', 'City');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('city', 'City');
}
$form = ActiveForm::begin([
        'id' => 'cityeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'country_id')->select2input($formDTO->getCountryDropDown());?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('localization/city/default/index')]);?>
<?php ActiveForm::end(); ?>
