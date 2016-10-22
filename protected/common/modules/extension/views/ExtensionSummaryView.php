<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\views;

use usni\UsniAdaptor;
/**
 * ExtensionSummaryView class file.
 *
 * @package common\modules\extension\views
 */
class ExtensionSummaryView extends \usni\library\views\UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $folder     = UsniAdaptor::app()->getSession()->get('installerFolder');
        $file       = $this->getViewFile();
        return $this->getView()->renderPhpFile($file, [
                                                        'folder' => $folder
                                                      ]);
    }
    
    /**
     * Get view file
     * @return string
     */
    protected function getViewFile()
    {
        return UsniAdaptor::getAlias('@common/modules/extension/views/summary.php');
    }
}