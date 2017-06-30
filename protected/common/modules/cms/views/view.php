<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\widgets\DetailView;
use usni\library\widgets\DetailBrowseDropdown;
use common\modules\cms\widgets\StatusLabel;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('cms', 'Page') . ' #' . $model['id'];
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('cms', 'Pages'),
                                        'url' => ['/cms/page/index']
                                    ],
                                    [
                                        'label' => $this->title
                                    ]
                                ];
$editUrl        = UsniAdaptor::createUrl('cms/page/update', ['id' => $model['id']]);
$deleteUrl      = UsniAdaptor::createUrl('cms/page/delete', ['id' => $model['id']]);

$browseParams   = [
                    'permission' => 'page.viewother',
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
                                            'menuitem',
                                            'parent',
                                            'alias',
                                            [
                                                'attribute' => 'summary', 
                                                'format'    => 'raw', 
                                            ],
                                            [
                                                'attribute' => 'content', 
                                                'format'    => 'raw', 
                                            ],
                                            [
                                                'attribute' => 'status',
                                                'value'     => StatusLabel::widget(['model' => $model]),
                                                'format'    => 'html'
                                            ],
                                            'metakeywords',
                                            'metadescription',
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
                                            ],
                                       ],
                    
                    'actionToolbar' => $toolbarParams
                 ];
echo DetailBrowseDropdown::widget($browseParams);
echo DetailView::widget($widgetParams);