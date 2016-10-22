<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace productCategories\views;

use usni\library\components\TranslatableGridView;
use usni\library\widgets\UiStatusDataColumn;
use usni\library\utils\StatusUtil;
use productCategories\components\ProductCategoryNameDataColumn;
use usni\library\utils\FileUploadUtil;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
/**
 * Product category grid view.
 * 
 * @package productCategories\views
 */
class ProductCategoryGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    [
                        'attribute' => 'image',
                        'value'     => [$this, 'getImage'],
                        'format'    => 'raw',
                        'filter'    => false,
                        'enableSorting' => false
                    ],
                    [
                        'attribute'     => 'name', 
                        'class'         => ProductCategoryNameDataColumn::className()
                    ],
                    [
                        'attribute'     => 'status',
                        'class'         => UiStatusDataColumn::className(),
                        'filter'        => StatusUtil::getDropdown()
                    ],
                    [
                        'class'         => UiActionColumn::className(),
                        'template'      => '{view} {update} {delete}'
                    ]
               ];
    }
    
    /**
     * Gets category image.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getImage($data, $key, $index, $column)
    {
        return FileUploadUtil::getThumbnailImage($data, 'image', ['thumbWidth' => 50, 'thumbHeight' => 50]);
    }
}