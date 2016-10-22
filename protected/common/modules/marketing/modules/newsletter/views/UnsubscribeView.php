<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\views;

use frontend\views\FrontPageView;
use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
/**
 * UnsubscribeView class file.
 * @package newsletter\views
 */
class UnsubscribeView extends FrontPageView
{
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $theme = FrontUtil::getThemeName();
        $file  = UsniAdaptor::getAlias("@themes/$theme/views/newsletter/_unsubscribenewsletter.php");
        return $this->getView()->renderPhpFile($file);
    }
}
?>