<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use usni\library\modules\notification\utils\NotificationUtil;
use usni\library\modules\notification\models\Notification;
use usni\library\modules\notification\grid\NotificationStatusDataColumn;
use usni\library\modules\notification\grid\EmailPriorityDataColumn;
use usni\library\modules\notification\behaviors\NotificationBehavior;
use usni\library\grid\ActionColumn;

/* @var $gridViewDTO \usni\library\modules\notification\dto\TemplateGridViewDTO */
/* @var $this \usni\library\web\AdminView */

$this->attachBehavior('notification', ['class' => NotificationBehavior::className()]);
$title          = UsniAdaptor::t('notification', 'Manage Notifications');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'showCreate'        => false,
    'showBulkEdit'      => false,
    'showBulkDelete'    => false,
    'gridId'            => 'notificationgridview',
    'pjaxId'            => 'notificationgridview-pjax',
    'showPerPageOption' => false,
    'showModalDetail'   => false,
    'layout'            => "<div class='block'>
                                <div class='toolbar-content'>
                                    {bulkeditform}
                                </div>
                           </div>"
];
$widgetParams   = [
                        'id'            => 'notificationgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Notification::className(),
                        'columns' => [
                            [
                                'attribute' => 'type',
                                'value'     => [$this, 'getTypeDisplayLabel'],
                            ],
                            'modulename',
                            [
                                'attribute' => 'status',
                                'class'     => NotificationStatusDataColumn::className(),
                                'filter'    => NotificationUtil::getStatusListData()
                            ],
                            [
                                'attribute' => 'priority',
                                'class'     => EmailPriorityDataColumn::className(),
                                'filter'    => NotificationUtil::getPriorityListData()
                            ],
                            [
                                'attribute' => 'senddatetime',
                                'value'     => [$this, 'getSendDateTime']
                            ],
                            [
                                'label'     => UsniAdaptor::t('application', 'Message'),
                                'attribute' => 'data',
                                'value'     => [$this, 'getNotificationMessage'],
                                'format'    => 'raw'
                            ],
                            [
                                'class'             => ActionColumn::className(),
                                'template'          => '{delete}',
                                'modelClassName'    => Notification::className(),
                                'permissionPrefix'  => 'notification'
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);