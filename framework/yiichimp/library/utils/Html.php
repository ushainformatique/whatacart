<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;

/**
 * Html extends native html functionality provided with yii2 framework.
 * 
 * @package usni\library\utils
 */
class Html extends \yii\helpers\Html
{
    const COLOR_DEFAULT     = 'default';
    const COLOR_PRIMARY     = 'primary';
    const COLOR_INFO        = 'info';
    const COLOR_SUCCESS     = 'success';
    const COLOR_WARNING     = 'warning';
    const COLOR_DANGER      = 'danger';

    /**
     * Gets default prompt for the dropdown.
     * @return string
     */
    public static function getDefaultPrompt()
    {
        return UsniAdaptor::t('application', '--Select--');
    }
}