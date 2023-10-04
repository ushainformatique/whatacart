<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
/**
 * Helper class for flash messages in the system.
 * 
 * @package usni\library\utils
 */
class FlashUtil
{
    /**
     * Set the flash message.
     * @param string $key       Key of the flash message.
     * @param string $flashMessage Module key.
     * @return void
     */
    public static function setMessage($key, $flashMessage)
    {
        UsniAdaptor::app()->getSession()->setFlash($key, $flashMessage);
    }
}