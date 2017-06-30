<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
/**
 * Provides functionality related to payments.
 * 
 * @package common\modules\payment
 */
class Module extends SecuredModule
{  
    public $controllerNamespace = 'common\modules\payment\controllers';
    
    /**
     * Overrides to register translations.
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
        $this->registerLogTargets();
    }
    
    /**
     * Registers translations.
     */
    public function registerTranslations()
    {
        UsniAdaptor::app()->i18n->translations['payment*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages'
        ];
        UsniAdaptor::app()->i18n->translations['paymenthint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages'
        ];
        
        UsniAdaptor::app()->i18n->translations['paypal*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages'
        ];
        UsniAdaptor::app()->i18n->translations['paypalhint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages'
        ];
    }
    
    /**
     * Register log targets
     */
    public function registerLogTargets()
    {
        $targets = UsniAdaptor::app()->log->targets;
        $targets[] = \Yii::createObject([
                        'class' => 'yii\log\FileTarget',
                        'logFile' => '@runtime/logs/paypal_standard.log',
                        'levels' => ['error', 'warning', 'info'],
                        'logVars' => ['_GET', '_POST', '_SESSION'],
                        'categories' => ['paypal_standard'],
                    ]);
        $targets[] = \Yii::createObject([
                        'class' => 'yii\log\FileTarget',
                        'logFile' => '@runtime/logs/paypal_express.log',
                        'levels' => ['error', 'warning', 'info'],
                        'logVars' => ['_GET', '_POST', '_SESSION'],
                        'categories' => ['paypal_express'],
                    ]);
        UsniAdaptor::app()->log->targets = $targets;
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions['PaymentModule'] = [
                                                'access.payment'  => UsniAdaptor::t('application', 'Access Tab'),
                                          ];
        return $permissions;
    }
}