<?php
use usni\library\widgets\DetailView;
use usni\library\utils\DateTimeUtil;
use usni\library\widgets\StatusLabel;

/* @var $detailViewDTO \customer\dto\CustomerDetailViewDTO */

$model         = $detailViewDTO->getModel();
$widgetParams  = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'attributes'    => [
                                            'username',
                                            'login_ip',
                                            [
                                                'attribute' => 'last_login', 
                                                'value'     => DateTimeUtil::getFormattedDateTime($model['last_login'])
                                            ],
                                            [
                                                'attribute' => 'status',     
                                                'value'     => StatusLabel::widget(['model' => $model]), 
                                                'format'    => 'html'
                                            ],
                                            'timezone',
                                            'groups',
                                            [
                                                'attribute' => 'created_by',
                                                'value'     => $this->getAuthorName($detailViewDTO->getCreatedBy())
                                            ],
                                            [
                                                'attribute' => 'created_datetime',
                                                'value'     => $this->getFormattedDateTime($model['created_datetime'])
                                            ],
                                            [
                                                'attribute' => 'modified_by',
                                                'value'     => $this->getAuthorName($detailViewDTO->getModifiedBy())
                                            ],
                                            [
                                                'attribute' => 'modified_datetime',
                                                'value'     => $this->getFormattedDateTime($model['modified_datetime'])
                                            ]
                                       ]
                 ];
echo DetailView::widget($widgetParams);