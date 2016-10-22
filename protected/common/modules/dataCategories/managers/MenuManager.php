<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\managers;

use common\modules\dataCategories\models\DataCategory;
use usni\library\managers\BaseMenuManager;
use usni\UsniAdaptor;
/**
 * MenuManager class file.
 * @package common\modules\dataCategories\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return DataCategory::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getIcon()
    {
        return 'folder-open-o';
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'dataCategories';
    }
    
    /**
     * @inheritdoc
     */
    public static function getSidebarHeader()
    {
        return UsniAdaptor::t('application', 'System');
    }
}