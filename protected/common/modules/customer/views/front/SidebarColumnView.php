<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
/**
 * SidebarColumnView class file.
 * @package customer\views\front
 */
class SidebarColumnView extends \usni\library\views\UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $theme        = FrontUtil::getThemeName();
        $file         = UsniAdaptor::getAlias('@themes/' . $theme . '/views/customers/_sidebar') . '.php';
        return $this->getView()->renderPhpFile($file);
    }
}
