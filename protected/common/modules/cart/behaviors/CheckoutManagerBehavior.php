<?php
namespace cart\behaviors;

use common\modules\order\business\AdminCheckoutManager;
use common\modules\order\events\ConfirmOrderEvent;
/**
 *Implement extended functions related to to checkout manager.
 *
 * @package cart\behaviors
 */
class CheckoutManagerBehavior extends \yii\base\Behavior
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    
    /**
     * Attach events with this behavior.
     * @return array
     */
    public function events()
    {
        return [AdminCheckoutManager::EVENT_AFTER_CONFIRM => [$this, 'handleAfterConfirm']];
    }
    
    /**
     * Process after confirm payment
     * @param ConfirmOrderEvent $event
     */
    public function handleAfterConfirm($event)
    {
        
    }
}
