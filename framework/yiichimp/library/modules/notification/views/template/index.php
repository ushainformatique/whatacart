<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use yii\grid\CheckboxColumn;
use usni\library\modules\notification\utils\NotificationUtil;
use usni\library\modules\notification\models\NotificationTemplate;
use yii\bootstrap\Modal;
use usni\library\modules\notification\utils\NotificationScriptUtil;
use usni\library\modules\notification\grid\PreviewActionColumn;

/* @var $gridViewDTO \usni\library\modules\notification\dto\TemplateGridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('notification', 'Manage Templates');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'         => 'create',
    'bulkDeleteUrl'     => 'bulk-delete',
    'showBulkEdit'      => false,
    'showBulkDelete'    => true,
    'gridId'            => 'templategridview',
    'pjaxId'            => 'templategridview-pjax',
    'permissionPrefix'  => 'notificationtemplate'
];
$widgetParams   = [
                        'id'            => 'templategridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => NotificationTemplate::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            [
                                'attribute' => 'notifykey'
                            ],
                            [
                                'attribute' => 'type',
                                'filter'    => NotificationUtil::getTypes()
                            ],
                            'subject',
                            [
                                'label'     => UsniAdaptor::t('notification',  'Layout'),
                                'attribute' => 'layout_id',
                                'value'     => 'layout',
                                'filter'    => $gridViewDTO->getLayoutOptions()
                            ],
                            [
                                'class'     => PreviewActionColumn::className(),
                                'template'  => '{view} {update} {delete} {preview}',
                                'modelClassName' => NotificationTemplate::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);

Modal::begin(['id' => 'gridPreviewModal', 'size' => Modal::SIZE_LARGE,
              'header' => UsniAdaptor::t('notification', 'Template Preview')]);
echo '';
Modal::end();

$url = UsniAdaptor::createUrl('/notification/template/grid-preview');
NotificationScriptUtil::registerGridPreviewScript($url, 'templategridview', $this);