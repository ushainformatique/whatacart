<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\db;

use usni\library\db\DataManager;
use usni\UsniAdaptor;
use newsletter\models\Newsletter;
/**
 * NewsletterDataManager class file.
 * 
 * @package newsletter\db
 */
class NewsletterDataManager extends DataManager
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
        $filePath = UsniAdaptor::app()->getModule('marketing/newsletter')->basePath . '/email/_customerNewsletter.php';
        return  [
                    [
                        'type'      => 'email',
                        'notifykey' => 'sendNewsletter',
                        'subject'   => UsniAdaptor::t('marketing', 'Newsletter'),
                        'content'   => file_get_contents($filePath)
                    ]
                ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Newsletter::className();
    }
    
    /**
     * @inheritdoc
     */
    public function loadDemoData()
    {
        return;
    }
}