<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\views\settings;

use frontend\utils\FrontUtil;
/**
 * MenuSettingsView class file.
 * 
 * @package backend\views\settings
 */
class MenuSettingsView extends \usni\library\modules\settings\views\MenuSettingsView
{
    /**
     * Gets menu list items.
     * @throws MethodNotImplementedException
     * @return array
     */
    protected function getListItems()
    {
        $sortOrderData = unserialize($this->model->sortOrder);
        return FrontUtil::getTopMenuItemsList($sortOrderData);
    }
}