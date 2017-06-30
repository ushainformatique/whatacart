<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\grid;

use usni\library\utils\Html;
use usni\UsniAdaptor;
/**
 * ProductNameDataColumn class file.
 *
 * @package products\grid
 */
class ProductNameDataColumn extends \yii\grid\DataColumn
{
    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        return Html::a($model['name'], UsniAdaptor::createUrl("/catalog/products/default/view", ["id" => $model['id']]), ['data-pjax' => '0']);
    }
}