<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\extension\utils;

use usni\library\utils\PermissionUtil;
use common\modules\extension\models\Extension;

/**
 * ExtensionPermissionUtil class file.
 * @package common\modules\newsletter\utils
 */
class ExtensionPermissionUtil extends PermissionUtil
{
    /**
     * Gets models associated to the newsletter module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    Extension::className()
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'extension';
    }
}
?>