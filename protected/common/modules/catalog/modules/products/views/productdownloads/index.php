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
use products\models\ProductDownload;
use products\utils\DownloadUtil;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('products', 'Manage Product Downloads');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'showBulkEdit'  => false,
    'showBulkDelete'=> false,
    'gridId'        => 'productdownloadgridview',
    'pjaxId'        => 'productdownloadgridview-pjax',
    'permissionPrefix'  => 'product'
];
$widgetParams   = [
                        'id'            => 'productdownloadgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => ProductDownload::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            'file',
                            [
                                'attribute'     => 'type',
                                'filter'        => DownloadUtil::getDownloadTypes()
                            ],
                            [
                                'class'             => ActionColumn::className(),
                                'template'          => '{view} {update} {delete}',
                                'modelClassName'    => ProductDownload::className(),
                                'permissionPrefix'  => 'product'
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);