<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\language\utils;

use usni\UsniAdaptor;
use usni\library\utils\CacheUtil;
/**
 * LanguageUtil class file
 * 
 * @package common\modules\localization\modules\currency\utils
 */
class LanguageUtil
{   
    /**
     * Get currency name.
     * @param string $languageCode
     * @return array
     */
    public static function getLanguageName($languageCode, $language = null)
    {
        $record                 = CacheUtil::get($languageCode . '-language');
        if($language == null)
        {
            $language = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        if($record === false)
        {
            $languageTable          = UsniAdaptor::tablePrefix() . 'language';
            $sql                    = "SELECT lt.name 
                                       FROM $languageTable lt
                                       WHERE lt.code = :code";
            $connection             = UsniAdaptor::app()->getDb();
            $record                 =  $connection->createCommand($sql, [':code' => $languageCode])->queryOne();
            CacheUtil::set($languageCode . '-language', $record);
        }
        return $record;
    }
    
    /**
     * Check if allowed to delete
     * @param Language $model
     * @return boolean
     */
    public static function checkIfAllowedToDelete($model)
    {
        if($model->code != 'en-US')
        {
            return true;
        }
        return false;
    }
}