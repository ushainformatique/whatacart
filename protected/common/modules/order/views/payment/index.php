<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use yii\grid\CheckboxColumn;
use usni\library\grid\ActionColumn;
use common\modules\order\models\OrderPaymentTransactionMap;
use common\modules\order\models\Order;
use usni\library\utils\Html;
use usni\library\utils\ArrayUtil;

/* @var $gridViewDTO \common\modules\order\dto\PaymentGridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('payment', 'Manage Payments');
$this->title    = $title;
$this->params['breadcrumbs'] = [
                                    [
                                        'label' => UsniAdaptor::t('order', 'Manage Orders'),
                                        'url'   => UsniAdaptor::createUrl('order/default/index')
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('payment', 'Manage Payments')
                                    ]
                                ];
$toolbarParams  = [
    'showCreate'     => false,
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => false,
    'showBulkDelete'=> true,
    'gridId'        => 'orderpaymentsgridview',
    'pjaxId'        => 'orderpaymentsgridview-pjax',
    'permissionPrefix'  => 'order',
    'showModalDetail' => false
];
$filterParams       = UsniAdaptor::app()->request->get('OrderPaymentTransactionMapSearch');
$createdDatetime    = ArrayUtil::getValue($filterParams, 'created_datetime');
$widgetParams   = [
                        'id'            => 'orderpaymentsgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => OrderPaymentTransactionMap::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'label'     => UsniAdaptor::t('order', 'Order Id'),
                                'attribute' => 'unique_id'
                            ],
                            [
                                'attribute' => 'amount',
                                'value' => 'formatted_amount'
                            ],
                            [
                                'attribute' => 'payment_method',
                                'value'     => 'payment_method_name',
                                'filter'    => $gridViewDTO->getPaymentMethods()
                            ],
                            [
                                'attribute' => 'created_datetime',
                                'value'     => 'formatted_time',
                                'filter'    => Html::textInput(Html::getInputName($gridViewDTO->getSearchModel(), 'created_datetime'), 
                                                                                  $createdDatetime, 
                                                                                  ['class' => 'form-control', 'id' => null, 'placeholder' => 'YYYY-MM-DD H:i:s'])
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{delete}',
                                'modelClassName' => Order::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);