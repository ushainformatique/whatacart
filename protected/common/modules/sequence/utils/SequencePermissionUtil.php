<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\sequence\utils;

use usni\library\utils\PermissionUtil;
use common\modules\sequence\models\Sequence;
/**
 * SequencePermissionUtil class file.
 * @package common\modules\sequence\utils
 */
class SequencePermissionUtil extends PermissionUtil
{

    /**
     * Gets models associated to the sequence module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    Sequence::className()
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'sequence';
    }
}
?>