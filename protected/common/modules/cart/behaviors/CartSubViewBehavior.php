<?php
namespace cart\behaviors;

use cart\widgets\CartSubView;
use cart\events\CartEvent;
/**
 * CartSubViewBehavior class file
 *
 * @package cart\behaviors
 */
class CartSubViewBehavior extends \yii\base\Behavior
{
    /**
     * Attach events with this behavior.
     * @return array
     */
    public function events()
    {
        return [CartSubView::EVENT_BEFORE_RENDERING_CART => [$this, 'handleBeforeRenderingCart'],
                CartSubView::EVENT_BEFORE_RENDERING_CART_ROW => [$this, 'handleBeforeRenderingCartRow']];
    }
    
    /**
     * Process before confirm form rendering
     * @param CartEvent $event
     */
    public function handleBeforeRenderingCart($event)
    {
        
    }
    
    /**
     * Process before confirm form rendering cart row
     * @param CartEvent $event
     */
    public function handleBeforeRenderingCartRow($event)
    {
        
    }
}
