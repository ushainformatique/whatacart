<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use common\modules\manufacturer\models\Manufacturer;
use yii\grid\CheckboxColumn;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;
use usni\library\grid\ActionColumn;
use common\modules\localization\modules\currency\models\Currency;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('currency', 'Manage Currencies');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => true,
    'showBulkDelete'=> true,
    'gridId'        => 'currencygridview',
    'pjaxId'        => 'currencygridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('currency', 'Currency') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => 'bulk-edit',
    'bulkEditFormId'    => 'currencybulkeditview',
    'permissionPrefix'  => 'currency'
];
$widgetParams   = [
                        'id'            => 'currencygridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Currency::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            'code',
                            'value',
                            [
                                'attribute' => 'status',
                                'class' => StatusDataColumn::className(),
                                'filter' => StatusUtil::getDropdown()
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => Currency::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);