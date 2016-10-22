<?php
namespace common\modules\order\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiActiveForm;
use marqu3s\summernote\Summernote;
/**
 * InvoiceEditView class file
 * @package common\modules\order\views
 */
class InvoiceEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'order_id'              => ['type' => 'text'],
                        'unique_id'             => ['type' => 'text'],
                        'price_excluding_tax'   => ['type' => 'text'],
                        'tax'                   => ['type' => 'text'],
                        'total_items'           => ['type' => 'text'],
                        'shipping_fee'          => ['type' => 'text'],
                        'terms'                 => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => ButtonsUtil::getDefaultButtonsMetadata('order/invoice/manage')
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return [
                    'order_id'              => ['inputOptions' => ['readonly' => true]],
                    'unique_id'             => ['inputOptions' => ['readonly' => true]],
                    'price_excluding_tax'   => ['inputOptions' => ['readonly' => true]],
                    'tax'                   => ['inputOptions' => ['readonly' => true]],
                    'total_items'           => ['inputOptions' => ['readonly' => true]],
                    'shipping_fee'          => ['inputOptions' => ['readonly' => true]]
                    
               ];
    }
}