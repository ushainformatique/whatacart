<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\utils;

use usni\library\utils\PermissionUtil;
use common\modules\cms\models\Page;

/**
 * CmsPermissionUtil class file.
 * 
 * @package common\modules\cms\utils
 */
class CmsPermissionUtil extends PermissionUtil
{
    /**
     * Get model to excluded permissions.
     * @return array
     */
    public static function getModelToExcludedPermissions()
    {
        return [];
    }

    /**
     * Gets models associated to the cms module.
     * @return array
     */
    public static function getModels()
    {
        return array(
            Page::className()
        );
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'cms';
    }
}