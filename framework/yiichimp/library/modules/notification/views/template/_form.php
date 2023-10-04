<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\modules\notification\widgets\FormButtons;
use marqu3s\summernote\Summernote;
use usni\library\modules\notification\utils\NotificationUtil;
use usni\library\modules\notification\utils\NotificationScriptUtil;
use yii\bootstrap\Modal;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\modules\notification\dto\TemplateFormDTO */

$model      = $formDTO->getModel();
$cancelUrl  = UsniAdaptor::createUrl('notification/template/index');
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('notification', 'Template');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('notification', 'Template');
}
$form = ActiveForm::begin([
        'id' => 'notificationtemplateeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
$types  = NotificationUtil::getTypes();
?>
<?= $form->field($model, 'type')->select2Input($types, false);?>
<?= $form->field($model, 'notifykey')->textInput(); ?>
<?= $form->field($model, 'subject')->textInput(); ?>
<?= $form->field($model, 'content')->widget(Summernote::className()); ?>
<?= $form->field($model, 'layout_id')->select2Input($formDTO->getLayoutOptions(), false); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('notification/template/index'),
                         'layout' => "<div class='form-actions text-right'>{submit}\n{cancel}\n{preview}</div>"]);?>
<?php 
ActiveForm::end();
Modal::begin(['id' => 'previewModal', 'size' => Modal::SIZE_LARGE,
              'header' => UsniAdaptor::t('notification', 'Template Preview')]);
echo '';
Modal::end();
$url = UsniAdaptor::createUrl('/notification/template/preview');
NotificationScriptUtil::registerPreviewScript($url, 'notificationtemplateeditview', $this);