<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace usni\library\utils;

use usni\library\utils\Html;
use usni\fontawesome\FA;
/**
 * MenuUtil implements the helper functions related to menu
 *
 * @package usni\library\utils
 */
class MenuUtil
{
    /**
     * Wrap admin sidebar menu label.
     * @param string $label
     * @return string.
     */
    public static function wrapLabel($label)
    {
        return Html::tag('span', $label);
    }
    
    /**
     * Gets admin sidebar icon.
     * @param string $icon
     * @return string
     */
    public static function getSidebarMenuIcon($icon)
    {
        return FA::icon($icon)->size(FA::SIZE_LARGE);
    }
}
