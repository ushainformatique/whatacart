<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use yii\grid\CheckboxColumn;
use common\modules\extension\models\Extension;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;
use common\modules\extension\widgets\ExtensionActionToolbar;
use common\modules\extension\grid\ModuleActionColumn;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$this->title    = $this->params['breadcrumbs'][] = UsniAdaptor::t('application', 'Manage Modules');

$toolbarParams  = [
    'gridId' => 'modulegridview',
    'pjaxId' => 'modulegridview-pjax',
    'permissionPrefix'  => 'extension',
    'showCreate' => false
];
$widgetParams   = [
                        'id'            => 'modulegridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => UsniAdaptor::t('payment', 'Manage Modules'),
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
                                'class'             => ModuleActionColumn::className(),
                                'template'          => '{settings} {changestatus}',
                                'modelClassName'    => Extension::className()
                            ]
                        ],
                ];
echo ExtensionActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);