<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
/**
 * Implements data access functionality related to product special.
 *
 * @package products\dao
 */
class SpecialDAO
{
    /**
     * Get product specials
     * @param int $productId
     * @return array
     */
    public static function getSpecials($productId)
    {
        $specialTable          = UsniAdaptor::tablePrefix(). 'product_special';
        $groupTable             = UsniAdaptor::tablePrefix(). 'group';
        $sql                    = "SELECT  sp.*, gp.name as groupName 
                                   FROM $specialTable sp, $groupTable gp 
                                   WHERE sp.product_id = :pid AND sp.group_id = gp.id";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId])->queryAll();
    }
    
    /**
     * Get product special by attribute.
     * @param string $attribute
     * @param integer $value
     * @return array.
     */
    public static function getSpecialByAttribute($attribute, $value)
    {
        $productSpecialTable   = UsniAdaptor::tablePrefix() . 'product_special';
        $sql                    = "SELECT pd.*
                                   FROM $productSpecialTable pd
                                   WHERE pd." . $attribute  . "= :gid";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':gid' => $value];
        return $connection->createCommand($sql, $params)->queryAll();
    }
}
