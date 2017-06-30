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
use products\models\ProductOption;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('products', 'Manage Options');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => false,
    'showBulkDelete'=> true,
    'gridId'        => 'productoptiongridview',
    'pjaxId'        => 'productoptiongridview-pjax',
    'permissionPrefix'  => 'product'
];
$widgetParams   = [
                        'id'            => 'productoptiongridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => ProductOption::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            'display_name',
                            [
                                'class'             => ActionColumn::className(),
                                'template'          => '{view} {update} {delete}',
                                'modelClassName'    => ProductOption::className(),
                                'permissionPrefix'  => 'product'
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);