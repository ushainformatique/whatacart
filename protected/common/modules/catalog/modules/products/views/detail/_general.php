<?php
use usni\library\widgets\DetailView;
use usni\UsniAdaptor;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            'name',
                                            'alias',
                                            [
                                                'attribute'   => 'description',
                                                'format'      => 'raw'
                                            ],
                                            [
                                                'label'     => UsniAdaptor::t('products', 'Tax Class'),
                                                'attribute' => 'tax_class_id',
                                                'value'     => $model['taxClassName']
                                            ],
                                            'metakeywords',
                                            'metadescription',
                                            [
                                                'label' => UsniAdaptor::t('products', 'Product Tags'),
                                                'value' => $model['tagNames']
                                            ]
                                        ]
                    ];
echo DetailView::widget($widgetParams);

