<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\behaviors;

use usni\UsniAdaptor;
use products\models\ProductDiscount;
use products\models\ProductSpecial;
use usni\library\utils\FileUploadUtil;
use products\dao\ProductDAO;
use products\dao\TaxDAO;
use customer\dao\CustomerDAO;
use taxes\models\TaxRule;
use usni\library\modules\users\models\Address;
use Yii;
use usni\library\modules\auth\dao\AuthDAO;
use common\modules\stores\dao\StoreDAO;
use common\modules\stores\business\ConfigManager;
use common\modules\order\dao\OrderDAO;
use products\dao\ProductAttributeDAO;
use products\models\ProductOptionMapping;
/**
 * Implement common functions related to products
 *
 * @author products\behaviors
 */
class ProductBehavior extends \yii\base\Behavior
{
    /**
     * Billing or shipping based on which tax calculation is done
     * @var string  
     */
    public $basedOn;
    
    /**
     * @var array of customer groups for currently logged in user 
     */
    public $customerGroups;
    
    /**
     * Zone for the tax calculation for the current customer
     * @var array 
     */
    public $zone;
    
    /**
     * inheritdoc
     */
    public function attach($owner)
    {
        parent::attach($owner);
        $this->basedOn          = $this->getBasedOnSetting();
        $this->customerGroups   = $this->resolveCustomerGroups();
        $this->zone             = $this->getCustomerZone();
    }
    
    /**
     * Get discounted price
     * @param int $productId
     * @param int $inputQty
     * @param string $inputDateTime
     * @return float
     */
    public function getDiscountedPrice($productId, $inputQty, $inputDateTime = null)
    {
        $storeBusinessManager   = ConfigManager::getInstance();
        $customerId             = $this->owner->userId;
        $defaultCustomerGroup   = $storeBusinessManager->getSettingValue('default_customer_group');
        if($inputDateTime == null)
        {
            $inputDateTime    = date('Y-m-d H:i:s');
        }
        $discounts      = ProductDiscount::find()->where('product_id = :pid', [':pid' => $productId])->orderBy('priority')->asArray()->all();
        if($customerId > 0)
        {
            $groups = AuthDAO::getGroups($customerId, 'customer');
            $groups = array_keys($groups);
        }
        else
        {
            $groups = [$defaultCustomerGroup];
        }
        if(!empty($discounts))
        {
            foreach($discounts as $discount)
            {
                //If input quantity is less that discount quantity, go to the next one
                if($inputQty < $discount['quantity'])
                {
                    continue;
                }
                $startDateTime  = $discount['start_datetime'];  
                $endDateTime    = $discount['end_datetime'];
                if(($startDateTime == null && $endDateTime == null)
                    || ($inputDateTime >= $startDateTime && $endDateTime == null)
                        || ($inputDateTime <= $endDateTime && $startDateTime == null)
                            || ($inputDateTime >= $startDateTime && $inputDateTime <= $endDateTime))
                {
                    if(in_array($discount['group_id'], $groups))
                    {
                        return $discount['price'];
                    } 
                }
            }
        }
        return -1;
    }
    
    /**
     * Get special price
     * @param int $productId
     * @param int $customerId
     * @param string $inputDateTime
     * @return float
     */
    public function getSpecialPrice($productId, $inputDateTime = null)
    {
        $storeBusinessManager   = ConfigManager::getInstance();
        $customerId             = $this->owner->userId;
        $defaultCustomerGroup   = $storeBusinessManager->getSettingValue('default_customer_group');
        if($inputDateTime == null)
        {
            $inputDateTime    = date('Y-m-d H:i:s');
        }
        $specials               = ProductSpecial::find()->where('product_id = :pid', [':pid' => $productId])->orderBy('priority')->asArray()->all();
        if($customerId > 0)
        {
            $groups      = AuthDAO::getGroups($customerId, 'customer');
            $groups     = array_keys($groups);
        }
        else
        {
            $groups      = [$defaultCustomerGroup];
        }
        if(!empty($specials))
        {
            foreach($specials as $special)
            {
                $startDateTime  = $special['start_datetime'];  
                $endDateTime    = $special['end_datetime'];
                if(($startDateTime == null && $endDateTime == null)
                    || ($inputDateTime >= $startDateTime && $endDateTime == null)
                        || ($inputDateTime <= $endDateTime && $startDateTime == null)
                            || ($inputDateTime >= $startDateTime && $inputDateTime <= $endDateTime))
                {
                    if(in_array($special['group_id'], $groups))
                    {
                        return $special['price'];
                    }
                }
            }
        }
        return -1;
    }
    
