<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\library\views\UiView;
use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
/**
 * SearchNavView class file.
 * @package frontend\views\commmon
 */
class SearchNavView extends UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $frontTheme     = FrontUtil::getThemeName();
        $file           = UsniAdaptor::getAlias('@themes/' . $frontTheme . '/views/common/_navSearch.php');
        return $this->getView()->renderPhpFile($file);
    }
}
