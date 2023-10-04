<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use yii\grid\CheckboxColumn;
use usni\library\modules\notification\grid\NotificationLayoutNameDataColumn;
use usni\library\grid\ActionColumn;
use usni\library\modules\notification\models\NotificationLayout;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('notification', 'Manage Layouts');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'         => 'create',
    'bulkDeleteUrl'     => 'bulk-delete',
    'showBulkEdit'      => false,
    'showBulkDelete'    => true,
    'gridId'            => 'layoutgridview',
    'pjaxId'            => 'layoutgridview-pjax',
    'permissionPrefix'  => 'notificationlayout'
];
$widgetParams   = [
                        'id'            => 'layoutgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => NotificationLayout::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'attribute' => 'name',
                                'class'     => NotificationLayoutNameDataColumn::className()
                            ],
                            [
                                'class'     => ActionColumn::className(),
                                'template'  => '{view} {update} {delete}',
                                'modelClassName' => NotificationLayout::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);