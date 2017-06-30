<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use yii\grid\CheckboxColumn;
use common\modules\order\grid\OrderStatusDataColumn;
use common\modules\order\models\Order;
use common\modules\order\grid\OrderActionColumn;

/* @var $gridViewDTO \common\modules\order\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('order', 'Manage Orders');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'showBulkEdit'  => false,
    'showBulkDelete'=> false,
    'gridId'        => 'ordergridview',
    'pjaxId'        => 'ordergridview-pjax',
    'permissionPrefix'  => 'order',
    'showModalDetail' => false
];
$widgetParams   = [
                        'id'            => 'ordergridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Order::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'unique_id',
                            'name',
                            [
                                'label'         => UsniAdaptor::t('customer', 'Customer'),
                                'attribute'     => 'customer_id',
                                'value'         => 'username',
                                'filter'        => $gridViewDTO->getCustomerFilterData()
                            ],
                            [
                                'attribute'     => 'status',
                                'class'         => OrderStatusDataColumn::className(),
                                'filter'        => $gridViewDTO->getStatusData()
                            ],
                            [
                                'label'         => UsniAdaptor::t('order', 'Amount'),
                                'attribute'     => 'amount'
                            ],
                            [
                                'label'         => UsniAdaptor::t('shipping', 'Shipping Method'),
                                'attribute'     => 'shipping',
                                'value'         => 'shipping_method_name',
                                'filter'        => $gridViewDTO->getShippingMethods()
                            ],
                            [
                                'label'         => UsniAdaptor::t('payment', 'Payment Method'),
                                'attribute'     => 'payment_method',
                                'value'         => 'payment_method_name',
                                'filter'        => $gridViewDTO->getPaymentMethods()
                            ],
                            [
                                'class'         => OrderActionColumn::className(),
                                'template'      => '{view} {update} {delete} {invoice} {paymentactivity} {viewpayments}',
                                'modelClassName' => Order::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);