<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\grid;

use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
use usni\library\grid\ActionColumn;
/**
 * MyOrderActionColumn class file.
 *
 * @package common\modules\order\grid
 */
class MyOrderActionColumn extends ActionColumn
{
    /**
     * @inheritdoc
     */
    protected function renderViewActionLink($url, $model, $key)
    {
        $url        = UsniAdaptor::createUrl('customer/site/order-view', ['id' => $model['id']]);
        $icon       = FA::icon('eye');
        $options    = [
                        'title' => \Yii::t('yii', 'View'),
                        'data-pjax' => '0',
                        'id'        => 'view-order-' . $model['id'],
                        'class'     => 'view-order'
                      ];
        return Html::a($icon, $url, $options);
    }
}