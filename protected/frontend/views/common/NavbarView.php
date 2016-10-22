<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\library\views\UiView;
use frontend\utils\FrontUtil;
use usni\UsniAdaptor;
/**
 * NavbarView class file.
 *
 * @package frontend\views\commmon
 */
class NavbarView extends UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $themeName       = FrontUtil::getThemeName();
        $file            = UsniAdaptor::getAlias('@themes/' . $themeName . '/views/common/_navbar') . '.php';
        return $this->getView()->renderPhpFile($file, ['globalMenuView' => FrontUtil::renderGlobalMenu()]);
    }
}
