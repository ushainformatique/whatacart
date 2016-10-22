<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\controllers;

use common\modules\stores\models\Store;
use usni\library\components\UiAdminController;
use common\modules\stores\models\StoreEditForm;
use common\modules\stores\views\StoreEditView;
use common\modules\stores\utils\StoreUtil;
use usni\UsniAdaptor;
use yii\helpers\Json;
use usni\library\utils\AddressUtil;
use usni\library\utils\FileUploadUtil;
use yii\web\ForbiddenHttpException;
use common\modules\stores\models\StoreTranslated;
use usni\library\utils\CacheUtil;
use usni\library\utils\TranslationUtil;
use usni\library\managers\UploadInstanceManager;
/**
 * DefaultController class file
 * 
 * @package common\modules\stores\controllers
 */
class DefaultController extends UiAdminController
{    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Store::className();
    }

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model                  = new StoreEditForm(['scenario' => 'create']);
        return $this->processStoreSave($model);
    }
    
    /**
     * Process store save.
     * @param Model $model
     * @return string
     */
    public function processStoreSave($model)
    {
        $postData           = UsniAdaptor::app()->request->post();
        if(isset($postData['Store']))
        {
            $this->beforeAssigningPostData($model);
        }
        if ($model->store->load($postData) 
                && $model->billingAddress->load($postData)
                    && $model->storeLocal->load($postData) 
                        && $model->storeSettings->load($postData)
                            && $model->storeImage->load($postData)
                                && $model->shippingAddress->load($postData)
            )
        {
            if($this->beforeModelSave($model))
            {
                if(StoreUtil::validateAndSaveStoreData($model))
                {
                    $this->afterModelSave($model);
                    return $this->redirect(UsniAdaptor::createUrl('stores/default/manage'));
                }
            }
        }
        $this->setBreadCrumbs($model);
        $storeView          = StoreEditView::className();
        $view               = new $storeView($model);
        $content            = $this->renderColumnContent([$view]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }
    
    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $model              = new StoreEditForm();
        $model->scenario    = 'update';
        $store              = Store::findOne($id);
        $model->store       = $store;
        if($store->billingAddress != null)
        {
            $model->billingAddress  = $store->billingAddress;
        }
        if($store->shippingAddress != null)
        {
            $model->shippingAddress  = $store->shippingAddress;
        }
        if($store->storeLocal != null)
        {
            $model->storeLocal  = $store->storeLocal;
        }
        if($store->storeSettings != null)
        {
            $model->storeSettings  = $store->storeSettings;
        }
        if($store->storeImage != null)
        {
            $model->storeImage  = $store->storeImage;
        }
        $model->store->setScenario('update');
        $model->billingAddress->setScenario('update');
        $model->shippingAddress->setScenario('update');
        return $this->processStoreSave($model);
    }
    
    /**
     * Changes status for the store.
     * @param int $id
     * @param int $status
     */
    public function actionChangeStatus($id, $status)
    {
        $model          = Store::findOne($id);
        $model->status  = $status;
        $model->save();
        echo $this->renderGridView();   
    }

    /**
     * Set default store.
     * @param int $id
     */
    public function actionSetDefaultStore($id)
    {
        Store::updateAll(['is_default' => 0], 'is_default = 1');
        $model          = Store::findOne($id);
        $model->is_default = true;
        $model->save();
        return $this->renderGridView();
    }

    /**
     * Populate shipping address.
     * @return string json result
     */
    public function actionPopulateShippingAddress()
    {
        $modelClass = 'StoreEditForm'; 
        $data       = AddressUtil::getFormFieldsToPopulateShippingAddress($modelClass);
        echo Json::encode($data);
    }
    
    /**
     * @inheritdoc
     */
    protected function beforeAssigningPostData($model)
    {
        $model->storeImage->logoSavedImage = $model->storeImage->store_logo;
        $model->storeImage->iconSavedImage = $model->storeImage->icon;
    }
    
    /**
     * @inheritdoc
     */
    protected function beforeModelSave($model)
    {
        //For store logo
        $config = [
                        'model'             => $model->storeImage,
                        'attribute'         => 'store_logo',
                        'uploadInstanceAttribute' => 'logoUploadInstance',
                        'type'              => 'image',
                        'savedAttribute'    => 'logoSavedImage',
                        'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                  ];
        $logoUploadInstanceManager = new UploadInstanceManager($config);
        $logoResult = $logoUploadInstanceManager->processUploadInstance();
        if($logoResult === false)
        {
            return false;
        }
        //for store  icon
        $config = [
                       'model'             => $model->storeImage,
                       'attribute'         => 'icon',
                       'uploadInstanceAttribute' => 'iconUploadInstance',
                       'type'              => 'image',
                       'savedAttribute'    => 'iconSavedImage',
                       'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                 ];
       $iconUploadInstanceManager = new UploadInstanceManager($config);
       $iconResult = $iconUploadInstanceManager->processUploadInstance();
       if($iconResult === false)
       {
           return false;
       }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function afterModelSave($model)
    {
        if($model->storeImage->store_logo != '')
        {
            $config = [
                        'model'             => $model->storeImage, 
                        'attribute'         => 'store_logo', 
                        'uploadInstance'    => $model->storeImage->logoUploadInstance, 
                        'savedFile'         => $model->storeImage->logoSavedImage
                      ];
            FileUploadUtil::save('image', $config);
        }
        if($model->storeImage->icon != '')
        {
            $config = [
                        'model'             => $model->storeImage, 
                        'attribute'         => 'icon', 
                        'uploadInstance'    => $model->storeImage->iconUploadInstance, 
                        'savedFile'         => $model->storeImage->iconSavedImage
                      ];
            FileUploadUtil::save('image', $config);
        }
        if($this->action->id == 'create')
        {
            TranslationUtil::saveTranslatedModels($model->store);
        }
        return true;
    }
    
    /**
     * @inheritdoc
     * Default store can not delete
     */
    public function actionDelete($id)
    {
        $storeTable             = Store::tableName();
        $storeTranslatedTable   = StoreTranslated::tableName();
        $query  = (new \yii\db\Query());
        $store  = $query->select("st.is_default, stt.name")
                        ->from([$storeTable . 'st', $storeTranslatedTable . ' stt'])
                        ->where('st.id = :id AND stt.owner_id = st.id AND stt.language = :lan', [':id' => $id, ':lan' => 'en-US'])->one();
        
        if($store['is_default'] || $store['name'] === 'Default')
        {
            throw new ForbiddenHttpException(UsniAdaptor::t('stores','You can not delete default store.'));
        }
        else
        {
            return parent::actionDelete($id);
        }
    }
    
    /**
     * Set store.
     * @return void.
     */
    public function actionSetStore()
    {
        if($_GET['id'] != null)
        {
            $storeManager = UsniAdaptor::app()->storeManager;
            $key = 'currentStore-' . $storeManager->applicationStoreCookieName;
            CacheUtil::delete($key);
            $storeManager->setCookie($_GET['id']);
            return $this->goHome();
        }
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . Store::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . Store::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . Store::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Store::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getActionToPermissionsMap()
    {
        $permissionsMap                         = parent::getActionToPermissionsMap();
        $permissionsMap['change-status']        = 'store.manage';
        $permissionsMap['set-default-store']    = 'store.manage';
        return $permissionsMap;
    }
    
    /**
     * @inheritdoc
     */
    protected static function getNonPermissibleActions()
    {
        $permissions = parent::getNonPermissibleActions();
        $permissions[] = 'set-store';
        return $permissions;
    }
}