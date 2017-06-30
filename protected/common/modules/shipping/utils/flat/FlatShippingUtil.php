<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\utils\flat;

use usni\UsniAdaptor;
/**
 * FlatShippingUtil class file.
 * 
 * @package common\modules\shipping\utils\flat
 */
class FlatShippingUtil
{
    const SHIP_TO_ALL_ZONES = 1;
    const SHIP_TO_SPECIFIC_ZONES = 2;
    
    /**
     * Gets type dropdown.
     * @return array
     */
    public static function getTypeDropdown()
    {
        return array(
            'none'     => UsniAdaptor::t('application','None'),
            'perOrder' => UsniAdaptor::t('shipping','Per Order'),
            'perItem'  => UsniAdaptor::t('shipping','Per Item')
        );
    }
    
    /**
     * Gets method name dropdown.
     * @return array
     */
    public static function getMethodNameDropdown()
    {
        return array(
            'fixed'             => UsniAdaptor::t('shipping','Fixed'),
            'fixedPlusHandling' => UsniAdaptor::t('shipping','Fixed plus handling')
        );
    }
    
    /**
     * Gets handling fees type dropdown.
     * @return array
     */
    public static function getHandlingFeesTypeDropdown()
    {
        return array(
            'fixed'    => UsniAdaptor::t('shipping','Fixed'),
            'percent'  => UsniAdaptor::t('shipping','Percent')
        );
    }
    
    /**
     * Gets ship to applicable dropdown.
     * @return array
     */
    public static function getShipToApplicableDropdown()
    {
        return array(
            self::SHIP_TO_ALL_ZONES       => UsniAdaptor::t('shipping', 'All Zones'),
            self::SHIP_TO_SPECIFIC_ZONES  => UsniAdaptor::t('shipping','Specific Zones')
        );
    }
}