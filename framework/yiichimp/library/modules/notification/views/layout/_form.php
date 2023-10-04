<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use marqu3s\summernote\Summernote;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\dto\FormDTO */

$model      = $formDTO->getModel();
$cancelUrl  = UsniAdaptor::createUrl('notification/layout/index');
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('notification', 'Layout');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('notification', 'Layout');
}
$form = ActiveForm::begin([
        'id' => 'notificationlayouteditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'content')->widget(Summernote::className()); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('notification/layout/index')]);?>
<?php ActiveForm::end();
