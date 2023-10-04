<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\service\controllers;

use usni\UsniAdaptor;
use usni\library\utils\FileUtil;
use usni\library\utils\FlashUtil;
use usni\library\modules\service\business\Manager;
use yii\filters\AccessControl;
use usni\library\modules\install\business\InstallManager;
/**
 * DefaultController for system.
 * 
 * @package usni\library\modules\service\controllers
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
                        'roles' => ['access.service'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['check-system'],
                        'roles' => ['service.checksystem'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['reload-permissions'],
                        'roles' => ['service.rebuildpermissions'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['reload-module-metadata'],
                        'roles' => ['service.rebuildmodulemetadata'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['clear-assets'],
                        'roles' => ['access.service'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['reload-install-data', 'rebuild'],
                    ]
                ],
            ],
        ];
    }
    
    /**
     * Loads the index page for the settings controller.
     * @return void
     */
    public function actionIndex()
    {
        return $this->render('/index');
    }

    /**
     * Checks system.
     * @return void
     */
    public function actionCheckSystem()
    {
        $systemResults = Manager::getInstance()->processCheckSystem();
        return $this->render('/requirements', [
                                                       'requirements' => $systemResults['requirements'],
                                                       'summary'      => $systemResults['summary']
                                              ]);
    }

    /**
     * Rebuild the module permissions.
     * @return void
     */
    public function actionReloadPermissions()
    {
        $result     = Manager::getInstance()->processLoadModulesPermissions();
        $message    = UsniAdaptor::t('auth', 'Rebuild Permissions');
        if($result == true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('serviceflash', '{service} execution is successful.', ['service' => $message]));
            return $this->redirect(UsniAdaptor::createUrl('service/default/index'));
        }
        if($result == false)
        {
            FlashUtil::setMessage('error', UsniAdaptor::t('serviceflash', '{service} execution fails.', ['service' => $message]));
            return $this->redirect(UsniAdaptor::createUrl('service/default/index'));
        }
    }

    /**
     * Reload install time data based on settings.
     * @return void
     */
    public function actionReloadInstallData()
    {
        //Sets time limit
        @set_time_limit(1800);
        if(file_exists(APPLICATION_PATH . '/protected/backend/runtime/apploaded.bin'))
        {
            unlink(APPLICATION_PATH . '/protected/backend/runtime/apploaded.bin');
        }
        FileUtil::writeFile(APPLICATION_PATH . '/protected/backend/runtime', 'rebuildstate.bin', 'wb', 'Rebuild in progress');
        InstallManager::reloadInstallData();
        echo "Success";
        unlink(APPLICATION_PATH . '/protected/backend/runtime' . '/rebuildstate.bin');
        FileUtil::writeFile(APPLICATION_PATH . '/protected/backend/runtime', 'apploaded.bin', 'wb', 'Application is loaded');
    }

    /**
     * Rebuild site.
     */
    public function actionRebuild()
    {
        $this->getView()->bodyClass = 'full-width';
        return $this->render('/rebuildapp');
    }
    
    /**
     * Clear assets
     * @return void
     */
    public function actionClearAssets()
    {
        FileUtil::clearAssets();
        return $this->redirect(UsniAdaptor::createUrl('service/default/index'));
    }

    /**
     * Rebuild module metadata.
     * @return void
     */
    public function actionReloadModuleMetadata()
    {
        return $this->redirect(UsniAdaptor::createUrl('service/default/index', ['rebuildModuleMetadata' => 'true']));
    }
}