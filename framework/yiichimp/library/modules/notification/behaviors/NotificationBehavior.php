<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\behaviors;

use usni\library\utils\ArrayUtil;
use usni\library\utils\DateTimeUtil;
use usni\library\modules\notification\utils\NotificationUtil;
/**
 * NotificationBehavior extends the functionality for notification model
 *
 * @package usni\library\modules\notification\behaviors
 */
class NotificationBehavior extends \yii\base\Behavior
{
    /**
     * Gets type display label.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getTypeDisplayLabel($data, $key, $index, $column)
    {
        $typeLabelData = NotificationUtil::getTypes();
        if(($label = ArrayUtil::getValue($typeLabelData, $data['type'])) !== null)
        {
            return $label;
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Gets send date time.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getSendDateTime($data, $key, $index, $column)
    {
        return DateTimeUtil::getFormattedDateTime($data['senddatetime']);
    }
    
    /**
     * Get unserialize data for notification.
     * @param @param ActiveRecord $data
     * @return string
     */
    public function getNotificationMessage($data, $key, $index, $column)
    {
        $content  = '';
        $message  = unserialize($data['data']);
        if(!empty($message))
        {
            foreach ($message as $key => $value)
            {
                if(is_array($value))
                {
                    $content .= $key . str_repeat('&nbsp;', 5) . implode(',', $value) . '<br/>';
                }
                else
                {
                    $content .= $key . str_repeat('&nbsp;', 5) . $value  . '<br/>';
                }
            }
        }
        return $content;
    }
}