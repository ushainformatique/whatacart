<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\forms\NameWithAliasFormField;
use marqu3s\summernote\Summernote;
use common\modules\cms\utils\DropdownUtil;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \common\modules\cms\dto\FormDTO */

$model          = $formDTO->getModel();
$parentOptions  = $formDTO->getParentDropdownOptions();
$cancelUrl      = UsniAdaptor::createUrl('cms/page/index');
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('cms', 'Page');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('cms', 'Page');
}
$form = ActiveForm::begin([
        'id' => 'pageeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->widget(NameWithAliasFormField::className()) ?>
<?= $form->field($model, 'alias')->textInput(); ?>
<?= $form->field($model, 'parent_id')->select2input($parentOptions, true); ?>
<?= $form->field($model, 'menuitem')->textInput(); ?>
<?= $form->field($model, 'summary')->widget(Summernote::className()); ?>
<?= $form->field($model, 'content')->widget(Summernote::className()); ?>
<hr/>,
<?= $form->field($model, 'metakeywords')->textarea(); ?>
<?= $form->field($model, 'metadescription')->textarea(); ?>
<?= $form->field($model, 'status')->select2input(DropdownUtil::getStatusSelectOptions());?>
<?= $form->field($model, 'custom_url')->textInput(); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('cms/page/index')]);?>
<?php ActiveForm::end(); ?>
