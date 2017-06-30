<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\widgets\DetailView;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('newsletter', 'Newsletter');
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('newsletter', 'Newsletters'),
                                        'url' => ['/marketing/newsletter/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'View') . ' ' . ' #' . $model['id']
                                    ]
                                ];
$deleteUrl      = UsniAdaptor::createUrl('marketing/newsletter/default/delete', ['id' => $model['id']]);
$editUrl        = UsniAdaptor::createUrl('marketing/newsletter/default/update', ['id' => $model['id']]);
$toolbarParams  = ['deleteUrl' => $deleteUrl, 'editUrl' => $editUrl];
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'caption'       => null,
                    'attributes'    => [
                                            [
                                                'label'     => UsniAdaptor::t('application', 'From'),
                                                'attribute' => 'storeName',
                                            ],
                                            [
                                                'label'     => UsniAdaptor::t('application', 'To'),
                                                'attribute' => 'to'
                                            ],
                                            'subject',
                                            [
                                                'attribute' => 'content',
                                                'format'    => 'raw'
                                            ],
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
                                       ],
                    
                    'actionToolbar' => $toolbarParams
                 ];
echo DetailView::widget($widgetParams);