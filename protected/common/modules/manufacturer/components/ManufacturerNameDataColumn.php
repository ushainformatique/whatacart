<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\components;

use usni\UsniAdaptor;
use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\library\components\UiHtml;
/**
 * ManufacturerNameDataColumn class file.
 * 
 * @package common\modules\manufacturer\components
 */
class ManufacturerNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return UiHtml::a($model->name, UsniAdaptor::createUrl("manufacturer/default/view", ["id" => $model->id]));
    }

}