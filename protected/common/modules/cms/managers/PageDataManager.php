<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\managers;

use usni\library\components\UiDataManager;
use common\modules\cms\models\Page;
use common\modules\cms\Module;
use frontend\utils\FrontUtil;
use usni\library\utils\FileUtil;
use usni\UsniAdaptor;
/**
 * Loads default data related to page.
 *
 * @package common\modules\cms\managers
 */
class PageDataManager extends UiDataManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Page::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        return [
                    [
                        'name'              => UsniAdaptor::t('cms', 'About Us'),
                        'alias'             => UsniAdaptor::t('cms', 'about-us'),
                        'content'           => static::getPageContent('_aboutus'),
                        'status'            => Module::STATUS_PUBLISHED,
                        'menuitem'          => UsniAdaptor::t('cms', 'About Us')   ,
                        'theme'             => 'classic',
                        'parent_id'         => 0,
                        'summary'           => UsniAdaptor::t('cms', 'About us summary'),
                        'metakeywords'      => UsniAdaptor::t('cms', 'about us'),
                        'metadescription'   => UsniAdaptor::t('cms', 'about us description'),
                    ],
                    [
                        'name'              => UsniAdaptor::t('cms', 'Delivery Information'),
                        'alias'             => UsniAdaptor::t('cms', 'delivery-info'),
                        'content'           => static::getPageContent('_delivery'),
                        'status'            => Module::STATUS_PUBLISHED,
                        'menuitem'          => UsniAdaptor::t('cms', 'Delivery Information'),
                        'theme'             => 'classic',
                        'parent_id'         => 0,
                        'summary'           => UsniAdaptor::t('cms', 'Delivery information summary'),
                        'metakeywords'      => UsniAdaptor::t('cms', 'delivery information'),
                        'metadescription'   => UsniAdaptor::t('cms', 'deliverr information description'),
                    ],
                    [
                        'name'              => UsniAdaptor::t('cms', 'Privacy Policy'),
                        'alias'             => UsniAdaptor::t('cms', 'privacy-policy'),
                        'content'           => static::getPageContent('_privacypolicy'),
                        'status'            => Module::STATUS_PUBLISHED,
                        'menuitem'          => UsniAdaptor::t('cms', 'Privacy Policy'),
                        'theme'             => 'classic',
                        'parent_id'         => 0,
                        'summary'           => UsniAdaptor::t('cms', 'Privacy policy summary'),
                        'metakeywords'      => UsniAdaptor::t('cms', 'privacy policy'),
                        'metadescription'   => UsniAdaptor::t('cms', 'privacy policy description'),
                    ],
                    [
                        'name'              => UsniAdaptor::t('cms', 'Terms & Conditions'),
                        'alias'             => UsniAdaptor::t('cms', 'terms'),
                        'content'           => static::getPageContent('_terms'),
                        'status'            => Module::STATUS_PUBLISHED,
                        'menuitem'          => UsniAdaptor::t('cms', 'Terms & Conditions'),
                        'theme'             => 'classic',
                        'parent_id'         => 0,
                        'summary'           => UsniAdaptor::t('cms', 'Terms & condition summary'),
                        'metakeywords'      => UsniAdaptor::t('cms', 'terms & condition'),
                        'metadescription'   => UsniAdaptor::t('cms', 'terms & condition description'),
                    ]
                ];
    }
    
	/**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }

    /**
     * Get content
     * @param string $template
     * @return string
     */
    protected static function getPageContent($template)
    {
        $theme          = FrontUtil::getThemeName();
        $rawLanguage    = UsniAdaptor::app()->languageManager->getLanguageWithoutLocale();
        $path           = FileUtil::normalizePath(APPLICATION_PATH . '/themes/' . $theme . '/views/cms/' . $rawLanguage . '/' . $template . '.php');
        return UsniAdaptor::app()->getView()->renderFile($path);
    }
}