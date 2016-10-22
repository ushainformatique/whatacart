<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\managers;

use usni\library\components\UiDataManager;
/**
 * Loads default data related to cms.
 *
 * @package common\modules\cms\managers
 */
class CmsDataManager extends UiDataManager
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
    public static function loadDefaultData()
    {
        PageDataManager::loadDefaultData();
    }
    
	/**
     * @inheritdoc
     */
    public static function loadDemoData()
    {
        PageDataManager::loadDemoData();
    }
}