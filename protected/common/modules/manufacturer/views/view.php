<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\library\widgets\StatusLabel;
use usni\UsniAdaptor;
use usni\library\widgets\DetailView;
use usni\library\utils\FileUploadUtil;
use usni\library\widgets\DetailBrowseDropdown;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('manufacturer', 'Manufacturer') . ' #' . $model['id'];
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('manufacturer', 'Manufacturers'),
                                        'url' => ['/manufacturer/default/index']
                                    ],
                                    [
                                        'label' => $this->title
                                    ]
                                ];
$editUrl        = UsniAdaptor::createUrl('manufacturer/default/update', ['id' => $model['id']]);
$deleteUrl      = UsniAdaptor::createUrl('manufacturer/default/delete', ['id' => $model['id']]);
$thumbnailImage = FileUploadUtil::getThumbnailImage($model, 'image');
$browseParams   = ['permission' => 'manufacturer.viewother',
                   'model' => $model,
                   'data'  => $detailViewDTO->getBrowseModels(),
                   'modalDisplay' => $detailViewDTO->getModalDisplay()];
$toolbarParams  = ['editUrl'   => $editUrl,
                   'deleteUrl' => $deleteUrl];
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'caption'       => $model['name'],
                    'attributes'    => [
                                            'name',
                                            [
                                                'attribute'  => 'image', 
                                                'value'      => $thumbnailImage,
                                                'format'     => 'raw'
                                            ],
                                            [
                                                'attribute' => 'status',
                                                'value'     => StatusLabel::widget(['model' => $model]),
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
echo DetailBrowseDropdown::widget($browseParams);
echo DetailView::widget($widgetParams);
