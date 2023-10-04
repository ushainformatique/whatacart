<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\db;

use usni\library\db\DataManager;
use usni\UsniAdaptor;
/**
 * ApplicationDataManager class file.
 *
 * @package usni\library\db
 */
class ApplicationDataManager extends DataManager
{
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('application', 'appRebuild', false);
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function loadDemoData()
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
