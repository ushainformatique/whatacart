<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\utils\StatusUtil;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\Thumbnail;

$cancelUrl = UsniAdaptor::createUrl('language/default/index');
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('language', 'Language');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('language', 'Language');
}
$form = ActiveForm::begin([
        'id' => 'languageeditview',
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data'],
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'code')->textInput(); ?>
<?= $form->field($model, 'locale')->textInput(); ?>
<?= Thumbnail::widget(['model' => $model, 
                       'attribute' => 'image',
                       'deleteUrl' => UsniAdaptor::createUrl('language/default/delete-image')]);?>
<?= $form->field($model, 'image')->fileInput(); ?>
<?= $form->field($model, 'sort_order')->textInput(); ?>
<?= $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown()); ?>

<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('language/default/index')]);?>
<?php ActiveForm::end(); ?>