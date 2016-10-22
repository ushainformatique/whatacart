<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\utils;

use usni\library\utils\PermissionUtil;
use common\modules\dataCategories\models\DataCategory;
/**
 * DataCategoryPermissionUtil class file.
 * 
 * @package common\modules\dataCategories\utils
 */
class DataCategoryPermissionUtil extends PermissionUtil
{

    /**
     * Gets models associated to the data category module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    DataCategory::className()
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'dataCategories';
    }
}