<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use products\models\ProductDownload;
use products\utils\DownloadUtil;
use usni\library\grid\FormattedDateTimeColumn;
use products\grid\MyDownloadsActionColumn;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */

$title              = UsniAdaptor::t('customer', 'My Downloads');
$this->title        = $title;
$this->leftnavView  = '/front/_sidebar';
$this->params['breadcrumbs'] = [    
                                    [
                                        'label' => UsniAdaptor::t('customer', 'My Account'),
                                        'url'   => ['/customer/site/my-account']
                                    ],
                                    [
                                        'label' => $title
                                    ]
                               ];

$widgetParams   = [
                        'id'            => 'mydownloadgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => ProductDownload::className(),
                        'columns' => [
                            'name',
                            'file',
                            [
                                'attribute'     => 'type',
                                'filter'        => DownloadUtil::getDownloadTypes()
                            ],
                            [
                                'label'     => UsniAdaptor::t('products', 'Size(in bytes)'),
                                'attribute' => 'size',
                            ],
                            [
                                'label'     => UsniAdaptor::t('products', 'Date Added'),
                                'attribute' => 'created_datetime',
                                'class'     => FormattedDateTimeColumn::className(),
                                'filter'    => false
                            ],
                            [
                                'class' => MyDownloadsActionColumn::className(),
                                'template' => '{download}',
                                'modelClassName' => ProductDownload::className()
                            ]
                        ],
                ];
echo GridView::widget($widgetParams);