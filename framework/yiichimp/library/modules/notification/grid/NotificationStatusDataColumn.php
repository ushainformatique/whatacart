<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\grid;

use yii\grid\DataColumn;
use usni\library\modules\notification\widgets\StatusLabel;

/**
 * NotificationStatusDataColumn class file.
 * 
 * @package usni\library\modules\notification\grid
 */
class NotificationStatusDataColumn extends DataColumn
{
    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return StatusLabel::widget(['model' => $model]);
    }
}