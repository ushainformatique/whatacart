<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

$model = $formDTO->getModel();
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('stockstatus', 'Stock Status');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('stockstatus', 'Stock Status');
}

$form = ActiveForm::begin([
        'id' => 'stockstatuseditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('localization/stockstatus/default/index')]);?>
<?php ActiveForm::end(); ?>