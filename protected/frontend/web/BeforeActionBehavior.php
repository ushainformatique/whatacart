<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\web;

use usni\UsniAdaptor;
use productCategories\business\Manager as ProductCategoryManager;
use customer\business\Manager as CustomerBusinessManager;
use frontend\components\Customer;
use frontend\components\Guest;
use newsletter\models\NewsletterCustomers;
use common\modules\stores\models\Store;
use yii\base\Exception;
use common\modules\dataCategories\models\DataCategory;
use usni\library\modules\language\models\Language;
use common\modules\stores\dao\StoreDAO;
use common\modules\dataCategories\dao\DataCategoryDAO;
/**
 * BeforeActionBehavior class file for front end.
 * The methods would be used when beforeAction event is raised by the application. It should be included in frontend config file.
 * 
 * @package frontend\web
 */
class BeforeActionBehavior extends \backend\web\BeforeActionBehavior
{
    /**
     * inheritdoc
     */
    public function handleOnBeforeAction($event)
    {
        if($event->action->id != 'error' && $event->action->id != 'change-language')
        {
            parent::handleOnBeforeAction($event);
            if(UsniAdaptor::app()->installed)
            {
                $this->setMenuItems();
                $this->updateOnlineUsers();
                $this->setComponents();
                $this->setNewsletterData();
                $this->setStoreTheme();
                $this->checkIsSelectedStoreActive();
                $this->checkIsSelectedLanguageDeleted();
            }
        }
    }
    
    /**
     * Set menu items in session
     */
    public function setMenuItems()
    {
        $store      = UsniAdaptor::app()->storeManager->selectedStore;
        $records    = ProductCategoryManager::getInstance()->prepareMenuItems($store['data_category_id']);
        UsniAdaptor::app()->session->set('globalMenuItems', $records);
    }
    
    /**
     * Update online customers.
     * @return void
     */
    public function updateOnlineUsers()
    {
        $customerOnlineConfig = UsniAdaptor::app()->storeManager->getSettingValue('customer_online');
        if($customerOnlineConfig)
        {
            $ip         = UsniAdaptor::app()->request->getUserIP();
            $url        = UsniAdaptor::app()->request->getAbsoluteUrl();
            $referer    = UsniAdaptor::app()->request->getReferrer();
            CustomerBusinessManager::getInstance()->updateOnlineUsers($ip, $url, $referer);
        }
    }
    
    /**
     * inheritdoc
     */
    public function setComponents()
    {
        $storeId = UsniAdaptor::app()->storeManager->selectedStoreId;
        if(UsniAdaptor::app()->user->isGuest)
        {
            //Not setting customer as would not be required
            $this->setComponentInSession('guest_' . $storeId, Guest::className(), 'guest');
        }
        else
        {
            $userId  = UsniAdaptor::app()->user->getId();
            //Not setting guest as would not be required
            $this->setComponentInSession('customer_' . $storeId . '_' . $userId, Customer::className(), 'customer');
        }
    }
    
    /**
     * Set newsletter data.
     */
    public function setNewsletterData()
    {
        if(UsniAdaptor::app()->user->isGuest == false)
        {
            $user                       = UsniAdaptor::app()->user->getIdentity();
            $newsletterCustomerCount    = NewsletterCustomers::find()->where('customer_id = :cid', [':cid' => $user->id])->count();
            UsniAdaptor::app()->getSession()->set('newsletterCustomerCount', $newsletterCustomerCount);
        }
    }
    
    /**
     * Set store theme
     */
    public function setStoreTheme()
    {
        $selectedStore = UsniAdaptor::app()->storeManager->selectedStore;
        if($selectedStore['theme'] != null)
        {
            $themeName = $selectedStore['theme'];
            
            $themeConfig = [
                            'basePath' => '@webroot/themes/' . $themeName,
                            'baseUrl' => '@web/themes/' . $themeName,
                            'class'   => 'yii\base\Theme',
                            'pathMap' => [
                                                '@app/views' => '@webroot/themes/' . $themeName,
                                                '@app/modules' => '@webroot/themes/' . $themeName . '/modules',
                                                '@common/modules' => '@webroot/themes/' . $themeName . '/modules'
                            ]
            ];
            UsniAdaptor::app()->view->theme = \Yii::createObject($themeConfig);
        }
    }
    
    /**
     * inheritdoc
     */
    public function setStoresData()
    {
        parent::setStoresData();
        $selectedStores = [];
        foreach(UsniAdaptor::app()->storeManager->stores as $record)
        {
            if($record['status'] == Store::STATUS_ACTIVE)
            {
                $selectedStores[] = $record;
            }
        }
        UsniAdaptor::app()->storeManager->stores    = $selectedStores;
    }
    
    /**
     * Check is selected store active.
     * @throws Exception
     */
    public function checkIsSelectedStoreActive()
    {
        $selectedStoreId = UsniAdaptor::app()->storeManager->selectedStoreId;
        //Check if selected store is inactive
        $selectedStoreStatus = StoreDAO::getStatus($selectedStoreId);
        if($selectedStoreStatus != Store::STATUS_ACTIVE)
        {
            throw new Exception(UsniAdaptor::t('stores', 'Selected store is not active. Please contact system admin.'));
        }
        //Check if data category associated to selected store is inactive
        $dataCategoryId         = StoreDAO::getDataCategoryId($selectedStoreId);
        $dataCategoryStatus     = DataCategoryDAO::getStatus($dataCategoryId);
        if($dataCategoryStatus != DataCategory::STATUS_ACTIVE)
        {
            throw new Exception(UsniAdaptor::t('stores', 'Data category associated to selected store is not active. Please contact system admin.'));
        }
    }
    
    /**
     * Check is selected language deleted.
     */
    public function checkIsSelectedLanguageDeleted()
    {
        $selectedLanguage   = UsniAdaptor::app()->languageManager->selectedLanguage;
        $language           = Language::find()->where('code = :code', [':code' => $selectedLanguage])->asArray()->one();
        if(empty($language))
        {
            UsniAdaptor::app()->cookieManager->setLanguageCookie('en-US');
        }
    }

    /**
     * Set language data
     */
    public function setLanguageData()
    {
        parent::setLanguageData();
        //Set from cookie
        UsniAdaptor::app()->language = UsniAdaptor::app()->languageManager->selectedLanguage;
    }
}