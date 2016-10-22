<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace wishlist\views;

use usni\library\views\UiView;
use wishlist\utils\WishlistUtil;
use frontend\utils\FrontUtil;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use common\utils\ApplicationUtil;
/**
 * WishlistSubView class file.
 * @package wishlist\views
 */
class WishlistSubView extends UiView
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
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $wishList               = ApplicationUtil::getWishList();
        $this->products         = WishlistUtil::getProducts();
        $this->itemCount        = $wishList->getCount();
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        return $this->getDetails();
    }
    
    /**
     * Get wishlist details
     * @return string
     */
    protected function getDetails()
    {
        return $this->getView()->renderPhpFile($this->getFullViewFile(), ['items' => $this->getRows(), 'isEmpty' => $this->isEmpty]);
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
            foreach($products as $data)
            {
                $content .= $this->getView()->renderPhpFile($this->getItemViewFile(), ['data' => $data]);
            }
        }
        else
        {
            $this->isEmpty = true;
            $content = UiHtml::tag('p', UsniAdaptor::t('wishlist', 'Your wish list is empty!'));
        }
        return $content;
    }
    
    /**
     * Get item view file
     * @return string
     */
    protected function getItemViewFile()
    {
        $frontTheme         = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $frontTheme . '/views/wishlist/_item.php');
    }
    
    /**
     * Get full view file
     * @return string
     */
    protected function getFullViewFile()
    {
        $frontTheme         = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $frontTheme . '/views/wishlist/_details.php');
    }
}