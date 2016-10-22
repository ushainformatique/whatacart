<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\views;

use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
/**
 * ErrorView class file
 * @package frontend\modules\site\views
 */
class ErrorView extends \usni\library\views\UiErrorView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $content     = parent::renderContent();
        $theme       = FrontUtil::getThemeName();
        $file        = UsniAdaptor::getAlias('@themes/' . $theme . '/views/layouts/innerpage') . '.php';
        return $this->getView()->renderPhpFile($file, ['columnLeft' => null,
                                                       'columnRight'=> null,
                                                       'content'    => $content
                                                ]);
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveErrorFile()
    {
        $themeName = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias("@themes/$themeName/views/site/error.php");
    }

    /**
     * @inheritdoc
     */
    protected function resolveExceptionFile()
    {
        $themeName = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias("@themes/$themeName/views/site/exception.php");
    }
}
?>