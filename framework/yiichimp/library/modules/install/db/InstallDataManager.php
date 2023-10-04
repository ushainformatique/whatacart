<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\install\db;

use usni\library\db\DataManager;
use usni\UsniAdaptor;
/**
 * Loads data related to install module.
 * 
 * @package usni\library\modules\install\db
 */
class InstallDataManager extends DataManager
{
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        $siteName = UsniAdaptor::app()->configManager->getValue('application', 'siteName');
        if($siteName == null)
        {
            $metaKeywords       = UsniAdaptor::t('install', 'My Demo Site Keywords');
            $metaDescription    = UsniAdaptor::t('install', 'My Demo Site Description');
        }
        else
        {
            $metaKeywords       = $siteName . ' ' . UsniAdaptor::t('install', 'Keywords');
            $metaDescription    = $siteName . ' ' . UsniAdaptor::t('application', 'Description');
        }
        UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('application', 'metaKeywords', $metaKeywords);
        UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('application', 'metaDescription', $metaDescription);
        UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('application', 'isRegistrationAllowed', 1);
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDemoData()
    {
        return;
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return null;
    }
}