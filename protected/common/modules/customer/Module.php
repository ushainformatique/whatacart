<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use customer\models\Customer;
/**
 * Provides functionality specific to customer.
 * 
 * @package customer
 */
class Module extends SecuredModule
{

    const CUSTOMER_GROUP = 'customer';

    /**
     * Overrides to register translations.
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Registers translations.
     */
    public function registerTranslations()
    {
        UsniAdaptor::app()->i18n->translations['customer*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['customerflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['customerflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * inheritdoc
     */
    public function getPermissionModels()
    {
        return [Customer::className()];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions = parent::getPermissions();
        $permissions['Customer']['customer.change-password']    = UsniAdaptor::t('users', 'Change Password');
        $permissions['Customer']['customer.change-status']      = UsniAdaptor::t('users', 'Change Status');
        $permissions['Customer']['customer.change-passwordother'] = UsniAdaptor::t('users', 'Change Others Password');
        return $permissions;
    }
    
    /**
     * @inheritdoc
     */
    public function getModelToExcludedPermissions()
    {
        return [Customer::className() => ['updateother']];
    }
}