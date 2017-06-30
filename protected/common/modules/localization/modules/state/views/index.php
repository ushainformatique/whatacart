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
use common\modules\localization\modules\state\models\State;
use common\modules\localization\grid\LocalizationNameDataColumn;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;

/* @var $gridViewDTO \common\modules\localization\modules\state\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title                  = UsniAdaptor::t('state', 'Manage States');
$this->title            = $this->params['breadcrumbs'][] = $title;
$countryDropdownData    = $gridViewDTO->getCountryDropdownData();

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => true,
    'showBulkDelete'=> true,
    'gridId'        => 'stategridview',
    'pjaxId'        => 'stategridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('state', 'State') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => '/localization/state/default/bulk-edit',
    'bulkEditFormId'    => 'statebulkeditview',
    'permissionPrefix'  => 'state'
];
$widgetParams   = [
                        'id'            => 'stategridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => State::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'attribute'     => 'country_id',
                                'value'         => 'country',
                                'filter'        => $countryDropdownData
                            ],
                            [
                                'attribute'         => 'name',
                                'class'             => LocalizationNameDataColumn::className(),
                                'modelClassName'    => 'State'
                            ],
                            'code',
                            [
                                'attribute' => 'status',
                                'class'     => StatusDataColumn::className(),
                                'filter'    => StatusUtil::getDropdown()
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => State::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);