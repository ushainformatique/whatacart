<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\managers;

use usni\library\components\UiDataManager;
/**
 * LocalizationDataManager class file
 * 
 * @package common\modules\localization\managers
 */
class LocalizationDataManager extends UiDataManager
{
    /**
     * @inheritdoc
     */
    public static function loadDefaultData()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDemoData()
    {
        return [];
    }
}
