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
use taxes\grid\TaxNameDataColumn;
use taxes\models\Zone;

/* @var $gridViewDTO \taxes\dto\ZoneGridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('tax', 'Manage Zones');
$this->title    = $this->params['breadcrumbs'][] = $title;
$countryData    = $gridViewDTO->getCountryDropdownData();
$stateData      = $gridViewDTO->getStateDropdownData();
$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => false,
    'showBulkDelete'=> true,
    'gridId'        => 'zonegridview',
    'pjaxId'        => 'zonegridview-pjax',
    'permissionPrefix'  => 'zone'
];
$widgetParams   = [
                        'id'            => 'zonegridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Zone::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'attribute'         => 'name',
                                'class'             => TaxNameDataColumn::className(),
                                'modelClassName'    => 'Zone'
                            ],
                            [
                                'attribute' => 'country_id',
                                'value'     => 'country',
                                'filter'    => $countryData
                            ],
                            [
                                'attribute' => 'state_id',
                                'value'     => 'state',
                                'filter'    => $stateData
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => Zone::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);