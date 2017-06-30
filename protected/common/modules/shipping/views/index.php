<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use yii\grid\CheckboxColumn;
use common\modules\extension\models\Extension;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;
use common\modules\shipping\grid\ShippingActionToolbar;
use common\modules\shipping\grid\ShippingActionColumn;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('shipping', 'Manage Shipping');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'gridId' => 'shippinggridview',
    'pjaxId' => 'shippinggridview-pjax',
    'permissionPrefix'  => 'extension',
    'showCreate' => false
];
$widgetParams   = [
                        'id'            => 'shippinggridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => UsniAdaptor::t('shipping', 'Manage Shipping'),
                        'modelClass'    => Extension::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            'code',
                            'author',
                            'version',
                            'product_version',
                            [
                                'attribute' => 'status',
                                'class' => StatusDataColumn::className(),
                                'filter' => StatusUtil::getDropdown()
                            ],
                            [
                                'class'             => ShippingActionColumn::className(),
                                'template'          => '{settings} {changestatus} {delete}',
                                'modelClassName'    => Extension::className()
                            ]
                        ],
                ];
echo ShippingActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);