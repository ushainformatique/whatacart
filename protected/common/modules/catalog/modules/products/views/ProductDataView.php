<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\library\utils\StatusUtil;
use usni\library\utils\FileUploadUtil;
use products\utils\ProductUtil;
use taxes\models\ProductTaxClass;
use usni\library\views\UiDetailView;
use usni\library\utils\DateTimeUtil;
/**
 * ProductDataView class file.
 *
 * @package products\views
 */
class ProductDataView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $taxClass = ProductTaxClass::findOne($this->model->tax_class_id);
        if($taxClass != null)
        {
            $taxClassName = $taxClass->name;
        }
        return [
                    [
                        'attribute'  => 'image',
                        'value'      => FileUploadUtil::getThumbnailImage($this->model, 'image'),
                        'format'     => 'raw'
                    ],
                    'minimum_quantity',
                    'location',
                    [
                        'attribute' => 'date_available',
                        'value'     => DateTimeUtil::getFormattedDate($this->model->date_available)
                    ],
                    'length',
                    'width',
                    'height',
                    'weight',
                    [
                        'attribute' => 'status', 
                        'value'     => StatusUtil::renderLabel($this->model), 
                        'format'    => 'raw'
                    ],
                    [
                        'attribute'  => 'tax_class_id', 
                        'value' => $taxClassName
                    ],
                    [
                        'attribute' => 'stock_status',
                        'value'     => ProductUtil::getStockStatus($this->model),
                        'format'    => 'raw'
                        
                    ],
                    [
                        'attribute' => 'subtract_stock',
                        'value'     => ProductUtil::getSubtractStock($this->model),
                        
                    ],
                    [
                        'attribute' => 'requires_shipping',
                        'value'     => ProductUtil::getSubtractStock($this->model),
                        
                    ],
                    [
                        'attribute' => 'length_class',
                        'value'     => ProductUtil::getLengthClass($this->model->length_class),
                        
                    ],
                    [
                        'attribute' => 'weight_class',
                        'value'     => ProductUtil::getWeightClass($this->model->weight_class),   
                    ],
                    [
                        'attribute' => 'is_featured',
                        'value'     => ProductUtil::getIsFeaturedProduct($this->model->is_featured)
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
}
?>