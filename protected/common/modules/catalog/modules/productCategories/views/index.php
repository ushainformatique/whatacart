<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use yii\grid\CheckboxColumn;
use usni\library\grid\ActionColumn;
use productCategories\models\ProductCategory;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;
use productCategories\grid\ProductCategoryNameDataColumn;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('productCategories', 'Manage Product Categories');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => true,
    'showBulkDelete'=> true,
    'gridId'        => 'productcategorygridview',
    'pjaxId'        => 'productcategorygridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('productCategories', 'Product Category') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => 'bulk-edit',
    'bulkEditFormId'    => 'productcategorybulkeditview',
    'permissionPrefix'  => 'productcategory',
];
$widgetParams   = [
                        'id'            => 'productcategorygridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => ProductCategory::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'attribute' => 'image',
                                'value'     => ['productCategories\utils\ProductCategoryUtil', 'getThumbnailImage'],
                                'format'    => 'raw',
                                'filter'    => false,
                                'enableSorting' => false
                            ],
                            [
                                'attribute' => 'name',
                                'class'     => ProductCategoryNameDataColumn::className()
                            ],
                            [
                                'attribute' => 'status',
                                'class' => StatusDataColumn::className(),
                                'filter' => StatusUtil::getDropdown()
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => ProductCategory::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);