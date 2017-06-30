<?php
use usni\library\widgets\DetailView;

/* @var $detailViewDTO \common\modules\order\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            [
                                                'attribute' => 'payment_method',
                                                'value'     => $model['payment_method_name']
                                            ],
                                            [
                                                'attribute' => 'total_including_tax',
                                                'value'     => $this->getPriceWithSymbol($model['total_including_tax'], $model['currency_symbol']),
                                                'format'    => 'raw'
                                            ],
                                            [
                                                'attribute' => 'tax',
                                                'value'     => $this->getPriceWithSymbol($model['tax'], $model['currency_symbol']),
                                                'format'    => 'raw'
                                            ],
                                            'payment_type',
                                            'comments'
                                        ]
                    ];
echo DetailView::widget($widgetParams);