<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\sequence;

use usni\library\components\UiSecuredModule;
use usni\UsniAdaptor;
use common\modules\sequence\utils\SequencePermissionUtil;
/**
 * Provides functionality related to manufacturer.
 * @package common\modules\manufacturer
 */
class Module extends UiSecuredModule
{  
    public $controllerNamespace = 'common\modules\sequence\controllers';
    
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
        UsniAdaptor::app()->i18n->translations['sequence*'] = [
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
        return SequencePermissionUtil::className();
    }
}
?>