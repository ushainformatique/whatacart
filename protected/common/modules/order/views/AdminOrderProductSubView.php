<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\UsniAdaptor;
use common\modules\order\utils\OrderUtil;
use usni\library\components\UiHtml;
/**
 * AdminOrderProductSubView class file. This would be used on order detail view, product tab in admin
 * @package cart\views
 */
class AdminOrderProductSubView extends \usni\library\views\UiView
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
     * Get rows content for the cart
     * @return string
     */
    protected function getRows()
    {
        $products             = OrderUtil::getOrderProducts($this->order['id'], true);
        $content              = null;
        $totalUnitPrice       = 0;
        $totalTax             = 0;
        if(!empty($products))
        {
            foreach($products as $data)
            {
                $content .= $this->getView()->renderPhpFile($this->getItemViewFile(), ['data' => $data, 'currencyCode'  => $this->order['currency_code']]);
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
     * @inheritdoc
     */
    protected function getItemViewFile()
    {
        return UsniAdaptor::getAlias('@common/modules/order/views/_orderItem.php');
    }
    
    /**
     * @inheritdoc
     */
    protected function getFullViewFile()
    {
        return UsniAdaptor::getAlias('@common/modules/order/views/_orderProductDetails.php');
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
        return ['items' => $items, 
                'isEmpty' => false, 
                'totalUnitPrice' => $this->totalUnitPrice, 
                'totalTax' => $this->totalTax, 
                'totalPrice' => $this->totalPrice,
                'shippingPrice' => $this->shippingPrice,
                'currencyCode'  => $this->order['currency_code']
                ];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        return $this->getView()->renderPhpFile($this->getFullViewFile(), $this->getFullViewParams());
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
}