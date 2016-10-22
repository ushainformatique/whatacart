<?php
namespace common\modules\order\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use common\modules\payment\utils\PaymentUtil;
/**
 * AdminSelectPaymentMethodView class file.
 *
 * @package common\modules\payment\views\cheque
 */
class AdminSelectPaymentMethodView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'payment_type'  => UiHtml::getFormSelectFieldOptionsWithNoSearch(PaymentUtil::getPaymentMethodDropdown(), [], ['prompt' => UiHtml::getDefaultPrompt()]),
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => ButtonsUtil::getDefaultButtonsMetadata("order/default/manage", UsniAdaptor::t('application', 'Continue'))
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('payment', 'Select Payment Method');
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        return null;
    }
}
?>