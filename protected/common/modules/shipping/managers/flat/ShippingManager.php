<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\managers\flat;

use common\modules\shipping\managers\BaseShippingManager;
use common\modules\shipping\utils\flat\FlatShippingUtil;
use products\utils\ProductUtil;
use usni\UsniAdaptor;
use common\modules\stores\utils\StoreUtil;
/**
 * Loads default data related to shipping.
 * 
 * @package common\modules\shipping\managers
 */
class ShippingManager extends BaseShippingManager
{   
    /**
     * @inheritdoc
     */
    public function getCalculatedPrice($cart)
    {
        return FlatShippingUtil::getCalculatedPrice($cart);
    }
    
    /**
     * @inheritdoc
     */
    public function getDescription($language = null)
    {
        if($language == null)
        {
            $language = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        }
        $data     = StoreUtil::getStoreConfgurationAttributesByCodeForStore('flat', 'shipping');
        if(!empty($data))
        {
            if($data['type'] == 'none')
            {
                return UsniAdaptor::t('shipping', 'No fees applied');
            }
            $typeData = FlatShippingUtil::getTypeDropdown();
            $type     = $typeData[$data['type']];
            $methodNameDD = FlatShippingUtil::getMethodNameDropdown();
            return ProductUtil::getFormattedPrice($data['price']) . ' ' . $type . ' ' . $methodNameDD[$data['method_name']];
        }
    }
}