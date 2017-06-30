<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\grid;

use yii\grid\DataColumn;
use usni\library\utils\Html;
use usni\UsniAdaptor;
/**
 * ProductCategoryNameDataColumn class file.
 *
 * @package productCategories\grid
 */
class ProductCategoryNameDataColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $name = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $model['level']). ' ' . $model['name'];
        return Html::a($name, UsniAdaptor::createUrl("catalog/productCategories/default/view", ["id" => $model['id']]), ['data-pjax' => '0']);
    }
}