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
use usni\library\utils\StatusUtil;
use usni\library\grid\ActionColumn;
use common\modules\dataCategories\models\DataCategory;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('dataCategories', 'Manage Data Categories');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkDelete'=> true,
    'gridId'        => 'datacategorygridview',
    'pjaxId'        => 'datacategorygridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('dataCategories', 'Data Category') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => 'bulk-edit',
    'permissionPrefix'  => 'datacategory'
];
$widgetParams   = [
                        'id'            => 'datacategorygridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => DataCategory::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            [
                                'attribute' => 'status',
                                'class' => StatusDataColumn::className(),
                                'filter' => StatusUtil::getDropdown()
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => DataCategory::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);