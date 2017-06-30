<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
/**
 * Provides functionality relates to installation of new extension or theme
 *
 * @package common\modules\extension
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
        UsniAdaptor::app()->i18n->translations['extension*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['extensionflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['extensionhint*'] = [
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
        return [Extension::className()];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions = parent::getPermissions();
        unset($permissions['Extension']['extension.create']);
        unset($permissions['Extension']['extension.view']);
        unset($permissions['Extension']['extension.viewother']);
        unset($permissions['Extension']['extension.bulk-edit']);
        unset($permissions['Extension']['extension.bulk-delete']);
        $permissions['Extension']['extension.manageother'] = UsniAdaptor::t('extension', 'Manager Others Extension');
        return $permissions;
    }
}