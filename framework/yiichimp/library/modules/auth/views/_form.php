<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\utils\StatusUtil;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\utils\Html;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\modules\auth\dto\FormDTO */

$model      = $formDTO->getModel();
$parentOptions = $formDTO->getParentDropdownOptions();
$memberOptions = $formDTO->getGroupMemberOptions();
$cancelUrl  = UsniAdaptor::createUrl('auth/group/index');
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('auth', 'Group');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('auth', 'Group');
}
$form = ActiveForm::begin([
        'id' => 'groupeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'parent_id')->select2input($parentOptions, true); ?>
<?= $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown());?>
<?= $form->field($model, 'members')->select2input($memberOptions, true, ['multiple' => 'multiple'], ['closeOnSelect' => false]); ?>
<?= Html::activeHiddenInput($model, 'category', ['value' => 'system']);?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('auth/group/index')]);?>
<?php ActiveForm::end(); ?>
