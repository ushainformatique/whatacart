<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace wishlist\models;

use usni\library\utils\ArrayUtil;
use usni\UsniAdaptor;
/**
 * Class storing the data in the wishlist
 * 
 * @package cart\models
 */
class Wishlist extends \yii\base\Component
{
    /**
     * Wishlist item list
     * @var integer 
     */
    public $itemsList = [];
    
    /**
     * Adds item to the cart.
     * @param int $productId
     * @param float $price
     */
    public function addItem($productId)
    {
        $this->itemsList[]  = $productId;
        $this->itemsList    = array_unique($this->itemsList);
        $this->updateSession();
    }
    
    /**
     * Remove item.
     * @param int $productId
     */
    public function removeItem($productId)
    {
        $key = array_search($productId, $this->itemsList);
        ArrayUtil::remove($this->itemsList, $key);
        $this->updateSession();
    }
    
    /**
     * Get count of items in the cart
     * @return integer
     */
    public function getCount()
    {
        return count($this->itemsList);
    }
    
    /**
     * Updates session
     * @return void
     */
    public function updateSession()
    {
        if(UsniAdaptor::app()->user->isGuest)
        {
            UsniAdaptor::app()->guest->updateSession('wishlist', $this);
        }
        else
        {
            UsniAdaptor::app()->customer->updateSession('wishlist', $this);
        }
    }
}
