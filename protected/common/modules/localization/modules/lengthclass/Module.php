<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
/**
 * Provides functionality specific to the lengthclass.
 * @package common\modules\localization\modules\lengthclass
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
        UsniAdaptor::app()->i18n->translations['lengthclass*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@common/modules/localization/modules/lengthclass/messages'
        ];
    }
}
?>