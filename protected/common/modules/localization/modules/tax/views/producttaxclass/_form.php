<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use marqu3s\summernote\Summernote;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\dto\FormDTO */

$model              = $formDTO->getModel();

if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('tax', 'Product Tax Class');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('tax', 'Product Tax Class');
}
$form = ActiveForm::begin([
        'id' => 'producttaxclasseditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'description')->widget(Summernote::className()); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('localization/tax/product-tax-class/index')]);?>
<?php ActiveForm::end(); ?>
