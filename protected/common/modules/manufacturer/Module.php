<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer;

use usni\library\components\UiSecuredModule;
use usni\UsniAdaptor;
use common\modules\manufacturer\utils\ManufacturerPermissionUtil;
/**
 * Provides functionality related to manufacturer.
 * @package common\modules\manufacturer
 */
class Module extends UiSecuredModule
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
     * @inheritdoc
     */
    public static function getPermissionUtil()
    {
        return ManufacturerPermissionUtil::className();
    }
}
?>