<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\models;

use usni\UsniAdaptor;
use customer\models\Customer;
/**
 * Class storing the data in the cart
 * 
 * @package cart\models
 */
class AdminCart extends Cart
{
    /**
     * @inheritdoc
     */
    public function updateSession()
    {
        UsniAdaptor::app()->customer->updateSession('cart', $this);
    }
    
    /**
     * @inheritdoc
     */
    public function getCustomer()
    {
        return Customer::findOne(UsniAdaptor::app()->customer->customerId);
    }
}
