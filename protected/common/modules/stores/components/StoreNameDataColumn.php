<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\components;

use usni\UsniAdaptor;
use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\library\components\UiHtml;
/**
 * StoreNameDataColumn class file.
 *
 * @package common\modules\stores\components
 */
class StoreNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return UiHtml::a($model->name, UsniAdaptor::createUrl("stores/default/view", ["id" => $model->id]), ['data-pjax' => 0, 'target' => '_blank']);
    }

}