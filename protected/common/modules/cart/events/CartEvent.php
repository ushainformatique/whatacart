<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\events;

use cart\models\Cart;
/**
 * CartEvent class file
 *
 * @package cart\events
 */
class CartEvent extends \yii\base\Event
{
    /**
     * Full view params configured
     * @var array 
     */
    public $viewParams;
    
    /**
     * @var Cart 
     */
    public $cart;
}
