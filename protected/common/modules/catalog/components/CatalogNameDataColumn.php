<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\catalog\components;

use usni\UsniAdaptor;
use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\library\components\UiHtml;
/**
 * CatalogNameDataColumn class file.
 * @package common\modules\catalog\components
 */
class CatalogNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $modelClassName  = UsniAdaptor::getObjectClassName($model);
        $controllerId    = lcfirst($modelClassName);
        return UiHtml::a($model->name, UsniAdaptor::createUrl("/catalog/$controllerId/default/view", ["id" => $model->id]), ['data-pjax' => '0']);
    }
}