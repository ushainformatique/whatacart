<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use newsletter\models\Newsletter;
/**
 * Provides functionality related to newsletter.
 * 
 * @package newsletter
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
        UsniAdaptor::app()->i18n->translations['newsletter*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages'
        ];
        UsniAdaptor::app()->i18n->translations['newsletterhint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissionModels()
    {
        return [
                Newsletter::className()
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getModelToExcludedPermissions()
    {
         return [Newsletter::className() => ['bulk-edit', 'bulk-delete']];
    }
}