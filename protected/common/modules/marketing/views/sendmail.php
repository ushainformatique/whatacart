<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \common\modules\marketing\dto\FormDTO */

use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use common\modules\marketing\utils\MarketingUtil;
use marqu3s\summernote\Summernote;

$title  = UsniAdaptor::t('marketing', 'Send Mail');
$model  = $formDTO->getModel();
$storeDropdownData      = $formDTO->getStoreDropdownData();
$customerDropdownData   = $formDTO->getCustomerDropdownData();
$groupDropdowndata      = $formDTO->getCustomerGroupDropdownData();
$productDropdownData    = $formDTO->getProductDropdownData();
$this->params['breadcrumbs'] = [
                                    [
                                        'label' => $title
                                    ],
                               ];
$this->title = $title;
$form = ActiveForm::begin([
        'id' => 'sendmaileditview',
        'layout' => 'horizontal',
        'caption' => $title
    ]);
?>
<?= $form->field($model, 'store_id')->select2input($storeDropdownData); ?>
<?= $form->field($model, 'to')->dropDownList(MarketingUtil::getToNewsletterDropdown()); ?>
<?= $form->field($model, 'customer_id')->select2input($customerDropdownData, true, ['multiple'=>'multiple']);?>
<?= $form->field($model, 'group_id')->select2input($groupDropdowndata, true, ['multiple'=>'multiple']);?>
<?= $form->field($model, 'product_id')->select2input($productDropdownData, true, ['multiple'=>'multiple']);?>
<?= $form->field($model, 'subject')->textInput(); ?>
<?= $form->field($model, 'content')->widget(Summernote::className()); ?>
<?= FormButtons::widget(['showCancelButton' => false, 'submitButtonLabel' => UsniAdaptor::t('marketing', 'Send')]);?>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs("$(document).ready(function() {
                    $('.field-sendmailform-group_id').hide();
                    $('.field-sendmailform-customer_id').hide();
                    $('.field-sendmailform-product_id').hide();
                  });");
$this->registerJs("$('body').on('change', '#sendmailform-to', function(){
                    var dropdownVal = $(this).val();
                    if(dropdownVal == 1)
                    {
                        $('.field-sendmailform-group_id').hide();
                        $('.field-sendmailform-customer_id').hide();
                        $('.field-sendmailform-product_id').hide();
                    }
                    if(dropdownVal == 2)
                    {
                        $('.field-sendmailform-group_id').show();
                        $('.field-sendmailform-customer_id').hide();
                        $('.field-sendmailform-product_id').hide();
                    }
                    if(dropdownVal == 3)
                    {
                        $('.field-sendmailform-group_id').hide();
                        $('.field-sendmailform-customer_id').show();
                        $('.field-sendmailform-product_id').hide();
                    }
                    if(dropdownVal == 4)
                    {
                        $('.field-sendmailform-group_id').hide();
                        $('.field-sendmailform-customer_id').hide();
                        $('.field-sendmailform-product_id').show();
                    }
               })");

