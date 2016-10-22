<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\components;

use usni\library\widgets\UiStatusDataColumn;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
/**
 * OrderStatusDataColumn class file.
 * 
 * @package common\modules\order\components
 */
class OrderStatusDataColumn extends UiStatusDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return OrderStatusUtil::renderLabel($model);
    }
}