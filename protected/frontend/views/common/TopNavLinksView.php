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
 * TopNavLinksView class file.
 * @package frontend\views\commmon
 */
class TopNavLinksView extends UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $theme          = FrontUtil::getThemeName();
        $file           = UsniAdaptor::getAlias('@themes/' . $theme . '/views/common/_topnav.php');
        $content        = $this->getView()->renderPhpFile($file);
        return $content;
    }
}
