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
use common\modules\enhancement\grid\EnhancementActionColumn;
use usni\library\grid\ActionToolbar;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('enhancement', 'Enhancements');
$this->title    = $this->params['breadcrumbs'][] = UsniAdaptor::t('application', 'Manage') . ' ' . $title;

$toolbarParams  = [
    'gridId' => 'enhancementgridview',
    'pjaxId' => 'enhancementgridview-pjax',
    'permissionPrefix'  => 'extension',
    'showCreate' => false
];
$widgetParams   = [
                        'id'            => 'enhancementgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => UsniAdaptor::t('payment', 'Manage Enhancements'),
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
                                'class'             => EnhancementActionColumn::className(),
                                'template'          => '{settings} {changestatus}',
                                'modelClassName'    => Extension::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);