<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\db;

use usni\library\db\DataManager;
/**
 * Loads default data related to cms.
 *
 * @package common\modules\cms\db
 */
class CmsDataManager extends DataManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        return PageDataManager::getInstance()->loadDefaultData();
    }
    
	/**
     * @inheritdoc
     */
    public function loadDemoData()
    {
        return PageDataManager::getInstance()->loadDemoData();
    }
}