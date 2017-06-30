<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\events;

/**
 * Order event class
 *
 * @package usni\library\modules\users\events
 */
class OrderEvent extends \yii\base\Event
{
    /**
     * @var array 
     */
    public $order;
}
