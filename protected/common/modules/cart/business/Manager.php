<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\business;

use products\business\SiteManager;
use cart\dto\CartDTO;
use products\dao\OptionDAO;
use cart\models\Item;
use products\models\Product;
use usni\UsniAdaptor;
use yii\helpers\Json;
/**
 * Implements business logic for cart
 *
 * @package cart\business
 */
class Manager extends \common\business\Manager
{
    /**
     * @var SiteManager
     */
    public $productManager;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->productManager = SiteManager::getInstance();
    }
    
    /**
     * Add cart item
     * @param \cart\dto\CartDTO $cartDTO
     */
    public function addItem($cartDTO)
    {
        $postData       = $cartDTO->getPostData();
        $inputOptions   = [];
        if(isset($postData['ProductOptionMapping']['option']))
        {
            $inputOptions = $postData['ProductOptionMapping']['option'];
        }
        
        $product        = $this->productManager->getProduct($postData['product_id'], $this->language);
        $cartDTO->setProduct($product);
        $cartDTO->setQty($postData['quantity']);
        $cartDTO->setInputOptions($inputOptions);
        $result         = $this->validateCartItem($cartDTO);
        if($result['success'] === true)
        {
            $itemCode           = $cartDTO->getCart()->getItemCode($product['id'], $inputOptions);
            /*
             * We need to think following scenarios
             * a) Today i add a product to the cart having base price as 100$ but i dont checkout. Next day
             * when i come to the site a special has started so my price in cart should be 80$
             * b) On the same product a discount is there for 2 or more products with price as 70$, thus if i
             * add another product my cart should show 2 but the price would be 70$
             */
            $optionsPrice       = $this->productManager->getPriceModificationBySelectedOptions($inputOptions, $product['id']);
            //Get the total quantity for product in the cart already available
            $totalQtyAvailable  = $cartDTO->getCart()->getItemQuantity($itemCode);
            /*
             * Here we need to check if product is already there in the cart even with different options i.e. different item code
             * we need to get the quantity of the product in the cart + input quantity and check if total quantity is >=
             * the minimum quantity for the dicsount, than final price would be the discounted price.
             * 
             * The quantity to get the final price should use the totalQuantity in cart and not the input quanity
             */
            $totalQtyAvailable  += $cartDTO->getQty();
            $priceExcludingTax  = $this->productManager->getFinalPrice($product, $totalQtyAvailable);

            //Update other items in the cart related to the product with the latest price
            $this->updatePriceForProduct($cartDTO, $priceExcludingTax);
            
            //Process the currently added item
            $optionData     = $this->prepareOptionsData($inputOptions, $optionsPrice, $priceExcludingTax);
            
            $optionStr      = $cartDTO->getCart()->getOptionStringByOptionData($optionData);
            
            $item           = $cartDTO->getCart()->itemsList->get($itemCode);
            $tax            = $this->productManager->getTaxAppliedOnProduct($product, $priceExcludingTax);
            if($item != null)
            {
                $item->setQty($totalQtyAvailable);
            }
            else
            {
                //Prepare cart item
                $item   = new Item();
                $item->setItemCode($itemCode);
                $item->setOptionsPrice($optionsPrice);
                $item->setPrice($priceExcludingTax);
                $item->setName($product['name']);
                $item->setRequireShipping($product['requires_shipping']);
                $item->setDisplayedOptions($optionStr);
                $item->setOptionsData(serialize($optionData));
                $item->setInputOptions(serialize($cartDTO->getInputOptions()));
                $item->setProductId($product['id']);
                $item->setModel($product['model']);
                $item->setTotalPrice($priceExcludingTax + $tax);
                $item->setThumbnail($product['image']);
                $item->setStockStatus($product['stock_status']);
                $item->setType($product['type']);
                $item->setQty($cartDTO->getQty());
            }
            $item->setTax($tax);
            $cartDTO->getCart()->itemsList->add($item);
        }
        $cartDTO->setResult($result);
    }
    
    /**
     * Validate cart item
     * @param CartDTO $cartDTO
     * @return array
     */
    public function validateCartItem($cartDTO)
    {
        $product            = $cartDTO->getProduct();
        $inputOptions       = $cartDTO->getInputOptions();
        $itemCode           = $cartDTO->getCart()->getItemCode($product['id'], $inputOptions);
        $itemQuantityInCart = $cartDTO->getCart()->getItemQuantity($itemCode);
        //If input quantity plus quantity in cart < min quantity
        if(!ctype_digit($cartDTO->getQty()) ||$itemQuantityInCart + ($cartDTO->getQty()) < $product['minimum_quantity'])
        {
            $result     = ['success' => false, 'errors' => [], 'qtyError' => true];
        }
        else
        {
            $errors  = $this->getErrorsForOptions($cartDTO);
            if(empty($errors))
            {
                $result     = ['success' => true];
            }
            else
            {
                $result     = ['success' => false, 'errors' => $errors, 'qtyError' => false];
            }
        }
        return $result;
    }
    
    /**
     * Get error for options
     * @param CartDTO $cartDTO
     * @return string
     */
    public function getErrorsForOptions($cartDTO)
    {
        $product            = $cartDTO->getProduct();
        $inputOptions       = $cartDTO->getInputOptions();
        $errors             = [];
        $productOptions     = OptionDAO::getOptions($product['id'], $this->language, 1);
        if(!empty($productOptions))
        {
            foreach($productOptions as $productOption)
            {
                $optionId = $productOption['optionId'];
                if(is_array($inputOptions) && isset($inputOptions[$optionId]))
                {
                    $value = $inputOptions[$optionId];
                    if(empty($value))
                    {
                        $errors[$optionId] = [$productOption['display_name'] . ' ' . UsniAdaptor::t('application', 'is required')]; 
                    }
                }
                else
                {
                    $errors[$optionId] = [$productOption['display_name'] . ' ' . UsniAdaptor::t('application', 'is required')]; 
                }
            }
        }
        return $errors;
    }
    
    /**
     * Update price for the product when adding a new item impacts the product final price
     * based on discounts
     * @param CartDTO $cartDTO
     * @param float $price
     */
    public function updatePriceForProduct(CartDTO $cartDTO, $price)
    {
        $cart           = $cartDTO->getCart();
        $product        = $cartDTO->getProduct();
        foreach($cart->itemsList as $itemCode => $item)
        {
            if($item->getProductId() == $product['id'])
            {
                $priceExcludingTax                          = $price + $item->getOptionsPrice();
                $tax                                        = $this->productManager->getTaxAppliedOnProduct($product, 
                                                                                                            $priceExcludingTax);
                $item->setPrice($priceExcludingTax);
                $item->setTotalPrice($priceExcludingTax + $tax);
                $cart->itemsList->add($item);
            }
        }
        $cartDTO->setCart($cart);
    }
    
    /**
     * Prepare options data in the format
     * //$optionData = [6 => ['Color' => ['Red']], 7 => ['Texture' => ['o1']], 8 => ['Shape' => ['Round', 'Cube']]];
     * @param array $options
     * @param float $optionsPrice
     * @param float $priceExcludingTax
     * @return array
     */
    public function prepareOptionsData($options, $optionsPrice, & $priceExcludingTax)
    {
        $optionData     = [];
        if(!empty($options))
        {
            $priceExcludingTax += $optionsPrice;
            foreach($options as $optionId => $optionValue)
            {
                if(!is_array($optionValue))
                {
                    $optionRecord = OptionDAO::getOptionDataByOptionValueId($optionValue, $this->language);
                    //We need to do this so that by mistake if name is same but ids are different, wrong values are not displayed
                    $optionData[$optionRecord['id']][$optionRecord['name']][] =  $optionRecord['value'];
                }
                else
                {
                    foreach($optionValue as $value)
                    {
                        $optionRecord = OptionDAO::getOptionDataByOptionValueId($value, $this->language);
                        $optionData[$optionRecord['id']][$optionRecord['name']][] =  $optionRecord['value'];
                    }
                }
            }
        }
        return $optionData;
    }
    
    /**
     * Remove item.
     * @param int $itemCode
     * @param CartDTO $cartDTO
     */
    public function removeItem($itemCode, $cartDTO)
    {
        $item = $cartDTO->getCart()->itemsList->get($itemCode);
        $cartDTO->getCart()->itemsList->remove($item);
        $product   = Product::find()->where('id = :id', [':id' => $item->productId])->asArray()->one();
        $cartDTO->setProduct($product);
        //Get the total quantity for product in the cart already available
        $totalQtyAvailable = $cartDTO->getCart()->getTotalQuantityForProduct($item->productId);
        /*
         * Here we need to check if product is already there in the cart even with different options i.e. different item code
         * we need to get the quantity of the product in the cart and check if total quantity is >=
         * the minimum quantity for the discount, than final price would be the discounted price.
         * 
         * The quantity to get the final price should use the totalQuantity in cart
         */
        $priceExcludingTax  = $this->productManager->getFinalPrice($product, $totalQtyAvailable);

        //Update other items in the cart related to the product with the latest price
        $this->updatePriceForProduct($cartDTO, $priceExcludingTax);
    }
    
    /**
     * Update item.
     * @param CartDTO $cartDTO
     */
    public function updateItem($cartDTO)
    {
        $postData       = $cartDTO->getPostData();
        $itemCode       = $postData['item_code'];
        $cart           = $cartDTO->getCart();
        $productId      = $cart->getProductIdByItemCode($itemCode);
        $product        = $this->productManager->getProduct($productId, $this->language);
        $cartDTO->setProduct($product);
        if($postData['qty'] < 1 || !ctype_digit($postData['qty']))
        {
            return Json::encode(['error' => UsniAdaptor::t('cart', 'Input quantity should be >= 1')]);
        }
        if($product['minimum_quantity'] > $postData['qty'])
        {
            return Json::encode(['error' => UsniAdaptor::t('cart', 'Input quantity should be >= minimum quantity')]);
        }
        else
        {
            $item       = $cart->itemsList->get($itemCode);
            $item->qty  = $postData['qty'];
            $cart->itemsList->add($item);
            $cartDTO->setCart($cart);
            //Check price for the updated quantity may be discount has applied
            $priceExcludingTax  = $this->productManager->getFinalPrice($product, $postData['qty']);
            $this->updatePriceForProduct($cartDTO, $priceExcludingTax);
            //Set tax for update, taxrule may be changed.
            $tax    = $this->productManager->getTaxAppliedOnProduct($product, $priceExcludingTax);
            $item->setTax($tax);
            return true;
        }
    }
}