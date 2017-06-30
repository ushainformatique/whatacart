<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\utils\StatusUtil;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\Thumbnail;

/* @var $this \usni\library\web\AdminView */

$cancelUrl = UsniAdaptor::createUrl('manufacturer/default/index');
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('manufacturer', 'Manufacturer');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('manufacturer', 'Manufacturer');
}
$form = ActiveForm::begin([
        'id' => 'manufacturereditview',
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data'],
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= Thumbnail::widget(['model' => $model, 
                       'attribute' => 'image',
                       'deleteUrl' => UsniAdaptor::createUrl('manufacturer/default/delete-image')]);?>
<?= $form->field($model, 'image')->fileInput(); ?>
<?= $form->field($model, 'status')->select2input(StatusUtil::getDropdown());?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('manufacturer/default/index')]);?>
<?php ActiveForm::end(); ?>
