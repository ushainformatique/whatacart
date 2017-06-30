<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\traits;

use products\models\ProductDownloadMapping;
use usni\UsniAdaptor;
use products\dao\DownloadDAO;
/**
 * Implement common functions related to product download
 *
 * @package products\traits
 */
trait DownloadTrait
{
    /**
     * Get download ids.
     * @param int $id
     * @return Array
     */
    public function getDownloadIds($id)
    {
        $relatedDownloadIdArray    = [];
        $relatedDownloadRecords = ProductDownloadMapping::find()->where('product_id = :pId', [':pId' => $id])->asArray()->all();
        if(!empty($relatedDownloadRecords))
        {
            foreach ($relatedDownloadRecords as $record)
            {
                $relatedDownloadIdArray[] = $record['download_id'];
            }
            return array_unique($relatedDownloadIdArray);
        }
        return $relatedDownloadIdArray;
    }
    
    /**
     * Check if allowed to download
     * @param array $download
     * @param int $customerId
     * @param array $order
     * @param string $currentDateTime
     * @return boolean
     */
    public function checkIfAllowedToDownload($download, $customerId, $order, $currentDateTime = null)
    {
        $count              = DownloadDAO::getCustomerDownloadCount($download['id'], $customerId);
        $allowedDownloads   = $download['allowed_downloads'];
        $numDays            = $download['number_of_days'];
        //If customer has already downloaded allowed times
        if($allowedDownloads != null && $allowedDownloads > 0)
        {
            if($count >= $download['allowed_downloads'])
            {
                return UsniAdaptor::t('productflash', 'You have downloaded maximum number of times allowed for {name}.', ['name' => $download['name']]);
            }
        }
        //If number of days after which it could be downloaded crossed
        if($numDays != null && $numDays > 0)
        {
            if($currentDateTime == null)
            {
                $currentDateTime = time();
            }
            $createdDateTime = strtotime($order['created_datetime']);
            $days    = floor($currentDateTime - $createdDateTime)/(60 * 60 * 24);
            if($days > $download['number_of_days'])
            {
                return UsniAdaptor::t('productflash', 'The number of days allowed to download are expired for {name}. Please contact system admin.', ['name' => $download['name']]);
            }
        }
        return true;
    }
    
    /**
     * Get download option for the product.
     * @param int $id
     * @return Array
     */
    public function getDownloadOption($id)
    {
        $relatedDownloadRecord = ProductDownloadMapping::find()->where('product_id = :pId', [':pId' => $id])->asArray()->one();
        if(!empty($relatedDownloadRecord))
        {
            return $relatedDownloadRecord['download_option'];
        }
        return null;
    }
}