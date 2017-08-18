<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\widgets;

use usni\UsniAdaptor;
use usni\library\utils\Html;
use common\modules\order\behaviors\AdminOrderProductSubViewBehavior;
use usni\library\utils\ArrayUtil;
use cart\widgets\CartSubView;
use cart\events\CartEvent;
/**
 * AdminOrderProductSubView class file. This would be used on order detail view, product tab in admin
 * 
 * @package common\modules\order\widgets
 */
class AdminOrderProductSubView extends \yii\bootstrap\Widget
{
    /**
     * Total unit price
     * @var float 
     */
    public $totalUnitPrice;
    
    /**
     * Total tax price
     * @var float 
     */
    public $totalTax;
    
    /**
     * Total price
     * @var float 
     */
    public $totalPrice;
    
    /**
     * Total shipping price
     * @var float 
     */
    public $shippingPrice;
    
    /**
     * Associated order
     * @var Order 
     */
    public $order;
    
    /**
     * Should render shipping price. This would be used when order is update and admin cart is displayed. On cart we
     * dont have to show shipping price but in order view we have to.
     * @var bool 
     */
    public $showShippingPrice =  true;
    
    /**
     * Full view file path
     * @var string 
     */
    public $fullView = '@common/modules/order/views/detail/_orderProductDetails.php';
    
    /**
     * Item view file path
     * @var string 
     */
    public $itemView = '@common/modules/order/views/detail/_orderItem.php';
    
    /**
     * Layout for the cart view
     * @var string 
     */
    public $layout = "{cart}";
    
    /**
     * @var string 
     */
    public $language;
    
    /**
     * @var array 
     */
    public $orderProducts;
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return ArrayUtil::merge($behaviors, [AdminOrderProductSubViewBehavior::className()]);
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
            default:
                return false;
        }
    }
    
    /**
     * Get rows content for the cart
     * @return string
     */
    protected function getRows()
    {
        $products             = $this->orderProducts;
        $content              = null;
        $totalUnitPrice       = 0;
        $totalTax             = 0;
        if(!empty($products))
        {
            foreach($products as $data)
            {
                $viewParams = ['data' => $data, 
                                'currencyCode'  => $this->order['currency_code'], 
                                'currencySymbol'  => $this->order['currency_symbol'],
                                'isConfirm'         => true];
                $viewParams = $this->beforeRenderingCartRow($viewParams);
                $content .= $this->getView()->render($this->itemView, $viewParams);
                $totalUnitPrice += $data['price'] * $data['quantity'];
                $totalTax       += $data['tax'] * $data['quantity'];
            }
        }
        else
        {
            $content = $this->renderEmptyText();
        }
        $this->totalUnitPrice = number_format($totalUnitPrice, 2, ".", "");
        $this->totalTax       = number_format($totalTax, 2, ".", "");
        return $content;
    }
    
    /**
     * Get full view params
     * @return array
     */
    protected function getFullViewParams()
    {
        $this->shippingPrice = $this->getShippingPrice();
        $items               = $this->getRows();
        $this->totalPrice    = $this->totalUnitPrice + $this->totalTax + $this->shippingPrice;
        $this->totalPrice    = number_format($this->totalPrice, 2, ".", "");
        $params = [
                    'items'             => $items, 
                    'isEmpty'           => false, 
                    'totalUnitPrice'    => $this->totalUnitPrice, 
                    'totalTax'          => $this->totalTax, 
                    'totalPrice'        => $this->totalPrice,
                    'shippingPrice'     => $this->shippingPrice,
                    'currencyCode'      => $this->order['currency_code'],
                    'currencySymbol'    => $this->order['currency_symbol'],
                    'isConfirm'         => true
               ];
        return $this->beforeRenderingCart($params);
    }
    
    /**
     * @inheritdoc
     */
    protected function renderCart()
    {
        return $this->getView()->render($this->fullView, $this->getFullViewParams());
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
     * Get shipping price.
     * @return double
     */
    protected function getShippingPrice()
    {
        if($this->showShippingPrice)
        {
            return $this->order['shipping_fee'];
        }
        return 0;
    }
    
    /**
     * Before rendering cart.
     * @param array $viewParams
     * @return array
     */
    public function beforeRenderingCart($viewParams)
    {
        $viewParams = ArrayUtil::merge($viewParams, ['order' => $this->order]);
        $event      = new CartEvent(['viewParams' => $viewParams]);
        $this->trigger(CartSubView::EVENT_BEFORE_RENDERING_CART, $event);
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
        $this->trigger(CartSubView::EVENT_BEFORE_RENDERING_CART_ROW, $event);
        return $event->viewParams;
    }
}