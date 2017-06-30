<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\widgets\DetailView;
use usni\library\widgets\DetailBrowseDropdown;
use usni\library\widgets\StatusLabel;
use productCategories\utils\ProductCategoryUtil;
use usni\library\utils\FileUploadUtil;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */
$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('productCategories', 'Product Category') . ' #' . $model['id'];
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('productCategories', 'Product Categories'),
                                        'url' => ['/catalog/productCategories/default/index']
                                    ],
                                    [
                                        'label' => $this->title
                                    ]
                                ];
$editUrl        = UsniAdaptor::createUrl('catalog/productCategories/default/update', ['id' => $model['id']]);
$deleteUrl      = UsniAdaptor::createUrl('catalog/productCategories/default/delete', ['id' => $model['id']]);
$browseParams   = ['permission' => 'productcategory.viewother',
                   'model' => $model,
                   'modalDisplay' => $detailViewDTO->getModalDisplay(),
                   'data'  => $detailViewDTO->getBrowseModels()];
$toolbarParams  = ['editUrl'   => $editUrl,
                   'deleteUrl' => $deleteUrl];
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'caption'       => $model['name'],
                    'attributes'    => [
                                            'name',
                                            'alias',
                                            [
                                                'attribute'  => 'image',
                                                'value'      => FileUploadUtil::getThumbnailImage($model, 'image'),
                                                'format'     => 'raw'
                                            ],
                                            'level',
                                            'parent_name',
                                            [
                                                'attribute'  => 'status', 
                                                'value'      => StatusLabel::widget(['model' => $model]), 
                                                'format'     => 'raw'
                                            ],
                                            [
                                                'label'     => UsniAdaptor::t('productCategories', 'Display in top menu'),
                                                'attribute'  =>  'displayintopmenu',
                                                'value'      => ProductCategoryUtil::getDisplayInTopMenu($model['displayintopmenu'])
                                            ],
                                            'data_category',
                                            [
                                                'label'     => UsniAdaptor::t('application', 'Meta Keywords'),
                                                'attribute' => 'metakeywords',
                                            ],
                                            [
                                                'label'     => UsniAdaptor::t('application', 'Meta Description'),
                                                'attribute' => 'metadescription',
                                            ],
                                            'code',
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
