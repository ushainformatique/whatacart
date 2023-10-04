<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\modules\users\widgets\UserNameDataColumn;
use usni\library\utils\TimezoneUtil;
use usni\library\modules\users\grid\UserActionColumn;
use yii\grid\CheckboxColumn;
use usni\library\grid\GridView;
use usni\library\modules\users\utils\UserUtil;
use usni\library\modules\users\widgets\ActionToolbar;
use usni\library\modules\users\models\User;
use usni\library\grid\StatusDataColumn;

/* @var $gridViewDTO \usni\library\modules\users\dto\UserGridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('users', 'Manage Users');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
                        'createUrl'         => 'create',
                        'bulkEditFormView'  => '/_bulkedit.php',
                        'showBulkEdit'      => true,
                        'showBulkDelete'    => false,
                        'gridId'            => 'usergridview',
                        'pjaxId'            => 'usergridview-pjax',
                        'bulkEditFormTitle' => UsniAdaptor::t('users', 'User') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
                        'bulkEditActionUrl' => 'bulk-edit',
                        'bulkEditFormId'    => 'userbulkeditview',
                        'groupList'         => $gridViewDTO->getGroupList(),
                        'permissionPrefix'  => 'user'
                  ];
$widgetParams  = [
                        'id'            => 'usergridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'columns' => [
                                        ['class' => CheckboxColumn::className()],   
                                        [
                                            'attribute' => 'username',
                                            'class'     => UserNameDataColumn::className()
                                        ],
                                        [
                                            'label'     => UsniAdaptor::t('users', 'Email'),
                                            'attribute' => 'email'
                                        ],
                                        [
                                            'label'     => UsniAdaptor::t('users', 'First Name'),
                                            'attribute' => 'firstname'
                                        ],
                                        [
                                            'label'     => UsniAdaptor::t('users', 'Last Name'),
                                            'attribute' => 'lastname',
                                        ],
                                        [
                                            'attribute' => 'timezone',
                                            'filter'    => TimezoneUtil::getTimezoneSelectOptions()
                                        ],
                                        [
                                            'attribute' => 'address1'
                                        ],
                                        [
                                            'attribute' => 'status',
                                            'class'     => StatusDataColumn::className(),
                                            'filter'    => UserUtil::getStatusDropdown()
                                        ],
                                        [
                                            'class'             => UserActionColumn::className(),
                                            'template'          => '{view} {update} {delete} {changepassword} {changestatus}',
                                            'modelClassName'    => User::className()
                                        ]
                                     ],
                 ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);