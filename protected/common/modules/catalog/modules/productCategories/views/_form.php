<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\forms\NameWithAliasFormField;
use usni\library\widgets\Thumbnail;
use marqu3s\summernote\Summernote;
use usni\library\utils\StatusUtil;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \products\dto\ProductCategoryFormDTO */

$model          = $formDTO->getModel();
$dataCategories = $formDTO->getDataCategories();
$parentOptions  = $formDTO->getParentDropdownOptions();

if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('productCategories', 'Product Category');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('productCategories', 'Product Category');
}
$form = ActiveForm::begin([
        'id' => 'productcategoryeditview',
        'layout' => 'horizontal',
        'caption' => $caption,
        'options' => ['enctype' => 'multipart/form-data'],
    ]);
?>
<?= $form->field($model, 'data_category_id')->select2input($dataCategories);?>
<?= $form->field($model, 'name')->widget(NameWithAliasFormField::className()); ?>
<?= $form->field($model, 'alias')->textInput(); ?>
<?= Thumbnail::widget(['model' => $model, 
                       'attribute' => 'image',
                       'showDeleteLink' => false]);?>
<?= $form->field($model, 'image')->fileInput(); ?>
<?= $form->field($model, 'description')->widget(Summernote::className());?>
<?= $form->field($model, 'parent_id')->select2input($parentOptions);?>
<?= $form->field($model, 'metakeywords')->textarea(); ?>
<?= $form->field($model, 'metadescription')->textarea(); ?>
<?= $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown());?>
<?= $form->field($model, 'code')->textInput(); ?>
<?= $form->field($model, 'displayintopmenu')->checkbox(); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('catalog/productCategories/default/index')]);?>
<?php ActiveForm::end(); ?>
