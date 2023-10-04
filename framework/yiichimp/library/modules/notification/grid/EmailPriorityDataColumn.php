<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\grid;

use yii\grid\DataColumn;
use usni\library\modules\notification\utils\NotificationUtil;
use usni\UsniAdaptor;
use usni\library\bootstrap\Label;
use usni\library\utils\Html;
/**
 * EmailPriorityDataColumn class file.
 * 
 * @package usni\library\modules\notification\grid
 */
class EmailPriorityDataColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = NotificationUtil::getPriorityDisplayLabel($model['priority']);
         if ($value == UsniAdaptor::t('notification', 'High'))
         {
             return Label::widget(['content' => $value, 'modifier' => Html::COLOR_SUCCESS]);
         }
        elseif ($value == UsniAdaptor::t('notification', 'Medium'))
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_WARNING]);
        }
        elseif ($value == UsniAdaptor::t('notification','Low'))
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_DANGER]);
        }
        else
        {
            return $value;
        }
    }
}
