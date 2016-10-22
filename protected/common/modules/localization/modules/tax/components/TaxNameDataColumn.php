<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\components;

use usni\UsniAdaptor;
use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\library\components\UiHtml;
/**
 * TaxNameDataColumn class file.
 * @package taxes\components
 */
class TaxNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $modelClassName  = UsniAdaptor::getObjectClassName($model);
        $controllerId    = strtolower($modelClassName);
        return UiHtml::a($model->name, UsniAdaptor::createUrl("/tax/$controllerId/view", array("id" => $model->id )));
    }

}