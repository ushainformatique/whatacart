<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\traits;
 
use common\modules\shipping\components\ShippingFactory;
use common\modules\shipping\dao\ShippingDAO;
use cart\models\Cart;
use common\modules\order\models\Order;
/**
 * Implement common functions related to shipping
 *
 * @package common\modules\shipping\traits
 */
trait ShippingTrait
{
    /**
     * Get calculated price by type
     * @param string $type
     * @param Cart $cart
     * @return float
     */
    public function getCalculatedPriceByType($type, $cart)
    {
        $shippingFactory = new ShippingFactory(['type' => $type]);
        $instance        = $shippingFactory->getInstance();
        $price           = $instance->getCalculatedPrice($cart);
        return number_format($price, 2, ".", "");
    }
    
    /**
     * Get shipping methods.
     * @return array
     */
    public function getShippingMethods()
    {
        $models = ShippingDAO::getMethods($this->language);
        $data   = [];
        foreach($models as $model)
        {
            $shippingFactory = new ShippingFactory(['type' => $model['code']]);
            $instance        = $shippingFactory->getInstance();
            $data[$model['code']] = $instance->getDescription();
        }
        return $data;
    }
    
    /**
     * Check if shipping method allowed to deactivate.
     * @return boolean
     */
    public function checkIfShippingMethodAllowedToDeactivate($code)
    {
        $count = Order::find()->where('shipping = :shipping', [':shipping' => $code])->count();
        if($count > 0)
        {
            return false;
        }
        return true;
    }
}
