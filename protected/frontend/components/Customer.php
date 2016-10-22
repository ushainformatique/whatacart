<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

use cart\models\Cart;
use cart\models\Checkout;
use usni\UsniAdaptor;
use customer\models\Customer as CustomerModel;
use wishlist\models\Wishlist;
use products\models\CompareProducts;
use common\utils\ApplicationUtil;
/**
 * Customer class file.
 * 
 * @package frontend\components
 */
class Customer extends \yii\base\Component
{
    /**
     * Cart model
     * @var Cart 
     */
    public $cart;
    
    /**
     * WishList model
     * @var Cart 
     */
    public $wishlist;
    
    /**
     * CompareProducts model
     * @var Cart 
     */
    public $compareproducts;
    
    /**
     * Checkout model
     * @var Checkout 
     */
    public $checkout;
    
    /**
     * Logged in customer id
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
            $this->cart = new Cart();
        }        
        if($this->checkout == null)
        {
            $this->checkout = new Checkout();
        }
        if($this->wishlist == null)
        {
            $this->wishlist = new Wishlist();
        }
        if($this->compareproducts == null)
        {
            $this->compareproducts = new CompareProducts();
        }
        $this->customerId = ApplicationUtil::getCustomerId();
    }
    
    /**
     * Updates session
     * @return void
     */
    public function updateSession($property, $value)
    {
        $this->$property    = $value;
        $this->customerId   = ApplicationUtil::getCustomerId();
        $storeId = UsniAdaptor::app()->storeManager->getCurrentStore()->id;
        UsniAdaptor::app()->getSession()->set('customer_' . $storeId . '_' . $this->customerId, serialize($this));
        $this->updateMetadata();
    }
    
    /**
     * Updates metadata in db
     * @return void
     */
    protected function updateMetadata()
    {
        $customer           = CustomerModel::findOne($this->customerId);
        $metadata           = $customer->metadata;
        $cartInfo           = serialize($this->cart->itemsList);
        $metadata->customer_id = $this->customerId;
        $metadata->cart     = $cartInfo;
        $metadata->wishlist = serialize($this->wishlist->itemsList);
        $metadata->compareproducts = serialize($this->compareproducts->itemsList);
        $metadata->save();
    }
}