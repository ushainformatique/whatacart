<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\utils;

use usni\UsniAdaptor;
use common\utils\ApplicationUtil;
use cart\models\Cart;
use yii\base\Model;
use products\models\CompareProducts;
use cart\models\Checkout;
use wishlist\models\Wishlist;
/**
 * ApplicationUtil class file.
 * 
 * @package common\utils
 */
class ApplicationUtil
{
    /**
     * Get checkout form model.
     * @param string $shortName
     * @return Model
     */
    public static function getCheckoutFormModel($shortName)
    {
        if(UsniAdaptor::app()->user->isGuest)
        {
            return UsniAdaptor::app()->guest->checkout->$shortName;
        }
        else
        {
            return UsniAdaptor::app()->customer->checkout->$shortName;
        }
    }
    
    /**
     * Get cart from the system
     * @return Cart
     */
    public static function getCart()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return UsniAdaptor::app()->guest->cart;
        }
        else
        {
            return UsniAdaptor::app()->customer->cart;
        }
    }
    
    /**
     * Gets checkout.
     * @return Checkout | AdminCheckout
     */
    public static function getCheckout()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return UsniAdaptor::app()->guest->checkout;
        }
        else
        {
            return UsniAdaptor::app()->customer->checkout;
        }
    }
    
    /**
     * Gets wishlist.
     * @return Wishlist
     */
    public static function getWishList()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return UsniAdaptor::app()->guest->wishlist;
        }
        else
        {
            return UsniAdaptor::app()->customer->wishlist;
        }
    }
    
    /**
     * Gets compare products.
     * @return CompareProducts
     */
    public static function getCompareProducts()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return UsniAdaptor::app()->guest->compareproducts;
        }
        else
        {
            return UsniAdaptor::app()->customer->compareproducts;
        }
    }
    
    /**
     * Get customer id.
     * @return int
     */
    public static function getCustomerId()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return 0; 
        }
        else
        {
            return UsniAdaptor::app()->user->getIdentity()->id;
        }
    }
    
    /**
     * Is cart empty
     * @return boolean
     */
    public static function isCartEmpty()
    {
        $cart = ApplicationUtil::getCart();
        if($cart->getCount() == 0)
        {
            return true;
        }
        return false;
    }
}
