<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace backend\components;

use cart\models\AdminCart;
use common\modules\order\models\AdminCheckout;
use usni\UsniAdaptor;
/**
 * Customer class file.
 * 
 * @package backend\components
 */
class Customer extends \yii\base\Component
{
    /**
     * AdminCart model
     * @var AdminCart 
     */
    public $cart;
    
    /**
     * Checkout model
     * @var CustomerOrder 
     */
    public $checkout;
    
    /**
     * Selected customer id
     * @var integer 
     */
    public $customerId;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->cart == null)
        {
            $this->cart = new AdminCart();
        }        
        if($this->checkout == null)
        {
            $this->checkout = new AdminCheckout();
        }
    }
    
    /**
     * Updates session
     * @return void
     */
    public function updateSession($property, $value)
    {
        $this->$property    = $value;
        UsniAdaptor::app()->getSession()->set('customer', serialize($this));
    }
}