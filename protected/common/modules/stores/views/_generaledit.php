<?php
use usni\library\utils\Html;
use usni\library\utils\StatusUtil;
use marqu3s\summernote\Summernote;

/* @var $formDTO \common\modules\stores\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$model = $formDTO->getModel()->store;
?>
<?= $form->field($model, 'name')->textInput();?>
<?= $form->field($model, 'data_category_id')->select2input($formDTO->getDataCategories());?>
<?php
if($model->is_default == true && $model->scenario == 'update')
{
    echo Html::activeHiddenInput($model, 'status');
}
else
{
    echo $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown());
}
?>
<?= $form->field($model, 'owner_id')->select2input($formDTO->getOwners());?>
<?= $form->field($model, 'metakeywords')->textarea();?>
<?= $form->field($model, 'metadescription')->textarea();?>
<?= $form->field($model, 'description')->widget(Summernote::className()); ?>
<?= $form->field($model, 'theme')->select2input($formDTO->getThemes());?>