<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\components;

use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use products\utils\ProductUtil;

/**
 * ReviewStatusDataColumn class file.
 * @package products\components
 */
class ReviewStatusDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        return ProductUtil::renderReviewStatus($model);
    }
}
?>