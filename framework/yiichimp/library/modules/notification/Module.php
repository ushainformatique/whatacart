<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use usni\library\modules\notification\models\Notification;
use usni\library\modules\notification\models\NotificationTemplate;
use usni\library\modules\notification\models\NotificationLayout;
/**
 * Provides functionality related to notifications in the system.
 * 
 * @package usni\library\modules\notification
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
        UsniAdaptor::app()->i18n->translations['notification*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['notificationflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['notificationhint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(parent::beforeAction($action))
        {
            $userId = UsniAdaptor::app()->user->getIdentity()->getId();
            if(UsniAdaptor::app()->authorizationManager->checkAccess($userId, 'access.' . $this->id))
            {
                return true;
            }
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissionModels()
    {
        return [Notification::className(), NotificationTemplate::className(), NotificationLayout::className()];
    }
    
    /**
     * @inheritdoc
     */
    public function getModelToExcludedPermissions()
    {
         return [Notification::className() => ['create', 'update', 'view', 'bulk-edit', 'bulk-delete', 'updateother', 'viewother', 'deleteother']];
    }
}