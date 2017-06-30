<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\grid;

use common\modules\localization\modules\orderstatus\widgets\StatusLabel;
/**
 * OrderStatusDataColumn class file.
 * 
 * @package common\modules\order\grid
 */
class OrderStatusDataColumn extends \yii\grid\DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return StatusLabel::widget(['model' => $model]);
    }
}