<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\language\dao;

use usni\UsniAdaptor;
/**
 * LanguageDAO class file.
 * 
 * @package usni\library\modules\language\dao
 */
class LanguageDAO
{
    /**
     * Get currency name.
     * @param string $code
     * @return array
     */
    public static function getLanguageName($code)
    {
        $languageTable          = UsniAdaptor::tablePrefix() . 'language';
        $sql                    = "SELECT lt.name 
                                   FROM $languageTable lt
                                   WHERE lt.code = :code";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':code' => $code])->queryOne();       
    }
}
