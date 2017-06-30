<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use yii\grid\CheckboxColumn;
use common\modules\extension\models\Extension;
use common\modules\payment\grid\PaymentActionColumn;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;
use common\modules\payment\grid\PaymentActionToolbar;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('payment', 'Manage Payments');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'gridId' => 'paymentgridview',
    'pjaxId' => 'paymentgridview-pjax',
    'permissionPrefix'  => 'extension',
    'showCreate' => false
];
$widgetParams   = [
                        'id'            => 'paymentgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => UsniAdaptor::t('payment', 'Manage Payments'),
                        'modelClass'    => Extension::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'name',
                            'code',
                            'author',
                            'version',
                            'product_version',
                            [
                                'attribute' => 'status',
                                'class' => StatusDataColumn::className(),
                                'filter' => StatusUtil::getDropdown()
                            ],
                            [
                                'class'             => PaymentActionColumn::className(),
                                'template'          => '{settings} {changestatus}',
                                'modelClassName'    => Extension::className()
                            ]
                        ],
                ];
echo PaymentActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);