<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\utils\StatusUtil;
use usni\library\utils\Html;

$model          = $formDTO->getModel();
$parentOptions  = $formDTO->getParentDropdownOptions();
$memberOptions  = $formDTO->getGroupMemberOptions();
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('customer', 'Customer Group');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('customer', 'Customer Group');
}
$form = ActiveForm::begin([
        'id' => 'customergroupeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'parent_id')->select2input($parentOptions, true); ?>
<?= $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown());?>
<?= $form->field($model, 'members')->select2input($memberOptions, true, ['multiple' => 'multiple'], ['closeOnSelect' => false]); ?>
<?= Html::activeHiddenInput($model, 'category', ['value' => 'customer']);?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('customer/group/index')]);?>
<?php ActiveForm::end(); ?>