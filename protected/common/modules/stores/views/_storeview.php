<?php
use usni\library\widgets\DetailView;
use usni\library\widgets\StatusLabel;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            'name',
                                            [
                                                'attribute' => 'status', 'value' => StatusLabel::widget(['model' => $model]), 'format' => 'raw'
                                            ],
                                            'fullName',
                                            'metakeywords',
                                            'metadescription',
                                            'dataCategory',
                                            [
                                                'attribute' => 'description',
                                                'format'    => 'raw'
                                            ],
                                            'theme'
                                       ]
                  ];
echo DetailView::widget($widgetParams);