<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views\front;

use frontend\utils\FrontUtil;
use products\utils\ProductUtil;
use products\models\ProductReview;
use products\views\front\RelatedProductListView;
use products\models\Product;
use usni\UsniAdaptor;
use wishlist\utils\WishlistUtil;
use products\utils\CompareProductsUtil;
use usni\library\components\UiHtml;
use frontend\views\FrontPageView;
use common\modules\stores\utils\StoreUtil;
use products\views\front\RatingAndReviewSummaryView;
use products\views\front\ProductReviewView;
/**
 * ProductView class file
 *
 * @package products\views\front
 */
class ProductView extends FrontPageView
{
    /**
     * Product Model
     * @var Product 
     */
    public $product;
    
    /**
     * Related product count
     * @var int 
     */
    public $relatedProductCount;
    
    /**
     * Related products view
     * @var string 
     */
    public $relatedProductsView;
    
    /**
     * Review count
     * @var int 
     */
    public $reviewCount;
    
    /**
     * Minimum quantity
     * @var int 
     */
    public $minimumQtyMessage;
    
    /**
     * Product spec tab
     * @var string 
     */
    public $productSpecTab;
    
    /**
     * Product spec tab content
     * @var string 
     */
    public $productSpecTabContent;
    
    /**
     * Description for product
     * @var string 
     */
    public $description;
    
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $product    = $this->product;
        $this->setRelatedProducts();
        //Get reviews count
        $this->reviewCount      = ProductReview::find()->where('product_id = :pId and status = :status', 
                                                                [':pId' => $product['id'], ':status' => ProductReview::STATUS_APPROVED])->count();
        $this->setMinQtyMessage();
        $this->setProductSpecificationsTab();
        $this->setDescription();
        $tags                   = $this->getTags();
        $tabContent             = $this->getTabContent();
        $filePath               = $this->getViewFile();
        
        //Product review settings check.
        $reviewSetting  = StoreUtil::getSettingValue('allow_reviews');
        $reviewSummary  = null;
        $summaryView    = new RatingAndReviewSummaryView(['productId' => $product['id'], 'count' => $this->reviewCount]);
        if($reviewSetting && UsniAdaptor::app()->user->isGuest === false)
        {
            $reviewSummary  = $summaryView->render();
        }
        $guestReviewSetting = StoreUtil::getSettingValue('allow_guest_reviews');
        if($guestReviewSetting && UsniAdaptor::app()->user->isGuest === true && (bool)$reviewSetting === true)
        {
            $reviewSummary  = $summaryView->render();
        }
        return $this->getView()->renderPhpFile( $filePath, array('minimumQuantityMessage' => $this->minimumQtyMessage, 
                                                                'title'         => $product['name'],
                                                                'reviewCount'   => $this->reviewCount,
                                                                'tabContent'    => $tabContent,
                                                                'specifications'=> $this->productSpecTab,
                                                                'tags'          => $tags,
                                                                'data'          => $product, 
                                                                'reviewSummary' => $reviewSummary,
                                                                'relatedProducts' => $this->relatedProductsView
                                                                )
                                                );
    }
    
    /**
     * Sets description
     */
    protected function setDescription()
    {
        $product            = $this->product;
        $notSet             = UsniAdaptor::t('application', '(not set)');
        $this->description  = $product['description'] == null ? $notSet : $product['description'];
    }

    /**
     * Renders tab content
     * @return string
     */
    protected function getTabContent()
    {
        $product            = $this->product;
        $theme              = FrontUtil::getThemeName();
        //Tab Content
        $filePath           = UsniAdaptor::getAlias('@themes/' . $theme . '/views/products/_tabContent.php');
        $prReviewView       = new ProductReviewView(['productId' => $product['id']]);
        $reviews            = $prReviewView->render();
        $data               = array('description'    => $this->description, 
                                    'reviews'         => $reviews
                                   );
        if($this->productSpecTab != null)
        {
            $data['attributes'] = $this->productSpecTabContent;
        }
        else
        {
            $data['attributes'] = null;
        }
        return $this->getView()->renderPhpFile( $filePath, $data);
    }


    /**
     * Set minimum quantity message
     */
    protected function setMinQtyMessage()
    {
        $message                    = UsniAdaptor::t('products', 'Minimum quantity is not available for this product'); 
        $this->minimumQtyMessage    = '<div class = "minproduct alert alert-danger" style="display: none">' . $message . '</div>';
    }

    /**
     * Set related products
     */
    protected function setRelatedProducts()
    {
        $product    = $this->product;
        $view       = new RelatedProductListView(['productId' => $product['id']]);
        $this->relatedProductsView = $view->render();
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        $cartJs     = ProductUtil::addToCartScriptOnDetail();
        $wishlistSetting = StoreUtil::getSettingValue('allow_wishlist');
        if($wishlistSetting)
        {
            $wishListJs = WishlistUtil::addToWishListScript();
            $this->getView()->registerJs($wishListJs);
        }
        $compareProductsSetting = StoreUtil::getSettingValue('allow_compare_products');
        if($compareProductsSetting)
        {
            $compareProductsJs = CompareProductsUtil::addToCompareProductsScript();
            $this->getView()->registerJs($compareProductsJs);
        }
        $this->getView()->registerJs($cartJs);
        $this->getView()->registerJs(ProductUtil::renderOptionErrorsScript());
        $reviewJs   = "$('body').on('click', '#product-write-review',function(){
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
        $this->getView()->registerJs($reviewJs);
    }
    
    /**
     * Get product tags.
     * @return string.
     */
    public function getTags()
    {
        $tagsName           = null;
        $product            = $this->product;
        $tags               = ProductUtil::getProductTags($product['id']);
        if(!empty($tags))
        {
            foreach ($tags as $tag)
            {
                $tagsName .= UiHtml::a($tag['name'], UsniAdaptor::createUrl('products/site/tag-list', ['tag' => $tag['name']])) . ' ,';
            }
        }
        if($tagsName != null)
        {
            return UsniAdaptor::t('products', 'Tags') . ': ' . rtrim($tagsName, ",");
        }
        else
        {
            return null;
        }
    }
    
    /**
     * Sets product specificaions view
     */
    protected function setProductSpecificationsTab()
    {
        $this->productSpecTabContent    = $this->getSpecContent();
        $this->productSpecTab           = null;
        if($this->productSpecTabContent != null)
        {
            $this->productSpecTab = '<li><a href="#tab-specifications" data-toggle="tab">' . UsniAdaptor::t('products', 'Specifications') . '</a></li>';
        }
    }
    
    /**
     * Get spec content
     * @return string
     */
    protected function getSpecContent()
    {
        $theme                  = FrontUtil::getThemeName();
        //Specification
        $filePath               = UsniAdaptor::getAlias('@themes/' . $theme . '/views/products/_attributes.php');
        return $this->getView()->renderPhpFile( $filePath, array('product' => $this->product));
    }
    
    /**
     * Get view file
     * @return string
     */
    protected function getViewFile()
    {
        $theme      = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $theme . '/views/products/view.php');
    }
}
