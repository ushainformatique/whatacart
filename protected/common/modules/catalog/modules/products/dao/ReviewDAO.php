<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to product reviews
 *
 * @package products\dao
 */
class ReviewDAO extends \yii\base\Component
{
    /**
     * Get product review
     * @param int $reviewId
     * @param string $language
     * @return array
     */
    public static function getReview($reviewId, $language)
    {
        $reviewTableName    = UsniAdaptor::tablePrefix() . 'product_review';
        $reviewTrTableName  = UsniAdaptor::tablePrefix() . 'product_review_translated';
        $productTableName   = UsniAdaptor::tablePrefix() . 'product';
        $productTrTableName = UsniAdaptor::tablePrefix() . 'product_translated';
        
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $reviewTableName"]);
        $sql                = "SELECT pr.*, prt.review, ptt.name AS product_name 
                                   FROM $reviewTableName pr, $reviewTrTableName prt, $productTableName pt, $productTrTableName ptt 
                                   WHERE pr.id = :id AND pr.id = prt.owner_id AND prt.language = :lan1 AND 
                                   pr.product_id = pt.id AND pt.id = ptt.owner_id AND ptt.language = :lan2
                                   ";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':id' => $reviewId, ':lan1' => $language, ':lan2' => $language])->cache(0, $dependency)->queryOne();
    }
}
