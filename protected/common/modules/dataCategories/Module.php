<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use common\modules\dataCategories\models\DataCategory;

/**
 * Provides functionality related to data category.
 *
 * DataCategory is the top level category under which all the content would reside for an application.
 * We can also call it the root category for the content.
 * @package backend\modules\dataCategories
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
        UsniAdaptor::app()->i18n->translations['dataCategories*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@common/modules/dataCategories/messages'
        ];
        UsniAdaptor::app()->i18n->translations['datacategoryflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@common/modules/dataCategories/messages'
        ];
        UsniAdaptor::app()->i18n->translations['datacategoryhint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@common/modules/dataCategories/messages'
        ];
    }
    
    /**
     * inheritdoc
     */
    public function getPermissionModels()
    {
        return [DataCategory::className()];
    }
}