<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\views\install;

use usni\library\modules\install\views\InstallWelcomeView;
use usni\UsniAdaptor;
/**
 * Extends welcome view functionality specific to application
 * 
 * @package backend\views\install
 */
class WelcomeView extends InstallWelcomeView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $file = UsniAdaptor::getAlias('@themes/bootstrap/views/install/welcome.php');
        return $this->getView()->renderPhpFile($file);
    }
}
