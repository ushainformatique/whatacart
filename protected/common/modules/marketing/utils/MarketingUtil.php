<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing\utils;

use common\modules\marketing\models\SendMailForm;
use usni\UsniAdaptor;
/**
 * MarketingUtil class file.
 * 
 * @package common\modules\marketing\utils
 */
class MarketingUtil
{   
    /**
     * Get To send mail dropdown.
     * @return array
     */
    public static function getToNewsletterDropdown()
    {
        return [
                    SendMailForm::ALL_CUSTOMERS               => UsniAdaptor::t('customer', 'All Customers'),
                    SendMailForm::CUSTOMER_GROUP              => UsniAdaptor::t('customer', 'Customer Group'),
                    SendMailForm::CUSTOMERS                   => UsniAdaptor::t('customer', 'Customers'),
                    SendMailForm::PRODUCTS                    => UsniAdaptor::t('products', 'Products Purchased'),
               ];
    }
}