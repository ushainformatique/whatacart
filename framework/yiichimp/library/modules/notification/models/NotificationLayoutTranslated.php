<?php 
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\models;
    
use usni\library\db\ActiveRecord;

/**
 * NotificationLayoutTranslated class file.
 * 
 * @package usni\library\modules\notification\models
 */
class NotificationLayoutTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getNotificationLayout()
    {
        return $this->hasOne(NotificationLayout::className(), ['id' => 'owner_id']);
    }
}