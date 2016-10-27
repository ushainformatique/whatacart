<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\views\front\ProductView;
use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use products\models\ProductReview;
use frontend\utils\FrontUtil;
use products\utils\CompareProductsUtil;
use yii\helpers\Json;
use products\views\front\CompareProductsView;
use usni\library\utils\FlashUtil;
use products\utils\ProductUtil;
use products\views\front\TagView;
use frontend\components\Breadcrumb;
use common\utils\ApplicationUtil;
use frontend\models\SearchForm;
use common\modules\stores\utils\StoreUtil;
use products\models\ProductRating;
use yii\filters\AccessControl;
use usni\library\utils\TranslationUtil;
/**
 * SiteController class file.
 * 
 * @package products\controllers
 */
class SiteController extends BaseController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors          = parent::behaviors();
        $excludedActions    = static::getExcludedActionsFromAccessControl();
        return array_merge($behaviors, [
            'access' => [
                'class' => AccessControl::className(),
                'except' => $excludedActions,
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied by default
                ],
            ],
        ]);
    }
    
    /**
     * Gets excluded actions from access control.
     * @return array
     */
    protected static function getExcludedActionsFromAccessControl()
    {
        return ['detail', 'review', 'add-to-compare', 'compare-products', 'remove', 'rating', 'tag-list'];
    }
    
    /**
     * Render product detail page.
     * @param $id int
     * @return void
     */
    public function actionDetail($id)
    {
        if(ProductUtil::checkIfProductAllowedToPerformAction($id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        $product        = ProductUtil::getProduct($id);
        $breadcrumbView = new Breadcrumb(['page' => $product['name']]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $this->getView()->params['title'] = $product['name']; 
        $productView  = new ProductView(['product' => $product]);
        $content      = $this->renderInnerContent([$productView]);
        $this->setMetaKeywords($product['metakeywords']);
        $this->setMetaDescription($product['metadescription']);
        FlashUtil::setMessage('reviewFormSubmit', UsniAdaptor::t('productflash', 'Thank you for your review. It has been submitted to the admin for approval.'));
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }

    /**
     * Perform review related operation for products.
     * @return void
     */
    public function actionReview()
    {
        if(UsniAdaptor::app()->request->isAjax && isset($_POST['ProductReview']))
        {
            $model = new ProductReview();
            $model->attributes = $_POST['ProductReview'];
            if($model->validate())
            {
                $model->save();
                TranslationUtil::saveTranslatedModels($model);
                ProductUtil::sendReviewNotification($model);
                echo "Success";
            }
            else
            {
                echo "Failure";
            }
            
        }
    }
    
    /**
     * Add product to compare list
     * @return string json result
     */
    public function actionAddToCompare()
    {
        $compareproducts   = ApplicationUtil::getCompareProducts();
        $compareproducts->addItem($_POST['productId']);
        $data       = CompareProductsUtil::renderCompareProductsInTopnav();
        $result     = ['success' => true, 'data' => $data];
        echo Json::encode($result);
    }
    
    /**
     * View product comparision.
     * @return string
     */
    public function actionCompareProducts()
    {
        $compareProductsSetting = StoreUtil::getSettingValue('allow_compare_products');
        if($compareProductsSetting)
        {
            $breadcrumbView = new Breadcrumb(['page' => UsniAdaptor::t('products', 'Compare Products')]);
            $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
            $this->getView()->params['title']       = UsniAdaptor::t('products', 'Compare Products'); 
            $view       =  new CompareProductsView();
            $content    = $this->renderInnerContent([$view]);
            return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
        }
        else
        {
            throw new \yii\web\NotFoundHttpException();
        }
    }
    
    /**
     * Render Tagged products list.
     * @return string.
     */
    public function actionTagList($tag)
    {
        $model          = new SearchForm();
        $queryParams    = UsniAdaptor::app()->getRequest()->getQueryParams();
        if($tag == null)
        {
            throw new \yii\web\BadRequestHttpException();
        }
        if($queryParams != null)
        {
            $model->attributes = $queryParams;
        }
        $tagView    = new TagView(['model' => $model]);
        $content    = $this->renderInnerContent([$tagView]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
        
    }
    
    /**
     * Remove item from cart.
     * @return string
     */
    public function actionRemove()
    {
        if(UsniAdaptor::app()->request->getIsAjax())
        {
            $compareProductList         = ApplicationUtil::getCompareProducts();
            $compareProductList->removeItem($_GET['product_id']);
            $headerContent              = CompareProductsUtil::renderCompareProductsInTopnav();
            return Json::encode(['success' => true, 'headerCompareProductListContent' => $headerContent]);
        }
        return Json::encode([]);
    }
    
    /**
     * Provide rating
     * @return void
     */
    public function actionRating()
    {
        if(UsniAdaptor::app()->request->getIsAjax())
        {
            $model              = new ProductRating();
            $model->rating      = $_POST['rating'];
            $model->product_id  = $_POST['productId'];
            if($model->validate())
            {
                $model->save();
            }
        }
    }
}
