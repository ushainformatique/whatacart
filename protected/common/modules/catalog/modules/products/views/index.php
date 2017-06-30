<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use yii\grid\CheckboxColumn;
use products\models\Product;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;
use backend\grid\FormattedPriceColumn;
use products\grid\ProductActionColumn;

/* @var $gridViewDTO \products\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('products', 'Manage Products');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => true,
    'showBulkDelete'=> true,
    'gridId'        => 'productgridview',
    'pjaxId'        => 'productgridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('products', 'Product') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => 'bulk-edit',
    'bulkEditFormId'    => 'productbulkeditview',
    'permissionPrefix'  => 'product',
];
$widgetParams   = [
                        'id'            => 'productgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Product::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'attribute' => 'image',
                                'value'     => ['products\utils\ProductUtil', 'getThumbnailImage'],
                                'format'    => 'raw',
                                'filter'    => false,
                                'enableSorting' => false
                            ],
                            'name',
                            'model',
                            'quantity',
                            [
                                'attribute'  => 'price',
                                'class'      => FormattedPriceColumn::className()
                            ],
                            [
                                'attribute' => 'status',
                                'class' => StatusDataColumn::className(),
                                'filter' => StatusUtil::getDropdown()
                            ],
                            [
                                'class' => ProductActionColumn::className(),
                                'template' => '{view} {update} {delete} {attributes} {options}',
                                'modelClassName' => Product::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);