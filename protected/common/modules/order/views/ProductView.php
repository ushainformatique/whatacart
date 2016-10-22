<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\views\UiDetailView;
use common\modules\order\views\AdminOrderProductSubView;
/**
 * ProductView class.
 *
 * @package common\modules\order\views
 */
class ProductView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    [
                        'label'     => null,
                        'attribute' => 'orderProductInformation',
                        'value'     => $this->getContent(),
                        'format'    => 'raw'
                    ]
                ];
    }

    /**
     * @inheritdoc
     */
    protected function shouldRenderTitle()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderCreatedAttributes()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderModifiedAttributes()
    {
        return false;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDetailModelBrowseView()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function wrapView($content)
    {
        return $content;
    }
    
    /**
     * @inheritdoc
     */
    protected function getHtmlOptions()
    {
        return ['tag' => 'div'];
    }
    
    /**
     * Get cart content
     * @return string
     */
    protected function getContent()
    {
        $subView    = new AdminOrderProductSubView(['order' => $this->model]);
        return $subView->render();
    }
    
    /**
     * @inheritdoc
     */
    protected function getItemTemplate()
    {
        return "<tr><td>{value}</td></tr>\n";
    }
}
