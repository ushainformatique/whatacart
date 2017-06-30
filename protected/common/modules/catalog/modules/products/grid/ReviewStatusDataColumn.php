<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\grid;

use yii\grid\DataColumn;
use products\utils\ReviewUtil;

/**
 * ReviewStatusDataColumn class file.
 * 
 * @package products\grid
 */
class ReviewStatusDataColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        return ReviewUtil::renderStatus($model);
    }
}