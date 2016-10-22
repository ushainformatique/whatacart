<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\UsniAdaptor;
use usni\library\components\UiActiveForm;
use dosamigos\datepicker\DatePicker;
use usni\library\utils\FlashUtil;
use common\modules\order\utils\OrderUtil;
/**
 * BaseAddPaymentView class file.
 *
 * @package common\modules\payment\views\cashbeforedelivery
 */
class BaseAddPaymentView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'totalAmount'           => ['type' => 'text'],
                        'alreadyPaidAmount'     => ['type' => 'text'],
                        'pendingAmount'         => ['type' => 'text'],
                        'amount'                => ['type' => 'text'],
                        'received_date'         => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => DatePicker::className(), 
                                                    'clientOptions' => [
                                                                            'autoclose' => true,
                                                                            'format'    => 'yyyy-mm-dd',
                                                                       ],   'options'   => ['class' => 'form-control']],
                        'transaction_id'        => ['type' => 'text'],
                        'transaction_fee'       => ['type' => 'text']
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => ButtonsUtil::getDefaultButtonsMetadata("order/default/manage")
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        $order          = OrderUtil::getOrder($this->model->order_id);
        $currencySymbol = UsniAdaptor::app()->currencyManager->getCurrencySymbol($order['currency_code']);
        $inputTemplate  = '<div class="input-group"><span class="input-group-addon">' . $currencySymbol . '</span>{input}</div>';
        return ['totalAmount' => ['inputOptions' => ['readonly' => true], 'inputTemplate' => $inputTemplate],
                'alreadyPaidAmount' => ['inputOptions' => ['readonly' => true], 'inputTemplate' => $inputTemplate],
                'pendingAmount' => ['inputOptions' => ['readonly' => true], 'inputTemplate' => $inputTemplate]
              ];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        return FlashUtil::render('transactionSuccess');
    }
}
?>