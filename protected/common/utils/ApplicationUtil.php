<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\utils;

use usni\UsniAdaptor;
use common\utils\ApplicationUtil;
use usni\library\utils\StringUtil;
use usni\library\utils\FileUploadUtil;
use usni\library\components\UiHtml;
use common\modules\stores\utils\StoreUtil;
use frontend\utils\FrontUtil;
use usni\library\utils\FileUtil;
use products\utils\ProductUtil;
use wishlist\utils\WishlistUtil;
use products\utils\CompareProductsUtil;
use cart\utils\CartUtil;
/**
 * ApplicationUtil class file.
 * 
 * @package common\utils
 */
class ApplicationUtil
{
    /**
     * Get checkout form model.
     * @param string $shortName
     * @return Model
     */
    public static function getCheckoutFormModel($shortName)
    {
        if(UsniAdaptor::app()->user->isGuest)
        {
            return UsniAdaptor::app()->guest->checkout->$shortName;
        }
        else
        {
            return UsniAdaptor::app()->customer->checkout->$shortName;
        }
    }
    
    /**
     * Get cart from the system
     * @return Cart
     */
    public static function getCart()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return UsniAdaptor::app()->guest->cart;
        }
        else
        {
            return UsniAdaptor::app()->customer->cart;
        }
    }
    
    /**
     * Gets checkout.
     * @return Checkout
     */
    public static function getCheckout()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return UsniAdaptor::app()->guest->checkout;
        }
        else
        {
            return UsniAdaptor::app()->customer->checkout;
        }
    }
    
    /**
     * Gets cart.
     * @return Cart
     */
    public static function getWishList()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return UsniAdaptor::app()->guest->wishlist;
        }
        else
        {
            return UsniAdaptor::app()->customer->wishlist;
        }
    }
    
    /**
     * Gets compare products.
     * @return CompareProducts
     */
    public static function getCompareProducts()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return UsniAdaptor::app()->guest->compareproducts;
        }
        else
        {
            return UsniAdaptor::app()->customer->compareproducts;
        }
    }
    
    /**
     * Get customer id.
     * @return int
     */
    public static function getCustomerId()
    {
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            return 0; 
        }
        else
        {
            return UsniAdaptor::app()->user->getUserModel()->id;
        }
    }
    
    /**
     * Get image for type of screen.
     * @param string $image
     * @param string $type
     * @return string
     */
    public static function getImage($image, $type, $defaultWidth, $defaultHeight)
    {
        $imageThumbWidth     = StoreUtil::getImageSetting($type . '_image_width', $defaultWidth);
        $imageThumbHeight    = StoreUtil::getImageSetting($type . '_image_height', $defaultHeight);
        if($image != null)
        {
            $src    = StringUtil::replaceBackSlashByForwardSlash(UsniAdaptor::app()->getAssetManager()->getImageUploadUrl() . DS . $image);
            return UiHtml::img($src, ["width" => $imageThumbWidth , "height" => $imageThumbHeight]);
        }
        else
        {
            return FileUploadUtil::getNoAvailableImage(["thumbWidth"=> $imageThumbWidth , "thumbHeight" => $imageThumbHeight]);
        }
    }
    
    /**
     * Get favicon.
     * @param string $baseUrl
     * @return mixed
     */
    public static function getFavIcon($baseUrl)
    {
        $icon = StoreUtil::getImageSetting('icon');
        if(!empty($icon))
        {
            return UsniAdaptor::app()->getAssetManager()->getImageUploadUrl() . DS . $icon;
        }
        return $baseUrl . "/assets/images/favicon.ico";
    }
    
    /**
     * Is cart empty
     * @return boolean
     */
    public static function isCartEmpty()
    {
        $cart = ApplicationUtil::getCart();
        if($cart->getCount() == 0)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Get version
     * @return string
     */
    public static function getVersion()
    {
        return '1.0.0';
    }
    
    /**
     * Get default data template
     * @param string $template
     * @return string
     */
    public static function getDefaultEmailTemplate($template)
    {
        $theme          = FrontUtil::getThemeName();
        $rawLanguage    = UsniAdaptor::app()->languageManager->getLanguageWithoutLocale();
        $path           = FileUtil::normalizePath(APPLICATION_PATH . '/themes/' . $theme . '/views/email/' . $rawLanguage . '/' . $template . '.php');
        return UsniAdaptor::app()->getView()->renderFile($path);
    }
    
    /**
     * Register global scripts
     * 
     * @param View $view
     * @return void
     */
    public static function registerGlobalScripts($view)
    {
        $js = ProductUtil::addToCartScript();
        $view->registerJs($js);
        $compareProductsSetting = StoreUtil::getSettingValue('allow_compare_products');
        if($compareProductsSetting)
        {
            $compareProductsJs  = CompareProductsUtil::addToCompareProductsScript();
            $view->registerJs($compareProductsJs);
            $removeFromCompareProductsJs  = CompareProductsUtil::removeFromCompareProductScript();
            $view->registerJs($removeFromCompareProductsJs);
        }
        $wishlistSetting = StoreUtil::getSettingValue('allow_wishlist');
        if($wishlistSetting)
        {
            $wishListJs             = WishlistUtil::addToWishListScript();
            $view->registerJs($wishListJs);
            $removeFromwishListJs   = WishlistUtil::removeFromWishListScript();
            $view->registerJs($removeFromwishListJs);
        }
        $view->registerJs(CartUtil::registerRemoveFromCartScript());
        $view->registerJs(CartUtil::registerUpdateCartScript());
    }
}
