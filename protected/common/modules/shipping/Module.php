<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping;

use usni\library\components\UiSecuredModule;
use usni\UsniAdaptor;
/**
 * Provides functionality related to shipping.
 * @package common\modules\shipping
 */
class Module extends UiSecuredModule
{  
    public $controllerNamespace = 'common\modules\shipping\controllers';
    
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
        UsniAdaptor::app()->i18n->translations['shipping*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages'
        ];
    }
}
?>