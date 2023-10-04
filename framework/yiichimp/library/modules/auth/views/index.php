<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use yii\grid\CheckboxColumn;
use usni\library\grid\StatusDataColumn;
use usni\library\modules\auth\grid\AuthNameDataColumn;
use usni\library\modules\auth\grid\AuthActionColumn;
use usni\library\modules\auth\models\Group;
use usni\library\utils\StatusUtil;

/* @var $gridViewDTO \usni\library\modules\auth\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('auth', 'Manage Groups');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => true,
    'showBulkDelete'=> true,
    'gridId'        => 'groupgridview',
    'pjaxId'        => 'groupgridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('auth', 'Group') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => 'bulk-edit',
    'bulkEditFormId'    => 'groupbulkeditview',
    'permissionPrefix'  => 'group'
];
$widgetParams   = [
                        'id'            => 'groupgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Group::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'attribute' => 'name',
                                'class'     => AuthNameDataColumn::className()
                            ],
                            [
                                'attribute' => 'status',
                                'class'     => StatusDataColumn::className(),
                                'filter'    => StatusUtil::getDropdown()
                            ],
                            [
                                'attribute' => 'level',
                                'filter'    => $gridViewDTO->getLevelFilterData(),
                                'headerOptions' => ['class' => 'sort-numerical']
                            ],
                            [
                                'class'     => AuthActionColumn::className(),
                                'template'  => '{view} {update} {delete} {managepermissions}',
                                'modelClassName' => Group::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);