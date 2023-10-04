<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\grid;

use usni\UsniAdaptor;
use yii\grid\DataColumn;
use usni\library\utils\Html;

/**
 * AuthNameDataColumn class file.
 * 
 * @package usni\library\modules\auth\grid
 */
class AuthNameDataColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return Html::a(str_repeat('&nbsp;&nbsp;&nbsp;', $model['level']) . $model['name'], 
                            UsniAdaptor::createUrl("/auth/group/view", array("id" => $model['id'] )));
    }

}