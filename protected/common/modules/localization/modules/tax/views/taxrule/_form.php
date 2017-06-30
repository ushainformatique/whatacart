<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use taxes\utils\TaxUtil;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \taxes\dto\TaxRuleFormDTO */

$model                  = $formDTO->getModel();
$productTaxClassData    = $formDTO->getProductTaxClassDropdownData();
$customerGroupData      = $formDTO->getCustomerGroupsDropdownData();
$zoneData               = $formDTO->getTaxZonesDropdownData();
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('tax', 'Tax Rule');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('tax', 'Tax Rule');
}
$form = ActiveForm::begin([
        'id' => 'taxruleeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'productTaxClass')->select2input($productTaxClassData, true, ['multiple'=>'multiple']);?>
<?= $form->field($model, 'based_on')->dropDownList(TaxUtil::getBasedOnDropdown());?>
<?= $form->field($model, 'customerGroups')->select2input($customerGroupData, true, ['multiple'=>'multiple']);?>
<?= $form->field($model, 'type')->dropDownList(TaxUtil::getTaxTypeDropdown()); ?>
<?= $form->field($model, 'value')->textInput(); ?>
<?= $form->field($model, 'taxZones')->select2input($zoneData, true, ['multiple'=>'multiple']);?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('localization/tax/rule/index')]);?>
<?php ActiveForm::end(); ?>