    /**
     * Get discount that would be displayed on front end
     * @param array $product
     * @return string
     */
    public function getDiscountToDisplay($product, $inputDateTime = null)
    {
        //If special price is applied then discount text should not be display.
        $specialPrice   = $this->getSpecialPrice($product['id']);
        if($specialPrice != -1)
        {
            return null;
        }
        $defaultCustomerGroup   = UsniAdaptor::app()->storeManager->getSettingValue('default_customer_group');
        if($inputDateTime == null)
        {
            $inputDateTime            = date('Y-m-d H:i:s');
        }
        $discounts              = ProductDiscount::find()
                                    ->where('product_id = :pid', [':pid' => $product['id']])->orderBy(['priority' => SORT_ASC])->asArray()->all();
        if($this->owner->userId > 0)
        {
            $groups = AuthDAO::getGroups($this->owner->userId, 'customer');
            $groups = array_keys($groups);
        }
        else
        {
            $groups = [$defaultCustomerGroup];
        }
        if(!empty($discounts))
        {
            foreach($discounts as $discount)
            {
                $startDateTime  = $discount['start_datetime'];  
                $endDateTime    = $discount['end_datetime'];
                if(($startDateTime == null && $endDateTime == null)
                    || ($inputDateTime >= $startDateTime && $endDateTime == null)
                        || ($inputDateTime <= $endDateTime && $startDateTime == null)
                            || ($inputDateTime >= $startDateTime && $inputDateTime <= $endDateTime))
                {
                    if(in_array($discount['group_id'], $groups))
                    {
                        //If quantity is greater than 1 than only show the discount
                        if($discount['quantity'] > 1)
                        {
                            $taxApplied     = $this->getTaxAppliedOnProduct($product, $discount['price']);
                            $discount['priceIncludingTax'] = $discount['price'] + $taxApplied;
                            return $discount;
                        }
                    }
                }
            }
        }
        return null;
    }
    
    /**
     * Process and get images
     * @param array $product
     * @return array
     */
    public function processAndGetImages($product)
    {
        if(is_array($product))
        {
            $product    = (object)$product; 
        }
        $images                     = [];
        $productThumbImageWidth     = UsniAdaptor::app()->storeManager->getImageSetting('product_list_image_width', 150);
        $productThumbImageHeight    = UsniAdaptor::app()->storeManager->getImageSetting('product_list_image_height', 150);
        //Main image
        if($product->image != null)
        {
            $images[]    = $product->image;
            FileUploadUtil::saveCustomImage($product, 'image', $productThumbImageWidth, $productThumbImageHeight);
        }
        //Additional Images
        $productImages      = ProductDAO::getImages($product->id, $this->owner->language);
        if(!empty($productImages))
        {
            foreach ($productImages as $productImage)
            {
                $productImageObj    = (object)$productImage;
                FileUploadUtil::saveCustomImage($productImageObj, 'image', $productThumbImageWidth, $productThumbImageHeight);
                $images[]   = $productImage['image'];
            }
        }
        return $images;
    }
    
