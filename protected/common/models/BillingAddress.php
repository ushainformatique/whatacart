<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */ 
namespace common\models;

use usni\UsniAdaptor;
use usni\library\modules\users\models\Address;
/**
 * BillingAddress class file
 *
 * @package common\models
 */
class BillingAddress extends Address
{    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Address::tableName();
    }
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('customer', 'Billing Address');
    }
    
    /**
     * @inheritdoc
     */
    public static function getType()
    {
        return Address::TYPE_BILLING_ADDRESS;
    }
}
