<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use common\modules\order\models\Order;
use common\modules\order\grid\OrderStatusDataColumn;
use usni\library\grid\FormattedDateTimeColumn;
use common\modules\order\grid\MyOrderActionColumn;

$title              = UsniAdaptor::t('order', 'My Orders');
$this->title        = $title;
$this->leftnavView  = '/front/_sidebar'; 
$this->params['breadcrumbs'] = [    
                                    [
                                        'label' => UsniAdaptor::t('customer', 'My Account'),
                                        'url'   => ['/customer/site/my-account']
                                    ],
                                    [
                                        'label' => $title
                                    ]
                               ];
$widgetParams   = [
                        'id'            => 'myordersgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => UsniAdaptor::t('order', 'My Orders'),
                        'modelClass'    => Order::className(),
                        'columns' => [
                                        [
                                            'label'     => UsniAdaptor::t('order', 'Order Id'),
                                            'attribute' => 'unique_id'
                                        ],
                                        [
                                            'attribute' => 'status',
                                            'class'     => OrderStatusDataColumn::className(),
                                            'filter'    => $gridViewDTO->getStatusData()
                                        ],
                                        [
                                            'label'     => UsniAdaptor::t('products', 'Amount'),
                                            'attribute' => 'amount',
                                        ],
                                        [
                                            'label'     => UsniAdaptor::t('order', 'Date Added'),
                                            'attribute' => 'created_datetime',
                                            'class'     => FormattedDateTimeColumn::className()
                                        ],
                                        [
                                            'class' => MyOrderActionColumn::className(),
                                            'template' => '{view}',
                                            'modelClassName' => Order::className()
                                        ]
                                     ],
                ];
echo GridView::widget($widgetParams);