<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\controllers;

use taxes\models\TaxRule;
use yii\filters\AccessControl;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use taxes\business\TaxRuleManager;
use taxes\dto\TaxRuleFormDTO;
use usni\library\web\actions\BulkEditAction;
/**
 * RuleController class file.
 * 
 * @package taxes\controllers
 */
class RuleController extends \usni\library\web\Controller
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
                        'roles' => ['taxrule.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['taxrule.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['taxrule.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit'],
                        'roles' => ['taxrule.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['taxrule.delete'],
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
        $managerConfig = [
                            'class'    => TaxRuleManager::className()
                         ];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => TaxRule::className(),
                         'updateUrl'  => 'update',
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/taxrule/create',
                         'formDTOClass' => TaxRuleFormDTO::className()
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => TaxRule::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/taxrule/update',
                         'formDTOClass' => TaxRuleFormDTO::className()
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => TaxRule::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/taxrule/index',
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => TaxRule::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/taxrule/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => TaxRule::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'taxrule.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => TaxRule::className(),
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => TaxRule::className()
                        ],
        ];
    }
}