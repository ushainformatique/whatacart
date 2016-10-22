<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\views\flat;

use usni\library\utils\ButtonsUtil;
use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use common\modules\shipping\views\ShippingBrowseView;
use common\modules\shipping\utils\flat\FlatShippingUtil;
use taxes\models\Zone;
use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
/**
 * FlatRateShippingEditView class file.
 * @package common\modules\shipping\views\flat
 */
class FlatRateShippingEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements               = [
                                    'method_name'   => ['type' => 'text'],
                                    'price'         => ['type' => 'text'],
                                    'type'          => UiHtml::getFormSelectFieldOptions(FlatShippingUtil::getTypeDropdown()),
                                    'calculateHandlingFee' => UiHtml::getFormSelectFieldOptions(FlatShippingUtil::getHandlingFeesTypeDropdown()),
                                    'handlingFee'   => ['type' => 'text'],
                                    'applicableZones' => UiHtml::getFormSelectFieldOptions(FlatShippingUtil::getShipToApplicableDropdown()),
                                    'specificZones' => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(Zone::className()), ['closeOnSelect' => false], ['multiple' => 'multiple']),
                                  ];
        $metadata               = [
                                     'elements'         => $elements,
                                     'buttons'          => ButtonsUtil::getDefaultButtonsMetadata("shipping/default/manage")
                                  ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected static function resolveBrowseModelViewClassName()
    {
        return ShippingBrowseView::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('shipping', 'Flat rate settings');
    }
    
    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        return FlashUtil::render('flatShippingSettingsSaved');
    }
}
?>