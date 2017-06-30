<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\grid;

use usni\UsniAdaptor;
use yii\grid\DataColumn;
use usni\library\utils\Html;
/**
 * LocalizationNameDataColumn class file.
 * 
 * @package common\modules\localization\grid
 */
class LocalizationNameDataColumn extends DataColumn
{
    /**
     * @var ActiveRecord 
     */
    public $modelClassName;
    
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $controllerId    = lcfirst($this->modelClassName);
        return Html::a($model['name'], UsniAdaptor::createUrl("/localization/$controllerId/default/view", ["id" => $model['id']]), ['data-pjax' => '0']);
    }
}