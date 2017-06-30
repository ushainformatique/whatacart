<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\utils\Html;

/* @var $this \usni\library\web\AdminView */
/* @var $model \common\modules\order\models\OrderHistory */
/* @var $order \common\modules\order\models\Order */
/* @var $detailViewDTO \common\modules\order\dto\DetailViewDTO */

$order          = $detailViewDTO->getModel();
$statusOptions  = $detailViewDTO->getStatusData();
?>
<h3><?php echo UsniAdaptor::t('order', 'Add Order History');?></h3>
<?php
$form = ActiveForm::begin([
        'id' => 'orderhistoryeditview',
        'layout' => 'horizontal',
        'decoratorView' => false
    ]);
?>
<?= $form->field($model, 'status')->select2input($statusOptions, true); ?>
<?= $form->field($model, 'comment')->textarea(); ?>
<?= $form->field($model, 'notify_customer', ['horizontalCssClasses' => ['wrapper'   => 'col-sm-12'], 
                                      'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}"])->checkbox(); ?>
<?= Html::activeHiddenInput($model, 'order_id', ['value' => $order['id']]);?>
<?= FormButtons::widget(['showCancelButton' => false,
                         'submitButtonLabel' => UsniAdaptor::t('order', 'Add History')]);?>
<?php ActiveForm::end();
$redirectUrl        = UsniAdaptor::app()->request->getUrl();
$formId             = 'orderhistoryeditview';
$url                = UsniAdaptor::createUrl('order/default/add-order-history');
$script             = "$('#{$formId}').on('beforeSubmit',
                             function(event)
                             {
                                var form = $(this);
                                if(form.find('.has-error').length) {
                                        return false;
                                }
                                $.ajax({
                                            url: '{$url}',
                                            type: 'post',
                                            beforeSend: function()
                                                        {
                                                            attachButtonLoader($('#{$formId}'));
                                                        },
                                            data: form.serialize()
                                        })
                                .done(function(data, statusText, xhr){
                                                        window.location.href = '{$redirectUrl}';
                                                      });

                                        return false;
                             })";
$this->registerJs($script);