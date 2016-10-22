<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes;

use usni\library\components\UiSecuredModule;
use usni\UsniAdaptor;
use taxes\utils\TaxPermissionUtil;
/**
 * Provides functionality related to taxation.
 * @package common\modules\tax
 */
class Module extends UiSecuredModule
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
        UsniAdaptor::app()->i18n->translations['tax*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@taxes/messages'
        ];
        UsniAdaptor::app()->i18n->translations['zone*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@taxes/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getPermissionUtil()
    {
        return TaxPermissionUtil::className();
    }
}
?>