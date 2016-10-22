<?php
namespace common\modules\order\components;

use usni\library\widgets\UiStatusDataColumn;
use common\modules\shipping\utils\ShippingUtil;
/**
 * ShippingNameDataColumn class file.
 *
 * @package common\modules\order\components
 */
class ShippingNameDataColumn extends UiStatusDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return ShippingUtil::getShippingMethodName($model['shipping']);
    }
}