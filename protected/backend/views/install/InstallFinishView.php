<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\views\install;

use usni\UsniAdaptor;
/**
 * Extends install settings view functionality specific to application
 * 
 * @package backend\views\install
 */
class InstallFinishView extends \usni\library\views\UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $file = UsniAdaptor::getAlias('@themes/bootstrap/views/install/final.php');
        return $this->getView()->renderPhpFile($file);
    }
}
