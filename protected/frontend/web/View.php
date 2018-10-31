<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\web;

use products\utils\ProductScriptUtil;
use usni\UsniAdaptor;
use wishlist\utils\WishlistScriptUtil;
use cart\utils\CartScriptUtil;
use usni\library\web\ConfigBehavior;
use products\behaviors\PriceBehavior;
use common\web\ImageBehavior;
/**
 * View object for the front interface.
 * 
 * @package frontend\web
 */
class View extends \usni\library\web\View
{
    /**
     * View file for left nav
     * @var string 
     */
    public $leftnavView;
    
    /**
     * View file for right nav
     * @var string 
     */
    public $rightnavView;
    
    /**
     * View file for header
     * @var string 
     */
    public $headerView = '//common/_header';
    
    /**
     * View file for footer
     * @var string 
     */
    public $footerView = '//common/_footer';
    
    /**
     * View file for breadcrumb
     * @var string 
     */
    public $breadcrumbView = '//common/_breadcrumbs';
    
    /**
     * View file for topnav
     * @var string 
     */
    public $topnavView;
    
    /**
     * View file for navbar
     * @var string 
     */
    public $navbarView = '//common/_navbar';
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            ConfigBehavior::className(),
            PriceBehavior::className(),
            ImageBehavior::className()
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function renderLeftColumn()
    {
        if($this->leftnavView != null)
        {
            return $this->render($this->leftnavView);
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function renderBreadcrumb()
    {
        if($this->breadcrumbView != null)
        {
            return $this->render($this->breadcrumbView);
        }
        return null;
    }
    
    /**
     * Renders footer.
     * @return string
     */
    public function renderFooter()
    {
        if($this->footerView != null)
        {
            return $this->render($this->footerView);
        }
        return null;
    }

    /**
     * Renders header.
     * @return string
     */
    public function renderHeader()
    {
        if($this->headerView != null)
        {
            $this->registerGlobalScripts();
            return $this->render($this->headerView);
        }
        return null;
    }
    
    /**
     * Register global scripts
     * 
     * @return void
     */
    public function registerGlobalScripts()
    {
        $js = ProductScriptUtil::addToCartScript();
        $this->registerJs($js);
        $compareProductsSetting = UsniAdaptor::app()->storeManager->getSettingValue('allow_compare_products');
        if($compareProductsSetting)
        {
            $compareProductsJs  = ProductScriptUtil::addToCompareProductsScript();
            $this->registerJs($compareProductsJs);
            $removeFromCompareProductsJs  = ProductScriptUtil::removeFromCompareProductScript();
            $this->registerJs($removeFromCompareProductsJs);
        }
        $wishlistSetting = UsniAdaptor::app()->storeManager->getSettingValue('allow_wishlist');
        if($wishlistSetting)
        {
            $wishListJs             = WishlistScriptUtil::addToWishListScript();
            $this->registerJs($wishListJs);
            $removeFromwishListJs   = WishlistScriptUtil::removeFromWishListScript();
            $this->registerJs($removeFromwishListJs);
        }
        $this->registerJs(CartScriptUtil::registerRemoveFromCartScript());
        $this->registerJs(CartScriptUtil::registerUpdateCartScript());
    }
    
    /**
     * Renders navigation bar.
     * @return string
     */
    public function renderNavBar()
    {
        if($this->navbarView != null)
        {
            return $this->render($this->navbarView);
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderHeadHtml()
    {
        $selectedStore  = UsniAdaptor::app()->storeManager->selectedStore;
        $keyword        = null;
        $description    = null;
        //If store metakeyword is empty then site's metakeyword would be used.
        if(!empty($selectedStore['metakeywords']))
        {
            $keyword = $selectedStore['metakeywords'];
        }
        else
        {
            $keyword = UsniAdaptor::app()->configManager->getValue('application', 'metaKeywords');
        }
        if (!isset($this->metaTags['keywords'])) 
        {
            $this->registerMetaTag([
                'name' => 'keywords',
                'content' => $keyword
            ]);
        }
        //If store metadescription is empty then site's metadescription would be used.
        if(!empty($selectedStore['metadescription']))
        {
            $description = $selectedStore['metadescription'];
        }
        else
        {
            $description = UsniAdaptor::app()->configManager->getValue('application', 'metaDescription');
        }
        if (!isset($this->metaTags['description'])) 
        {
            $this->registerMetaTag([
                'name' => 'description',
                'content' => $description
            ]);
        }
        return parent::renderHeadHtml();
    }

    /**
     * Get fav icon.
     * @return string
     */
    public function getFavIcon()
    {
        $image = UsniAdaptor::app()->configManager->getValue('application', 'favicon');
        if($image != null)
        {
            return str_replace('https', 'http', UsniAdaptor::app()->assetManager->getImageUploadUrl() . '/' . $image);
        }
        return null;
    }
}