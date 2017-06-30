<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
/**
 * Provides functionality related to order status.
 * 
 * @package common\modules\localization\modules\orderstatus
 */
class Module extends SecuredModule
{  
    public $controllerNamespace = 'common\modules\localization\modules\orderstatus\controllers';
    
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
        UsniAdaptor::app()->i18n->translations['orderstatus*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@common/modules/localization/modules/orderstatus/messages'
        ];
        UsniAdaptor::app()->i18n->translations['orderstatusflash'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@common/modules/localization/modules/orderstatus/messages'
        ];
    }
}