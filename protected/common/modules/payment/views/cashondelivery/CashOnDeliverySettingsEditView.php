<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\views\cashondelivery;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use usni\library\components\UiHtml;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use usni\library\utils\DAOUtil;
/**
 * CashOnDeliverySettingsEditView class file
 *
 * @package common\modules\paypal\views
 */
class CashOnDeliverySettingsEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'order_status' => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(OrderStatus::className())),
                    ];
        $metadata = [
                        'elements'   => $elements,
                        'buttons'    => ButtonsUtil::getDefaultButtonsMetadata('payment/default/manage')
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('payment', 'Cash On Delivery Settings');
    }
    
    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        return FlashUtil::render('cashondeliverySettingsSaved');
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        return null;
    }
}