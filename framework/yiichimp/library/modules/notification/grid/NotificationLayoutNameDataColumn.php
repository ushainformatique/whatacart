<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\grid;

use usni\UsniAdaptor;
use yii\grid\DataColumn;
use usni\library\utils\Html;

/**
 * NotificationLayoutNameDataColumn class file.
 * 
 * @package usni\library\modules\notification\grid
 */
class NotificationLayoutNameDataColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return Html::a($model['name'], UsniAdaptor::createUrl("notification/layout/view", ["id" => $model['id']]));
    }

}