<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
/**
 * Implements data access functionality related to product discount.
 *
 * @package products\dao
 */
class DiscountDAO
{
    /**
     * Get product discounts
     * @param int $productId
     * @return array
     */
    public static function getDiscounts($productId)
    {
        $discountTable          = UsniAdaptor::tablePrefix(). 'product_discount';
        $groupTable             = UsniAdaptor::tablePrefix(). 'group';
        $sql                    = "SELECT dc.*, gp.name as groupName
                                   FROM $discountTable dc, $groupTable gp 
                                   WHERE dc.product_id = :pid AND dc.group_id = gp.id";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId])->queryAll();
    }
    
    /**
     * Get product discount by attribute.
     * @param string $attribute
     * @param integer $value
     * @return array.
     */
    public static function getDiscountByAttribute($attribute, $value)
    {
        $productDiscountTable   = UsniAdaptor::tablePrefix() . 'product_discount';
        $sql                    = "SELECT pd.*
                                   FROM $productDiscountTable pd
                                   WHERE pd." . $attribute  . "= :gid";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':gid' => $value];
        return $connection->createCommand($sql, $params)->queryAll();
    }
}
