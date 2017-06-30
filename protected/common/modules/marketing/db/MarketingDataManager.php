<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing\db;

use usni\library\db\DataManager;
use usni\UsniAdaptor;
/**
 * MarketingDataManager class file
 * 
 * @package common\modules\marketing\db
 */
class MarketingDataManager extends DataManager
{
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        $this->saveNotificationTemplate();
        return true;
    }
    
    /**
     * inheritdoc
     */
    public function getNotificationDataSet()
    {
        $filePath = UsniAdaptor::app()->getModule('marketing')->basePath . '/email/_customerSendMail.php';
        return  [
                    [
                        'type'      => 'email',
                        'notifykey' => 'sendMail',
                        'subject'   => UsniAdaptor::t('marketing', 'Send Mail'),
                        'content'   => file_get_contents($filePath)
                    ]
                ];
    }
    
    /**
     * @inheritdoc
     */
    public function loadDemoData()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return null;
    }
}