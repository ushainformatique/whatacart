<?php
namespace common\modules\order\events;
/**
 * ConfirmOrderEvent class file
 *
 * @package cart\events
 */
class ConfirmOrderEvent extends \yii\base\Event
{    
    public $checkoutDTO;
}
