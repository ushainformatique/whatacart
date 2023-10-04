<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\library\widgets\StatusLabel;
use usni\UsniAdaptor;
use usni\library\widgets\DetailView;
use usni\library\modules\auth\widgets\DetailBrowseDropdown;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('auth', 'Group') . ' #' . $model['id'];
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('auth', 'Groups'),
                                        'url' => ['/auth/group/index']
                                    ],
                                    [
                                        'label' => $this->title
                                    ]
                                ];
$editUrl        = UsniAdaptor::createUrl('auth/group/update', ['id' => $model['id']]);
$deleteUrl      = UsniAdaptor::createUrl('auth/group/delete', ['id' => $model['id']]);
$browseParams   = [
                    'permission' => 'group.viewother',
                    'model' => $model,
                    'data'  => $detailViewDTO->getBrowseModels(),
                    'modalDisplay' => $detailViewDTO->getModalDisplay()];
$toolbarParams  = ['editUrl'   => $editUrl,
                   'deleteUrl' => $deleteUrl];
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'caption'       => $model['name'],
                    'attributes'    => [
                                            [
                                                'attribute' => 'status', 
                                                'value' => StatusLabel::widget(['model' => $model]), 
                                                'format' => 'raw'
                                            ],
                                            [
                                                'attribute' => 'parent_id', 
                                                'value' => $model['parent_name']
                                            ],
                                            [
                                                'attribute'  => 'member', 
                                                'value'      => $model['members']
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