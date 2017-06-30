<?php
use usni\library\widgets\DetailView;
use usni\UsniAdaptor;
use products\utils\DownloadUtil;
/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */

$model          = $detailViewDTO->getModel();

$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            [
                                                'attribute' => 'categories',
                                                'value'     => $model['categories']
                                            ],
                                            [
                                                'attribute'  => 'relatedProducts', 
                                                'value'     => $model['relatedProducts']
                                            ],
                                            [
                                                'attribute' => 'manufacturer',
                                                'value'     => $model['manufacturerName']
                                            ],
                                            [
                                                'label'     => UsniAdaptor::t('products', 'Downloads'),
                                                'format'    => 'raw',
                                                'value'     => $model['downloads']
                                            ],
                                        ]
                    ];
echo DetailView::widget($widgetParams);

