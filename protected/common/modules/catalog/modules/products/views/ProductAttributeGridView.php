<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\components\TranslatableGridView;
use usni\library\utils\DAOUtil;
use products\models\ProductAttributeGroup;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
/**
 * ProductAttributeGridView class file
 * @package products\views
 */
class ProductAttributeGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                       [
                           'attribute'  => 'name',
                       ],
                       [
                           'attribute'  => 'attribute_group',
                           'value'      => [$this, 'getAttributeGroup'],
                           'filter'     => DAOUtil::getDropdownDataBasedOnModel(ProductAttributeGroup::className())
                       ],
                       'sort_order',
                       [
                           'class'      => UiActionColumn::className(),
                           'template'   => '{view} {update} {delete}'
                       ]
                   ];
        return $columns;
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        $content = parent::getActionToolbarOptions();
        $content['showBulkEdit'] = false;
        return $content;
    }
    
    /**
     * Gets attribute group.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getAttributeGroup($data, $key, $index, $column)
    {
        return $data->group->name;
    }
}
?>