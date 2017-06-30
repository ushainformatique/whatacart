<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace wishlist\widgets;

use usni\UsniAdaptor;
use usni\library\utils\Html;
use common\utils\ApplicationUtil;
/**
 * WishlistSubView renders wishlist for the user.
 * 
 * @package wishlist\widgets
 */
class WishlistSubView extends \yii\bootstrap\Widget
{
    /**
     * Is wishlist empty
     * @var boolean 
     */
    public $isEmpty;
    
    /**
     * Items in the wishlist
     * @var mixed 
     */
    public $items;
    
    /**
     * Count of items
     * @var int 
     */
    public $itemCount;
    
    /**
     * Products in the wishlist
     * @var array 
     */
    public $products;
    
    /**
     * @var string 
     */
    public $fullView = '/_details';
    
    /**
     * @var string 
     */
    public $itemView = '/_item';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $wishList               = ApplicationUtil::getWishList();
        $this->itemCount        = $wishList->getCount();
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->getView()->render($this->fullView, ['items' => $this->getRows(), 'isEmpty' => $this->isEmpty]);
    }
    
    /**
     * Get rows content for the cart
     * @return string
     */
    protected function getRows()
    {
        $content  = null;
        $products = $this->products;
        if(!empty($products))
        {
            $this->isEmpty = false;
            foreach($products as $item)
            {
                $content .= $this->getView()->render($this->itemView, ['item' => $item]);
            }
        }
        else
        {
            $this->isEmpty = true;
            $content = Html::tag('p', UsniAdaptor::t('wishlist', 'Your wish list is empty!'));
        }
        return $content;
    }
}