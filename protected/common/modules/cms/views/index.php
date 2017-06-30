<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use common\modules\cms\widgets\ActionToolbar;
use yii\grid\CheckboxColumn;
use common\modules\cms\grid\StatusDataColumn;
use usni\library\grid\ActionColumn;
use common\modules\cms\models\Page;
use common\modules\cms\grid\CmsNameDataColumn;
use common\modules\cms\utils\DropdownUtil;

/* @var $gridViewDTO \common\modules\cms\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('cms', 'Manage Pages');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => true,
    'showBulkDelete'=> true,
    'gridId'        => 'pagegridview',
    'pjaxId'        => 'pagegridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('cms', 'Page') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => 'bulk-edit',
    'bulkEditFormId'    => 'pagebulkeditview',
    'permissionPrefix'  => 'page',
    'parentDropdownOptions' => $gridViewDTO->getParentDropdownOptions()
];
$widgetParams   = [
                        'id'            => 'pagegridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Page::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'attribute' => 'name',
                                'class'     => CmsNameDataColumn::className()
                            ],
                            [
                                'attribute' => 'status',
                                'class' => StatusDataColumn::className(),
                                'filter' => DropdownUtil::getStatusSelectOptions()
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => Page::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);