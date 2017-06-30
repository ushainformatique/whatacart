<?php
use usni\library\widgets\DetailView;
use usni\UsniAdaptor;
use common\modules\localization\modules\orderstatus\widgets\StatusLabel;

/* @var $detailViewDTO \common\modules\order\dto\DetailViewDTO */
/* @var $this \frontend\web\View */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
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
                                                'label'      => UsniAdaptor::t('stores', 'Store'),
                                                'attribute'  => 'store_id',
                                                'value'      => $model['store_name']
                                            ],
                                            'shipping_comments'
                                        ]
                    ];
echo DetailView::widget($widgetParams);

