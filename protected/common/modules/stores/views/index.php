<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;
use common\modules\stores\models\Store;
use common\modules\stores\grid\StoreActionColumn;

/* @var $gridViewDTO \usni\library\modules\auth\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('stores', 'Manage Stores');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'gridId'        => 'storegridview',
    'pjaxId'        => 'storegridview-pjax'
];
$widgetParams   = [
                        'id'            => 'storegridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Store::className(),
                        'columns' => [
                            [
                                'attribute' => 'name'
                            ],
                            [
                                'attribute' => 'status',
                                'class'     => StatusDataColumn::className(),
                                'filter'    => StatusUtil::getDropdown()
                            ],
                            [
                                'class'         => StoreActionColumn::className(),
                                'template'      => '{view} {update} {delete} {activate} {default}'
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);