<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\language\managers;

use usni\library\components\UiDataManager;
use common\modules\localization\modules\language\models\Language;
/**
 * Loads default data related to language.
 * 
 * @package common\modules\localization\modules\language\managers
 */
class LanguageDataManager extends UiDataManager
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
    public static function getDefaultDataSet()
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
                    ],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
}