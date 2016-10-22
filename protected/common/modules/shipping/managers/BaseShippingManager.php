<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\managers;

/**
 * Base class for shipping manager.
 * @package common\modules\shipping\managers
 */
abstract class BaseShippingManager extends \yii\base\Component
{   
    /**
     * Get calculate price for the shipping
     * @param Cart $cart
     */
    abstract public function getCalculatedPrice($cart);
    
    /**
     * Get dropdown description for the shipping
     * @param $language Language in which description should be displayed
     */
    abstract public function getDescription($language = null);
}
?>