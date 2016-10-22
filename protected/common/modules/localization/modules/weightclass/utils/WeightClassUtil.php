<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\utils;

use products\utils\ProductUtil;
/**
 * WeightClassUtil class file
 *
 * @package common\modules\localization\modules\weightclass\utils
 */
class WeightClassUtil
{   
    /**
     * Check if allowed to delete
     * @param WeightClass $model
     * @return boolean
     */
    public static function checkIfAllowedToDelete($model)
    {
        $count = ProductUtil::getCountByAttribute('weight_class', $model['id']);
        if($model['value'] != 1.00 && $count == 0)
        {
            return true;
        }
        return false;
    }
}