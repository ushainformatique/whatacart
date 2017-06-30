<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use yii\grid\CheckboxColumn;
use products\grid\ReviewStatusDataColumn;
use products\grid\ProductReviewActionColumn;
use products\models\ProductReview;
use usni\library\grid\ActionToolbar;

/* @var $gridViewDTO \products\dto\ProductReviewGridViewDTO */
/* @var $this \usni\library\web\AdminView */
$title  = UsniAdaptor::t('products', 'Manage Trash Reviews');
$this->params['breadcrumbs'] = [
                                    [
                                        'label' => UsniAdaptor::t('products', 'Manage Reviews'),
                                        'url'   => ['/catalog/products/review/index']
                                    ],
                                    [
                                        'label' => $title,
                                    ]
                               ];
$this->title    = $title;

$toolbarParams  = [
    'bulkDeleteUrl' => 'trash-bulk-delete',
    'showBulkEdit'  => false,
    'showBulkDelete'=> true,
    'showCreate'    => false,
    'gridId'        => 'productreviewtrashgridview',
    'pjaxId'        => 'productreviewtrashgridview-pjax',
    'permissionPrefix'  => 'productreview',
    'bulkDeletePermission' => 'productreview.delete'
];
$widgetParams   = [
                        'id'            => 'productreviewtrashgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => ProductReview::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            'review',
                            [
                                    'label'     => UsniAdaptor::t('products', 'Product'),
                                    'attribute' => 'product_id',
                                    'value'     => 'product_name',
                            ],
                            [
                                   'attribute'  => 'status',
                                   'class'      => ReviewStatusDataColumn::className(),
                            ],
                            [
                                'class'             => ProductReviewActionColumn::className(),
                                'template'          => '{deletetrash}, {undo}',
                                'modelClassName'    => ProductReview::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);