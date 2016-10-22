<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace wishlist\utils;

use usni\UsniAdaptor;
use customer\utils\CustomerUtil;
use products\models\Product;
use common\utils\ApplicationUtil;
/**
 * Utility functions related to Wishlist
 * @package cart\utils
 */
class WishlistUtil
{
    /**
     * Populate customer metadata in session
     * @return void
     */
    public static function populateCustomerMetadataInSession()
    {
        $itemsList        = CustomerUtil::getMetadataItems('wishlist');
        if(UsniAdaptor::app()->customer != null)
        {
            $wishList         = UsniAdaptor::app()->customer->wishlist;
            $wishList->itemsList  = $itemsList;
            UsniAdaptor::app()->customer->updateSession('wishlist', $wishList);
        }
    }
    
    /**
     * Get products.
     * @return array
     */
    public static function getProducts()
    {
        $products   = [];
        $wishList   = ApplicationUtil::getWishList();
        if($wishList->itemsList != null)
        {
            $records = Product::find()->where(['id' => $wishList->itemsList])->all();
            foreach($records as $record)
            {
                $data['product_id']  = $record->id;
                $data['name']        = $record->name;
                $data['model']       = $record->model;
                $data['unit_price']  = $record->price;
                $data['url']         = UsniAdaptor::createUrl('catalog/products/site/detail', ['id' => $data['product_id']]);
                $data['thumbnail']   = $record->image;
                $data['stock_status']   = $record->stock_status;
                $products[] = $data;
            }
        }
        return $products;
    }
    
    /**
     * Renders wishlist in top navigation.
     * @return string
     */
    public static function renderWishlistInTopnav()
    {
        $wishlist   = ApplicationUtil::getWishList();
        $count      = $wishlist->getCount();
        $label      = UsniAdaptor::t('wishlist', 'Wish List');
        if($count > 0)
        {
            return $label . ' (' . $count . ')';
        }
        return $label;
    }
    
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
                                    //$('.wishlist-product').load(location.href + ' .wishlist-product');
                                }	
                            }
                        });
               })";
        return $js;
    }
}
?>