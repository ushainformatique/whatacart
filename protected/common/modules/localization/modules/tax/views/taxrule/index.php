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
use taxes\models\TaxRule;
use taxes\utils\TaxUtil;

/* @var $gridViewDTO \taxes\dto\TaxRuleGridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title              = UsniAdaptor::t('tax', 'Manage Tax Rules');
$this->title        = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/taxrule/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => true,
    'showBulkDelete'=> true,
    'gridId'        => 'taxrulegridview',
    'pjaxId'        => 'taxrulegridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('tax', 'Tax Rule') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => '/localization/tax/rule/bulk-edit',
    'bulkEditFormId'    => 'taxrulebulkeditview',
    'permissionPrefix'  => 'taxrule'
];
$widgetParams   = [
                        'id'            => 'taxrulegridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => TaxRule::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            [
                                'attribute' => 'based_on', 
                                'value'     => 'based_on_value',
                                'filter'    => TaxUtil::getBasedOnDropdown()
                            ],
                            [
                                'label'     => UsniAdaptor::t('customer', 'Customer Groups'),
                                'attribute' => 'customer_group_id',
                                'value'     => 'customer_group',
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => TaxRule::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);