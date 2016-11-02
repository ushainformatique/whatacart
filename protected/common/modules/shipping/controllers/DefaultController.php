<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
use common\modules\extension\models\ExtensionSearch;
use common\modules\shipping\views\ShippingGridView;
use usni\library\utils\FileUtil;
use common\modules\stores\utils\StoreUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\shipping\controllers
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
        $filterModel->category = 'shipping';
        return $filterModel;
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveGridViewClassName($model)
    {
        return ShippingGridView::className();
    }
    
    /**
     * @inheritdoc
     */
    public function getGridViewBreadcrumb($model)
    {
        return [
            [
                'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('shipping', 'Shipping')
            ]
        ];
    }
    
    /**
     * Reloads the shipping methods
     * @return void
     */
    public function actionReload()
    {
        $shippingMethods = Extension::find()->where('category = :category', [':category' => 'shipping'])->all();
        $installedCodes    = [];
        foreach($shippingMethods as $shipping)
        {
            $installedCodes[] = $shipping->code;
        }
        $path       = UsniAdaptor::getAlias('@common/modules/shipping/config');
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
                $shipping = Extension::find()->where('code = :code AND category = :category', [':category' => 'shipping', ':code' => $code])->one();
                $shipping->delete();
                //Delete store configuration
                StoreUtil::deleteStoreConfiguration($code, 'shipping');
            }
        }
        return $this->redirect(UsniAdaptor::createUrl('shipping/default/manage'));
    }
}