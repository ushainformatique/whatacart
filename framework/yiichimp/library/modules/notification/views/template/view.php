<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\widgets\DetailView;
use usni\library\widgets\DetailBrowseDropdown;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('notification', 'Template') . ' #' . $model['id'];
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                                    UsniAdaptor::t('notification', 'Templates'),
                                        'url' => ['/notification/template/index']
                                    ],
                                    [
                                        'label' => $this->title
                                    ]
                                ];
$editUrl        = UsniAdaptor::createUrl('notification/template/update', ['id' => $model['id']]);
$deleteUrl      = UsniAdaptor::createUrl('notification/template/delete', ['id' => $model['id']]);
$browseParams   = [
                    'permission' => 'notificationtemplate.viewother',
                    'model' => $model,
                    'data'  => $detailViewDTO->getBrowseModels(),
                    'textAttribute' => 'notifykey',
                    'modalDisplay' => $detailViewDTO->getModalDisplay()];
$toolbarParams  = ['editUrl'   => $editUrl,
                   'deleteUrl' => $deleteUrl];
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'caption'       => $model['notifykey'],
                    'attributes'    => [
                                            'type',
                                            'notifykey',
                                            'subject',
                                            [
                                              'attribute'   => 'content', 'format' => 'raw'  
                                            ],
                                            [
                                                'label'     => UsniAdaptor::t('notification', 'Notification Layout'),
                                                'attribute' => 'notification_layout'
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
echo DetailBrowseDropdown::widget($browseParams);
echo DetailView::widget($widgetParams);