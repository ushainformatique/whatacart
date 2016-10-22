<?php
namespace common\modules\extension\controllers;

use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use usni\library\utils\ArrayUtil;
use common\modules\extension\models\Extension;
/**
 * DefaultController class file
 *
 * @package common\modules\extension\controllers
 */
class DefaultController extends \usni\library\components\UiAdminController
{
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        return $this->redirect(UsniAdaptor::createUrl('extension/default/manage'));
    }
    
    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        return $this->redirect(UsniAdaptor::createUrl('extension/default/manage'));
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Extension::className();
    }
    
    /**
     * Change status.
     * @param int $id
     * @param int $status
     * @return void
     */
    public function actionChangeStatus($id, $status)
    {
        $extensions = Extension::findOne($id);
        $extensions->status = $status;
        $extensions->save();
        return $this->renderGridView();
    }
    
    /**
     * Settings for the extension
     * @param int $id
     * @return string
     */
    public function actionSettings($id)
    {
        $extension = Extension::findOne($id);
        $data      = unserialize($extension->data);
        $settings  = ArrayUtil::getValue($data, 'settings');
        if(!empty($settings))
        {
            $controllerPath = ArrayUtil::getValue($settings, 'controllerPath');
            if(!empty($settings))
            {
                return $this->redirect(UsniAdaptor::createUrl($controllerPath));
            }
        }
        FlashUtil::setMessage('settingsRouteMissing', UsniAdaptor::t('extensionflash', 'Settings route is missing in the configuration'));
        return $this->redirect(UsniAdaptor::createUrl('extension/default/manage'));
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Extension::getLabel(2)
               ];
    }
}