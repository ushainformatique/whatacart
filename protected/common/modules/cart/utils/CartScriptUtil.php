<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\utils;

use usni\UsniAdaptor;
/**
 * CartScriptUtil class file.
 * 
 * @package cart\utils
 */
class CartScriptUtil
{   
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
}