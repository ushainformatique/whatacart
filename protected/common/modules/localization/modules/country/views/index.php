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
use common\modules\localization\modules\country\models\Country;
use common\modules\localization\grid\LocalizationNameDataColumn;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('country', 'Manage Countries');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => false,
    'showBulkDelete'=> true,
    'gridId'        => 'countrygridview',
    'pjaxId'        => 'countrygridview-pjax',
    'permissionPrefix'  => 'country'
];
$widgetParams   = [
                        'id'            => 'countrygridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Country::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'attribute'         => 'name',
                                'class'             => LocalizationNameDataColumn::className(),
                                'modelClassName'    => 'Country'
                            ],
                            'iso_code_2',
                            'iso_code_3',
                            [
                                'attribute'     => 'status',
                                'class'         => StatusDataColumn::className(),
                                'filter'        => StatusUtil::getDropdown(),
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => Country::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);