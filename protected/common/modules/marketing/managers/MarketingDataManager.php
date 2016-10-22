<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing\managers;

use usni\library\components\UiDataManager;
use usni\library\modules\notification\utils\NotificationUtil;
use common\utils\ApplicationUtil;
use usni\UsniAdaptor;
/**
 * MarketingDataManager class file
 * 
 * @package common\modules\marketing\managers
 */
class MarketingDataManager extends UiDataManager
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
        //Save notification for send mail.
        $data = [
                    [
                        'type'      => 'email',
                        'notifykey' => 'sendMail',
                        'subject'   => UsniAdaptor::t('marketing', 'Send Mail'),
                        'content'   => ApplicationUtil::getDefaultEmailTemplate('_customerSendMail')
                    ]
                ];
        NotificationUtil::saveNotificationTemplate($data);
        static::writeFileInCaseOfOverRiddenMethod('installdefaultdata.bin');
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