<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\controllers;

use usni\library\modules\notification\models\Notification;
use yii\filters\AccessControl;
use usni\library\web\actions\IndexAction;
use usni\library\dto\GridViewDTO;
use usni\library\web\actions\DeleteAction;
/**
 * DefaultController class file.
 * 
 * @package usni\library\modules\notification\controllers
 */
class DefaultController extends \usni\library\web\Controller
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['notification.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['notification.delete'],
                    ]
                ],
            ],
        ];
    }
    
    /**
     * inheritdoc
     */
    public function actions()
    {
        return [
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Notification::className(),
                         'dtoClass' => GridViewDTO::className(),
                         'viewFile' => '/index'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => Notification::className(),
                         'redirectUrl'=> '/notification/default/index',
                         'permission' => 'notification.deleteother',
                        ],
        ];
    }
}