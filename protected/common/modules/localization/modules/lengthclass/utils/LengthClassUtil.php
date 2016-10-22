<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass\utils;

use products\utils\ProductUtil;
/**
 * LengthClassUtil class file
 *
 * @package common\modules\localization\modules\lengthclass\utils
 */
class LengthClassUtil
{   
    /**
     * Check if allowed to delete
     * @param LengthClass $model
     * @return boolean
     */
    public static function checkIfAllowedToDelete($model)
    {
        $count = ProductUtil::getCountByAttribute('length_class', $model['id']);
        if($model['value'] != 1.00 && $count == 0)
        {
            return true;
        }
        return false;
    }
}