    /**
     * Get final price for the product. If the special price is there it would be returned as the final unit price.
     * In case discount is there for one item, it would be returned as the final unit price.
     * @param array $product
     * @param int $inputQty
     * @param string $inputDateTime
     * @return string
     */
    public function getFinalPrice($product, $inputQty = 1, $inputDateTime = null)
    {
        if($inputDateTime == null)
        {
            $inputDateTime    = date('Y-m-d H:i:s');
        }
        $specialPrice       = $this->getSpecialPrice($product['id'], $inputDateTime);
        if($specialPrice == -1)
        {
            $discountedPrice = $this->getDiscountedPrice($product['id'], $inputQty, $inputDateTime);
            if($discountedPrice == -1)
            {
                $price = $product['price'];
            }
            else
            {
                $price = $discountedPrice;
            }
        }
        else
        {
            $price = $specialPrice;
        }
        return $price;
    }
    
    /**
     * Get availability
     * @param array $product
     * @return string
     */
    public function getAvailability($product)
    {
        $displayStockSetting    = UsniAdaptor::app()->storeManager->getSettingValue('display_stock');
        if ($displayStockSetting)
        {
            $availability = $product['quantity'];
        }
        else
        {
            $availability = $product['stock_status'] == 1 ? UsniAdaptor::t('products', 'In Stock') : UsniAdaptor::t('products', 'Out Of Stock');
        }
        return $availability;
    }
    
    /**
     * Get customer rating
     * @param int $productId
     * @param int $customerId
     * @return int
     */
    public function getCustomerRating($productId, $customerId)
    {
        $rating     = ProductDAO::getCustomerRating($productId, $customerId);
        if($rating != null)
        {
            return $rating['rating'];
        }
        return 0;
    }
    
    /**
     * Get tax applied on product.
     * @param Product $product
     * @param float $productPriceExcludingTax
     * @param array $zone
     * @param array $customerGroups
     * @param boolean $basedOn
     * @return float
     */
    public function getTaxAppliedOnProduct($product, $productPriceExcludingTax)
    {
        $priceWithTaxSetting        = ConfigManager::getInstance()->getSettingValue('display_price_with_tax');
        //If price should not be displayed with tax or product tax class is 0
        if($priceWithTaxSetting == false || $product['tax_class_id'] == 0)
        {
            return 0;
        }
        $taxValue   = 0;
        $rules      = [];
        if($this->zone != null)
		{
            $rules  = TaxDAO::getTaxRules($product['tax_class_id'], $this->zone['id'], $this->basedOn, $this->customerGroups);
        }
        if(!empty($rules))
        {
            foreach($rules as $rule)
            {
                $type           = $rule['type'];
                $totalTaxByType = $rule['value'];
                Yii::info("Total tax by type $type is " . $totalTaxByType, __METHOD__);
                if($type == TaxRule::TAX_TYPE_PERCENT)
                {
                    $taxValue += ($productPriceExcludingTax * ($totalTaxByType / 100));
                    Yii::info("Tax value by percent is " . $taxValue, __METHOD__);
                }
                elseif($type == TaxRule::TAX_TYPE_FLAT)
                {
                    $taxValue += $totalTaxByType;
                    Yii::info("Tax value flat is " . $taxValue, __METHOD__);
                }
                else
                {
                    throw new \yii\base\NotSupportedException();
                }
            }
        }
        return number_format($taxValue, 2, ".", "");
    }
    
