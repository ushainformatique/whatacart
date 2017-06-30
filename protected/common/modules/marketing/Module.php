<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing;

use usni\UsniAdaptor;
/**
 * Provides functionality related to marketing.
 * 
 * @package common\modules\marketing
 */
class Module extends \usni\library\components\SecuredModule
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
        UsniAdaptor::app()->i18n->translations['marketing*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions['MarketingModule'] = [
                                                'access.marketing'  => UsniAdaptor::t('application', 'Access Tab'),
                                                'marketing.mail'    => UsniAdaptor::t('marketing', 'Marketing Mails'),
                                          ];
        return $permissions;
    }
}