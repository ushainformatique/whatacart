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
use products\models\ProductAttributeGroup;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('products', 'Manage Attribute Groups');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => false,
    'showBulkDelete'=> true,
    'gridId'        => 'productattributegroupgridview',
    'pjaxId'        => 'productattributegroupgridview-pjax',
    'permissionPrefix'  => 'product'
];
$widgetParams   = [
                        'id'            => 'productattributegroupgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => ProductAttributeGroup::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            [
                                'class'             => ActionColumn::className(),
                                'template'          => '{view} {update} {delete}',
                                'modelClassName'    => ProductAttributeGroup::className(),
                                'permissionPrefix'  => 'product'
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);