<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\utils;

use usni\UsniAdaptor;
use products\models\ProductOptionValue;
use usni\library\utils\TranslationUtil;
use products\models\ProductRelatedProductMapping;
use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\currency\models\Currency;
use products\models\ProductCategoryMapping;
use taxes\models\TaxRuleDetails;
use taxes\models\TaxRule;
use products\models\ProductReview;
use usni\library\extensions\bootstrap\widgets\UiLabel;
use usni\library\components\UiHtml;
use usni\library\modules\auth\managers\AuthManager;
use products\models\ProductDiscount;
use products\models\ProductSpecial;
use products\models\ProductImage;
use usni\library\utils\FileUploadUtil;
use usni\library\components\Lightbox;
use taxes\models\TaxRate;
use common\modules\stores\models\Store;
use taxes\models\Zone;
use usni\library\utils\NumberUtil;
use customer\utils\CustomerUtil;
use products\models\ProductOptionMapping;
use products\models\ProductOptionMappingDetails;
use products\models\Product;
use products\models\ProductOption;
use products\models\ProductOptionTranslated;
use products\models\ProductTranslated;
use yii\helpers\VarDumper;
use Yii;
use common\modules\localization\modules\lengthclass\models\LengthClass;
use common\modules\localization\modules\weightclass\models\WeightClass;
use common\utils\ApplicationUtil;
use common\modules\stores\utils\StoreUtil;
use usni\library\modules\users\models\Address;
use yii\caching\DbDependency;
use products\models\ProductImageTranslated;
use products\models\ProductAttribute;
use products\models\ProductAttributeTranslated;
use products\models\ProductAttributeMapping;
use products\models\ProductAttributeGroupTranslated;
use products\models\ProductTagMapping;
use products\models\Tag;
use products\models\TagTranslated;
use yii\web\UploadedFile;
use products\models\ProductRating;
use customer\models\Customer;
use products\notifications\ProductReviewEmailNotification;
use usni\library\modules\notification\utils\NotificationUtil;
use usni\library\modules\notification\models\Notification;
use usni\library\modules\users\utils\UserUtil;
use usni\library\modules\users\models\User;
use common\modules\order\utils\OrderUtil;
use usni\library\utils\StatusUtil;
use productCategories\utils\ProductCategoryUtil;
/**
 * ProductUtil class file
 *
 * @package products\utils
 */
class ProductUtil
{
    //Stock options
    const IN_STOCK          = 1;
    const OUT_OF_STOCK      = 2;
    
