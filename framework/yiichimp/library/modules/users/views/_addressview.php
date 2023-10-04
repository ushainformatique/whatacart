<?php
use usni\library\widgets\DetailView;
use usni\library\utils\CountryUtil;
use usni\library\widgets\StatusLabel;

$model          = $detailViewDTO->getAddress();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            'address1',
                                            'address2',
                                            'city',
                                            'state',
                                            [
                                               'attribute'  => 'country',
                                               'value'      => CountryUtil::getCountryName($model['country'])
                                            ],
                                            'postal_code',
                                            [
                                                'attribute' => 'status',   
                                                'value'     => StatusLabel::widget(['model' => $model]), 
                                                'format'    => 'html'
                                            ],
                                       ]
                  ];
echo DetailView::widget($widgetParams);