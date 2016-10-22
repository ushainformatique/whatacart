<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\widgets;

use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
/**
 * CustomerNameDataColumn class file.
 * @package customer\widgets
 */
class CustomerNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        return UiHtml::a($model->username, UsniAdaptor::createUrl("customer/default/view", ["id" => $model->id]), ['data-pjax' => 0]);
    }

}
