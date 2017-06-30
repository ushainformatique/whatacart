<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to product download.
 *
 * @package products\dao
 */
class DownloadDAO
{
    /**
     * Get all downloads.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'product_download';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_download_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT pd.*, pdt.name FROM $table pd, $trTable pdt "
                    . "WHERE pd.id = pdt.owner_id AND pdt.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':lang' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get by id.
     * @param integer $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'product_download';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_download_translated';
        $sql        = "SELECT pd.*, pdt.name FROM $table pd, $trTable pdt "
                    . "WHERE pd.id = :id AND pdt.owner_id = pd.id AND pdt.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
    
    /**
     * Get customer download count.
     * @param int $downloadId
     * @return array
     */
    public static function getCustomerDownloadCount($downloadId, $customerId)
    {
        $downloadTable      = UsniAdaptor::tablePrefix() . 'customer_download_mapping';
        $sql                = "SELECT COUNT(*) AS cnt 
                                FROM $downloadTable dt
                                WHERE download_id = :did AND customer_id = :cid";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':did' => $downloadId, ':cid' => $customerId])->queryScalar();        
    }
}