<?php
use usni\library\widgets\DetailView;
use usni\UsniAdaptor;
use common\modules\order\utils\OrderUtil;

/* @var $detailViewDTO \common\modules\order\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            [
                                                'label'      => UsniAdaptor::t('users', 'Address'),
                                                'value'      => OrderUtil::getConcatenatedAddress($model['billingAddress']),
                                                'format'     => 'raw'
                                            ]
                                        ]
                    ];
echo DetailView::widget($widgetParams);