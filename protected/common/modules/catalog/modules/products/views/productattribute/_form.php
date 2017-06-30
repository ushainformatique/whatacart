<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \products\dto\ProductAttributeFormDTO */

$model              = $formDTO->getModel();
$attributeGroups    = $formDTO->getAttributeGroupData();

if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('products', 'Attribute');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('products', 'Attribute');
}
$form = ActiveForm::begin([
        'id' => 'productattributeeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'sort_order')->textInput(); ?>
<?= $form->field($model, 'attribute_group')->select2input($attributeGroups);?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('catalog/products/attribute/index')]);?>
<?php ActiveForm::end(); ?>
