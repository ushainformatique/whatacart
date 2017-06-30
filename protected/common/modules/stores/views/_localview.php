<?php
use usni\library\widgets\DetailView;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            ['attribute' => 'country', 'value' => $model['country']],
                                            ['attribute' => 'currency', 'value' => $model['currency']],
                                            ['attribute' => 'language', 'value' => $model['language']],
                                            ['attribute' => 'length_class', 'value' => $model['lengthClass']],
                                            'state',
                                            'timezone',
                                            ['attribute' => 'weight_class', 'value' => $model['weightClass']]
                                       ]
                  ];
echo DetailView::widget($widgetParams);