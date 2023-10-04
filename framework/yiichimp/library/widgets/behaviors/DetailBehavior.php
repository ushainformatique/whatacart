<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets\behaviors;

use usni\UsniAdaptor;
use usni\library\utils\DateTimeUtil;
/**
 * Implement extended functionality related to detail view
 *
 * @package usni\library\widgets\behaviors
 */
class DetailBehavior extends \yii\base\Behavior
{
    /**
     * Get name for record editor.
     * @param array $data
     * @return string
     */
    public function getAuthorName($data)
    {
        if(empty($data))
        {
            return UsniAdaptor::t('application','(not set)');
        }
        else
        {
            return $data['username'];
        }
    }
    
    /**
     * Get formatted date time
     * @param string $value
     * @return string
     */
    public function getFormattedDateTime($value)
    {
        return DateTimeUtil::getFormattedDateTime($value);
    }
}
