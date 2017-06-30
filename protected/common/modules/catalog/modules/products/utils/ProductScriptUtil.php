<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\utils;

use usni\UsniAdaptor;
/**
 * ProductScriptUtil class file
 *
 * @package products\utils
 */
class ProductScriptUtil
{   
    /**
     * Add to cart script
     * @return string
     */
    public static function addToCartScriptOnDetail()
    {
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
     * Add to compare productst script
     * @return string
     */
    public static function addToCompareProductsScript()
    {
        $url = UsniAdaptor::createUrl('/catalog/products/site/add-to-compare');
        $js = "$('body').on('click', '.product-compare, .add-product-compare', function(){
                    var selectedVal = $(this).data('productid');
                    $.ajax({
                            url: '{$url}',
                            type: 'post',
                            data: 'productId=' + selectedVal,
                            dataType: 'json',
                            success: function(json) {
                                if (json['success']) {
                                    $('.success').fadeIn('slow');
                                    $('.top-nav-compareproduct').html(json['data']);
                                    $('html, body').animate({ scrollTop: 0 }, 'slow'); 
                                }	
                            }
                        });
               })";
        return $js;
    }
    
    /**
     * Remove from compare products list script
     * @return string
     */
    public static function removeFromCompareProductScript()
    {
        $url = UsniAdaptor::createUrl('catalog/products/site/remove');
        $js = "$('body').on('click', '.productcompare-remove', function(){
                    var selectedVal = $(this).data('productid');
                    $.ajax({
                            url: '{$url}',
                            type: 'get',
                            data: 'product_id=' + selectedVal,
                            dataType: 'json',
                            success: function(json) {
                                if (json['success']) {
                                    $('.success').fadeIn('slow');
                                    $('.top-nav-compareproduct').html(json['headerCompareProductListContent']);
                                    $.pjax.reload({container:'#comparegridview-pjax', 'timeout':2000});
                                }	
                            }
                        });
               })";
        return $js;
    }
}