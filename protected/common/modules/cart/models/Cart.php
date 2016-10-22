<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\models;

use usni\library\utils\ArrayUtil;
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use products\models\ProductOptionValue;
use cart\utils\CartUtil;
use common\modules\order\utils\OrderUtil;
use products\models\ProductOption;
use products\models\ProductOptionTranslated;
use products\models\ProductOptionValueTranslated;
use products\models\Product;
use common\modules\stores\utils\StoreUtil;
/**
 * Class storing the data in the cart
 * 
 * @package cart\models
 */
class Cart extends \yii\base\Model
{
    /**
     * Cart item list
     * @var integer 
     */
    public $itemsList = [];
    
    /**
     * Get total quantiy for product in the cart
     * @param Product $product
     * @return int
     */
    public function getTotalQuantityForProduct($product)
    {
        $totalQty = 0;
        foreach($this->itemsList as $itemCode => $data)
        {
            if($data['product_id'] == $product['id'])
            {
                $totalQty += $data['qty'];
            }
        }
        return $totalQty;
    }
    
    /**
     * Update price for the product when adding a new item impacts the product final price
     * based on discounts
     * @param Product $product
     * @param float $price
     */
    public function updatePriceForProduct($product, $price)
    {
        foreach($this->itemsList as $itemCode => $data)
        {
            if($data['product_id'] == $product['id'])
            {
                $priceExcludingTax                          = $price + $data['options_price'];
                $tax                                        = ProductUtil::getTaxAppliedOnProduct($product, static::getCustomer(), $priceExcludingTax);
                $this->itemsList[$itemCode]['price']        = $priceExcludingTax;
                $this->itemsList[$itemCode]['total_price']  = $priceExcludingTax + $tax;
            }
        }
    }
    
    /**
     * Adds item to the cart.
     * @param Product $product
     * @param int $qty
     * @param float $optionsPrice
     * @param Array $options
     */
    public function addItem($product, $qty, $optionsPrice, $options = [])
    {
        //Get the total quantity for product in the cart already available
        $totalQtyAvailable = $this->getTotalQuantityForProduct($product);
        /*
         * Here we need to check if product is already there in the cart even with different options i.e. different item code
         * we need to get the quantity of the product in the cart + input quantity and check if total quantity is >=
         * the minimum quantity for the dicsount, than final price would be the discounted price.
         * 
         * The quantity to get the final price should use the totalQuantity in cart and not the input quanity
         */
        $totalQtyAvailable  += $qty;
        $priceExcludingTax  = ProductUtil::getFinalPrice($product, static::getCustomer(), $totalQtyAvailable);
        
        //Update other items in the cart related to the product with the latest price
        $this->updatePriceForProduct($product, $priceExcludingTax);
        
        //Process the currently added item
        $itemCode       = CartUtil::getItemCode($product['id'], $options);
        $availableData  = ArrayUtil::getValue($this->itemsList, $itemCode, false);
        if($availableData === false)
        {
            $this->itemsList[$itemCode]['qty'] = $qty;
        }
        else
        {
            $this->itemsList[$itemCode]['qty'] = $availableData['qty'] + $qty;
        }
        
        $optionData         = [];
        if(!empty($options))
        {
            $priceExcludingTax += $optionsPrice;
            foreach($options as $optionId => $optionValue)
            {
                if(!is_array($optionValue))
                {
                    $optionRecord = $this->getOptionRecordByOptionValue($optionValue);
                    //We need to do this so that by mistake if name is same but ids are different, wrong values are not displayed
                    $optionData[$optionRecord['id']][$optionRecord['name']][] =  $optionRecord['value'];
                }
                else
                {
                    foreach($optionValue as $value)
                    {
                        $optionRecord = $this->getOptionRecordByOptionValue($value);
                        $optionData[$optionRecord['id']][$optionRecord['name']][] =  $optionRecord['value'];
                    }
                }
            }
        }
        //$optionData = [6 => ['Color' => ['Red']], 7 => ['Texture' => ['o1']], 8 => ['Shape' => ['Round', 'Cube']]];
        $optionStr  = OrderUtil::getOptionStringByOptionData($optionData);
        
        $optionData = serialize($optionData);
        $tax                                   = ProductUtil::getTaxAppliedOnProduct($product, static::getCustomer(), $priceExcludingTax);
        $this->itemsList[$itemCode]['price']   = $priceExcludingTax;
        $this->itemsList[$itemCode]['options_price']   = $optionsPrice;
        $this->itemsList[$itemCode]['name']    = $product['name'];
        $this->itemsList[$itemCode]['requires_shipping']    = $product['requires_shipping'];
        $this->itemsList[$itemCode]['selectedOptions'] = $optionStr;
        $this->itemsList[$itemCode]['optionsData'] = $optionData;
        $this->itemsList[$itemCode]['options'] = serialize($options);
        $this->itemsList[$itemCode]['product_id'] = $product['id'];
        $this->itemsList[$itemCode]['model']   = $product['model'];
        $this->itemsList[$itemCode]['tax']     = $tax;
        $this->itemsList[$itemCode]['total_price'] = $priceExcludingTax + $tax;
        $this->itemsList[$itemCode]['thumbnail'] = $product['image'];
        $this->itemsList[$itemCode]['item_code'] = $itemCode;
        $this->itemsList[$itemCode]['stock_status'] = $product['stock_status'];
        $this->updateSession();
    }
    
