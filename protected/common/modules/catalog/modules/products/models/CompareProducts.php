<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\models;

use usni\library\utils\ArrayUtil;
use usni\UsniAdaptor;
/**
 * Class storing the data for the compare products
 * 
 * @package products\models
 */
class CompareProducts extends \yii\base\Component
{
    /**
     * Compare products item list
     * @var integer 
     */
    public $itemsList = [];
    
    /**
     * Adds item to the compare products.
     * @param int $productId
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
            UsniAdaptor::app()->guest->updateSession('compareproducts', $this);
        }
        else
        {
            UsniAdaptor::app()->customer->updateSession('compareproducts', $this);
        }
    }
}
