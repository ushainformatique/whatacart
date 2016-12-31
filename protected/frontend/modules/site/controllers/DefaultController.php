<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\controllers;

use frontend\controllers\BaseController;
use frontend\modules\site\views\HomePageView;
use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
use frontend\models\SearchForm;
use frontend\views\common\SearchResultsView;
use usni\library\utils\FlashUtil;
use frontend\modules\site\models\ContactForm;
use frontend\modules\site\views\ContactPageView;
use frontend\components\Breadcrumb;
use usni\library\utils\ErrorUtil;
use frontend\modules\site\views\ErrorView;
use frontend\modules\site\views\MaintenanceView;
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
            ],
        ];
    }
    /**
     * Renders home page.
     * @return string the rendering result.
     */
    public function actionIndex()
    {
        $view        = new HomePageView();
        $content     = $this->renderInnerContent([$view]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }

    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return ['index' => UsniAdaptor::t('application', 'Home')];
    }
    
    /**
     * Render Search.
     * @return string
     */
    public function actionSearch()
    {
        $model          = new SearchForm();
        $queryParams    = UsniAdaptor::app()->getRequest()->getQueryParams();
        if($queryParams != null)
        {
            $model->attributes = $queryParams;
            if($model->validate())
            {
                $searchView     = new SearchResultsView(['model' => $model]);
                $content        = $this->renderInnerContent([$searchView]);
                return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
            }
            else
            {
                throw new \yii\base\InvalidParamException(UsniAdaptor::t('application', 'Invalid search param'));
            }
        }
    }
    
    /**
     * Contact us action
     * @return string
     */
    public function actionContactUs()
    {
        $model = new ContactForm();
        if(isset($_POST['ContactForm']))
        {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate())
            {
                if($model->sendMail())
                {
                    FlashUtil::setMessage('contactMailSuccess', UsniAdaptor::t('applicationflash', 'Thank you for contacting us. We would revert back to you within 24 hours.'));
                }
                else
                {
                    FlashUtil::setMessage('contactMailFailure', UsniAdaptor::t('applicationflash', 'There is an error sending email'));
                }
                return $this->refresh();
            }
        }
        $breadcrumbView = new Breadcrumb(['page' => 'Contact Us']);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $contactView = new ContactPageView(['model' => $model]);
        $content     = $this->renderInnerContent([$contactView]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
    
    /**
	 * This is the action to handle external exceptions.
     * @return void
	 */
	public function actionError()
	{
        $errorHandler   = UsniAdaptor::app()->errorHandler;
        $error          = $errorHandler->exception;
        if($error != null)
		{
            $errorInfo   = ErrorUtil::getInfo($error, $errorHandler);
            $errorView   = new ErrorView($error, $errorInfo);
            $content     = $this->renderInnerContent([$errorView]);
            return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
		}
	}
    
    /**
     * Site maintenance.
     * @return string
     */
    public function actionMaintenance()
    {
        $view       = new MaintenanceView();
        $content    = $this->renderInnerContent([$view]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
}