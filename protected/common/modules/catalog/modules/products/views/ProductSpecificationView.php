<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use products\utils\ProductUtil;
use usni\library\views\UiDetailView;
/**
 * ProductSpecificationView class file.
 *
 * @package products\views
 */
class ProductSpecificationView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    'model',
                    'sku',
                    [
                        'attribute'  => 'price',
                        'value'      => ProductUtil::getFormattedPrice($this->model->price)
                    ],
                    'quantity'
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
}
?>