<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\utils;

use usni\UsniAdaptor;
use customer\utils\CustomerUtil;
use usni\library\modules\users\models\Address;
use products\utils\ProductUtil;
use common\utils\ApplicationUtil;
use common\modules\order\utils\OrderUtil;
use customer\models\Customer;
/**
 * Utility functions related to cart.
 * 
 * @package cart\utils
 */
class CartUtil
{
    /**
     * Get products.
     * @param Cart $cart
     * @return array
     */
    public static function getProducts($cart)
    {
        $products   = [];
        if($cart != null)
        {
            foreach($cart->itemsList as $productId => $cartData)
            {
                $products[] = $cartData;
            }
        }
        return $products;
    }
    
    /**
     * Register remove from cart script.
     * 
     * @return void
     */
    public static function registerRemoveFromCartScript()
    {
        $url            = UsniAdaptor::app()->request->getUrl();
        $removeClass    = 'cart-remove';
        $removeUrl      = UsniAdaptor::createUrl('cart/default/remove');
        $js = "$('body').on('click', '.{$removeClass}', function(e){
                    var itemCode    = $(this).data('itemcode');
                    $.ajax({
                            url: '{$removeUrl}',
                            type: 'post',
                            data: 'item_code=' + itemCode,
                            dataType: 'json',
                            success: function(json) {
                                  window.location.href = '{$url}';
                            }
                        });
                        e.stopImmediatePropagation();
                        return false;
              })";
        return $js;
    }
    
    /**
     * Register update cart script.
     * 
     * @return void
     */
    public static function registerUpdateCartScript()
    {
        $updateClass    = 'cart-update';
        $updateUrl      = UsniAdaptor::createUrl('cart/default/update');
        $js = "$('body').on('click', '.{$updateClass}', function(e){
                    var itemCode = $(this).data('itemcode');
                    var qty = $(this).closest('tr').find('.cart-qty').val();
                    var obj = $(this);
                    $.ajax({
                            url: '{$updateUrl}',
                            type: 'post',
                            data: 'item_code=' + itemCode + '&qty=' + qty,
                            dataType: 'json',
                            success: function(json) {
                                if (json['error']) {
                                    var errorContainer = obj.closest('td').find('.input-error').html(json['error']);
                                    errorContainer.show();
                                }
                                else if (json['content']) {
                                    if($('#shopping-container').length)
                                    {
                                        $('#shopping-container').html(json['content']);
                                    }
                                    //Need to update cart at the top
                                    $('#cart').html(json['headerCartContent']);
                                }	
                            }
                        });
                        e.stopImmediatePropagation();
                        return false;
              })";
        return $js;
    }
    
    /**
     * Get header cart content.
     * @return string
     */
    public static function getHeaderCartData()
    {
        $cart           = ApplicationUtil::getCart();
        $cartItemCnt    = $cart->getCount();
        $cartCost       = $cart->getFormattedAmount();
        return ['itemCount' => $cartItemCnt, 'itemCost' => $cartCost];
    }
    
    /**
     * Populate customer address in form model
     * @param Model $modelEditForm
     * @param Customer $customer
     * @param int $type
     */
    public static function populateCustomerAddressInFormModel($modelEditForm, $customer, $type)
    {
        $addressModelToFormFieldMapping = ['country', 'postal_code', 'state', 'address1', 'address2', 'city'];
        if($customer == null)
        {
            $address = new Address();
        }
        else
        {
            $address = CustomerUtil::getAddressByType($customer, $type);
        }
        if($address != false)
        {
            foreach ($addressModelToFormFieldMapping as $attribute)
            {
                if(property_exists($modelEditForm, $attribute) && $modelEditForm->$attribute == '')
                {
                    $modelEditForm->$attribute = $address[$attribute];
                }
            }
        }
    }
    
    /**
     * Populate customer metadata in session
     * @return void
     */
    public static function populateCustomerMetadataInSession()
    {
        $itemsList        = CustomerUtil::getMetadataItems('cart');
        if(UsniAdaptor::app()->customer instanceof \frontend\components\Customer)
        {
            $cart             = ApplicationUtil::getCart();
            $cart->itemsList  = $itemsList;
            UsniAdaptor::app()->customer->updateSession('cart', $cart);
        }
    }
    
    /**
     * Populate customer info in model
     * @param Model $model
     * @param int $type
     * @param integer $customerId
     * @param int $type
     */
    public static function populateCustomerInfoInFormModel($model, $type, $customerId)
    {
        if($customerId != null && $customerId != Customer::GUEST_CUSTOMER_ID)
        {
            $address = OrderUtil::getLatestOrderAddressByType($customerId, $type);
            if($address !== false)
            {
                $model->attributes = $address;
            }
        }
    }
    
    /**
     * Get option code by options for product
     * @param int $productId
     * @param array $options
     * @return string
     */
    public static function getItemCode($productId, $options = [])
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
     * Get previous link metadata.
     * @param string $id
     * @return array
     */
    public static function getPreviousLinkElementData($id)
    {
        return array(
            'type'  => 'link',
            'label' => UsniAdaptor::t('cart', 'Back'),
            'url'   => '#',
            'id'    => $id
        );
    }
    
    /**
     * Get product id and options by item code
     * @param string $itemCode
     * @return string
     */
    public static function getProductAndOptionsByItemCode($itemCode)
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
     * Register same as billing address script
     * @param View $view
     */
    public static function registerSameAsBillingAddressScript($view)
    {
        $sameAsBillingScript = "$('#deliveryinfoeditform-sameasbillingaddress').change(function(){
                                    var attributes = ['firstname', 'lastname', 'address1', 'city', 'country', 'postal_code', 'state', 'address2', 'email', 'mobilephone'];
                                    var c = this.checked;
                                    if(c)
                                    {
                                          $.each(attributes, function(index, value){
                                            if(value == 'country')
                                            {
                                                var inputValue = $('#billinginfoeditform-' + value).select2('val');
                                                $('#deliveryinfoeditform-' + value).select2('val', inputValue);
                                            }
                                            else
                                            {
                                                var inputValue = $('#billinginfoeditform-' + value).val();
                                                $('#deliveryinfoeditform-' + value).val(inputValue);
                                            }
                                          });
                                    }
                                })";
        $view->registerJs($sameAsBillingScript);
    }
    
    /**
     * 
     * @param type $cart
     * @param type $product
     * @param type $inputQty
     * @param type $productOptions
     * @param type $inputOptions
     * @return boolean
     */
    public static function processAddToCartItem($cart, $product, $inputQty, $inputOptions = [])
    {
        $itemCode = CartUtil::getItemCode($product['id'], $inputOptions);
        $itemQuantityInCart = $cart->getItemCountInCart($itemCode);
        //If input quantity plus quantity in cart < min quantity
        if($itemQuantityInCart + $inputQty < $product['minimum_quantity'])
        {
            $result     = ['success' => false, 'errors' => [], 'qtyError' => true];
        }
        else
        {
            $errors  = ProductUtil::getErrorsForOptions($product['id'], $inputOptions);
            if(empty($errors))
            {
                /*
                 * We need to think following scenarios
                 * a) Today i add a product to the cart having base price as 100$ but i dont checkout. Next day
                 * when i come to the site a special has started so my price in cart should be 80$
                 * b) On the same product a discount is there for 2 or more products with price as 70$, thus if i
                 * add another product my cart should show 2 but the price would be 70$
                 */
                $modifiedPrice = ProductUtil::getPriceModificationBySelectedOptions($inputOptions, $product['id'], $inputQty);
                $cart->addItem($product, $inputQty, $modifiedPrice, $inputOptions);
                $result     = ['success' => true];
            }
            else
            {
                $result     = ['success' => false, 'errors' => $errors, 'qtyError' => false];
            }
        }
        return $result;
    }
}