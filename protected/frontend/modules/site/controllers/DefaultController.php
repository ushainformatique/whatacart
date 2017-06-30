<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use frontend\models\SearchForm;
use usni\library\utils\FlashUtil;
use frontend\dto\HomePageDTO;
use frontend\business\HomeManager;
use productCategories\dto\ProductCategoryListViewDTO;
use productCategories\business\SiteManager;
use productCategories\models\ProductCategory;
use frontend\business\SearchManager;
use usni\library\utils\ArrayUtil;
use frontend\modules\site\business\Manager;
use usni\library\dto\FormDTO;
use yii\base\InvalidParamException;
/**
 * DefaultController class file
 * 
 * @package frontend\modules\site\controllers
 */
class DefaultController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    /**
     * Renders home page.
     * @return string the rendering result.
     */
    public function actionIndex()
    {
        $manager     = new HomeManager();
        $homePageDTO = new HomePageDTO();
        $manager->setPageData($homePageDTO);
        return $this->render('/home', ['homePageDTO' => $homePageDTO]);
    }

    /**
     * Render Search.
     * @return string
     */
    public function actionSearch()
    {
        $manager        = SiteManager::getInstance();
        $model          = new SearchForm();
        $listViewDTO    = new ProductCategoryListViewDTO();
        $listViewDTO->setSearchModel($model);
        $dataCategoryId = UsniAdaptor::app()->storeManager->selectedStore['data_category_id'];
        $listViewDTO->setDataCategoryId($dataCategoryId);
        $queryParams    = UsniAdaptor::app()->getRequest()->getQueryParams();
        if($queryParams != null)
        {
            $model->load($queryParams);
            if($model->validate())
            {
                $listViewDTO->setSortingOption(UsniAdaptor::app()->request->get('sort'));
                $listViewDTO->setPageSize(UsniAdaptor::app()->request->get('showItemsPerPage'));        
            }
            else
            {
                throw new InvalidParamException(UsniAdaptor::t('application', 'Invalid search param'));
            }
        }
        $dp             = SearchManager::getInstance()->getDataProvider($listViewDTO);
        $listViewDTO->setDataprovider($dp);
        $catOptions     = $manager->getMultiLevelSelectOptions(new ProductCategory(), false);
        $listViewDTO->setCategoryList($catOptions);
        return $this->render('//common/searchview', ['listViewDTO' => $listViewDTO]); 
    }
    
    /**
     * Contact us action
     * @return string
     */
    public function actionContactUs()
    {
        $postData   = ArrayUtil::getValue($_POST, 'ContactForm');
        $manager    = new Manager();
        $formDTO    = new FormDTO();
        $formDTO->setPostData($postData);
        $manager->processContactUs($formDTO);
        if($formDTO->getIsTransactionSuccess() === true)
        {
            $message = UsniAdaptor::t('applicationflash', 'Thank you for contacting us. We would revert back to you within 24 hours.');
            FlashUtil::setMessage('success', $message);
            $this->refresh();
        }
        elseif($formDTO->getIsTransactionSuccess() === false)
        {
            FlashUtil::setMessage('error', UsniAdaptor::t('applicationflash', 'There is an error sending email'));
            return $this->refresh();
        }
        else
        {
            return $this->render('/contactus', ['formDTO' => $formDTO]); 
        }
    }
    
    /**
     * Site maintenance.
     * @return string
     */
    public function actionMaintenance()
    {
        $customMessage = UsniAdaptor::app()->configManager->getValue('application', 'customMaintenanceModeMessage');
        return $this->render('/maintenance', ['customMessage' => $customMessage]);
    }
    
    /**
     * Error action
     * @return string
     */
    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) 
        {
            return $this->render('/error', ['exception' => $exception, 'handler' => \Yii::$app->errorHandler]);
        }
    }
}