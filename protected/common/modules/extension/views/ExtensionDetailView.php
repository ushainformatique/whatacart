<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\views;

use usni\library\views\UiDetailView;
use usni\UsniAdaptor;
/**
 * ExtensionDetailView class file
 *
 * @package common\modules\extension\views
 */
class ExtensionDetailView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    'name',
                    'category',
                    'author',
                    'version',
                    'product_version',
                    ['attribute'        => 'data',    'value'   => $this->getSummary(), 'format' => 'html'],
               ];
    }
    
    /**
     * Get summary
     * @return summary
     */
    protected function getSummary()
    {
        $subView = UsniAdaptor::getAlias('@common/modules/extension/views/_data.php');
        return UsniAdaptor::app()->getView()->renderPhpFile($subView, ['extensionData' => unserialize($this->model->data)]);
    }
    
    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return $this->model->name;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderOptions()
    {
        return null;
    }
}
?>