<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\components;

use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
/**
 * ProductCategoryNameDataColumn class file.
 *
 * @package productCategories\components
 */
class ProductCategoryNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $name = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $model['level']). ' ' . $model['name'];
        return UiHtml::a($name, UsniAdaptor::createUrl("catalog/productCategories/default/view", ["id" => $model['id']]), ['data-pjax' => '0']);
    }
}