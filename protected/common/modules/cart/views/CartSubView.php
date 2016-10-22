<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\library\views\UiView;
use cart\utils\CartUtil;
use frontend\utils\FrontUtil;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use common\utils\ApplicationUtil;
/**
 * CartSubView class file.
 * 
 * @package cart\views
 */
class CartSubView extends UiView
{
    /**
     * Is cart empty
     * @var boolean 
     */
    public $isEmpty;
    
    /**
     * Total unit price in the cart
     * @var float 
     */
    public $totalUnitPrice = 0;
    
    /**
     * Total tax price in the cart
     * @var float 
     */
    public $totalTax = 0;
    
    /**
     * Total price in the cart
     * @var float 
     */
    public $totalPrice = 0;
    
    /**
     * Products in the cart
     * @var array 
     */
    public $products;
    
    /**
     * Total shipping price in the cart
     * @var float 
     */
    public $shippingPrice = 0;
    
    /**
     * Item count in the cart
     * @var int 
     */
    public $itemCount = 0;
    
    /**
     * Formatted cost 
     * @var string 
     */
    public $formattedCost;
    
    /**
     * Shopping cart
     * @var Cart 
     */
    public $cart;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->cart == null)
        {
            $this->cart         = $this->getCart();
        }
        $this->totalUnitPrice   = $this->cart->getTotalUnitPrice();
        $this->totalTax         = $this->cart->getTax();
        $this->products         = CartUtil::getProducts($this->cart);
        $this->itemCount        = $this->cart->getCount();
        $this->formattedCost    = $this->cart->getFormattedAmount();
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $rowContent = $this->getCartDetails();
        $buttonContent = $this->getButtons();
        return $rowContent . $buttonContent;
    }
    
    /**
     * Get cart details
     * @return string
     */
    protected function getCartDetails()
    {
        return $this->getView()->renderPhpFile($this->getFullViewFile(), $this->getFullViewParams());
    }
    
    /**
     * Get full view params
     * @return array
     */
    protected function getFullViewParams()
    {
        $this->totalPrice       = $this->totalUnitPrice + $this->totalTax + $this->shippingPrice;
        $this->totalPrice       = number_format($this->totalPrice, 2, ".", "");
        return ['items' => $this->getRows(), 
                'isEmpty' => $this->isEmpty, 
                'totalUnitPrice' => $this->totalUnitPrice, 
                'totalTax' => $this->totalTax, 
                'totalPrice' => $this->totalPrice,
                'products' => $this->products, 
                'shippingPrice' => $this->shippingPrice,
                'cart'  => $this->cart,
                'itemCount' => $this->itemCount,
                'currencyCode' => $this->resolveCurrencyCode()
               ];
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
                $content .= $this->getView()->renderPhpFile($this->getItemViewFile(), ['data' => $data, 'currencyCode' => $this->resolveCurrencyCode()]);
            }
        }
        else
        {
            $this->isEmpty = true;
            $content = $this->renderEmptyText();
        }
        return $content;
    }
    
    /**
     * Renders empty text
     * @return string
     */
    protected function renderEmptyText()
    {
        return UiHtml::tag('p', UsniAdaptor::t('cart', 'Your shopping cart is empty!'), ['class' => 'text-center']);
    }


    /**
     * Get buttons
     * @return string
     */
    protected function getButtons()
    {
        $buttonViewFile = $this->getButtonViewFile();
        if($buttonViewFile != null)
        {
            $products = $this->products;
            return $this->getView()->renderPhpFile($this->getButtonViewFile(), ['products' => $products]);
        }
        return null;
    }
    
    /**
     * Get item view file
     * @return string
     */
    protected function getItemViewFile()
    {
        $frontTheme         = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $frontTheme . '/views/cart/_item.php');
    }
    
    /**
     * Get button view file
     * @return string
     */
    protected function getButtonViewFile()
    {
        $frontTheme         = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $frontTheme . '/views/cart/_cartbuttons.php');
    }
    
    /**
     * Get full view file
     * @return string
     */
    protected function getFullViewFile()
    {
        $frontTheme         = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $frontTheme . '/views/cart/_cartdetails.php');
    }
    
    /**
     * Get cart
     * @return Cart
     */
    protected function getCart()
    {
        return ApplicationUtil::getCart();
    }
    
    /**
     * Resolve currency code
     * @return string
     */
    protected function resolveCurrencyCode()
    {
        return UsniAdaptor::app()->currencyManager->getDisplayCurrency();
    }
}