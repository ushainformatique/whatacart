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
use products\utils\ProductScriptUtil;
use usni\library\utils\BulkScriptUtil;
use products\grid\ProductReviewActionToolbar;
use products\utils\ReviewUtil;

/* @var $gridViewDTO \products\dto\ProductReviewGridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('products', 'Manage Reviews');
$this->title    = $this->params['breadcrumbs'][] = $title;
$dropdownData   = $gridViewDTO->getProductDropDownData();

$toolbarParams  = [
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => false,
    'showBulkDelete'=> true,
    'showCreate'    => false,
    'gridId'        => 'productreviewgridview',
    'pjaxId'        => 'productreviewgridview-pjax',
    'permissionPrefix'  => 'productreview',
    'bulkDeletePermission' => 'productreview.delete'
];
$widgetParams   = [
                        'id'            => 'productreviewgridview',
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
                                    'filter'    => $dropdownData
                            ],
                            [
                                   'attribute'  => 'status',
                                   'class'      => ReviewStatusDataColumn::className(),
                                   'filter'     => ReviewUtil::getStatusDropdown()
                            ],
                            [
                                'class'             => ProductReviewActionColumn::className(),
                                'template'          => '{approve} {spam} {delete}',
                                'modelClassName'    => ProductReview::className()
                            ]
                        ],
                ];
echo ProductReviewActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);

//Register scripts
$modelClass = ProductReview::className();
$pjaxId     = 'productreviewgridview-pjax';
ProductScriptUtil::registerReviewGridStatusScript('approve', $this, $pjaxId);
ProductScriptUtil::registerReviewGridStatusScript('unapprove', $this, $pjaxId);
ProductScriptUtil::registerReviewGridStatusScript('spam', $this, $pjaxId);
ProductScriptUtil::registerReviewGridStatusScript('remove-spam', $this, $pjaxId);
$approveUrl      = UsniAdaptor::createUrl('/catalog/products/review/bulk-approve');
BulkScriptUtil::registerBulkApproveScript($approveUrl, 'productreviewgridview', 'approve-btn', $this, $pjaxId);
$unapproveUrl  = UsniAdaptor::createUrl('/catalog/products/review/bulk-unapprove');
BulkScriptUtil::registerBulkUnApproveScript($unapproveUrl, 'productreviewgridview', 'unapprove-btn', $this, $pjaxId);