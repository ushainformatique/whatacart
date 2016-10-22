<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\models;

use usni\UsniAdaptor;
use customer\models\Customer;
use products\utils\ProductUtil;
use common\modules\order\utils\OrderUtil;
/**
 * Class storing the data in the cart
 * 
 * @package cart\models
 */
class AdminCart extends Cart
{
    /**
     * @inheritdoc
     */
    public function updateSession()
    {
        UsniAdaptor::app()->customer->updateSession('cart', $this);
    }
    
    /**
     * @inheritdoc
     */
    public function getCustomer()
    {
        return Customer::findOne(UsniAdaptor::app()->customer->customerId);
    }
    
    /**
     * Adds order product item to the cart.
     * @param OrderProduct $orderProduct
     * @param Order $order
     */
    public function addOrderProductItem($orderProduct, $order)
    {
        $currencyCode           = $order->currency_code;
        $defaultCurrencyCode    = UsniAdaptor::app()->currencyManager->getDefault();
        if($currencyCode != $defaultCurrencyCode)
        {
            //get price in base currency
            $productPrice = OrderUtil::getPriceByInBaseCurrency($orderProduct['price'], $currencyCode, $order->currency_conversion_value);
            $productTax = OrderUtil::getPriceByInBaseCurrency($orderProduct['tax'], $currencyCode, $order->currency_conversion_value);
            $productOptionsPrice = OrderUtil::getPriceByInBaseCurrency($orderProduct['options_price'], $currencyCode, $order->currency_conversion_value);
        }
        else
        {
            $productPrice = $orderProduct['price'];
            $productTax = $orderProduct['tax'];
            $productOptionsPrice = $orderProduct['options_price'];
        }
        $itemCode   = $orderProduct['item_code'];
        $dbProduct = ProductUtil::getProduct($orderProduct['product_id']);
        $this->itemsList[$itemCode]['price']    = $productPrice;
        $this->itemsList[$itemCode]['qty']      = $orderProduct['quantity'];
        $this->itemsList[$itemCode]['options_price']   = $productOptionsPrice;
        $this->itemsList[$itemCode]['name']    = $orderProduct['name'];
        $this->itemsList[$itemCode]['requires_shipping']    = $dbProduct['requires_shipping'];
        $this->itemsList[$itemCode]['selectedOptions'] = $orderProduct['displayed_options'];
        $this->itemsList[$itemCode]['options'] = $orderProduct['options'];
        $this->itemsList[$itemCode]['product_id'] = $orderProduct['product_id'];
        $this->itemsList[$itemCode]['model']   = $orderProduct['model'];
        $this->itemsList[$itemCode]['tax']     = $productTax;
        $this->itemsList[$itemCode]['total_price'] = $productPrice + $productTax;
        $this->itemsList[$itemCode]['thumbnail'] = $dbProduct['image'];
        $this->itemsList[$itemCode]['item_code'] = $orderProduct['item_code'];
        $this->itemsList[$itemCode]['stock_status'] = $dbProduct['stock_status'];
        $this->updateSession();
    }
}
