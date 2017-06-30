<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to product tags.
 *
 * @package products\dao
 */
class TagDAO
{
    /**
     * Get product tags.
     * @param int $productId
     * @param string $language
     * @return array
     */
    public static function getProductTags($productId, $language)
    {
        $productTagMappingTable = UsniAdaptor::tablePrefix() . 'product_tag_mapping';
        $tagTable               = UsniAdaptor::tablePrefix() . 'tag';
        $trTagTable             = UsniAdaptor::tablePrefix() . 'tag_translated';
        $sql                    = "SELECT ttt.name 
                                   FROM $productTagMappingTable ptm, $tagTable tt, $trTagTable ttt
                                   WHERE ptm.product_id = :pid AND ptm.tag_id = tt.id AND tt.id = ttt.owner_id AND ttt.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lang' => $language])->queryAll();        
    }
    
    /**
     * Get all product options.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'tag';
        $trTable    = UsniAdaptor::tablePrefix() . 'tag_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT tg.*, tgt.name FROM $table tg, $trTable tgt "
                    . "WHERE tg.id = tgt.owner_id AND tgt.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':lang' => $language])->cache(0, $dependency)->queryAll();
    }
}
