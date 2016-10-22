<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\components;

use usni\UsniAdaptor;
use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\library\components\UiHtml;
/**
 * OrderStatusNameDataColumn class file.
 * 
 * @package common\modules\localization\modules\orderstatus\components
 */
class OrderStatusNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return UiHtml::a($model->name, UsniAdaptor::createUrl("orderstatus/default/view", ["id" => $model->id]));
    }

}