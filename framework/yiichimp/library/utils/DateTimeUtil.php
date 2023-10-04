<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
/**
 * DateTime utility methods.
 * 
 * @package usni\library\utils
 */
class DateTimeUtil
{
    /**
     * Gets formatted date time.
     *
     * @param string $dateTime  Datetime.
     * @param string $dateWidth Date width format.
     * @param string $timeWidth Time width format.
     *
     * @return null
     */
    public static function getFormattedDateTime($dateTime, $format = 'medium')
    {
        if ($dateTime != '0000-00-00 00:00:00' and $dateTime != null)
        {
            if(is_integer($dateTime))
            {
                return UsniAdaptor::app()->formatter->asDatetime($dateTime, $format);
            }
            return UsniAdaptor::app()->formatter->asDatetime(strtotime($dateTime), $format);
        }
        elseif ($dateTime == null || $dateTime == '0000-00-00 00:00:00')
        {
            return $dateTime = UsniAdaptor::t('application', '(not set)');
        }
        return $dateTime;
    }
    
    /**
     * Gets formatted date.
     *
     * @param string $dateTime  Datetime.
     * @param string $dateWidth Date width format.
     * @param string $timeWidth Time width format.
     *
     * @return null
     */
    public static function getFormattedDate($dateTime, $format = 'medium')
    {
        if ($dateTime != '0000-00-00 00:00:00' and $dateTime != null)
        {
            if(is_integer($dateTime))
            {
                return UsniAdaptor::app()->formatter->asDate($dateTime, $format);
            }
            return UsniAdaptor::app()->formatter->asDate(strtotime($dateTime), $format);
        }
        elseif ($dateTime == null || $dateTime == '0000-00-00 00:00:00')
        {
            return $dateTime = UsniAdaptor::t('application', '(not set)');
        }
        return $dateTime;
    }
}