    /**
     * Get chosen address by based on params.
     * @param stirng $basedOn
     * @return Address
     */
    public function getAddressByBasedOn($basedOn)
    {
        $customerId                 = $this->owner->userId;
        $storeId                    = $this->owner->selectedStoreId;
        $storeShippingAddressRecord = StoreDAO::getStoreAddressByType($storeId, Address::TYPE_SHIPPING_ADDRESS);
        $storeBillingAddressRecord  = StoreDAO::getStoreAddressByType($storeId, Address::TYPE_BILLING_ADDRESS);
        $storeShippingAddress       = $storeShippingAddressRecord === false ? null:$storeShippingAddressRecord;
        $storeBillingAddress        = $storeBillingAddressRecord === false ? null:$storeBillingAddressRecord;
        if($customerId > 0)
        {
            $shippingAddress    = CustomerDAO::getAddressByType($customerId, Address::TYPE_SHIPPING_ADDRESS);
            $billingAddress     = CustomerDAO::getAddressByType($customerId, Address::TYPE_BILLING_ADDRESS);
            if($shippingAddress == false)
            {
                $addressByOrder     = OrderDAO::getLatestOrderAddressByType($customerId, Address::TYPE_SHIPPING_ADDRESS);
                $shippingAddress    = $addressByOrder === false ? null : $addressByOrder;
            }
            if($billingAddress == false)
            {
                $addressByOrder = OrderDAO::getLatestOrderAddressByType($customerId, Address::TYPE_BILLING_ADDRESS);
                $billingAddress = $addressByOrder === false ? null : $addressByOrder;
            }
        }
        else
        {
            $shippingAddress = null;
            $billingAddress  = null;
        }
        $chosenAddress   = null;
        if($basedOn == TaxRule::TAX_BASED_ON_SHIPPING)
        {
            if($shippingAddress == null)
            {
                $chosenAddress = $billingAddress == null ? $storeShippingAddress : $billingAddress;
            }
            else
            {
                $chosenAddress = $shippingAddress;
            }
        }
        elseif($basedOn == TaxRule::TAX_BASED_ON_BILLING)
        {
            if($billingAddress == null)
            {
                $chosenAddress = $shippingAddress == null ? $storeBillingAddress : $shippingAddress;
            }
            else
            {
                $chosenAddress = $billingAddress;
            }
        }
        return $chosenAddress;
    }
    
    /**
     * Get customer zone
     * @return array
     */
    public function getCustomerZone()
    {
        $chosenAddress      = $this->getAddressByBasedOn($this->basedOn);
        return TaxDAO::getZoneByAddress($chosenAddress, $this->owner->language);
    }
    
    /**
     * Resolve logged in customer groups
     * @return array
     */
    public function resolveCustomerGroups()
    {
        $storeConfigManager = ConfigManager::getInstance();
        $customerGroups     = [];
        $defaultCustomerGroup   = $storeConfigManager->getSettingValue('default_customer_group');
        $customerId     = $this->owner->userId;
        if($customerId != null)
        {
            $groupsData     = AuthDAO::getGroups($customerId, 'customer');
            if(!empty($groupsData))
            {
                $customerGroups = array_keys($groupsData);
            }
        }
        if(empty($customerGroups))
        {
            $customerGroups = [$defaultCustomerGroup];
        }
        return $customerGroups;
    }
    
    /**
     * Get based on setting for the store
     * @return string
     */
    public function getBasedOnSetting()
    {
        $basedOn            = ConfigManager::getInstance()->getSettingValue('tax_calculation_based_on');
        if($basedOn == null)
        {
            $basedOn = TaxRule::TAX_BASED_ON_BILLING;
        }
        return $basedOn;
    }
    
    /**
     * Gets product attributes.
     * @param int $productId
     * @return string
     */
    public function getProductAttributes($productId)
    {
        $productAttributes  = ProductAttributeDAO::getAttributesByProduct($productId, $this->owner->language);
        if(!empty($productAttributes))
        {
            $content            = null;
            foreach ($productAttributes as $productAttribute)
            {
                $content .= $productAttribute['name'] . ': ' . $productAttribute['attribute_value'] . '<br>';
            }
            return $content;
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get required options count
     * @param int $productId
     * @return int
     */
    public function getRequiredOptionsCount($productId)
    {
        return ProductOptionMapping::find()->where('product_id = :pId AND required = :req', [':pId' => $productId, ':req' => 1])->count();
    }
}