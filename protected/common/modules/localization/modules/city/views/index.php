<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use yii\grid\CheckboxColumn;
use common\modules\localization\modules\city\models\City;
use usni\library\grid\ActionColumn;

/* @var $gridViewDTO \common\modules\localization\modules\city\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('city', 'Manage Cities');
$this->title    = $this->params['breadcrumbs'][] = $title;
$dropdownData   = $gridViewDTO->getCountryDropdownData();
$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => false,
    'showBulkDelete'=> true,
    'gridId'        => 'citygridview',
    'pjaxId'        => 'citygridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('city', 'City') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => 'bulk-edit',
    'bulkEditFormId'    => 'citybulkeditview',
    'permissionPrefix'  => 'city'
];
$widgetParams   = [
                        'id'            => 'citygridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => City::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            [
                                'attribute' => 'country_id',
                                'value'     => 'country_name',
                                'filter'    =>  $dropdownData,
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => City::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);