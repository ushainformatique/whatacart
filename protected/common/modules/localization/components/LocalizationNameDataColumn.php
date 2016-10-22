<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\components;

use usni\UsniAdaptor;
use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\library\components\UiHtml;
/**
 * LocalizationNameDataColumn class file.
 * 
 * @package common\modules\localization\components
 */
class LocalizationNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $modelClassName  = UsniAdaptor::getObjectClassName($model);
        $controllerId    = lcfirst($modelClassName);
        return UiHtml::a($model->name, UsniAdaptor::createUrl("/localization/$controllerId/default/view", ["id" => $model->id]), ['data-pjax' => '0']);
    }
}