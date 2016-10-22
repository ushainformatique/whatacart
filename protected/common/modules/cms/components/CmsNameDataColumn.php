<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\components;

use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
/**
 * CmsNameDataColumn class file.
 * 
 * @package common\modules\cms\components
 */
class CmsNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $modelClassName  = UsniAdaptor::getObjectClassName($model);
        $controllerId    = strtolower($modelClassName);
        return UiHtml::a($model['name'],UsniAdaptor::createUrl("/cms/$controllerId/view", ["id" => $model->id]));
    }

}
