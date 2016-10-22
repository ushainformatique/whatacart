<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\stockstatus\utils;

use products\utils\ProductUtil;
/**
 * StockStatusUtil class file.
 * 
 * @package common\modules\localization\modules\stockstatus\utils
 */
class StockStatusUtil
{
    /**
     * Check if allowed to delete
     * @param OrderStatus $model
     * @return boolean
     */
    public static function checkIfAllowedToDelete($model)
    {
        $products = ProductUtil::getCountByAttribute('stock_status', $model['id']);
        if(empty($products))
        {
            return true;
        }
        return false;
    }
}