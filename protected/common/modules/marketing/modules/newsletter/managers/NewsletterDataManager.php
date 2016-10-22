<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\managers;

use usni\library\components\UiDataManager;
use usni\UsniAdaptor;
use usni\library\modules\notification\utils\NotificationUtil;
use newsletter\models\Newsletter;
use common\utils\ApplicationUtil;
/**
 * NewsletterDataManager class file.
 * 
 * @package newsletter\managers
 */
class NewsletterDataManager extends UiDataManager
{
    /**
     * @inheritdoc
     */
    public static function loadDefaultData()
    {
        $installedData  = static::getUnserializedData('installdefaultdata.bin');
        $isDataLoaded   = static::checkIfClassDataLoaded($installedData);
        if($isDataLoaded)
        {
            return false;
        }
        //Save notification for newsletter.
        $data = [
                    [
                        'type'      => 'email',
                        'notifykey' => 'sendNewsletter',
                        'subject'   => UsniAdaptor::t('newsletter', 'Newsletter'),
                        'content'   => ApplicationUtil::getDefaultEmailTemplate('_customerNewsletter')
                    ]
                ];
        NotificationUtil::saveNotificationTemplate($data);
        static::writeFileInCaseOfOverRiddenMethod('installdefaultdata.bin');
        return true;
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
    public static function loadDemoData()
    {
        return;
    }
}