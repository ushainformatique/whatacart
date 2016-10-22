<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\UsniAdaptor;
use usni\library\utils\ButtonsUtil;
use common\components\CurrencyManager;
use customer\utils\CustomerUtil;
use usni\library\utils\ArrayUtil;
use usni\library\components\UiHtml;
use usni\library\utils\FlashUtil;
/**
 * OrderEditView class file.
 *
 * @package common\modules\order\views
 */
class OrderEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $selectedCurrency = $this->model->currencyCode;
        if($selectedCurrency != null)
        {
            UsniAdaptor::app()->currencyManager->setCookie($selectedCurrency);
        }
        $data         = CurrencyManager::getList();
        $store        = UsniAdaptor::app()->storeManager->getCurrentStore();
        $guestData    = [0 => UsniAdaptor::t('application', 'Guest')];
        $customerData = CustomerUtil::getDropdownDataBasedOnModel();
        $customerData = ArrayUtil::merge($guestData, $customerData);
        $elements = [
                        'customerId'   => UiHtml::getFormSelectFieldOptionsWithNoSearch($customerData, [], ['prompt' => UiHtml::getDefaultPrompt()]),
                        'storeId'      => ['type' => 'hidden', 'value' => $store->id],
                        'currencyCode' => UiHtml::getFormSelectFieldOptionsWithNoSearch($data, [], ['prompt' => UiHtml::getDefaultPrompt()]),
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => ButtonsUtil::getDefaultButtonsMetadata('order/default/manage', UsniAdaptor::t('application', 'Continue'))
                    ];
        return $metadata;
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
    protected function renderFlashMessages()
    {
        return FlashUtil::render('guestCheckoutNowAllowed', 'alert alert-danger');
    }
}