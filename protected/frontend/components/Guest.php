<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

use usni\UsniAdaptor;
use cart\models\Cart;
use cart\models\Checkout;
use wishlist\models\Wishlist;
use products\models\CompareProducts;
/**
 * Guest class file.
 * 
 * @package frontend\components
 */
class Guest extends \yii\base\Component
{
    /**
     * Cart model
     * @var Cart 
     */
    public $cart;
    
    /**
     * Wishlist model
     * @var Wishlist
     */
    public $wishlist;
    
    /**
     * CompareProducts model
     * @var CompareProducts
     */
    public $compareproducts;
    
    /**
     * Checkout model
     * @var Cart 
     */
    public $checkout;
    
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
    }
    
    /**
     * Updates session
     * @return void
     */
    public function updateSession($property, $value)
    {
        $this->$property = $value;
        $storeId = UsniAdaptor::app()->storeManager->selectedStoreId;
        UsniAdaptor::app()->getSession()->set('guest_' . $storeId, serialize($this));
    }
}
