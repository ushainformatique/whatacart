<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\library\widgets\StatusLabel;
use usni\UsniAdaptor;
use usni\library\widgets\DetailView;
use usni\library\widgets\DetailBrowseDropdown;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('customer', 'Customer Group') . ' #' . $model['id'];
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('customer', 'Customer Group'),
                                        'url' => ['/customer/group/index']
                                    ],
                                    [
                                        'label' => $this->title
                                    ]
                                ];
$editUrl        = UsniAdaptor::createUrl('customer/group/update', ['id' => $model['id']]);
$deleteUrl      = UsniAdaptor::createUrl('customer/group/delete', ['id' => $model['id']]);
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
                                            ]
                                       ],
                    
                    'actionToolbar' => $toolbarParams
                 ];
echo DetailBrowseDropdown::widget($browseParams);
echo DetailView::widget($widgetParams);