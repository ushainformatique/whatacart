<?php

/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\web;

use usni\UsniAdaptor;
use usni\library\utils\Html;
use products\utils\ProductScriptUtil;
use wishlist\utils\WishlistScriptUtil;
use usni\library\widgets\Lightbox;
/**
 * View object for product front end
 *
 * @package products\web
 */
class ProductView extends \frontend\web\View
{
    /**
     * @var array containing all the data required for the view
     */
    public $product;
    
    /**
     * Get manufacturer url
     * @return string
     */
    public function getManufacturerName()
    {
        if ($this->product['manufacturerName'] != null)
        {
            $url = UsniAdaptor::createUrl('manufacturer/site/list', ['manufacturerId' => $this->product['manufacturer']]);
            return Html::a($this->product['manufacturerName'], $url);
        }
        return UsniAdaptor::t('application', '(not set)');
    }

    /**
     * Get review summary
     * @return string
     */
    public function getReviewSummary()
    {
        //Product review settings check.
        $reviewSetting = $this->product['allowReviews'];
        $ratingContent = null;
        $reviewContent = null;
        $guestReviewSetting = $this->product['allowGuestReviews'];
        //Logged in user
        if ($reviewSetting && UsniAdaptor::app()->user->isGuest === false
            || (($guestReviewSetting && UsniAdaptor::app()->user->isGuest === true && (bool) $reviewSetting === true)))
        {
            $ratingContent = $this->render('/front/_rating', ['product' => $this->product]);
            $reviewContent = $this->render('/front/_reviewsummary', ['productId' => $this->product['id'], 
                                                                                  'reviewCount' => $this->product['reviewCnt']]);
        }
        return $ratingContent . $reviewContent;
    }

    /**
     * @inheritdoc
     */
    public function registerScripts()
    {
        $cartJs             = ProductScriptUtil::addToCartScriptOnDetail();
        $wishlistSetting    = $this->product['allowWishlist'];
        if ($wishlistSetting)
        {
            $wishListJs = WishlistScriptUtil::addToWishListScript();
            $this->registerJs($wishListJs);
        }
        $compareProductsSetting = $this->product['allowCompare'];
        if ($compareProductsSetting)
        {
            $compareProductsJs = ProductScriptUtil::addToCompareProductsScript();
            $this->registerJs($compareProductsJs);
        }
        $this->registerJs($cartJs);
        $this->registerJs(ProductScriptUtil::renderOptionErrorsScript());
        $reviewJs = "$('body').on('click', '#product-write-review',function(){
                            $('a[href=\'#tab-review\']').trigger('click');
                            $('html, body').animate({
                                    scrollTop: $('#reviewformcontainer').offset().top
                                }, 1000);
                        });
                        $('body').on('click', '#product-list-review',function(){
                            $('a[href=\'#tab-review\']').trigger('click');
                            $('html, body').animate({
                                    scrollTop: $('#review-listview').offset().top
                                }, 1000);
                        });
                        ";
        $this->registerJs($reviewJs);
    }

    /**
     * Get product tags.
     * @param array $tags Description
     * @return string.
     */
    public function renderTags($tags)
    {
        $tagsString = null;
        if (!empty($tags))
        {
            foreach ($tags as $tag)
            {
                $tagsString .= Html::a($tag['name'], UsniAdaptor::createUrl('catalog/products/site/tag-list', ['name' => $tag['name']])) . ' ,';
            }
        }
        return $tagsString;
    }
    
    /**
     * Render images.
     * @return string
     */
    public function renderImages()
    {
        $uniqueId                   = uniqid('image-');
        $images                     = $this->product['images'];
        $productThumbImageWidth     = UsniAdaptor::app()->storeManager->getImageSetting('product_list_image_width', 150);
        $productThumbImageHeight    = UsniAdaptor::app()->storeManager->getImageSetting('product_list_image_height', 150);
        $content    = null;
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
                                    'title'         => $this->product['name'],
                                    'group'         => $uniqueId,
                                    'class'         => 'col-sm-3',
                                    'thumbclass'    => 'img-responsive',
                                    'id'            => $this->product['name'] . '-' . $key
                                ];
            }
            $content   = Lightbox::widget([
                                            'view' => $this,
                                            'containerTag' => 'div',
                                            'containerOptions' => ['class' => 'row'],
                                            'files' => $files
                                          ]);
        }
        return $content;
    }
    
    /**
     * Get discount text
     * @return string
     */
    public function getDiscountText()
    {
        $discountStr        = null;
        $discountToDisplay  = $this->product['discountToDisplay'];
        if($discountToDisplay != null)
        {
            $orOrMore           = UsniAdaptor::t('products', 'or more');
            $purchaseLabel      = UsniAdaptor::t('products', 'On purchase of');
            $productPriceLabel  = UsniAdaptor::t('products', 'Products discounted price would be');
            $formattedPrice     = $this->getFormattedPrice($discountToDisplay['priceIncludingTax']);
            $value              = $purchaseLabel . ' ' . $discountToDisplay['quantity'] . ' ' . $orOrMore  . ' ' . $productPriceLabel . ' ' . $formattedPrice;
            $discountStr = str_replace('{#discount#}', $value, '<li>{#discount#}</li>');
        }
        return $discountStr;
    }
}
