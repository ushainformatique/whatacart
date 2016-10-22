<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\library\views\UiDetailView;
use common\modules\manufacturer\utils\ManufacturerUtil;
/**
 * ProductRelatedView class file.
 *
 * @package products\views
 */
class ProductRelatedView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    [
                        'attribute' => 'categories',
                        'value'     => $this->model->renderCategories()
                    ],
                    [
                        'attribute'  => 'relatedProducts', 
                        'value'     => $this->model->renderRelatedProducts()
                    ],
                    [
                        'attribute' => 'manufacturer',
                        'value'     => $this->getManufacturer()
                    ],
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
     * Get manufacturer
     * @return string.
     */
    protected function getManufacturer()
    {
        $manufacturer = ManufacturerUtil::getManufacturer($this->model->manufacturer);
        return $manufacturer['name'];
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