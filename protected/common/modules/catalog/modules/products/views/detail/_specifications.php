<?php
use usni\library\widgets\DetailView;
/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            'model',
                                            'sku',
                                            [
                                                'attribute'  => 'price',
                                                'value'      => $this->getFormattedPrice($model['price'])
                                            ],
                                            'quantity'
                                        ]
                    ];
echo DetailView::widget($widgetParams);

