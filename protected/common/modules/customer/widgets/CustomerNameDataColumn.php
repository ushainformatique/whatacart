<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\widgets;

use yii\grid\DataColumn;
use usni\UsniAdaptor;
use usni\library\utils\Html;
/**
 * CustomerNameDataColumn class file.
 * 
 * @package customer\widgets
 */
class CustomerNameDataColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        return Html::a($model['username'], UsniAdaptor::createUrl("customer/default/view", ["id" => $model['id']]), ['data-pjax' => 0]);
    }
}
