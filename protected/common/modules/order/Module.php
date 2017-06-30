<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use common\modules\order\models\Order;
/**
 * Provides functionality related to order.
 *
 * @package common\modules\order
 */
class Module extends SecuredModule
{  
    public $controllerNamespace = 'common\modules\order\controllers';
    
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
        UsniAdaptor::app()->i18n->translations['order*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissionModels()
    {
        return array(
            Order::className()
        );
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions = parent::getPermissions();
        unset($permissions['Order']['order.bulk-edit']);
        unset($permissions['Order']['order.bulk-delete']);
        return $permissions;
    }
}