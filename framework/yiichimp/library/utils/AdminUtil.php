<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
/**
 * Class consisting of utility functions related to admin.
 * 
 * @package usni\library\utils
 */
class AdminUtil
{
    /**
     * Get Yes No Select options.
     * @return array
     */
    public static function getYesNoOptions()
    {
        return [
                    1 => UsniAdaptor::t('application', 'Yes'),
                    0 => UsniAdaptor::t('application', 'No'),
               ];
    }
    
    /**
     * Get yes no option display text
     * @param int $value
     * @return string
     */
    public static function getYesNoOptionDisplayText($value)
    {
        $options = static::getYesNoOptions();
        return $options[$value];
    }
}