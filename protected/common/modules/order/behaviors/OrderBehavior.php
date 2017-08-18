<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\behaviors;

use common\modules\order\events\OrderEvent;
use common\modules\order\models\Order;
/**
 * OrderBehavior class file
 *
 * @package common\modules\order\behaviors
 */
class OrderBehavior extends \yii\base\Behavior
{
    /**
     * Attach events with this behavior.
     * @return array
     */
    public function events()
    {
        return [Order::EVENT_AFTER_ORDER_POPULATION => [$this, 'handleAfterOrderPopulation'],
                Order::EVENT_AFTER_ADDING_HISTORY => [$this, 'handleAfterAddingHistory']];
    }
    
    /**
     * Handle after order population.
     * @param OrderEvent $event
     */
    public function handleAfterOrderPopulation($event)
    {
        
    }
    
    /**
     * Handle after adding order history
     * @param OrderEvent $event
     */
    public function handleAfterAddingHistory($event)
    {
        
    }
    
    /**
     * Get amount.
     * @param Order $model
     * @return float
     */
    public function getAmount($model)
    {
        return number_format($model['total_including_tax'] + $model['shipping_fee'], 2, ".", ",");
    }
}
