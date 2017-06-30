<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\web;

use yii\web\UserEvent;
use usni\UsniAdaptor;
use cart\models\Cart;
use wishlist\models\Wishlist;
use products\models\CompareProducts;
use customer\business\Manager;
use common\utils\ApplicationUtil;
use cart\models\Item;
use cart\models\ItemCollection;

/**
 * CustomerBehavior extends the functionality related to User component for the front end customer. It would also handle
 * afterLogin event raised by the application.
 * 
 * @package frontend\web
 */
class CustomerBehavior extends \usni\library\web\UserBehavior
{
    /**
     * Called after successfully logging into the system.
     * @param UserEvent $event
     */
    public function processAfterLogin(UserEvent $event)
    {
        $this->populateCustomerCartMetadataInSession();
        $this->populateCustomerWishlistMetadataInSession();
        $this->populateCustomerCompareProductsMetadataInSession();
        UsniAdaptor::app()->guest->updateSession('cart', new Cart());
        UsniAdaptor::app()->guest->updateSession('wishlist', new Wishlist());
        UsniAdaptor::app()->guest->updateSession('compareproducts', new CompareProducts());
        parent::processAfterLogin($event);
    }
    
    /**
     * Populate customer metadata in session
     * @return void
     */
    public function populateCustomerCartMetadataInSession()
    {
        $itemsList = Manager::getInstance()->getMetadataItems('cart'); 
        if(UsniAdaptor::app()->customer instanceof \frontend\components\Customer)
        {
            $customerItemCollection = new ItemCollection();
            foreach($itemsList as $itemCode => $record)
            {
                $item = $this->createItem($record);
                $customerItemCollection->add($item);
            }
            $cart             = ApplicationUtil::getCart();
            $cart->itemsList  = $customerItemCollection;
            UsniAdaptor::app()->customer->updateSession('cart', $cart);
        }
        
    }
    
    /**
     * Create item from array record
     * @param array $record
     * @return Item
     */
    public function createItem($record)
    {
        $item = new Item();
        $keys = array_keys($record);
        foreach($keys as $key)
        {
            $func = 'set' . ucfirst($key);
            $item->$func($record[$key]);
        }
        return $item;
    }
    
    /**
     * Populate customer metadata in session
     * @return void
     */
    public function populateCustomerWishlistMetadataInSession()
    {
        $itemsList = Manager::getInstance()->getMetadataItems('wishlist');
        if(UsniAdaptor::app()->customer != null)
        {
            $wishList         = UsniAdaptor::app()->customer->wishlist;
            $wishList->itemsList  = $itemsList;
            UsniAdaptor::app()->customer->updateSession('wishlist', $wishList);
        }
    }
    
    /**
     * Populate customer metadata in session
     * @return void
     */
    public function populateCustomerCompareProductsMetadataInSession()
    {
        $itemsList = Manager::getInstance()->getMetadataItems('compareproducts');
        $compareproducts    = UsniAdaptor::app()->customer->compareproducts;
        $compareproducts->itemsList  = $itemsList;
        UsniAdaptor::app()->customer->updateSession('compareproducts', $compareproducts);
    }
}