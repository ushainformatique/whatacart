<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use common\modules\manufacturer\models\Manufacturer;
/**
 * Provides functionality related to manufacturer.
 * 
 * @package common\modules\manufacturer
 */
class Module extends SecuredModule
{  
    public $controllerNamespace = 'common\modules\manufacturer\controllers';
    
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
        UsniAdaptor::app()->i18n->translations['manufacturer*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * Get permission models
     * @return array
     */
    public function getPermissionModels()
    {
        return [Manufacturer::className()];
    }
}