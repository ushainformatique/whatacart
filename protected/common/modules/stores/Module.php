<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\stores;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use common\modules\stores\models\Store;
/**
 * Provides functionality relates to stores.
 * 
 * @package common\modules\stores
 */
class Module extends SecuredModule
{
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
        UsniAdaptor::app()->i18n->translations['stores*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['storehint*'] = [
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
        return [Store::className()];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions = parent::getPermissions();
        unset($permissions['Store']['store.bulk-delete']);
        return $permissions;
    }
}