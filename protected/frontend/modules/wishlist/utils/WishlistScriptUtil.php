<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace wishlist\utils;

use usni\UsniAdaptor;
/**
 * WishlistScriptUtil class file.
 * 
 * @package cart\utils
 */
class WishlistScriptUtil
{
    /**
     * Add to wish list script
     * @return string
     */
    public static function addToWishListScript()
    {
        $url = UsniAdaptor::createUrl('wishlist/default/add-to-wishlist');
        $js = "$('body').on('click', '.product-wishlist', function(){
                    var selectedVal = $(this).data('productid');
                    $.ajax({
                            url: '{$url}',
                            type: 'post',
                            data: 'productId=' + selectedVal,
                            dataType: 'json',
                            success: function(json) {
                                if (json['success']) {
                                    $('.success').fadeIn('slow');
                                    $('.top-nav-wishlist').html(json['data']);
                                    $('html, body').animate({ scrollTop: 0 }, 'slow'); 
                                }	
                            }
                        });
               })";
        return $js;
    }
    
    /**
     * Remove from wishlist script
     * @return string
     */
    public static function removeFromWishListScript()
    {
        $url = UsniAdaptor::createUrl('wishlist/default/remove');
        $js = "$('body').on('click', '.wishlist-remove', function(){
                    var selectedVal = $(this).data('productid');
                    $.ajax({
                            url: '{$url}',
                            type: 'post',
                            data: 'product_id=' + selectedVal,
                            dataType: 'json',
                            success: function(json) {
                                if (json['success']) {
                                    $('.success').fadeIn('slow');
                                    $('.top-nav-wishlist').html(json['headerWishlistContent']);
                                    $('#wishlist-full').html(json['content']);
                                }	
                            }
                        });
               })";
        return $js;
    }
}