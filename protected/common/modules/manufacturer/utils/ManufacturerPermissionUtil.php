<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\manufacturer\utils;

use usni\library\utils\PermissionUtil;
use common\modules\manufacturer\models\Manufacturer;
/**
 * ManufacturerPermissionUtil class file.
 * @package common\modules\manufacturer\utils
 */
class ManufacturerPermissionUtil extends PermissionUtil
{

    /**
     * Gets models associated to the manufacturer module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    Manufacturer::className()
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'manufacturer';
    }
}
?>