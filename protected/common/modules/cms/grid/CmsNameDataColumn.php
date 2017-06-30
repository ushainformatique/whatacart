<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\grid;

use yii\grid\DataColumn;
use usni\library\utils\Html;
use usni\UsniAdaptor;
/**
 * CmsNameDataColumn class file.
 * 
 * @package common\modules\cms\grid
 */
class CmsNameDataColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $controllerId = UsniAdaptor::app()->controller->id;
        return Html::a(str_repeat('&nbsp;&nbsp;&nbsp;', $model['level']) . $model['name'], 
                            UsniAdaptor::createUrl("/cms/$controllerId/view", array("id" => $model['id'] )));
    }
}
