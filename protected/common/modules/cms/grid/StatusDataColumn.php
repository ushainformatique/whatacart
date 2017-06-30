<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\grid;

use yii\grid\DataColumn;
use common\modules\cms\widgets\StatusLabel;
/**
 * StatusDataColumn class file.
 * 
 * @package common\modules\cms\grid
 */
class StatusDataColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return StatusLabel::widget(['model' => $model]);
    }
}