    /**
     * Get option record by option value
     * @param string $optionValue
     * @return array
     */
    protected function getOptionRecordByOptionValue($optionValue)
    {
        $language        = UsniAdaptor::app()->languageManager->getContentLanguage();
        $poTableName     = ProductOption::tableName();
        $poTrTableName   = ProductOptionTranslated::tableName();
        $povTableName    = ProductOptionValue::tableName();
        $povTrTableName  = ProductOptionValueTranslated::tableName();
        return ProductOptionValue::find()
                            ->select([$poTableName . '.id', $poTrTableName . '.name', $povTrTableName . '.value'])
                            ->innerJoin($poTableName, $poTableName . '.id = ' . $povTableName . '.option_id')
                            ->innerJoin($poTrTableName, $poTrTableName . '.owner_id = ' . $poTableName . '.id')
                            ->innerJoin($povTrTableName, $povTrTableName . '.owner_id = ' . $povTableName . '.id')
                            ->where($povTableName . '.id = :id AND ' . $poTrTableName . '.language = :lan1 AND ' . $povTrTableName . '.language = :lan2', 
                                    [':id' => $optionValue, ':lan1' => $language, ':lan2' => $language])
                            ->asArray()->one();
    }


    /**
     * Remove item.
     * @param int $itemCode
     */
    public function removeItem($itemCode)
    {
        $availableData = ArrayUtil::getValue($this->itemsList, $itemCode, false);
        if($availableData !== false)
        {
            unset($this->itemsList[$itemCode]);
            $productId = $availableData['product_id'];
            $product   = Product::find()->where('id = :id', [':id' => $productId])->asArray()->one();
            //Get the total quantity for product in the cart already available
            $totalQtyAvailable = $this->getTotalQuantityForProduct($product);
            /*
             * Here we need to check if product is already there in the cart even with different options i.e. different item code
             * we need to get the quantity of the product in the cart and check if total quantity is >=
             * the minimum quantity for the discount, than final price would be the discounted price.
             * 
             * The quantity to get the final price should use the totalQuantity in cart
             */
            $priceExcludingTax  = ProductUtil::getFinalPrice($product, static::getCustomer(), $totalQtyAvailable);

            //Update other items in the cart related to the product with the latest price
            $this->updatePriceForProduct($product, $priceExcludingTax);
        }
        $this->updateSession();
    }
    
    /**
     * Get count of items in the cart
     * @return integer
     */
    public function getCount()
    {
        $totalCnt = 0;
        foreach($this->itemsList as $product => $data)
        {
            $totalCnt += $data['qty'];
        }
        return $totalCnt;
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
        foreach($this->itemsList as $product => $data)
        {
            if((bool)$data['requires_shipping'])
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
        $currencyCode           = $this->getSelectedCurrency();
        $defaultCurrencyCode    = UsniAdaptor::app()->currencyManager->getDefault();
        $totalPrice = 0.0;
        foreach($this->itemsList as $product => $data)
        {
            $priceByCurrency        = ProductUtil::getPriceByCurrency($data['total_price'], $defaultCurrencyCode, $currencyCode);
            $totalPrice += $data['qty'] * $priceByCurrency;
        }
        return number_format($totalPrice, 2, ".", "");
    }
    
    /**
     * Get tax in the cart
     * @return float
     */
    public function getTax()
    {
        $currencyCode           = $this->getSelectedCurrency();
        $defaultCurrencyCode    = UsniAdaptor::app()->currencyManager->getDefault();
        $totalTax               = 0.0;
        foreach($this->itemsList as $product => $data)
        {
            $priceByCurrency = ProductUtil::getPriceByCurrency($data['tax'], $defaultCurrencyCode, $currencyCode);
            $totalTax += $data['qty'] * $priceByCurrency;
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
        return ProductUtil::getPriceWithSymbol($totalPrice);
    }
    
    /**
     * Get customer
     * @return Customer
     */
    public function getCustomer()
    {
        return UsniAdaptor::app()->user->getUserModel();
    }
    
    /**
     * Get item count in cart
     * @param Product $product
     * @param Array $options
     * @return int
     */
    public function getItemCountInCart($product, $options = [])
    {
        $itemCode = CartUtil::getItemCode($product['id'], $options);
        $availableData  = ArrayUtil::getValue($this->itemsList, $itemCode, false);
        if($availableData === false)
        {
            return 0;
        }
        else
        {
            return $availableData['qty'];
        }
    }
    
    /**
     * Get unit price in the cart
     * @return float
     */
    public function getTotalUnitPrice()
    {
        $currencyCode           = $this->getSelectedCurrency();
        $defaultCurrencyCode    = UsniAdaptor::app()->currencyManager->getDefault();
        $totalPrice = 0.0;
        foreach($this->itemsList as $product => $data)
        {
            $priceByCurrency        = ProductUtil::getPriceByCurrency($data['price'], $defaultCurrencyCode, $currencyCode);
            $totalPrice += $data['qty'] * $priceByCurrency;
        }
        return number_format($totalPrice, 2, ".", "");
    }
    
    /**
     * Based on the conditions check if user can proceed for checkout
     * @return boolean
     */
    public function shouldProceedForCheckout()
    {
        $outOfStockCheckoutSettings  = StoreUtil::getSettingValue('allow_out_of_stock_checkout');
        foreach ($this->itemsList as $item)
        {
            if(!$outOfStockCheckoutSettings && $item['stock_status'] == ProductUtil::OUT_OF_STOCK)
            {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Get selected currency
     * @return string
     */
    public function getSelectedCurrency()
    {
        return UsniAdaptor::app()->currencyManager->getDisplayCurrency();
    }
}