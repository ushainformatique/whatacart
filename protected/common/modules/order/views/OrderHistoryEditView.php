<?php
namespace common\modules\order\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use usni\UsniAdaptor;
use usni\library\components\UiActiveForm;
/**
 * OrderHistoryEditView class file
 * 
 * @package common\modules\order\views
 */
class OrderHistoryEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'status' => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(OrderStatus::className())),
                        'comment'           => ['type' => 'textarea'],
                        'notify_customer'   => ['type' => 'checkbox'],
                        'order_id'          => ['type' => UiActiveForm::INPUT_HIDDEN, 'value' => $_GET['id']]
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => self::getOrderHistoryButton()
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('order', 'Add Order History');
    }
    
    /**
     * Get order history button.
     * @return array
     */
    public static function getOrderHistoryButton()
    {
        return [
                    'save'  => ButtonsUtil::getSubmitButton(UsniAdaptor::t('order', 'Add History'))
               ];
    }
    
    /**
     * Override to register form submit script
     */
    protected function registerScripts()
    {
        $formId             = static::getFormId();
        $url                = UsniAdaptor::createUrl('order/default/add-order-history');
        $script             = "$('#{$formId}').on('beforeSubmit',
                                     function(event, jqXHR, settings)
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
                                                                    $.fn.attachLoader('#{$formId}');
                                                                },
                                                    data: form.serialize()
                                                })
                                        .done(function(data, statusText, xhr){
                                                                $('.tabbable').load(location.href + ' .tabbable');
                                                                $.fn.removeLoader('#{$formId}');
                                                                $('#{$formId}')[0].reset();
                                                              });

                                                return false;
                                     })";
        $this->getView()->registerJs($script);
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return array(
            'notify_customer' => array(
                    'options' => [],
                    'horizontalCheckboxTemplate' => "<div class=\"col-xs-12\"><div class=\"checkbox checkbox-admin\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}</div>"
            )
        );
    }
}