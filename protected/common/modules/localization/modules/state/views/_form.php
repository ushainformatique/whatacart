<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\utils\StatusUtil;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \common\modules\localization\modules\state\dto\FormDTO */

$model          = $formDTO->getModel();
$countryData    = $formDTO->getCountryDropdownData();
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('state', 'State');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('state', 'State');
}
$form = ActiveForm::begin([
        'id' => 'stateeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'code')->textInput(); ?>
<?= $form->field($model, 'country_id')->select2input($countryData);?>
<?= $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown());?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('localization/state/default/index')]);?>
<?php ActiveForm::end(); ?>
