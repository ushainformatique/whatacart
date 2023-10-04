<?php 
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\models;
    
use usni\library\db\ActiveRecord;
/**
 * NotificationTemplateTranslated class file
 * 
 * @package usni\library\modules\notification\models
 */
class NotificationTemplateTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getNotificationTemplate()
    {
        return $this->hasOne(NotificationTemplate::className(), ['id' => 'owner_id']);
    }
}