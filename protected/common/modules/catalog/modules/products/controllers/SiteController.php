<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use yii\helpers\Json;
use common\utils\ApplicationUtil;
use frontend\models\SearchForm;
use products\models\ProductRating;
use yii\filters\AccessControl;
use products\dto\ProductDTO;
use products\widgets\TopNavCompareProducts;
use usni\library\dto\GridViewDTO;
use products\business\SiteManager;
use products\web\ProductView;
use products\dto\TagListViewDTO;
use frontend\business\SearchManager;
use products\dao\TagDAO;
use yii\base\InvalidParamException;
/**
 * SiteController class file.
 * 
 * @package products\controllers
 */
class SiteController extends BaseController
{
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
        $siteManager    = SiteManager::getInstance();
        $isValid        = $siteManager->isValidProductId($id);
        if(!$isValid)
        {
            throw new InvalidParamException(UsniAdaptor::t('products', "Invalid product"));
        }
        //Populate dtos
        $productDTO     = new ProductDTO();
        $productDTO->setId($id);
        
        //Fetch and populate details
        $siteManager->populateDetails($productDTO);
        
        $view   = new ProductView(['product' => $productDTO->getProduct()]);
        $view->theme = $this->getView()->theme;
        //Set metatag and description for each product
        $productDetail = $productDTO->getProduct();
        if($productDetail['metakeywords'] != null)
        {
            $view->registerMetaTag([
                'name' => 'keywords',
                'content' => $productDetail['metakeywords']
            ]);
        }
        if($productDetail['metadescription'] != null)
        {
            $view->registerMetaTag([
                'name' => 'description',
                'content' => $productDetail['metadescription']
            ]);
        }
        $this->setView($view);
        //Fetch the result set
        return $this->render("/front/view", ['productDTO' => $productDTO]);
    }

    /**
     * Perform review related operation for products.
     * @return void
     */
    public function actionReview()
    {
        if(UsniAdaptor::app()->request->isAjax && isset($_POST['ProductReview']))
        {
            $isReviewPosted = SiteManager::getInstance()->postReview($_POST['ProductReview'], UsniAdaptor::app()->languageManager->selectedLanguage);
            if($isReviewPosted)
            {
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
        $data       = TopNavCompareProducts::widget();
        $result     = ['success' => true, 'data' => $data];
        echo Json::encode($result);
    }
    
    /**
     * View product comparision.
     * @return string
     */
    public function actionCompareProducts()
    {
        $compareProductsSetting = UsniAdaptor::app()->storeManager->getSettingValue('allow_compare_products');
        if($compareProductsSetting)
        {
            $gridViewDTO    = new GridViewDTO();
            $dataProvider   = SiteManager::getInstance()->getCompareProductsDataProvider(ApplicationUtil::getCompareProducts());
            $gridViewDTO->setDataProvider($dataProvider);
            return $this->render('/front/compareview', ['gridViewDTO' => $gridViewDTO]);
        }
        else
        {
            throw new \yii\web\NotFoundHttpException();
        }
    }
    
    /**
     * Render tagged products list.
     * 
     * @param string $name name of the tag
     * @return string.
     */
    public function actionTagList($name)
    {
        $model          = new SearchForm();
        $queryParams    = UsniAdaptor::app()->getRequest()->getQueryParams();
        if($name == null)
        {
            throw new \yii\web\BadRequestHttpException();
        }
        if($queryParams != null)
        {
            $model->tag = $queryParams['name'];
        }
        $listViewDTO    = new TagListViewDTO();
        $listViewDTO->setSearchModel($model);
        $listViewDTO->setSortingOption(UsniAdaptor::app()->request->get('sort'));
        $listViewDTO->setPageSize(UsniAdaptor::app()->request->get('showItemsPerPage'));
        $dataCategoryId = UsniAdaptor::app()->storeManager->selectedStore['data_category_id'];
        $listViewDTO->setDataCategoryId($dataCategoryId);
        $dp             = SearchManager::getInstance()->getDataProvider($listViewDTO);
        $listViewDTO->setDataprovider($dp);
        $tagList        = TagDAO::getAll(UsniAdaptor::app()->languageManager->selectedLanguage);
        $listViewDTO->setTagList($tagList);
        return $this->render('/front/searchbytagview', ['listViewDTO' => $listViewDTO]);
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
            $headerContent              = TopNavCompareProducts::widget();
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
