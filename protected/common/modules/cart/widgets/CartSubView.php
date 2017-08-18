<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\widgets;

use usni\UsniAdaptor;
use usni\library\utils\Html;
use common\utils\ApplicationUtil;
use cart\models\Cart;
use cart\behaviors\CartSubViewBehavior;
use cart\events\CartEvent;
/**
 * CartSubView class file.
 * 
 * @package cart\widgets
 */
class CartSubView extends \yii\bootstrap\Widget
{
    const EVENT_BEFORE_RENDERING_CART = 'beforeRenderingCart';
    const EVENT_BEFORE_RENDERING_CART_ROW = 'beforeRenderingCartRow';
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [CartSubViewBehavior::className()]);
    }
    
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
     * Shopping cart
     * @var Cart 
     */
    public $cart;
    
    /**
     * Layout for the cart view
     * @var string 
     */
    public $layout = "{cart}\n{buttons}";
    
    /**
     * Full view file path
     * @var string 
     */
    public $fullView;
    
    /**
     * Item view file path
     * @var string 
     */
    public $itemView;
    
    /**
     * Button view file path
     * @var string 
     */
    public $buttonView;
    
    /**
     * @var boolean is rendered on confirm screen
     */
    public $isConfirm = false;


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
        $this->totalUnitPrice       = $this->cart->getTotalUnitPrice();
        $this->totalTax             = $this->cart->getTax();
        $this->products             = $this->cart->getProducts();
        $this->itemCount            = $this->cart->getTotalQuantity();
    }
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        return $content;
    }
    
    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{summary}`, `{items}`.
     * @return string|boolean the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{cart}':
                return $this->renderCart();
            case '{buttons}':
                return $this->renderButtons();
            default:
                return false;
        }
    }
    
    /**
     * Get cart details
     * @return string
     */
    protected function renderCart()
    {
        return $this->getView()->render($this->fullView, $this->getFullViewParams());
    }
    
    /**
     * Get full view params
     * @return array
     */
    protected function getFullViewParams()
    {
        $this->totalPrice       = $this->totalUnitPrice + $this->totalTax + $this->shippingPrice;
        $this->totalPrice       = number_format($this->totalPrice, 2, ".", "");
        $params = ['items' => $this->getRows(), 
                    'isEmpty' => $this->isEmpty, 
                    'totalUnitPrice' => $this->totalUnitPrice, 
                    'totalTax' => $this->totalTax, 
                    'totalPrice' => $this->totalPrice,
                    'products' => $this->products, 
                    'shippingPrice' => $this->shippingPrice,
                    'cart'  => $this->cart,
                    'itemCount' => $this->itemCount,
                    'currencyCode' => $this->getCurrencyCode(),
                    'isConfirm' => $this->isConfirm
                  ];
        return $this->beforeRenderingCart($params);
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
                $viewParams = ['item' => $item, 'currencyCode' => $this->getCurrencyCode(),
                                                                       'isConfirm' => $this->isConfirm];
                $viewParams = $this->beforeRenderingCartRow($viewParams);
                $content .= $this->getView()->render($this->itemView, $viewParams);
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
        return Html::tag('p', UsniAdaptor::t('cart', 'Your shopping cart is empty!'), ['class' => 'text-center']);
    }


    /**
     * Render buttons
     * @return string
     */
    protected function renderButtons()
    {
        $buttonViewFile = $this->buttonView;
        if($buttonViewFile != null)
        {
            $products = $this->products;
            return $this->getView()->render($this->buttonView, ['products' => $products]);
        }
        return null;
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
    public function getCurrencyCode()
    {
        return UsniAdaptor::app()->currencyManager->selectedCurrency;
    }
    
    /**
     * Before rendering cart.
     * @param array $viewParams
     * @return array
     */
    public function beforeRenderingCart($viewParams)
    {
        $event = new CartEvent(['viewParams' => $viewParams, 'cart' => $this->cart]);
        $this->trigger(self::EVENT_BEFORE_RENDERING_CART, $event);
        return $event->viewParams;
    }
    
    /**
     * Before rendering cart row.
     * @param array $viewParams
     * @return array
     */
    public function beforeRenderingCartRow($viewParams)
    {
        $event = new CartEvent(['viewParams' => $viewParams]);
        $this->trigger(self::EVENT_BEFORE_RENDERING_CART_ROW, $event);
        return $event->viewParams;
    }
}