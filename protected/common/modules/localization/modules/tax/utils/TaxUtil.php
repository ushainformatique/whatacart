<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace taxes\utils;

use usni\UsniAdaptor;
use taxes\models\TaxRule;
/**
 * TaxUtil class file.
 * 
 * @package taxes\utils
 */
class TaxUtil
{
    /**
     * Get tax type dropdown.
     * @return array
     */
    public static function getTaxTypeDropdown()
    {
        return [
                    TaxRule::TAX_TYPE_FLAT      => UsniAdaptor::t('tax', 'Flat'),
                    TaxRule::TAX_TYPE_PERCENT   => UsniAdaptor::t('tax', 'Percent')
               ];
    }
    
    /**
     * Get based on dropdown.
     * @return array
     */
    public static function getBasedOnDropdown()
    {
        return [
                    TaxRule::TAX_BASED_ON_SHIPPING  => UsniAdaptor::t('customer', 'Shipping Address'),
                    TaxRule::TAX_BASED_ON_BILLING   => UsniAdaptor::t('customer', 'Billing Address')
               ];
    }
    
    /**
     * Get based on display value.
     * @param string $basedOn
     * @return string
     */
    public static function getBasedOnDisplayValue($basedOn)
    {
        $data = self::getBasedOnDropdown();
        return $data[$basedOn];
    }
}