<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\behaviors;

use cart\events\CartEvent;
/**
 * OrderEmailProductSubViewBehavior class file.
 * 
 * @package common\modules\order\behaviors
 */
class OrderEmailProductSubViewBehavior extends \cart\behaviors\CartSubViewBehavior
{
    /**
     * Process before confirm form rendering
     * @param CartEvent $event
     */
    public function handleBeforeRenderingCart($event)
    {
        
    }
}