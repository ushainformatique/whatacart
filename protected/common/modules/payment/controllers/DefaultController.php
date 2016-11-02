<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
use common\modules\extension\models\ExtensionSearch;
use common\modules\payment\views\PaymentGridView;
use usni\library\utils\FileUtil;
use common\modules\stores\utils\StoreUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\payment\controllers
 */
class DefaultController extends UiAdminController
{   
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
        $extension = Extension::findOne($id);
        $extension->status = $status;
        $extension->save();
        return $this->renderGridView();
    }
    
    /**
     * @inheritdoc
     */
    protected function getFilterModel($model)
    {
        $filterModel = new ExtensionSearch();
        $filterModel->load($_GET, 'ExtensionSearch');
        $filterModel->category = 'payment';
        return $filterModel;
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveGridViewClassName($model)
    {
        return PaymentGridView::className();
    }
    
    /**
     * @inheritdoc
     */
    public function getGridViewBreadcrumb($model)
    {
        return [
            [
                'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('payment', 'Payments')
            ]
        ];
    }
    
    /**
     * Reloads the payment methods
     * @return void
     */
    public function actionReload()
    {
        $payments = Extension::find()->where('category = :category', [':category' => 'payment'])->all();
        $installedCodes    = [];
        foreach($payments as $payment)
        {
            $installedCodes[] = $payment->code;
        }
        $path       = UsniAdaptor::getAlias('@common/modules/payment/config');
        $subDirs    = glob($path . '/*', GLOB_ONLYDIR);
        //If newly added
        foreach($subDirs as $subDir)
        {
            $subPath    = FileUtil::normalizePath($subDir);
            $data       = require($subPath . '/config.php');
            //If not in db
            if(!in_array($data['code'], $installedCodes))
            {
                $extension = new Extension(['scenario' => 'create']);
                $extension->setAttributes($data);
                if($extension->save())
                {
                    $installedCodes[] = $data['code'];
                }
            }
        }
        //if folder is removed
        foreach($installedCodes as $code)
        {
            $folderPath = FileUtil::normalizePath($path . '/' . $code);
            if(!file_exists($folderPath))
            {
                $payment = Extension::find()->where('code = :code AND category = :category', [':category' => 'payment', ':code' => $code])->one();
                $payment->delete();
                //Delete store configuration
                StoreUtil::deleteStoreConfiguration($code, 'payment');
            }
        }
        return $this->redirect(UsniAdaptor::createUrl('payment/default/manage'));
    }
}