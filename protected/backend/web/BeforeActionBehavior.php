<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace backend\web;

use usni\UsniAdaptor;
use yii\base\Behavior;
use usni\library\modules\language\business\Manager as LanguageBusinessManager;
use yii\base\Event;
use usni\library\web\Controller;
use common\modules\stores\business\Manager as StoreBusinessManager;
use common\modules\localization\modules\currency\business\Manager as CurrencyBusinessManager;
use backend\components\Customer;
use common\modules\stores\business\ConfigManager;
use usni\library\utils\ArrayUtil;
use usni\library\utils\FlashUtil;
/**
 * BeforeActionBehavior class file.
 * The methods would be used when beforeAction event is raised by the application. It should be included in backend config file.
 * 
 * @package backend\web
 */
class BeforeActionBehavior extends Behavior
{
    /**
     * Attach events with this behavior.
     * @return array
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => [$this, 'handleOnBeforeAction']];
    }
    
    /**
     * Event handler before action is run.
     * 
     * @param Event $event
     * @return void
     */
    public function handleOnBeforeAction($event)
    {
        if(UsniAdaptor::app()->installed)
        {
            if($event->action->id != 'error' && $event->action->id != 'change-language')
            {
                UsniAdaptor::app()->configManager->load();
                $this->setLanguageData();
                $this->setStoresData();
                $this->setCurrencyData();
                $this->setComponents();
                $this->setMailerConfig();
            }
        }
    }
    
    /**
     * Set stores data
     */
    public function setStoresData()
    {
        UsniAdaptor::app()->storeManager->stores        = StoreBusinessManager::getInstance()->getAll();
        if(empty(UsniAdaptor::app()->storeManager->stores))
        {
            UsniAdaptor::app()->storeManager->stores    = StoreBusinessManager::getInstance(['language' => 'en-US'])->getAll();   
            FlashUtil::setMessage('warning', UsniAdaptor::t('application', 'Selected store is currently in default language and is missing for the selected language. Please enter the data in the selected language.'));
        }
        foreach(UsniAdaptor::app()->storeManager->stores as $record)
        {
            if($record['id'] == UsniAdaptor::app()->cookieManager->getSelectedStoreId())
            {
                UsniAdaptor::app()->storeManager->selectedStore = $record;
                break;
            }
        }
        //Set from cookie
        UsniAdaptor::app()->storeManager->selectedStoreId = UsniAdaptor::app()->cookieManager->getSelectedStoreId();
        //Set config for the selected store
        UsniAdaptor::app()->storeManager->config  = ConfigManager::getInstance()->getConfiguration();
    }
    
    /**
     * Set currency data
     */
    public function setCurrencyData()
    {
        //Set currencies
        $currencyBusinessManager = new CurrencyBusinessManager();
        UsniAdaptor::app()->currencyManager->currencyCodes      = $currencyBusinessManager->getCodeList();
        UsniAdaptor::app()->currencyManager->currencies         = $currencyBusinessManager->getList();
        UsniAdaptor::app()->currencyManager->defaultCurrency    = $currencyBusinessManager->getDefault();
        //Set from cookie
        UsniAdaptor::app()->currencyManager->selectedCurrency   = UsniAdaptor::app()->cookieManager->getSelectedCurrency();
        UsniAdaptor::app()->currencyManager->currencySymbol     = UsniAdaptor::app()->currencyManager->getSelectedCurrencySymbol();
    }
    
    /**
     * Set language data
     */
    public function setLanguageData()
    {
        //Set languages
        $manager                = new LanguageBusinessManager();
        UsniAdaptor::app()->languageManager->languages              = $manager->getList();
        UsniAdaptor::app()->languageManager->translatedLanguages    = $manager->getTranslatedLanguages();
        //Set from cookie
        UsniAdaptor::app()->language = UsniAdaptor::app()->languageManager->selectedLanguage = UsniAdaptor::app()->cookieManager->getSelectedLanguage();
    }
    
    /**
     * Sets component in session.
     * 
     * @param $key Session key
     * @param $component Name of the model
     * @param $name Name of the component in session.
     * @return void
     */
    public function setComponentInSession($key, $component, $name)
    {
        $sessionData = UsniAdaptor::app()->session->get($key);
        if($sessionData == null)
        {
            $sessionData = new $component();
            UsniAdaptor::app()->session->set($key, serialize($sessionData));
        }
        else
        {
            $sessionData = unserialize($sessionData);
        }
        UsniAdaptor::app()->set($name, $sessionData);
    }
    
    /**
     * Set components in session
     */
    public function setComponents()
    {
        $this->setComponentInSession('customer', Customer::className(), 'customer');
    }
    
    /**
     * Set email settings from config in mailer.
     * @return array
     */
    public function setMailerConfig()
    {
        $config         = [];
        $emailSettings  = UsniAdaptor::app()->configManager->getValue('settings', 'emailSettings');
        if($emailSettings != null)
        {
            $config = unserialize($emailSettings);
        }
        $sendMethod = trim(ArrayUtil::getValue($config, 'sendingMethod', null)); 
        if($sendMethod == 'smtp')
        {
            $configurationArray = [
                                    'scheme'        => 'smtps',
                                    'host'          => trim(ArrayUtil::getValue($config, 'smtpHost', '')),
                                    'username'      => trim(ArrayUtil::getValue($config, 'smtpUsername', '')),
                                    'password'      => ArrayUtil::getValue($config, 'smtpPassword', ''),
                                    'port'          => trim(ArrayUtil::getValue($config, 'smtpPort', '')),
                                    //'encryption'    => 'tls',
                                  ];
            UsniAdaptor::app()->mailer->setTransport($configurationArray);
        }
        UsniAdaptor::app()->mailer->useFileTransport = ArrayUtil::getValue($config, 'testMode', true);
    }
}