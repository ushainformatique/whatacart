<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use newsletter\utils\NewsletterUtil;
use marqu3s\summernote\Summernote;

/* @var $this \usni\library\web\AdminView */

$cancelUrl          = UsniAdaptor::createUrl('marketing/newsletter/default/index');
$model              = $formDTO->getModel();
$storeDropdownData  = $formDTO->getStoreDropdownData();
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('newsletter', 'Newsletter');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('newsletter', 'Newsletter');
}
$form = ActiveForm::begin([
        'id' => 'newslettereditview',
        'layout' => 'horizontal',
        'caption' => $this->title
    ]);
?>
<?= $form->field($model, 'store_id')->dropDownList($storeDropdownData);?>
<?= $form->field($model, 'to')->dropDownList(NewsletterUtil::getToNewsletterDropdown());?>
<?= $form->field($model, 'subject')->textInput(); ?>
<?= $form->field($model, 'content')->widget(Summernote::className()); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('marketing/newsletter/default/index')]);?>
<?php ActiveForm::end(); ?>
