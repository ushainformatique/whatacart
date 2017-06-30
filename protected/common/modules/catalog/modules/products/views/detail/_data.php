<?php
use usni\library\widgets\DetailView;
use usni\UsniAdaptor;
use usni\library\utils\FileUploadUtil;
use usni\library\utils\DateTimeUtil;
use usni\library\widgets\StatusLabel;
use products\models\Product;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            [
                                                'attribute'  => 'image',
                                                'value'      => FileUploadUtil::getThumbnailImage($model, 'image'),
                                                'format'     => 'raw'
                                            ],
                                            'minimum_quantity',
                                            'location',
                                            [
                                                'attribute' => 'date_available',
                                                'value'     => DateTimeUtil::getFormattedDate($model['date_available'])
                                            ],
                                            'length',
                                            'width',
                                            'height',
                                            'weight',
                                            [
                                                'attribute' => 'status', 
                                                'value'     => StatusLabel::widget(['model' => $model]), 
                                                'format'    => 'raw'
                                            ],
                                            [
                                                'attribute' => 'tax_class_id', 
                                                'value'     => $model['taxClassName']
                                            ],
                                            [
                                                'attribute' => 'stock_status',
                                                'value'     => $model['stock_status'] == Product::IN_STOCK ? UsniAdaptor::t('products', 'In Stock') : UsniAdaptor::t('products', 'Out of Stock')
                                            ],
                                            [
                                                'attribute' => 'subtract_stock',
                                                'value'     => $model['subtract_stock'] == 1 ? UsniAdaptor::t('application', 'Yes') : UsniAdaptor::t('application', 'No'),

                                            ],
                                            [
                                                'attribute' => 'requires_shipping',
                                                'value'     => $model['requires_shipping'] == 1 ? UsniAdaptor::t('application', 'Yes') : UsniAdaptor::t('application', 'No'),

                                            ],
                                            [
                                                'attribute' => 'length_class',
                                                'value'     => $model['lengthClass'],

                                            ],
                                            [
                                                'attribute' => 'weight_class',
                                                'value'     => $model['weightClass'],   
                                            ],
                                            [
                                                'attribute' => 'is_featured',
                                                'value'     => $model['is_featured'] == 1 ? UsniAdaptor::t('application', 'Yes') : UsniAdaptor::t('application', 'No')
                                            ]
                                        ]
                    ];
echo DetailView::widget($widgetParams);

