<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
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

$title          = UsniAdaptor::t('customer', 'Manage Customer Groups');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/groups/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => true,
    'showBulkDelete'=> true,
    'gridId'        => 'customergroupgridview',
    'pjaxId'        => 'customergroupgridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('customer', 'Customer Group') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => 'bulk-edit',
    'bulkEditFormId'    => 'customergroupbulkeditview',
    'permissionPrefix'  => 'group'
];
$widgetParams   = [
                        'id'            => 'customergroupgridview',
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
                                'template'  => '{view} {update} {delete}',
                                'modelClassName' => Group::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);