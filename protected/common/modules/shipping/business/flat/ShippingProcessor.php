<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\business\flat;

use common\modules\shipping\business\BaseShippingProcessor;
use common\modules\shipping\utils\flat\FlatShippingUtil;
use usni\UsniAdaptor;
use common\modules\stores\business\ConfigManager;
use products\behaviors\PriceBehavior;
use products\behaviors\ProductBehavior;
/**
 * Process business logic related to flat shipping
 * 
 * @package common\modules\shipping\business\flat
 */
class ShippingProcessor extends BaseShippingProcessor
{
    /**
     * @var integer 
     */
    public $userId;
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            PriceBehavior::className(),
            ProductBehavior::className()
        ];
    }
    
    /**
     * @var ConfigManager 
     */
    public $configManager;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->configManager    = ConfigManager::getInstance();
        $this->userId           = UsniAdaptor::app()->user->getId();
    }
    
    /**
     * inheritdoc
     */
    public function getCalculatedPrice($cart)
    {
        $data  = $this->configManager->getConfigurationByCode('flat', 'shipping');
        $isShippingFeeAllowedBasedOnZones = true;
        if($data['applicableZones'] != FlatShippingUtil::SHIP_TO_ALL_ZONES)
        {
            $specificZones = unserialize($data['specificZones']);
            if(!empty($specificZones))
            {
                foreach($specificZones as $zone)
                {
                    if($this->zone['id'] === $zone)
                    {
                        break;
                    }
                    else
                    {
                        $isShippingFeeAllowedBasedOnZones = false;
                    }
                }
            }
        }
        if(!empty($data))
        {
            if($isShippingFeeAllowedBasedOnZones === false)
            {
                return 0;
            }
            if($data['type'] == 'none')
            {
                return 0;
            }
            $price = 0;
            if($data['calculateHandlingFee'] == 'fixed')
            {
                if($data['type'] == 'perOrder')
                {
                    $price = $data['price'];
                }
                elseif($data['type'] == 'perItem')
                {
                    $price = $data['price'] * $cart->getTotalQuantity();
                }
            }
            elseif($data['calculateHandlingFee'] == 'percent')
            {
                $price = ($data['price']/100) * ($cart->getTotalUnitPrice() + $cart->getTax());
            }
            else
            {
                $price = $data['price'];
            }
            if($data['method_name'] == 'fixedPlusHandling')
            {
                $price += $data['handlingFee'];
            }
            return $price;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        $data   = $this->configManager->getConfigurationByCode('flat', 'shipping');
        if(!empty($data))
        {
            if($data['type'] == 'none')
            {
                return UsniAdaptor::t('shipping', 'No fees applied');
            }
            $methodNameDD = FlatShippingUtil::getMethodNameDropdown();
            if($data['method_name'] == 'fixed')
            {
                $typeData = FlatShippingUtil::getTypeDropdown();
                $type     = $typeData[$data['type']];
                return $this->getFormattedPrice($data['price'], $this->selectedCurrency) . ' ' . $type . ' ' . $methodNameDD[$data['method_name']]; 
            }
            if($data['method_name'] == 'percent')
            {
                return $data['price'] . ' Percent '  . $methodNameDD[$data['method_name']];
            }
        }
    }
}