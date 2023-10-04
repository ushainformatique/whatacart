<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\language\db;

use usni\library\db\DataManager;
use usni\library\modules\language\models\Language;
/**
 * Loads default data related to language.
 * 
 * @package usni\library\modules\language\db
 */
class LanguageDataManager extends DataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Language::className();
    }

    /**
     * @inheritdoc
     */
    public function getDefaultDataSet()
    {
        return [
                    [
                        'id'         => 1,
                        'name'       => 'English',
                        'code'       => 'en-US', 
                        'locale'     => 'en-US',
                        'image'      => '',
                        'sort_order' => 1,
                        'status'     => Language::STATUS_ACTIVE,
                    ]
               ];
    }
}