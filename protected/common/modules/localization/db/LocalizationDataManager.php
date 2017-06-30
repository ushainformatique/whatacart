<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\db;

use usni\library\db\DataManager;
/**
 * LocalizationDataManager class file
 * 
 * @package common\modules\localization\db
 */
class LocalizationDataManager extends DataManager
{
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public function loadDemoData()
    {
        return [];
    }
}
