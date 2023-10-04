<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\modules\users\models\User;
use usni\library\modules\users\widgets\UserNameDataColumn;
use usni\library\grid\StatusDataColumn;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('users', 'Latest Users');

$widgetParams   = [
                        'id'            => 'latestusersgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'caption'       => $title,
                        'modelClass'    => User::className(),
                        'layout'        => "<div class='panel panel-default'>
                                                <div class='panel-heading'>{caption}</div>
                                                    {items}
                                               </div>",
                        'columns'       => [
                                                [
                                                    'attribute' => 'username',
                                                    'class'     => UserNameDataColumn::className()
                                                ],
                                                'email',
                                                [
                                                    'attribute' => 'status',
                                                    'class' => StatusDataColumn::className()
                                                ],
                                        ],
                ];
echo GridView::widget($widgetParams);