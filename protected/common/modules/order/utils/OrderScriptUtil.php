<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\utils;

use usni\UsniAdaptor;
/**
 * OrderScriptUtil class file.
 * 
 * @package common\modules\order\utils
 */
class OrderScriptUtil
{   
    /**
     * Add order product script.
     * @return string
     */
    public static function addOrderProductScript()
    {
        $url = UsniAdaptor::createUrl('order/default/add-product');
        $productError = UsniAdaptor::t('products', 'Product can not be blank');
        $qtyError     = UsniAdaptor::t('order', 'Input Quantity should be >= minimum quantity');
        $js = "     
                    var dataString = '';
                    $('body').on('click', '#addproduct-button', function(e){
                    var productId = $('#orderproductform-product_id').val();
                    if(productId == '')
                    {
                        var container = $('#orderproductform-product_id').closest('.form-group');
                        $(container).find('.help-block').html('{$productError}');
                        $(container).removeClass('has-error');
                        $(container).removeClass('has-success');
                        $(container).addClass('has-error');   
                        return false;
                    }
                    $.ajax({
                            url: '{$url}',
                            type: 'post',
                            data: $('#orderproducteditview').serialize(),
                            dataType: 'json',
                            beforeSend: function()
                                        {
                                            attachButtonLoader($('#addproduct-button'));
                                        },
                            success: function(json) 
                            {
                                removeButtonLoader($('#addproduct-button'));
                                if (json['success']) 
                                {
                                    $('#order-cart-products').html(json['data']);
                                    $('#orderproductform-product_id').val('').change();
                                    $('#orderproductform-quantity').val('1');
                                    $('#order-product-options').html('');
                                }
                                else
                                {
                                    if(json['qtyError'])
                                    {
                                        $('.field-orderproductform-quantity').addClass('has-error');
                                        $('.field-orderproductform-quantity').find('.help-block-error').html('{$qtyError}');
                                    }
                                    else
                                    {
                                        $.fn.renderOptionErrors(json['errors'], 'field-productoptionmapping', 'has-error',
                                                                                                      'has-success');
                                    }
                                }
                            }
                        });
                    e.stopImmediatePropagation();
                    return false;
               })";
        return $js;
    }
    
    /**
     * Render option fields script
     * @return string
     */
    public static function renderOptionFieldsScript()
    {
        $url                = UsniAdaptor::createUrl('order/default/render-option-form');
        $script             = "$('#orderproductform-product_id').on('change',
                            function(event, jqXHR, settings)
                            {
                                var dropDown    = $(this);
                                var value       = $(this).val();
                                if(value == '')
                                {
                                    return false;
                                }
                                else
                                {
                                    $.ajax({
                                            url: '{$url}',
                                            type: 'get',
                                            data: 'productId=' + value,
                                            beforeSend: function()
                                                        {
                                                            attachButtonLoader($('#orderproductform-product_id'));
                                                        },
                                            success: function(data){
                                                removeButtonLoader($('#orderproductform-product_id'));
                                                $('#order-product-options').html(data);
                                            }
                                        });
                                }
                            }
                        )";
        return $script;
    }
    
    /**
     * Register remove from cart script.
     * 
     * @return void
     */
    public static function registerRemoveFromCartScript()
    {
        $removeClass    = 'order-cart-remove';
        $removeUrl      = UsniAdaptor::createUrl('order/default/remove');
        $js = "$('body').on('click', '.{$removeClass}', function(e){
                    var itemCode    = $(this).data('itemcode');
                    $.ajax({
                            url: '{$removeUrl}',
                            type: 'post',
                            data: 'item_code=' + itemCode,
                            dataType: 'json',
                            success: function(json) {
                                if (json['data']) {
                                    $('#order-cart-products').html(json['data']);
                                }	
                            }
                        });
                e.stopImmediatePropagation();
                return false;
              })";
        return $js;
    }
}
