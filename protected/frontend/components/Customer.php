<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

use cart\models\Cart;
use cart\models\Checkout;
use usni\UsniAdaptor;
use wishlist\models\Wishlist;
use products\models\CompareProducts;
use customer\business\Manager as CustomerBusinessManager;
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
        $this->customerId = UsniAdaptor::app()->user->getId();
    }
    
    /**
     * Updates session
     * @return void
     */
    public function updateSession($property, $value)
    {
        $this->$property    = $value;
        $storeId = UsniAdaptor::app()->storeManager->selectedStoreId;
        UsniAdaptor::app()->session->set('customer_' . $storeId . '_' . $this->customerId, serialize($this));
        CustomerBusinessManager::getInstance(['userId' => $this->customerId])->updateMetadata($this->cart, $this->wishlist, $this->compareproducts);
    }
}