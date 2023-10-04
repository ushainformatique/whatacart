<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;

/**
 * StatusUtil class file.
 * 
 * @package usni\library\utils
 */
class StatusUtil
{
    /**
     * Active status constant.
     */
    const STATUS_ACTIVE = 1;
    /**
     * Inactive status constant.
     */
    const STATUS_INACTIVE = 0;
    /**
     * Pending status constant.
     */
    const STATUS_PENDING    = 2;

    /**
     * Gets status dropdown.
     * @return array
     */
    public static function getDropdown()
    {
        return array(
            self::STATUS_ACTIVE     => UsniAdaptor::t('application', 'Active'),
            self::STATUS_INACTIVE   => UsniAdaptor::t('application', 'Inactive')
        );
    }
}