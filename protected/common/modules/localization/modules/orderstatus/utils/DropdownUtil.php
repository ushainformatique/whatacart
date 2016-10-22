<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\utils;

use usni\UsniAdaptor;
use usni\library\utils\CacheUtil;
use common\modules\localization\modules\orderstatus\models\OrderStatusTranslated;
/**
 * DropdownUtil class file
 * 
 * @package common\modules\localization\modules\orderstatus\utils
 */
class DropdownUtil
{
    /**
     * Get status data
     * @return array
     */
    public static function getStatusData()
    {
        $language   = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $statusData = CacheUtil::get('orderStatusDataCache');
        if($statusData == false)
        {
            $statusDataRecords = OrderStatusTranslated::find()->where('language = :ln', [':ln' => $language])->asArray()->all();
            foreach($statusDataRecords as $statusRecord)
            {
               $statusData[$statusRecord['name']] = $statusRecord['owner_id']; 
            }
            CacheUtil::set('orderStatusDataCache', serialize($statusData));
        }
        else
        {
           $statusData = unserialize($statusData); 
        }
        return $statusData;
    }
    
    /**
     * Get status id
     * @param $status
     * @return int
     */
    public static function getStatusId($status)
    {
        $statusData = self::getStatusData();
        return $statusData[$status];
    }
}