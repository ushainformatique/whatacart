<?php
use usni\library\widgets\DetailView;
use common\modules\order\widgets\AdminOrderProductSubView;
use usni\UsniAdaptor;

/* @var $detailViewDTO \common\modules\order\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'template'      => '<tr><td>{value}</td></tr>',
                    'attributes'    => [
                                            [
                                                'label'     => null,
                                                'attribute' => 'orderProductInformation',
                                                'value'     => AdminOrderProductSubView::widget([
                                                                        'language' => UsniAdaptor::app()->languageManager->selectedLanguage,
                                                                        'order'    => $model,
                                                                        'orderProducts' => $detailViewDTO->getOrderProducts()
                                                                    ]),
                                                'format'    => 'raw'
                                            ]
                                        ]
                    ];
echo DetailView::widget($widgetParams);

