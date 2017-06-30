<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\utils;

use newsletter\models\Newsletter;
use usni\UsniAdaptor;
/**
 * NewsletterUtil class file.
 * 
 * @package newsletter\utils
 */
class NewsletterUtil
{   
    /**
     * Get To newsletter dropdown.
     * @return array
     */
    public static function getToNewsletterDropdown()
    {
        return [
                    Newsletter::ALL_SUBSCRIBERS  => UsniAdaptor::t('newsletter', 'All Subscribers'),
                    Newsletter::ALL_CUSTOMERS    => UsniAdaptor::t('newsletter', 'All Customers')
               ];
    }
}
