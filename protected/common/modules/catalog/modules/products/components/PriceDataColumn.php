<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\components;

use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use products\utils\ProductUtil;
/**
 * PriceDataColumn class file.
 * 
 * @package common\modules\catalog\components
 */
class PriceDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        return ProductUtil::getFormattedPrice($model->price);
    }
}