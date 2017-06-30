<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\grid;

use usni\UsniAdaptor;
use yii\grid\DataColumn;
use usni\library\utils\Html;
/**
 * TaxNameDataColumn class file.
 * 
 * @package taxes\grid
 */
class TaxNameDataColumn extends DataColumn
{
    /**
     * @var string 
     */
    public $modelClassName;
    
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $controllerId   = strtolower($this->modelClassName);
        return Html::a($model['name'], UsniAdaptor::createUrl("/tax/$controllerId/view", array("id" => $model['id'] )));
    }

}