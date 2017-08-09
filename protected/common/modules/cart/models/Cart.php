<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\models;

use usni\UsniAdaptor;
use products\models\Product;
use cart\models\ItemCollection;
use products\behaviors\PriceBehavior;
/**
 * Class storing the data in the cart
 * 
 * @package cart\models
 */
class Cart extends \yii\base\Model
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            PriceBehavior::className(),
        ];
    }
    
    /**
     * Cart item list
     * @var ItemCollection 
     */
    public $itemsList;
    
    /**
     * inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        if(empty($this->itemsList))
        {
            $this->itemsList = new ItemCollection();
        }
    }
    
    /**
     * Updates session
     * @return void
     */
    public function updateSession()
    {
        if(UsniAdaptor::app()->user->isGuest)
        {
            UsniAdaptor::app()->guest->updateSession('cart', $this);
        }
        else
        {
            UsniAdaptor::app()->customer->updateSession('cart', $this);
        }
    }
    
    /**
     * Is shipping required
     * @return boolean
     */
    public function isShippingRequired()
    {
        foreach($this->itemsList as $product => $item)
        {
            if((bool)$item->requireShipping)
            {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get cost in the cart
     * @return float
     */
    public function getAmount()
    {
        $totalPrice = 0.0;
        foreach($this->itemsList as $product => $item)
        {
            $totalPrice += $item->qty * $item->totalPrice;
        }
        return number_format($totalPrice, 2, ".", "");
    }
    
    /**
     * Get tax in the cart
     * @return float
     */
    public function getTax()
    {
        $totalTax               = 0.0;
        foreach($this->itemsList as $itemCode => $item)
        {
            $totalTax += $item->qty * $item->tax;
        }
        return number_format($totalTax, 2, ".", "");
    }
    
    /**
     * Get cost in the cart
     * @return float
     */
    public function getFormattedAmount()
    {
        $totalPrice = $this->getAmount();
        return $this->getPriceWithSymbol($totalPrice);
    }
    
    /**
     * Get customer
     * @return Customer
     */
    public function getCustomer()
    {
        return UsniAdaptor::app()->user->getIdentity();
    }
    
    /**
     * Get unit price in the cart
     * @return float
     */
    public function getTotalUnitPrice()
    {
        $totalPrice = 0.0;
        foreach($this->itemsList as $itemCode => $item)
        {
            $totalPrice += $item->qty * $item->price;
        }
        return number_format($totalPrice, 2, ".", "");
    }
    
    /**
     * Based on the conditions check if user can proceed for checkout
     * @return boolean
     */
    public function shouldProceedForCheckout()
    {
        $outOfStockCheckoutSettings  = UsniAdaptor::app()->storeManager->getSettingValue('allow_out_of_stock_checkout');
        foreach ($this->itemsList as $item)
        {
            if(!$outOfStockCheckoutSettings && $item->stockStatus == Product::OUT_OF_STOCK)
            {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Get cart total quantity.
     * @return intreger.
     */
    public function getTotalQuantity()
    {
        $totalQty = 0;
        foreach ($this->itemsList as $itemCode => $item)
        {
            $totalQty += $item->qty;
        }
        return $totalQty;
    }
    
    /**
     * Get products.
     * @return array
     */
    public function getProducts()
    {
        return iterator_to_array($this->itemsList, false);
    }
    
    /**
     * Get option code by options for product
     * @param int $productId
     * @param array $options
     * @return string
     */
    public function getItemCode($productId, $options = [])
    {
        $itemCode = $productId;
        if(!empty($options))
        {
            $optionCode = base64_encode(serialize($options));
            $itemCode .= '_' . $optionCode;
        }
        return $itemCode;
    }
    
    /**
     * Get product id by item code
     * @param string $itemCode
     * @return integer
     */
    public function getProductIdByItemCode($itemCode)
    {
        list($productId, $inputOptions) = $this->getProductAndOptionsByItemCode($itemCode);
        return $productId;
    }
    
    /**
     * Get options by item code
     * @param string $itemCode
     * @return integer
     */
    public function getOptionsByItemCode($itemCode)
    {
        list($productId, $inputOptions) = $this->getProductAndOptionsByItemCode($itemCode);
        return $inputOptions;
    }
    
    /**
     * Get product id and options by item code
     * @param string $itemCode
     * @return string
     */
    public function getProductAndOptionsByItemCode($itemCode)
    {
        if(strpos($itemCode, '_') !== false)
        {
            $data       = explode('_', $itemCode);
            $productId  = $data[0];
            $options    = unserialize(base64_decode($data[1]));
        }
        else
        {
            $productId = $itemCode;
            $options   = [];
        }
        return [$productId, $options];
    }
    
    /**
     * Get option string by option data
     * @param array $optionData
     * @return string representation of option data
     */
    public function getOptionStringByOptionData($optionData)
    {
        $optionStr  = null;
        if(!empty($optionData))
        {
            $keys = array_keys($optionData);
            foreach($keys as $key)
            {
                $value = $optionData[$key];
                $optionName = key($value);
                $optionStr .= $optionName . ": " . implode(',', $value[$optionName]) . "<br/>";
            }
        }
        return $optionStr;
    }
    
    /**
     * Returns the quantity for the itemcode in the collection.
     * @param string $itemCode
     * @return integer quantity for the item.
     */
    public function getItemQuantity($itemCode)
    {
        $item = $this->itemsList->get($itemCode);
        if($item == null)
        {
            return 0;
        }
        return $item->qty;
    }
    
    /**
     * Get total quantity for product in the cart
     * @param int $productId
     * @return int
     */
    public function getTotalQuantityForProduct($productId)
    {
        $totalQty = 0;
        foreach($this->itemsList as $itemCode => $item)
        {
            if($item->productId == $productId)
            {
                $totalQty += $item->qty;
            }
        }
        return $totalQty;
    }
}
