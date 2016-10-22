<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\components;

use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\components\UiHtml;
/**
 * MyOrderActionColumn class file.
 *
 * @package common\modules\order\components
 */
class MyOrderActionColumn extends UiActionColumn
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
        return UiHtml::a($icon, $url, $options);
    }
}