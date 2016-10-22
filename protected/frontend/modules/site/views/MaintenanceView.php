<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */
namespace frontend\modules\site\views;

use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
/**
 * MaintenanceView class file.
 * 
 * @package frontend\modules\site\views
 */
class MaintenanceView extends \frontend\views\FrontPageView
{
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $theme = FrontUtil::getThemeName();
        $file  = UsniAdaptor::getAlias("@themes/$theme/views/site/maintenance.php");
        return $this->getView()->renderPhpFile($file);
    }
}