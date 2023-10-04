<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\widgets;

use yii\grid\DataColumn;
use usni\UsniAdaptor;
use usni\library\utils\Html;
/**
 * UserNameDataColumn class file.
 * 
 * @package usni\library\modules\users\widgets
 */
class UserNameDataColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return Html::a($model['username'], UsniAdaptor::createUrl("users/default/view", ["id" => $model['id']]), ['target' => '_blank', 'data-pjax' => 0]);
    }

}