    /**
     * Get model name based on ID.
     * 
     * @param int $id
     * @return string
     */
    public static function getAttributeGroup($id, $language = null)
    {
        if($language == null)
        {
            $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $table      = UsniAdaptor::tablePrefix(). 'product_attribute_group';
        $tableTr    = UsniAdaptor::tablePrefix(). 'product_attribute_group_translated';
        $sql        = "SELECT tt.name FROM $table t, $tableTr tt WHERE t.id = :id AND t.id = tt.owner_id AND tt.language = :lan";
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $record     = UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lan' => $language])->cache(0, $dependency)->queryOne();
        if($record !== false)
        {
            return $record['name'];
        }
        return false;
    }
    
    /**
     * Get product pption type.
     * @return Array
     */
    public static function getProductOptionType()
    {
        return [
                   'select'             => 'Select',
                   'radio'              => 'Radio',
                   'checkbox'           => 'Checkbox'
               ];
    }
    
    /**
     * Validate and save product option data.
     * @param Array  $postData Contains Post data.
     * @param ProductOption $option
     * @return boolean
     */
    public static function validateAndSaveProductOptionData($postData, $option)
    {
        if (isset($postData['ProductOption']))
        {
            $transaction = UsniAdaptor::db()->beginTransaction();
            try
            {
                $option->attributes      = $postData['ProductOption'];
                if($option->validate())
                {
                    if($option->save())
                    {
                        if(self::afterOptionSave($option, $postData))
                        {
                            $transaction->commit();
                            return true;
                        }
                    }
                }
                $transaction->rollBack();
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
        }
        return false;
    }

    /**
     * Save product option value.
     * @param Model $option
     * @param string $scenario
     * @param Array $postData
     * @return boolean
     */
    public static function saveOptionValue($option, $scenario, $postData)
    {
        if(ArrayUtil::getValue($postData, 'ProductOptionValue') != null)
        {
            if($scenario == 'create')
            {        
                foreach($postData['ProductOptionValue']['value'] as $inputValue)
                {
                    if($inputValue != '')
                    {
                        $optionValueModel            = new ProductOptionValue();
                        $optionValueModel->option_id = $option->id;
                        $optionValueModel->value     = $inputValue;
                        if($optionValueModel->save())
                        {
                            if(!self::afterOptionValueSave($optionValueModel))
                            {
                                return false;
                            }
                        }
                    }
                }
            }
            else
            {
                $inputOptionValues  = array_filter($postData['ProductOptionValue']['value']);
                $inputOptionValuesKeys = array_keys($inputOptionValues);
                $optionValuesModels = $option->optionValues;
                $unsetValues        = [];
                $setValues          = [];
                //Unset the values which are removed from the screen using - option
                foreach($optionValuesModels as $optionValueModel)
                {
                    if(!in_array($optionValueModel->id, $inputOptionValuesKeys))
                    {
                        $unsetValues[] = $optionValueModel->id;
                    }
                    else
                    {
                        $setValues[$optionValueModel->id] = $optionValueModel;
                    }
                }
                //Set the value which are sent in input
                foreach($inputOptionValues as $key => $modifiedValue)
                {
                    if(ArrayUtil::getValue($setValues, $key) != null)
                    {
                        $inputValue           = $setValues[$key];
                        $inputValue->value    = $modifiedValue;
                        $inputValue->save();
                    }
                    elseif($modifiedValue != '')
                    {
                        $optionValueModel            = new ProductOptionValue();
                        $optionValueModel->option_id = $option->id;
                        $optionValueModel->value     = $modifiedValue;
                        if($optionValueModel->save())
                        {
                            if(!self::afterOptionValueSave($optionValueModel))
                            {
                                return false;
                            }
                        }
                    }
                }
                //Delete the values from db if not in input
                $tableName      = UsniAdaptor::tablePrefix() . 'product_option_value';
                $tableTrName    = UsniAdaptor::tablePrefix() . 'product_option_value_translated';
                UsniAdaptor::app()->db->createCommand()->delete($tableTrName, ['in', 'owner_id', $unsetValues])->execute();
                UsniAdaptor::app()->db->createCommand()->delete($tableName, ['in', 'id', $unsetValues])->execute();
            }
        }
        return true;
    }
    
    /**
     * Save translations of product option.
     * @param Model $option
     * @param Array $postData
     * @return void
     */
    public static function afterOptionSave($option, $postData)
    {
        $defaultLanguageOption = $option;
        if($option->scenario == 'create')
        {
            TranslationUtil::saveTranslatedModels($option);    
        }
        if(!self::saveOptionValue($defaultLanguageOption, $option->scenario, $postData))
        {
            return false;
        }
        return true;
    }
    
    /**
     * Save translations for product option value.
     * @params ProductOptionValue $model
     * @return void
     */
    public static function afterOptionValueSave($model)
    {
        TranslationUtil::saveTranslatedModels($model);
        return true;
    }
    
    /**
     * Get related products id.
     * @param int $id
     * @return Array
     */
    public static function getRelatedProductIds($id)
    {
        $relatedProductIdArray    = [];
        $relatedProductsMappingRecords = ProductRelatedProductMapping::find()->where('product_id = :pId', [':pId' => $id])->asArray()->all();
        if(!empty($relatedProductsMappingRecords))
        {
            foreach ($relatedProductsMappingRecords as $record)
            {
                $relatedProductIdArray[] = $record['related_product_id'];
            }
            return array_unique($relatedProductIdArray);
        }
        return $relatedProductIdArray;
    }
    
    /**
     * Get Overall rating of products.
     * @param int $productId
     * @param float $step
     * @return int $totalRating
     */
    public static function getOverallRating($productId, $step = 0.5)
    {
        $totalRating = 0;
        $starRating  = 0;
        $ratings     = ProductRating::find()->select('COUNT(*) AS cnt, rating')->where('product_id = :aId', [':aId' => $productId])->groupBy(['rating'])->asArray()->all();
        if (count($ratings) > 0)
        {
            $ratings     = ArrayUtil::map($ratings, 'rating', 'cnt');
            $cumulativeTotal = 0;
            $totalCount      = 0; 
            foreach($ratings as $rating => $cnt)
            {
                $cumulativeTotal += $rating * $cnt;
                $totalCount      += $cnt;
            }

            if($totalCount > 0)
            {
                $totalRating = $cumulativeTotal / $totalCount;
            }
            $starRating  = self::getStarRating($totalRating, $step);
        }
        return $starRating;
    }
    
    /**
     * Gets star rating based on total rating
     * @param float $totalRating
     * @param float $step
     * @return mixed
     */
    public static function getStarRating($totalRating, $step = 0.5)
    {
        $starRating = 0;
        $i = 1;
        while($i <= 5)
        {
            $i = floatval($i);
            $nextCount = $i + $step;
            if(NumberUtil::compareFloat($totalRating, $i))
            {
                $starRating = $i;
                break;
            }
            elseif(NumberUtil::compareFloat($totalRating, $nextCount))
            {
                $starRating = $nextCount;
                break;
            }
            elseif($totalRating > $i && $totalRating < $nextCount)
            {
                if($totalRating > $i + ($step / 2))
                {
                    $starRating = $nextCount;
                }
                else
                {
                    $starRating = $i;
                }
                break;
            }
            else
            {
                $i = $nextCount;
            }
        }
        return $starRating;
    }
    
    /**
     * Add to cart script
     * @return string
     */
    public static function addToCartScriptOnDetail()
    {
        $cart   = ApplicationUtil::getCart();
        $url    = UsniAdaptor::createUrl('cart/default/add-to-cart');
        $js = "     
                    var dataString = '';
                    $('body').on('click', '.add-cart-detail', function(){
                    $('#inputquantity-error').hide();
                    $.ajax({
                            url: '{$url}',
                            type: 'post',
                            data: $('#detailaddtocart').serialize() + '&isDetail=1',
                            dataType: 'json',
                            success: function(json) {
                                    if (json['success']) {
                                        $('.success').fadeIn('slow');
                                        $('#cart').html(json['data']);
                                        $('html, body').animate({ scrollTop: 0 }, 'slow'); 
                                    }
                                    else{
                                            if(json['qtyError'])
                                            {
                                                $('#inputquantity-error').removeClass('hidden');
                                                $('#inputquantity-error').show();
                                            }
                                            else
                                            {
                                                $.fn.renderOptionErrors(json['errors'], 'field-productoptionmapping', 'has-error',
                                                                                                      'has-success');
                                            }
                                    }
                                }
                        });
               })";
        return $js;
    }
    
    /**
     * Add to cart script
     * @return string
     */
    public static function addToCartScript()
    {
        $url = UsniAdaptor::createUrl('cart/default/add-to-cart');
        $js = "     
                    var dataString = '';
                    $('body').on('click', '.add-cart', function(){
                    var selectedVal              = $(this).data('productid');
                    $.ajax({
                            url: '{$url}',
                            type: 'post',
                            data: 'product_id=' + selectedVal + '&quantity=1&isDetail=0',
                            dataType: 'json',
                            success: function(json) {
                                if (json['success']) {
                                    $('#cart').html(json['data']);
                                    $('html, body').animate({ scrollTop: 0 }, 'slow'); 
                                }	
                            }
                        });
               })";
        return $js;
    }
    
    /**
     * Get input quantity when user clicks on add to cart.
     * @param Product $product
     * @param integer $inputQty
     * @return int
     */
    public static function getAddToCartInputQuantity($product, $inputQty)
    {
        $minQuantity    = $product->minimum_quantity;
        if($inputQty != null && $inputQty >= $minQuantity)
        {
            $quantity = $inputQty;
        }
        else
        {
            $quantity = $minQuantity;
        }
        return $quantity;
    }
    
    /**
     * Get price based on the selected currency.
     * @param float $price
     * @param  string $defaultCurrencyCode
     * @param  string $currencyCode
     * @return float
     */
    public static function getPriceByCurrency($price, $defaultCurrencyCode = null, $currencyCode = null)
    {
        if($currencyCode == null)
        {
            $currencyCode           = UsniAdaptor::app()->currencyManager->getDisplayCurrency();
        }
        if($defaultCurrencyCode == null)
        {
            $defaultCurrencyCode    = UsniAdaptor::app()->currencyManager->getDefault();
        }
        if($defaultCurrencyCode != $currencyCode)
        {
            $currencyTableName  = Currency::tableName();
            $sql                = "SELECT *
                                   FROM $currencyTableName 
                                   WHERE code = :code";
            $connection         = UsniAdaptor::app()->getDb();
            $currency           = $connection->createCommand($sql, [':code' => $currencyCode])->queryOne();
            if(!empty($currency))
            {
                $price              = $currency['value'] * $price;
            }
        }
        return number_format($price, 2, ".", "");
    }
    
    /**
     * Get formatted price.
     * @param float $priceByCurrency
     * @param string $currencyCode
     * @return string
     */
    public static function getPriceWithSymbol($priceByCurrency, $currencyCode = null)
    {
        $currencySymbol = UsniAdaptor::app()->currencyManager->getCurrencySymbol($currencyCode);
        return $currencySymbol . '' . $priceByCurrency;
    }
    
    /**
     * Get Stock Select options.
     * @return array
     */
    public static function getOutOfStockSelectOptions()
    {
        return array(
            self::IN_STOCK      => UsniAdaptor::t('products', 'In Stock'),
            self::OUT_OF_STOCK  => UsniAdaptor::t('products', 'Out of Stock')
        );
    }
    
    /**
     * Save product category mapping
     * @param Product $product
     * @return void
     */
    public static function saveProductCategoryMapping($product)
    {
        $data = [];
        $data['product_id']  = $product->id;
        $data['category_id'] = $product->categories;
        if(is_array($data['category_id']))
        {
            $user                       = UsniAdaptor::app()->user->getUserModel();
            $productCategoryMappingData = [];
            foreach ($data['category_id'] as $catId)
            {
                $dataCategoryId                 = ProductCategoryUtil::getDataCategoryId($catId);
                $productCategoryMappingData[]   = [$product->id, $catId, $dataCategoryId, $user->id, date('Y-m-d H:i:s'), $user->id, date('Y-m-d H:i:s')];
            }
            $columns    = ['product_id', 'category_id', 'data_category_id', 'created_by', 'created_datetime', 'modified_by', 'modified_datetime'];
            $table      = UsniAdaptor::tablePrefix() . 'product_category_mapping';
            try
            {
                UsniAdaptor::app()->db->createCommand()->batchInsert($table, $columns, $productCategoryMappingData)->execute();
            }
            catch (\yii\db\Exception $e)
            {
                throw $e;
            }
        }
        else
        {
            $productCategoryMapping = new ProductCategoryMapping(['scenario' => 'create']);
            $productCategoryMapping->product_id         = $product->id;
            $productCategoryMapping->category_id        = $product->categories;
            $productCategoryMapping->data_category_id   = ProductCategoryUtil::getDataCategoryId($product->categories);
            $productCategoryMapping->save();
        }
    }
    
    /**
     * Saves related products mapping
     * @param Product $product
     */
    public static function saveRelatedProductsMapping($product)
    {
        ProductRelatedProductMapping::deleteAll('product_id = :pid', [':pid' => $product->id]);
        if(!empty($product->relatedProducts) && is_array($product->relatedProducts))
        {
            $relatedProductMappingData =  [];
            $user                       = UsniAdaptor::app()->user->getUserModel();
            foreach ($product->relatedProducts as $relatedProductId)
            {
                $relatedProductMappingData[] = [$product->id, $relatedProductId, $user->id, date('Y-m-d H:i:s')];
            }
            $table      = UsniAdaptor::tablePrefix() . 'product_related_product_mapping';
            $columns    = ['product_id', 'related_product_id', 'created_by', 'created_datetime'];
            try
            {
                UsniAdaptor::app()->db->createCommand()->batchInsert($table, $columns, $relatedProductMappingData)->execute();
            }
            catch (\yii\db\Exception $e)
            {
                throw $e;
            }
        }
    }
    
    /**
     * Get final price for the product. If the special price is there it would be returned as the final unit price.
     * In case discount is there for one item, it would be returned as the final unit price.
     * @param Product $product
     * @param Customer $customer
     * @param int $inputQty
     * @param string $inputDateTime
     * @return string
     */
    public static function getFinalPrice($product, $customer, $inputQty = 1, $inputDateTime = null)
    {
        $specialPrice    = self::getSpecialPrice($product, $customer, $inputDateTime);
        if($specialPrice == -1)
        {
            $discountedPrice = self::getDiscountedPrice($product, $customer, $inputQty, $inputDateTime);
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
     * Get formatted price.
     * @param float $price
     * @return string
     */
    public static function getFormattedPrice($price, $currencyCode = null)
    {
        if($currencyCode == null)
        {
            $currencyCode = UsniAdaptor::app()->currencyManager->getDisplayCurrency();
        }
        $defaultCurrencyCode    = UsniAdaptor::app()->currencyManager->getDefault();
        $priceByCurrency        = ProductUtil::getPriceByCurrency($price, $defaultCurrencyCode, $currencyCode);
        return ProductUtil::getPriceWithSymbol($priceByCurrency, $currencyCode);
    }
    
    /**
     * Get displayed price.
     * @param Product $product
     * @param Customer $customer
     * @param boolean $isDetail
     * @return string
     */
    public static function getDisplayedPrice($product, $customer, $store = null, $isDetail = false)
    {
        $tax                        = 0;
        $priceWithTaxSetting        = StoreUtil::getSettingValue('display_price_with_tax');
        $priceExcludingTax          = ProductUtil::getFinalPrice($product, $customer);
        $oldPrice                   = $product['price'];
        if($priceWithTaxSetting)
        {
            $tax    = ProductUtil::getTaxAppliedOnProduct($product, $customer, $priceExcludingTax, $store);
        }
        return self::getPriceInHtml($oldPrice, $priceExcludingTax, $tax, $isDetail);
    }
    
    /**
     * Get price including tax
     * @param Product $product
     * @param Customer $customer
     * @return float
     */
    public static function getPriceIncludingTax($product, $customer, $store = null)
    {
        if($store == null)
        {
            $store = UsniAdaptor::app()->storeManager->getCurrentStore();
        }
        $priceExcludingTax  = ProductUtil::getFinalPrice($product, $customer);
        $tax                = ProductUtil::getTaxAppliedOnProduct($product, $customer, $priceExcludingTax);
        return $priceExcludingTax + $tax;
    }
    
    /**
     * Get price in html
     * @param float $oldPrice
     * @param float $priceExcludingTax
     * @param float $tax
     * @param boolean $isDetail
     * @return string
     */
    public static function getPriceInHtml($oldPrice, $priceExcludingTax, $tax, $isDetail = false)
    {
        if($oldPrice == $priceExcludingTax)
        {
            $price = ProductUtil::getFormattedPrice($priceExcludingTax + $tax);
            if($isDetail)
            {
                return UiHtml::tag('strong', UiHtml::tag('span', $price, ['class' => 'price-new']));
            }
            else
            {
                return UiHtml::tag('span', $price, ['class' => 'price-new']);
            }
        }
        else
        {
            $priceNew = ProductUtil::getFormattedPrice($priceExcludingTax + $tax);
            if($isDetail)
            {
                $str  = UiHtml::tag('strong', UiHtml::tag('span', $priceNew, ['class' => 'price-new']));
            }
            else
            {
                $str  = UiHtml::tag('span', $priceNew, ['class' => 'price-new']);
            }
            $str      .= ' ' . UiHtml::tag('span', ProductUtil::getFormattedPrice($oldPrice + $tax), ['class' => 'price-old']);
            if($tax > 0)
            {
                $str  .= '<br/>' . UiHtml::tag('span', UsniAdaptor::t('products', 'Ex. Tax') . ': ' . ProductUtil::getFormattedPrice($priceExcludingTax), ['class' => 'price-tax']);
            }
            return $str;
        }
    }
    
    /**
     * Get discounted price
     * @param Product $product
     * @param Customer $customer
     * @param int $inputQty
     * @param string $inputDateTime
     * @return float
     */
    public static function getDiscountedPrice($product, $customer, $inputQty, $inputDateTime = null)
    {
        $defaultCustomerGroup = StoreUtil::getSettingValue('default_customer_group');
        if($inputDateTime == null)
        {
            $inputDateTime    = date('Y-m-d H:i:s');
        }
        $discounts      = ProductDiscount::find()->where('product_id = :pid', [':pid' => $product['id']])->orderBy('priority')->asArray()->all();
        if($customer != null)
        {
            $groups = array_keys(CustomerUtil::getCustomerGroups($customer['id']));
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
     * @param Product $product
     * @param Customer $customer
     * @param string $inputDateTime
     * @return float
     */
    public static function getSpecialPrice($product, $customer, $inputDateTime = null)
    {
        $defaultCustomerGroup   = StoreUtil::getSettingValue('default_customer_group');
        if($inputDateTime == null)
        {
            $inputDateTime    = date('Y-m-d H:i:s');
        }
        $specials               = ProductSpecial::find()->where('product_id = :pid', [':pid' => $product['id']])->orderBy('priority')->asArray()->all();
        if($customer != null)
        {
            $groups = array_keys(CustomerUtil::getCustomerGroups($customer['id']));
        }
        else
        {
            $groups = [$defaultCustomerGroup];
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
     * Get chosen address by based on param.
     * @param stirng $basedOn
     * @param Customer $customer
     * @param $product
     * @param Store $store
     * @return Address
     */
    public static function getAddressByBasedOn($basedOn, $customer, $store = null)
    {
        if($store == null)
        {
            $store = UsniAdaptor::app()->storeManager->getCurrentStore();
        }
        $storeShippingAddressRecord = StoreUtil::getAddressByType($store->id, Address::TYPE_SHIPPING_ADDRESS);
        $storeBillingAddressRecord  = StoreUtil::getAddressByType($store->id, Address::TYPE_BILLING_ADDRESS);
        $storeShippingAddress       = $storeShippingAddressRecord === false ? null:$storeShippingAddressRecord;
        $storeBillingAddress        = $storeBillingAddressRecord === false ? null:$storeBillingAddressRecord;
        if($customer != null)
        {
            if($customer->shippingAddress != false)
            {
                $shippingAddress = $customer->shippingAddress->getAttributes();
            }
            else
            {
                $addressByOrder = OrderUtil::getLatestOrderAddressByType($customer->id, Address::TYPE_SHIPPING_ADDRESS);
                $shippingAddress = $addressByOrder === false ? null:$addressByOrder;
            }
            if($customer->billingAddress != false)
            {
                $billingAddress = $customer->billingAddress->getAttributes();
            }
            else
            {
                $addressByOrder = OrderUtil::getLatestOrderAddressByType($customer->id, Address::TYPE_BILLING_ADDRESS);
                $billingAddress = $addressByOrder === false ? null:$addressByOrder;
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
                if($billingAddress == null)
                {
                    $chosenAddress = $storeShippingAddress;
                }
                else
                {
                    $chosenAddress = $billingAddress;
                }
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
                if($shippingAddress == null)
                {
                    $chosenAddress = $storeBillingAddress;
                }
                else
                {
                    $chosenAddress = $shippingAddress;
                }
            }
            else
            {
                $chosenAddress = $billingAddress;
            }
        }
        return $chosenAddress;
    }
    
    /**
     * Get zone by address
     * @param Address $address
     * @return Zone
     */
    public static function getZoneByAddress($address)
    {
        if($address != null)
        {
            $country = static::getCountryByCode($address['country']);
            if(!empty($country['id']))
            {
                $tableName  = Zone::tableName();
                $query      = new \yii\db\Query();
                Yii::info("Country is " . $country['name'], __METHOD__);
                $zone       = $query->select('*')->from($tableName)
                              ->where('country_id = :cid AND zip = :zip AND is_zip_range = :izr', 
                                           [':cid' => $country['id'], ':zip' => $address['postal_code'], ':izr' => 0])->one();
                if(empty($zone))
                {
                    $query      = new \yii\db\Query();
                    $zone       = $query->select('*')->from($tableName)
                                  ->where('country_id = :cid AND (:zip BETWEEN from_zip AND to_zip) AND is_zip_range = :izr', 
                                           [':cid' => $country['id'], ':zip' => $address['postal_code'], ':izr' => 1])->one();
                    if(empty($zone))
                    {
                        return null;
                    }
                }
                return $zone;
            }                
        }
        return null;
    }
    
    /**
     * Get tax applied on product.
     * @param Product $product
     * @param Customer $customer
     * @param Float $productPriceExcludingTax
     * $param Store $store
     * @return float
     */
    public static function getTaxAppliedOnProduct($product, $customer, $productPriceExcludingTax, $store = null)
    {
        $customerGroups = [];
        if($store == null)
        {
            $store = UsniAdaptor::app()->storeManager->getCurrentStore();
        }
        Yii::info("Store name is " . $store->name, __METHOD__);
        $defaultCustomerGroup   = StoreUtil::getSettingValue('default_customer_group');
        $basedOn                = StoreUtil::getSettingValue('tax_calculation_based_on');
        if($basedOn == null)
        {
            $basedOn = TaxRule::TAX_BASED_ON_BILLING;
        }
        $chosenAddress  = static::getAddressByBasedOn($basedOn, $customer, $store);
        $zone           = static::getZoneByAddress($chosenAddress);
        $taxValue       = 0;
        if($zone != null)
		{
			$taxClass       = $product['tax_class_id'];
            if($taxClass == 0)
            {
                return 0;
            }
			if($customer != null)
			{
				$customerGroups = $customer->groups;
            }
            if(empty($customerGroups))
            {
                $customerGroups = [$defaultCustomerGroup];
            }
            Yii::info("Customer groups are " . VarDumper::export($customerGroups), __METHOD__);
            $taxRates       = [];
            $types          = [];
            
            $taxRuleDetailsTable    = TaxRuleDetails::tableName();
            $taxRateTable           = TaxRate::tableName();
            $taxRuleTable           = TaxRule::tableName();
            $customerGroups         = implode(',', $customerGroups);
            $query  = (new \yii\db\Query());
            $rules  = $query->select('ttrate.type, ttrate.value, ttrule.based_on')->from([$taxRuleDetailsTable . 'ttrd', $taxRateTable . 'ttrate', 
                      $taxRuleTable .'ttrule'])
                      ->where("ttrd.product_tax_class_id = :pid AND (ttrd.customer_group_id IN ($customerGroups)) AND ttrd.tax_zone_id = :zid AND ttrd.tax_rule_id = ttrule.id AND ttrd.tax_rate_id = ttrate.id AND ttrule.based_on = :basedOn", 
                     [':pid' => $taxClass, ':zid' => $zone['id'], ':basedOn' => $basedOn])->all();
            foreach($rules as $rule)
            {
                Yii::info("Tax rule based on " . $rule['based_on'], __METHOD__);
                Yii::info("Input based on " . $basedOn, __METHOD__);
                
                $type               = $rule['type'];
                $taxRates[$type][]  = $rule['value'];
                $types[]            = $rule['type'];
            }
            $types  = array_unique($types);
            Yii::info("Tax types applied are " . VarDumper::export($types), __METHOD__);
            foreach($types as $type)
            {
                $totalTaxByType = array_sum($taxRates[$type]);
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
        return $taxValue;
    }
    
    /**
     * Renders label for the status.
     * @param string $data ActiveRecord of the model.
     * @return string
     */
    public static function renderReviewStatus($data)
    {
        $value = self::getLabel($data);
        if($value == UsniAdaptor::t('application', 'Pending'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_WARNING]);
        }
        elseif ($value == UsniAdaptor::t('products', 'Approve'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_SUCCESS]);
        }
        elseif ($value == UsniAdaptor::t('products', 'Spam'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DANGER]);
        }
        elseif ($value == UsniAdaptor::t('application', 'Delete'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DANGER]);
        }
    }
    
    /**
     * Gets label for the status.
     * @param string $data ActiveRecord of the model.
     * @return string
     */
    public static function getLabel($data)
    {
        if ($data->status == ProductReview::STATUS_PENDING)
        {
            return UsniAdaptor::t('application', 'Pending');
        }
        else if ($data->status == ProductReview::STATUS_APPROVED)
        {
            return UsniAdaptor::t('products', 'Approve');
        }
        else if ($data->status == ProductReview::STATUS_SPAM)
        {
            return UsniAdaptor::t('products', 'Spam');
        }
        else if ($data->status == ProductReview::STATUS_DELETED)
        {
            return UsniAdaptor::t('application', 'Delete');
        }
    }
    
    /**
     * Gets status dropdown.
     * @return array
     */
    public static function getReviewStatusDropdown()
    {
        return [
                    ProductReview::STATUS_APPROVED    => UsniAdaptor::t('products', 'Approve'),
                    ProductReview::STATUS_PENDING     => UsniAdaptor::t('application', 'Pending'),
                    ProductReview::STATUS_DELETED     => UsniAdaptor::t('application', 'Delete'),
               ];
    }
    
    /**
     * Registers review status script on product review grid view.
     * @param int $status
     * @param Object $view
     * @param string $sourceId
     * @return void
     */
    public static function registerReviewGridStatusScript($status, $view, $sourceId)
    {
        $actionurlbystatus = UsniAdaptor::createUrl('/catalog/products/review/' . $status);
        $linkClass  = '.' . $status . '-review-link';
        $view->registerJs("
                                $('body').on('click', '{$linkClass}',
                                function()
                                {
                                      var modelId   = $(this).parent().parent().data('key');
                                      $.ajax({
                                          'type' : 'GET',
                                          'url'  : '{$actionurlbystatus}?id=' + modelId,
                                          'success' : function(data)
                                                      {
                                                          $.pjax.reload({container:'#{$sourceId}', 'timeout':2000});
                                                      }
                                      });
                                      return false;
                                });

        ",  \yii\web\View::POS_END);
    }
    
    /**
     * Update status for selected records.
     * @param array $selectedItemsIds
     * @param int $sourceStatus
     * @param int $targetStatus
     * @return void
     */
    public static function updateStatusForSelectedRecords($selectedItemsIds, $sourceStatus, $targetStatus)
    {
        $user     = UsniAdaptor::app()->user->getUserModel();
        foreach ($selectedItemsIds as $itemId)
        {
            $productReview = ProductReview::findOne($itemId);
            if(AuthManager::checkAccess($user, 'productreview.approve'))
            {
                if($productReview['status'] == $sourceStatus)
                {
                    UsniAdaptor::db()->createCommand()
                                  ->update(ProductReview::tableName(), ['status' => $targetStatus],
                                           'id = :id', [':id' => $productReview['id']])->execute();
                }
            }
        }
    }
    
    /**
     * Save product discounts
     * @param Product $product
     * @return void
     */
    public static function saveProductDiscounts($product)
    {
        ProductDiscount::deleteAll('product_id = :pid', [':pid' => $product->id]);
        $discounts  = $product->discounts;
        if(!empty($discounts))
        {
            foreach($discounts as $discount)
            {
                $prDiscount = new ProductDiscount(['scenario' => 'create']);
                $prDiscount->setAttributes($discount);
                $prDiscount->product_id = $product->id;
                $prDiscount->save();
            }
        }
    }
    
    /**
     * Save product specials
     * @param Product $product
     * @return void
     */
    public static function saveProductSpecials($product)
    {
        ProductSpecial::deleteAll('product_id = :pid', [':pid' => $product->id]);
        $specials  = $product->specials;
        if(!empty($specials))
        {
            foreach($specials as $special)
            {
                $prSpecial = new ProductSpecial(['scenario' => 'create']);
                $prSpecial->setAttributes($special);
                $prSpecial->product_id = $product->id;
                $prSpecial->save();
            }
        }
    }
    
    /**
     * Get attributes grouped by attribute group.
     * @param Model $product
     * @return string $valueContent
     */
    public static function getGroupedAttributes($product)
    {
        $groupedData    = [];
        $data           = static::getAttributes($product['id']);
        if(count($data) > 0)
        {
            foreach($data as $record)
            {
               $groupedData[$record['attribute_group']][$record['groupName']][] = $record; 
            }
        }
        return $groupedData;
    }
    
    /**
     * Save product images.
     * @param Product $product
     * @return void
     */
    public static function saveProductImages($product)
    {
        $images             = $product->images;
        if(!empty($images))
        {
            foreach($images as $index => $productImage)
            {
                $savedFile  = null;
                if($productImage->isNewRecord)
                {
                    $productImage->product_id = $product->id;
                }
                else
                {
                    $productImage->scenario = 'update';
                    $savedFile = $productImage->image;
                }
                if($productImage->save())
                {
                    $config = [
                        'model'             => $productImage, 
                        'attribute'         => 'image', 
                        'uploadInstance'    => $productImage->uploadInstance, 
                        'savedFile'         => $savedFile,
                        'createThumbnail'   => true
                      ];
                    FileUploadUtil::save('image', $config);
                }
            }
        }   
    }
    
    /**
     * Validate image uploads.
     * @param $product Product
     * @return array
     */
    public static function validateImageUploads($product)
    {
        $imageData  = $product->productImageData;
        $uploadInstances    = [];
        $imageErrors        = [];
        if(!empty($imageData))
        {
            foreach($imageData as $index => $record)
            {
                if($record['id'] == '-1' || $record['id'] == null)
                {
                    $productImage = new ProductImage(['scenario' => 'create']);
                }
                else
                {
                    $productImage = ProductImage::findOne($record['id']);
                }
                $productImage->uploadInstance = UploadedFile::getInstanceByName("ProductImage[$index][uploadInstance]");
                if($productImage->uploadInstance != null)
                {
                    $productImage->image = FileUploadUtil::getEncryptedFileName($productImage->uploadInstance->name);
                }
                $productImage->caption  = $record['caption'];
                if(!$productImage->validate())
                {
                    //Setting it to null so that user does not get confused becuase name would be displayed but uploaded data would not be there
                    //@see http://www.yiiframework.com/forum/index.php/topic/33889-file-upload-field-becomes-empty/
                    $productImage->image    = null;
                    $errors = $imageErrors[$index]    = $productImage->getErrors();
                    foreach($errors as $attribute => $error)
                    {
                        foreach($error as $value)
                        {
                            $product->addError('images', UsniAdaptor::t('products', 'At row') . ' ' . $index . ' ' . $value);
                        }
                    }
                }
                $uploadInstances[$index] = $productImage;
            }
        }
        $product->images = $uploadInstances;
        return $imageErrors;
    }
    
/**
     * Render product images.
     * @param mixed $product
     * @param string $fileGroup
     * @return string
     */
    public static function renderImages($product, $fileGroup)
    {
        if(is_array($product))
        {
            $product    = (object)$product; 
        }
        $images                     = [];
        $productThumbImageWidth     = StoreUtil::getImageSetting('product_list_image_width', 150);
        $productThumbImageHeight    = StoreUtil::getImageSetting('product_list_image_height', 150);
        $content                    = null;
        //Main image
        if($product->image != null)
        {
            $images[]    = $product->image;
            FileUploadUtil::saveCustomImage($product, 'image', $productThumbImageWidth, $productThumbImageHeight);
        }
        //Additional Images
        $productImages      = self::getProductImages($product->id);
        if(!empty($productImages))
        {
            foreach ($productImages as $productImage)
            {
                $productImageObj    = (object)$productImage;
                FileUploadUtil::saveCustomImage($productImageObj, 'image', $productThumbImageWidth, $productThumbImageHeight);
                $images[]   = $productImage['image'];
            }
        }
        if(!empty($images))
        {
            $files       = [];
            foreach ($images as $key => $value)
            {
                if($key == 0)
                {
                    $itemOptions = [];
                }
                else
                {
                    $itemOptions = ['class' => 'image-additional'];
                }
                $prefix = $productThumbImageWidth . '_' . $productThumbImageHeight . '_';
                $thumb      = UsniAdaptor::app()->assetManager->getThumbnailUploadUrl() . '/' . $prefix . $value;
                $original   = UsniAdaptor::app()->assetManager->getImageUploadUrl() . '/' . $value;
                $files[]    = [
                                    'itemTag'       => null,
                                    'thumb'         => $thumb,
                                    'original'      => $original,
                                    'title'         => $product->name,
                                    'group'         => $fileGroup,
                                    'class'         => 'col-sm-3',
                                    'thumbclass'    => 'img-responsive',
                                    'id'            => $product->name . '-' . $key
                                ];
            }
            $content   = LightBox::widget([
                                                            'containerTag' => 'div',
                                                            'containerOptions' => ['class' => 'row'],
                                                            'files' => $files
                                                    ]);
        }
        return $content;
    }
    
    /**
     * Get product option values.
     * @param int $productId
     * @param int $optionId
     * @return int
     */
    public static function getAssigedProductOptionValues($productId, $optionId, $language = null)
    {
        if($language == null)
        {
            $language = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $ovTrTableName  = UsniAdaptor::tablePrefix(). 'product_option_value_translated';
        $ovTableName    = UsniAdaptor::tablePrefix(). 'product_option_value';
        $mappingDetailsTableName = UsniAdaptor::tablePrefix(). 'product_option_mapping_details';
        $mappingTableName   = UsniAdaptor::tablePrefix(). 'product_option_mapping';
        $sql            = "SELECT tpomd.*, tpom.product_id, tpom.option_id, tpovt.value
                            FROM $mappingTableName tpom, $mappingDetailsTableName tpomd, $ovTableName tpov,
                                      $ovTrTableName tpovt 
                            WHERE tpom.product_id = :pid AND tpom.option_id = :oid 
                            AND tpom.id = tpomd.mapping_id AND tpomd.option_value_id = tpov.id 
                            AND tpov.id = tpovt.owner_id 
                            AND tpovt.language = :lan
                         ";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':oid' => $optionId, ':lan' => $language])->queryAll();
    }
    
    /**
     * Get product options values.
     * @param Array $options
     * @param int $productId
     * @return array
     */
    public static function getPriceModificationBySelectedOptions($options, $productId)
    {
        $totalPriceModification = 0;
        if(!empty($options))
        {
            foreach($options as $optionId => $optionValue)
            {
                if(!is_array($optionValue))
                {
                    $mappingDetail = ProductOptionMappingDetails::find()->innerJoinWith('optionMapping')
                                 ->where('product_id = :pid AND option_id = :oid AND option_value_id = :ovid',
                                 [':pid' => $productId, ':oid' => $optionId, ':ovid' => $optionValue])->asArray()->one();
                    if(!empty($mappingDetail))
                    {
                        if($mappingDetail['price_prefix'] == '+')
                        {
                            $totalPriceModification = $totalPriceModification + $mappingDetail['price'];
                        }
                        else
                        {
                            $totalPriceModification = $totalPriceModification - $mappingDetail['price'];
                        }
                    }
                }
                else
                {
                    foreach($optionValue as $value)
                    {
                        $mappingDetail = ProductOptionMappingDetails::find()->innerJoinWith('optionMapping')
                                 ->where('product_id = :pid AND option_id = :oid AND option_value_id = :ovid',
                                 [':pid' => $productId, ':oid' => $optionId, ':ovid' => $value])->asArray()->one();
                        if(!empty($mappingDetail))
                        {
                            if($mappingDetail['price_prefix'] == '+')
                            {
                                $totalPriceModification = $totalPriceModification + $mappingDetail['price'];
                            }
                            else
                            {
                                $totalPriceModification = $totalPriceModification - $mappingDetail['price'];
                            }
                        }
                    }
                }
            }
        }
        return $totalPriceModification;
    }
    
    /**
     * Get error for options
     * @param int $productId
     * @param array $inputOptions
     * @param string $language
     * @return string
     */
    public static function getErrorsForOptions($productId, $inputOptions, $language = null)
    {
        $errors             = [];
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $poTableName        = ProductOption::tableName();
        $poTrTableName      = ProductOptionTranslated::tableName();
        $mappingTableName   = ProductOptionMapping::tableName();
        $query              = new \yii\db\Query();
        $productOptions     = $query->select('tpo.id AS optionId, tpoTr.display_name')
                            ->from([
                                      $mappingTableName . ' AS tpom', $poTableName . ' AS tpo', $poTrTableName . ' AS tpoTr'
                                   ])
                            ->where('tpom.product_id = :pid AND tpom.required = :req AND tpom.option_id = tpo.id AND tpo.id = tpoTr.owner_id '
                                . 'and tpoTr.language = :lan', 
                                [':pid' => $productId, ':lan' => $language, ':req' => 1])
                            ->all();
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
     * Render option error script
     * @return string
     */
    public static function renderOptionErrorsScript()
    {
        $js = "     
                $.fn.renderOptionErrors = function(data, modelClassName, errorCssClass, successCssClass)
                {
                    $.each(data, function(index, errorMsgObj){
                        $.each(errorMsgObj, function(k,v){
                            if(modelClassName != '')
                            {
                                index   = modelClassName + '-' + index;
                                console.log(index);
                            }
                            $('.' + index).find('.help-block').html(v);
                            var container = $('.' + index);
                            $(container).removeClass(errorCssClass);
                            $(container).removeClass(successCssClass);
                            $(container).addClass(errorCssClass);
                        });
                    });
                }";
        return $js;
    }
    
    /**
     * Gets related product multi level options.
     * @param int $id
     * @return array
     */
    public static function getRelatedProductOptions($id)
    {
        $allProducts    = self::getAllProducts();
        $relatedProductRecords = array('' => UiHtml::getDefaultPrompt());
        foreach ($allProducts as $product)
        {
            if ($product['id'] != $id)
            {
                $relatedProductRecords[$product['id']] = $product['name'];
            }
        }
        return $relatedProductRecords;
    }
    
    /**
     * Get product labels
     * @return array
     */
    public static function getProductLabels()
    {
        return [
                    'name'              => UsniAdaptor::t('application', 'Name'),
                    'alias'             => UsniAdaptor::t('application', 'Alias'),
                    'model'             => UsniAdaptor::t('products', 'Model'),
                    'price'             => UsniAdaptor::t('products', 'Price'),
                    'quantity'          => UsniAdaptor::t('products', 'Quantity'),
                    'description'       => UsniAdaptor::t('application', 'Description'),
                    'status'            => UsniAdaptor::t('application', 'Status'),
                    'metakeywords'      => UsniAdaptor::t('application', 'Meta Keywords'),
                    'metadescription'   => UsniAdaptor::t('application', 'Meta Description'),
                    'tagNames'          => UsniAdaptor::t('products', 'Tags'),
                    'minimum_quantity'  => UsniAdaptor::t('products', 'Minimum Quantity'),
                    'subtract_stock'    => UsniAdaptor::t('products', 'Subtract Stock'),
                    'stock_status'      => UsniAdaptor::t('products', 'Stock Status'),
                    'requires_shipping' => UsniAdaptor::t('products', 'Requires Shipping'),
                    'manufacturer'      => UsniAdaptor::t('manufacturer', 'Manufacturer'),
                    'relatedProducts'   => UsniAdaptor::t('products', 'Related Products'),
                    'attribute'         => UsniAdaptor::t('products', 'Attribute'),
                    'language_id'       => UsniAdaptor::t('localization', 'Language'),
                    'is_featured'       => UsniAdaptor::t('products', 'Featured Product'),
                    'itemPerPage'       => UsniAdaptor::t('application', 'Items Per Page'),
                    'sort_by'           => UsniAdaptor::t('application', 'Sort By'),
                    'tax_class_id'      => UsniAdaptor::t('tax', 'Tax Class'),
                    'sku'               => UsniAdaptor::t('products', 'SKU'),
                    'categories'        => UsniAdaptor::t('productCategories', 'Categories'),
                    'location'          => UsniAdaptor::t('products', 'Location'),
                    'length'            => UsniAdaptor::t('products', 'Length'),
                    'width'             => UsniAdaptor::t('products', 'Width'),
                    'height'             => UsniAdaptor::t('products', 'Height'),
                    'date_available'    => UsniAdaptor::t('products', 'Date Available'),
                    'weight'            => UsniAdaptor::t('products', 'Weight'),
                    'length_class'      => UsniAdaptor::t('lengthclass', 'Length Class'),
                    'weight_class'      => UsniAdaptor::t('weightclass', 'Weight Class'),
                    'buy_price'         => UsniAdaptor::t('products', 'Buy Price'),
                    'initial_quantity'  => UsniAdaptor::t('products', 'Initial Stock')
               ];
    }
    
    /**
     * Get product hints
     * @return array
     */
    public static function getProductHints()
    {
        return [
                    'name'              => UsniAdaptor::t('productshint', 'Name for Product'),
                    'alias'             => UsniAdaptor::t('productshint', 'Alias for Product'),
                    'model'             => UsniAdaptor::t('productshint', 'Model for Product'),
                    'price'             => UsniAdaptor::t('productshint', 'Price for Product'),
                    'metakeywords'      => UsniAdaptor::t('productshint', 'Meta Keywords for Product'),
                    'metadescription'   => UsniAdaptor::t('productshint', 'Meta Description for Product'),
                    'tagNames'          => UsniAdaptor::t('productshint', 'Tags associated with the product. e.g - Useful Products'),
                    'minimum_quantity'  => UsniAdaptor::t('productshint', 'Minimum Quantity required to add product to the cart.'),
                    'subtract_stock'    => UsniAdaptor::t('productshint', 'Subtract Stock by the purchase quantity for e.g. If there are 100 laptops, and 2 items are purchased, stock would be reduced to 98.'),
                    'stock_status'      => UsniAdaptor::t('productshint', 'Select "Out of Stock", "In Stock" as the message shown on the product page when the product quantity reaches 0.'),
                    'is_featured'       => UsniAdaptor::t('productshint', 'If you want to emphasize the most important products, the Featured Products is exactly what you need.'),
                    'sku'               => UsniAdaptor::t('productshint', 'A random code for the product.'),
                    'categories'        => UsniAdaptor::t('productshint', 'Categories for the Product'),
                    'length'            => UsniAdaptor::t('productshint', 'Length for the product'),
                    'width'             => UsniAdaptor::t('productshint', 'Width for the product'),
                    'height'             => UsniAdaptor::t('productshint', 'Height for the product'),
                    'initial_quantity'  => UsniAdaptor::t('productshint', 'Initial stock for the product'),
               ];
    }
    
    /**
     * Get stock status.
     * @return string
     */
    public static function getStockStatus($model)
    {
        if($model->stock_status == ProductUtil::IN_STOCK)
        {
            return UsniAdaptor::t('products', 'In Stock');
        }
        else
        {
            return UsniAdaptor::t('products', 'Out of Stock');
        }
    }
    
    /**
     * Get subtract stock.
     * @return string
     */
    public static function getSubtractStock($model)
    {
        if($model->subtract_stock == 1)
        {
            return UsniAdaptor::t('application', 'Yes');
        }
        else
        {
            return UsniAdaptor::t('application', 'No');
        }
    }
    
    /**
     * Get length class.
     * @param integer $lengthClassId
     * @return string
     */
    public static function getLengthClass($lengthClassId)
    {
        $lengthClass = LengthClass::findOne($lengthClassId);
        return $lengthClass->name;
    }
    
    /**
     * Get weight class.
     * @param integer $weightClassId
     * @return string
     */
    public static function getWeightClass($weightClassId)
    {
        $weightClass = WeightClass::findOne($weightClassId);
        return $weightClass->name;
    }
    
    /**
     * Should resize image
     * @param string $image
     * @param int $targetImageWidth
     * @param int $targetImageHeight
     * @return boolean
     */
    public static function shouldResizeImage($image, $targetImageWidth, $targetImageHeight)
    {
        $originalFilePath = UsniAdaptor::app()->assetManager->imageUploadPath . '/' . $image;
        $resizeImage = true;
        list($width, $height, $type, $attr) = getimagesize($originalFilePath);
        if($width < $targetImageWidth && $height < $targetImageHeight)
        {
            $resizeImage        = false;
        }
        return $resizeImage;
    }
    
    /**
     * Get country by code
     * @param string $code
     * @return stdClass
     */
    public static function getCountryByCode($code, $language = null)
    {
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $tableName        = UsniAdaptor::tablePrefix() . 'country';
        $trTableName      = UsniAdaptor::tablePrefix() . 'country_translated';
        $sql              = "SELECT c.*, ctr.name
                             FROM $tableName c, $trTableName ctr
                             WHERE c.iso_code_2 = :code AND ctr.language = :lan";
        $connection       = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':code' => $code, ':lan' => $language])->queryOne();
    }
    
    /**
     * Save option mapping details
     * @param type $productId
     * @param type $optionId
     * @param type $postData
     */
    public static function saveOptionMappingDetails($productId, $optionId, $postData)
    {
        $optionValueMapping                 = new ProductOptionMapping(['scenario' => 'create']);
        $optionValueMapping->product_id     = $productId;
        $optionValueMapping->option_id      = $optionId;
        $optionValueMapping->required       = $postData['required'];
        if($optionValueMapping->save())
        {
            foreach($postData['option_value_id'] as $index => $optionValueId)
            {    
                $optionMappingDetails                   = new ProductOptionMappingDetails(['scenario' => 'create']);
                $optionMappingDetails->mapping_id       = $optionValueMapping->id;
                $optionMappingDetails->option_value_id  = $optionValueId;
                if($postData['quantity'][$index] == null)
                {
                    $optionMappingDetails->quantity =  1;
                }
                else
                {
                    $optionMappingDetails->quantity       = $postData['quantity'][$index];
                }
                $optionMappingDetails->subtract_stock = $postData['subtract_stock'][$index];
                $optionMappingDetails->price_prefix   = $postData['price_prefix'][$index];
                $optionMappingDetails->price          = $postData['price'][$index];
                $optionMappingDetails->weight_prefix  = $postData['weight_prefix'][$index];
                $optionMappingDetails->weight         = $postData['weight'][$index];
                $optionMappingDetails->save();
            }    
        }
    }
    
    /**
     * Get discounts
     * @param Product $product
     * @param Customer $customer
     * @param Store $store
     * @param string $inputTemplate
     * @return float
     */
    public static function getDiscounts($product, $customer, $store = null, $inputTemplate = null, $currentDate = null)
    {
        $defaultCustomerGroup   = StoreUtil::getSettingValue('default_customer_group');
        if($currentDate == null)
        {
            $currentDate            = date('Y-m-d H:i:s');
        }
        $discounts              = ProductDiscount::find()->where('product_id = :pid', [':pid' => $product['id']])->asArray()->all();
        if($customer != null)
        {
            $groups = array_keys(CustomerUtil::getCustomerGroups($customer->id));
        }
        else
        {
            $groups = [$defaultCustomerGroup];
        }
        $discountStr = null;
        $orOrMore           = UsniAdaptor::t('products', 'or more');
        $purchaseLabel      = UsniAdaptor::t('products', 'On purchase of');
        $productPriceLabel  = UsniAdaptor::t('products', 'Products discounted price would be');
        if(!empty($discounts))
        {
            foreach($discounts as $discount)
            {
                $startDateTime  = $discount['start_datetime'];  
                $endDateTime    = $discount['end_datetime'];
                if(($startDateTime == null && $endDateTime == null)
                    || ($currentDate >= $startDateTime && $endDateTime == null)
                        || ($currentDate <= $endDateTime && $startDateTime == null)
                            || ($currentDate >= $startDateTime && $currentDate <= $endDateTime))
                {
                    if(in_array($discount['group_id'], $groups))
                    {
                        //If quantity is greater than 1 than only show the discount
                        if($discount['quantity'] > 1)
                        {
                            $taxApplied = self::getTaxAppliedOnProduct($product, $customer, $discount['price'], $store);
                            $formattedPrice = self::getFormattedPrice($discount['price'] + $taxApplied);
                            $value  = $purchaseLabel . ' ' . $discount['quantity'] . ' ' . $orOrMore  . ' ' . $productPriceLabel . ' ' . $formattedPrice;
                            if($inputTemplate != null)
                            {
                                $discountStr = str_replace('{#discount#}', $value, $inputTemplate);
                            }
                            else
                            {
                                $discountStr = $value;
                            }
                            return $discountStr;
                        }
                    }
                }
            }
        }
        return $discountStr;
    }
    
    /**
     * Get product
     * @param int $productId
     * @param string $language
     * @return array
     */
    public static function getProduct($productId, $language = null)
    {
        if($language == null)
        {
            $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $productTable           = Product::tableName();
        $productTranslatedTable = ProductTranslated::tableName();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $productTable WHERE id = :id", 'params' => [':id' => $productId]]);
        $sql                    = "SELECT p.* , pt.name, pt.alias, pt.metakeywords, pt.metadescription, pt.description
                                   FROM $productTable p, $productTranslatedTable pt WHERE p.id = :id AND p.id = pt.owner_id AND pt.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':id' => $productId, ':lan' => $language])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get attributes for product
     * @param int $productId
     * @param string $language
     * @return array
     */
    public static function getAttributes($productId, $language = null)
    {
        if($language == null)
        {
            $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $attributeTable       = ProductAttribute::tableName();
        $attributeTranslatedTable = ProductAttributeTranslated::tableName();
        $mappingTable         = ProductAttributeMapping::tableName();
        $groupTrTable         = ProductAttributeGroupTranslated::tableName();
        $sql                  = "SELECT pa.* , pat.name, pam.attribute_value, pagtr.name AS groupName FROM $attributeTable pa, $attributeTranslatedTable pat, $mappingTable pam, 
                                $groupTrTable pagtr WHERE pam.product_id = :id AND pam.attribute_id = pa.id AND pa.id = pat.owner_id 
                                AND pat.language = :lan AND pa.attribute_group = pagtr.owner_id AND pagtr.language = :lan2";
        $connection           = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':id' => $productId, ':lan' => $language, ':lan2' => $language])->queryAll();
    }
    
    /**
     * Get product
     * @param int $productId
     * @param string $language
     * @return array
     */
    public static function getRelatedProducts($productId, $language = null)
    {
        if($language == null)
        {
            $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $productTable           = Product::tableName();
        $productTranslatedTable = ProductTranslated::tableName();
        $mappingTableName       = ProductRelatedProductMapping::tableName();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $mappingTableName WHERE product_id = :id", 'params' => [':id' => $productId]]);
        $sql                    = "SELECT tp.* , tpt.name, tpt.alias, tpt.metakeywords, tpt.metadescription, tpt.description
                                   FROM $productTable tp, $productTranslatedTable tpt, $mappingTableName tprpm 
                                   WHERE tprpm.product_id = :pid AND tprpm.related_product_id = tp.id AND tp.id = tpt.owner_id AND tpt.language = :lan LIMIT 6";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Does product have required options
     * @param int $productId
     * @return int
     */
    public static function doesProductHaveRequiredOptions($productId)
    {
        return ProductOptionMapping::find()->where('product_id = :pId AND required = :req', [':pId' => $productId, ':req' => 1])->count();
    }
    
    /**
     * Get related products count
     * @param int $productId
     * @return int
     */
    public static function getRelatedProductsCount($productId)
    {
        return ProductRelatedProductMapping::find()->where('product_id = :pId', [':pId' => $productId])->count();
    }
    
    /**
     * Get all products
     * @return array
     */
    public static function getAllProducts()
    {
        $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        $productTable           = Product::tableName();
        $productTrTable         = ProductTranslated::tableName();
        $sql                    = "SELECT pr.*, prt.name 
                                   FROM $productTable pr, $productTrTable prt 
                                   WHERE pr.id = prt.owner_id AND prt.language = :lan AND pr.status = :status";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':lan' => $language, ':status' => Product::STATUS_ACTIVE])->queryAll();
    }
    
    /**
     * Get product discounts
     * @param int $productId
     * @return array
     */
    public static function getProductDiscounts($productId)
    {
        $discountTable          = ProductDiscount::tableName();
        $sql                    = "SELECT * 
                                   FROM $discountTable 
                                   WHERE product_id = :pid";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId])->queryAll();
    }
    
    /**
     * Get product specials
     * @param int $productId
     * @return array
     */
    public static function getProductSpecials($productId)
    {
        $specialTable           = ProductSpecial::tableName();
        $sql                    = "SELECT * 
                                   FROM $specialTable 
                                   WHERE product_id = :pid";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId])->queryAll();
    }
    
    /**
     * Get assigned options for the product
     * @param int $productId
     * @param string $language
     * @return array
     */
    public static function getAssignedOptions($productId, $language = null)
    {
        if($language == null)
        {
            $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $ovTrTableName  = UsniAdaptor::tablePrefix(). 'product_option_value_translated';
        $ovTableName    = UsniAdaptor::tablePrefix(). 'product_option_value';
        $poTableName    = UsniAdaptor::tablePrefix(). 'product_option';
        $poTrTableName  = UsniAdaptor::tablePrefix(). 'product_option_translated';
        $mappingDetailsTableName = UsniAdaptor::tablePrefix(). 'product_option_mapping_details';
        $mappingTableName   = UsniAdaptor::tablePrefix(). 'product_option_mapping';
        $sql            = "SELECT tpom.id, tpomd.price, tpomd.price_prefix, tpov.id as optionValueId, 
                            tpovTr.value, tpo.type, tpo.id AS optionId, tpoTr.display_name, tpom.required,
                            tpomd.weight, tpomd.weight_prefix, tpomd.quantity, tpomd.subtract_stock, tpo.sort_order
                            FROM $mappingTableName tpom, $mappingDetailsTableName tpomd, $ovTableName tpov,
                                      $ovTrTableName tpovTr, $poTableName tpo, $poTrTableName tpoTr 
                            WHERE tpom.product_id = :pid AND tpom.id = tpomd.mapping_id AND tpomd.option_value_id = tpov.id AND tpov.id = tpovTr.owner_id 
                                  AND tpovTr.language = :lan AND tpov.option_id = tpo.id AND tpo.id = tpoTr.owner_id and tpoTr.language = :lan
                         ";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => $language])->queryAll();
    }
    
    /**
     * Get product images
     * @param int $productId
     * @return array
     */
    public static function getProductImages($productId)
    {
        $imagesTable    = ProductImage::tableName();
        $imagesTrTable  = ProductImageTranslated::tableName();
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $imagesTable WHERE product_id = :pid", 'params' => [':pid' => $productId]]);
        $sql            = "SELECT it.*, itr.caption 
                           FROM $imagesTable it, $imagesTrTable itr
                           WHERE product_id = :pid AND it.id = itr.owner_id AND language = :lan";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => 'en-US'])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get customer rating for the product
     * @param int $customerId
     * @param int $productId
     * @return int
     */
    public static function getCustomerRating($customerId, $productId)
    {
        $custTable      = Customer::tableName();
        $ratingTable    = ProductRating::tableName();
        $sql            = "SELECT rating 
                           FROM $custTable c, $ratingTable pr
                           WHERE product_id = :pid AND pr.created_by = :cid";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':cid' => $customerId])->queryOne();
    }
    
    /**
     * Get tag items
     * @param string $query
     * @param string $language
     * @return array
     */
    public static function getTagItems($query, $language = null)
    {
        if($language == null)
        {
            $language = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $models = TagTranslated::find()->where('name LIKE :name AND language = :lan', [':name' => "%$query%", ':lan' => $language])->asArray()->all();
        $items = [];
        if(!empty($models))
        {
            foreach ($models as $model)
            {
                $items[] = ['name' => $model['name']];
            }
        }
        return $items;
    }
    
    /**
     * Get product categories
     * @param int $productId
     * @param string $language
     * @return array
     */
    public static function getProductCategories($productId, $language = null)
    {
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $categoryTableName  = UsniAdaptor::tablePrefix() . 'product_category';
        $mappingTableName   = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $trTableName        = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $mappingTableName"]);
        $sql                = "SELECT c.*, ct.name 
                                   FROM $categoryTableName c, $mappingTableName cm, $trTableName ct 
                                   WHERE cm.product_id = :pid AND cm.category_id = c.id AND c.id = ct.owner_id AND ct.language = :lan";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Sends review email
     * @param Model $review
     * @return boolean
     */
    public static function sendReviewNotification($review)
    {
        $mailer             = UsniAdaptor::app()->mailer;
        $reviewRecord       = self::getReview($review['id']);             
        $emailNotification  = new ProductReviewEmailNotification(['review' => $reviewRecord]);
        $mailer->emailNotification = $emailNotification;
        $message            = $mailer->compose();
        list($fromName, $fromAddress) = NotificationUtil::getSystemFromAddressData();
        $super              = UserUtil::getUserById(User::SUPER_USER_ID);
        $isSent             = $message->setFrom([$fromAddress => $fromName])
                            ->setTo($super['email'])
                            ->setSubject($emailNotification->getSubject())
                            ->send();
        $data               = serialize(array(
                                'fromName'    => $fromName,
                                'fromAddress' => $fromAddress,
                                'toAddress'   => $super['email'],
                                'subject'     => $emailNotification->getSubject(),
                                'body'        => $message->toString()));
        $status             = $isSent === true ? Notification::STATUS_SENT : Notification::STATUS_PENDING;
        //Save notification
        return NotificationUtil::saveEmailNotification($emailNotification, $status, $data);
    }
    
    /**
     * Get product review
     * @param int $reviewId
     * @param string $language
     * @return array
     */
    public static function getReview($reviewId, $language = null)
    {
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $reviewTableName    = UsniAdaptor::tablePrefix() . 'product_review';
        $reviewTrTableName  = UsniAdaptor::tablePrefix() . 'product_review_translated';
        $productTableName   = UsniAdaptor::tablePrefix() . 'product';
        $productTrTableName = UsniAdaptor::tablePrefix() . 'product_translated';
        
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $reviewTableName"]);
        $sql                = "SELECT pr.*, prt.review, ptt.name AS product_name 
                                   FROM $reviewTableName pr, $reviewTrTableName prt, $productTableName pt, $productTrTableName ptt 
                                   WHERE pr.id = :id AND pr.id = prt.owner_id AND prt.language = :lan1 AND 
                                   pr.product_id = pt.id AND pt.id = ptt.owner_id AND ptt.language = :lan2
                                   ";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':id' => $reviewId, ':lan1' => $language, ':lan2' => $language])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get current store's products.
     * @return array
     */
    public static function getStoreProducts($limit = null)
    {
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $trProductTable         = UsniAdaptor::tablePrefix() . 'product_translated';
        $mappingTable           = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $dataCategoryId         = UsniAdaptor::app()->storeManager->getSelectedStoreDataCategory();
        $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $productTable"]);
        $sql                    = "SELECT tp.*, tpt.name, tpt.description 
                                   FROM $mappingTable tpcm, $productTable tp, $trProductTable tpt
                                   WHERE tpcm.data_category_id = :dci AND tpcm.product_id = tp.id AND tp.status = :status AND tp.id = tpt.owner_id AND tpt.language = :lang
                                   GROUP BY tp.id
                                   ORDER BY tp.id DESC";
        if($limit != null)
        {
            $sql .= " LIMIT $limit";
        }
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':dci' => $dataCategoryId, ':status' => StatusUtil::STATUS_ACTIVE, ':lang' => $language];
        $records                = $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
        return $records;
    }
    
    /**
     * Get tax class
     * @param int $taxClassId
     * @param string $language
     * @return array
     */
    public static function getTaxClass($taxClassId, $language = null)
    {
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $tableName          = UsniAdaptor::tablePrefix() . 'product_tax_class';
        $trTableName        = UsniAdaptor::tablePrefix() . 'product_tax_class_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                = "SELECT t.*, tt.name 
                               FROM $tableName t, $trTableName tt 
                               WHERE t.id = :tid AND t.id = tt.owner_id AND tt.language = :lan";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':tid' => $taxClassId, ':lan' => $language])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Render out of stock message
     * @param string $name
     * @param int $stock_status
     * @return string
     */
    public static function renderOutOfStockMessage($name, $stock_status)
    {
        $outOfStockWarningSetting   = StoreUtil::getSettingValue('show_out_of_stock_warning');
        $outOfStockCheckoutSetting  = StoreUtil::getSettingValue('allow_out_of_stock_checkout');
        if((!$outOfStockCheckoutSetting) && $outOfStockWarningSetting && $stock_status == ProductUtil::OUT_OF_STOCK)
        {
            return $name . '<span class="badge">' . UsniAdaptor::t('products', 'Out of Stock') . "</span>";
        }
        else
        {
            return $name; 
        }
    }
    
    /**
     * Get product option values
     * @param int $optionId
     * @param string $language
     * @return array
     */
    public static function getProductOptionValues($optionId, $language = null)
    {
        if($language == null)
        {
            $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $ovTable        = UsniAdaptor::tablePrefix() . 'product_option_value';
        $ovTrTable      = UsniAdaptor::tablePrefix() . 'product_option_value_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $ovTable"]);
        $sql            = "SELECT ov.*, ovTr.value 
                           FROM $ovTable ov, $ovTrTable ovTr WHERE ov.option_id = :oid AND ov.id = ovTr.owner_id AND ovTr.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':oid' => $optionId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get is featured product.
     * @param boolean $isFeatured
     * @return string
     */
    public static function getIsFeaturedProduct($isFeatured)
    {
        if($isFeatured)
        {
            return UsniAdaptor::t('application', 'Yes');
        }
        return UsniAdaptor::t('application', 'No');
    }
    
    /**
     * Get product tags.
     * @param int $productId
     * @return array
     */
    public static function getProductTags($productId)
    {
        $productTagMappingTable = UsniAdaptor::tablePrefix() . 'product_tag_mapping';
        $tagTable               = UsniAdaptor::tablePrefix() . 'tag';
        $trTagTable             = UsniAdaptor::tablePrefix() . 'tag_translated';
        $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        $sql                    = "SELECT ttt.name 
                                   FROM $productTagMappingTable ptm, $tagTable tt, $trTagTable ttt
                                   WHERE ptm.product_id = :pid AND ptm.tag_id = tt.id AND tt.id = ttt.owner_id AND ttt.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lang' => $language])->queryAll();        
    }
    
    /**
     * Get product count by attribute
     * @param string $attribute
     * @param mixed $value
     * @return array
     */
    public static function getCountByAttribute($attribute, $value)
    {
        $productTable           = Product::tableName();
        $sql                    = "SELECT COUNT(*) as cnt 
                                   FROM $productTable pr 
                                   WHERE pr." . $attribute  . "= :attr";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':attr' => $value])->queryScalar();
    }
    
    /**
     * Get product by attribute.
     * @param string $attribute
     * @param integer $value
     * @return array.
     */
    public static function getProductByAttribute($attribute, $value)
    {
        $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $trProductTable         = UsniAdaptor::tablePrefix() . 'product_translated';
        $sql                    = "SELECT p.*, pt.name, pt.alias, pt.description
                                   FROM $productTable p, $trProductTable pt
                                   WHERE p." . $attribute  . "= :tcid AND p.id = pt.owner_id AND pt.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':tcid' => $value, ':lang' => $language];
        $records                = $connection->createCommand($sql, $params)->queryAll();
        return $records;
    }
    
    /**
     * Get product attribute based on product id
     * @param integer $productId
     * @return array
     */
    public static function getProductAttributeBasedOnProduct($productId,  $language = null)
    {
        if($language == null)
        {
            $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $prAttrMappingTableName = UsniAdaptor::tablePrefix() . 'product_attribute_mapping';
        $prAttributeTableName   = UsniAdaptor::tablePrefix() . 'product_attribute';
        $prAttributeTrTableName = UsniAdaptor::tablePrefix() . 'product_attribute_translated';
        $sql                    = "SELECT pam.*, pat.name
                                   FROM $prAttrMappingTableName pam, $prAttributeTableName pa, $prAttributeTrTableName pat
                                   WHERE pam.product_id = :pid AND pam.attribute_id = pa.id AND pa.id = pat.owner_id AND pat.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':pid' =>  $productId, ':lan' => $language];
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get product discount by attribute.
     * @param string $attribute
     * @param integer $value
     * @return array.
     */
    public static function getProductDiscountByAttribute($attribute, $value)
    {
        $productDiscountTable   = UsniAdaptor::tablePrefix() . 'product_discount';
        $sql                    = "SELECT pd.*
                                   FROM $productDiscountTable pd
                                   WHERE pd." . $attribute  . "= :gid";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':gid' => $value];
        return $connection->createCommand($sql, $params)->queryAll();
    }
    
    /**
     * Get product special by attribute.
     * @param string $attribute
     * @param integer $value
     * @return array.
     */
    public static function getProductSpecialByAttribute($attribute, $value)
    {
        $productSpecialTable    = UsniAdaptor::tablePrefix() . 'product_special';
        $sql                    = "SELECT ps.*
                                   FROM $productSpecialTable ps
                                   WHERE ps." . $attribute  . "= :gid";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':gid' => $value];
        return $connection->createCommand($sql, $params)->queryAll();
    }
    
    /**
     * Check if product allowed to perform action.
     * @param integer $productId
     * @return boolean
     */
    public static function checkIfProductAllowedToPerformAction($productId)
    {
        $productIdArray     =  [];
        $records            = self::getStoreProducts();
        foreach ($records as $record)
        {
            $productIdArray[] = $record['id'];
        }
        if(!in_array($productId, $productIdArray))
        {
            return false;
        }
        return true;
    }
}