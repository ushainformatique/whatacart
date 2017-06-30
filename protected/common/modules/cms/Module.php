<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use common\modules\cms\models\Page;
/**
 * Provides functionality related to content management.
 * 
 * @package common\modules\cms
 */
class Module extends SecuredModule
{
    /**
     * Status constant for published.
     */
    const STATUS_PUBLISHED = 1;
    /**
     * Status constant for unpublished.
     */
    const STATUS_UNPUBLISHED = 2;
    /**
     * Status constant for archived.
     */
    const STATUS_ARCHIVED = 3;
    
    /**
     * Status constant for trashed.
     */
    const STATUS_TRASHED = 4;
    
    public $controllerNamespace = 'common\modules\cms\controllers';

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
        UsniAdaptor::app()->i18n->translations['cms*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['cmshint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissionModels()
    {
        return array(
            Page::className()
        );
    }
}