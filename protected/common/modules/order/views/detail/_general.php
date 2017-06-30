<?php
use usni\library\widgets\DetailView;
use usni\UsniAdaptor;
use common\modules\localization\modules\orderstatus\widgets\StatusLabel;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model              = $detailViewDTO->getModel();
$currencySymbol     = UsniAdaptor::app()->currencyManager->getCurrencySymbol($model['currency_code']);
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            'unique_id',
                                            [
                                                'label'      => UsniAdaptor::t('customer', 'Customer'),
                                                'attribute'  => 'customer_id',
                                                'value'      => $model['firstname'] . ' ' . $model['lastname']
                                            ],
                                            [
                                                'attribute' => 'status', 
                                                'value'     => StatusLabel::widget(['model' => $model]), 
                                                'format'    => 'raw' 
                                            ],
                                            [
                                                'attribute' => 'shipping', 
                                                'value'     => $model['shipping_method_name'], 
                                                'format'    => 'raw' 
                                            ],
                                            [
                                                 'attribute'  => 'shipping_fee',
                                                 'value'      => $this->getPriceWithSymbol($model['shipping_fee'], $currencySymbol)
                                             ],
                                            [
                                                'label'      => UsniAdaptor::t('stores', 'Store'),
                                                'attribute'  => 'store_id',
                                                'value'      => $model['store_name']
                                            ],
                                            'shipping_comments'
                                        ]
                    ];
echo DetailView::widget($widgetParams);

