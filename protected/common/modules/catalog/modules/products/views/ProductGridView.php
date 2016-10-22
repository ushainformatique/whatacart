<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\components\TranslatableGridView;
use usni\library\widgets\UiStatusDataColumn;
use usni\library\utils\StatusUtil;
use productCategories\models\ProductCategory;
use usni\library\utils\AdminUtil;
use usni\UsniAdaptor;
use products\components\ProductActionColumn;
use products\components\PriceDataColumn;
/**
 * Product Grid View.
 * @package products\views
 */
class ProductGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $shouldRenderOwnerCreatedModels = !(AdminUtil::doesUserHaveOthersPermissionsOnModel(ProductCategory::className(), UsniAdaptor::app()->user->getUserModel()));
        $productCategory = new ProductCategory();
        $catOptions      = $productCategory->getMultiLevelSelectOptions('name', 0, '-', true, $shouldRenderOwnerCreatedModels);
        return [
                    'name',
                    'model',
                    [
                        'attribute' => 'categories',
                        'value'     => [$this, 'getCategories'],
                        'filter'    => $catOptions
                    ],
                    'quantity',
                    [
                        'attribute'  => 'price',
                        'class'      => PriceDataColumn::className()
                    ],
                    [
                        'attribute'     => 'status',
                        'class'         => UiStatusDataColumn::className(),
                        'filter'        => StatusUtil::getDropdown()
                    ],
                    [
                        'class'     => $this->getActionColumnClassName(),
                        'template'  => '{view} {update} {delete} {attributes} {options}'
                    ]
            ];
    }
    
    /**
     * Gets categories.
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getCategories($model, $key, $index, $column)
    {
        return $model->renderCategories();
    }
    
    /**
     * Get action column class name
     * @return string
     */
    protected function getActionColumnClassName()
    {
        return ProductActionColumn::className();
    }
}
?>