<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use usni\UsniAdaptor;
/**
 * Contains metadata related to customer.
 * 
 * @package customer\models
 */
class CustomerMetadata extends \usni\library\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 2)
    {
        return UsniAdaptor::t('customer', 'Customer Metadata');
    }
}