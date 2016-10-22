<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\controllers;

use usni\library\components\UiBaseController;
use usni\library\utils\ConfigurationUtil;
use usni\library\filters\MaintenanceFilter;
use usni\UsniAdaptor;
/**
 * UiWebController class file.
 * @package frontend\controllers
 */
abstract class UiWebController extends UiBaseController
{
    /**
     * Store metaKeywords.
     * @var string
     */
    public $metaKeywords;

    /**
     * Store metaDescription.
     * @var string
     */
    public $metaDescription;

    /**
     * Get actions.
     * @return array
     */
    public function actions()
    {
        return array(
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        );
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'maintenance' => [
                'class' => MaintenanceFilter::className()
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(!UsniAdaptor::app()->installed)
        {
            return parent::beforeAction($action);
        }
        if (parent::beforeAction($action)) 
        {
            if (!empty($this->metaDescription))
            {
                $this->setMetaDescription($this->metaDescription);
            }
            else
            {
                $this->setMetaDescription(ConfigurationUtil::getValue('application', 'metaDescription'));
            }
            if (!empty($this->metaKeywords))
            {
                $this->setMetaKeywords($this->metaKeywords);
            }
            else
            {
                $this->setMetaKeywords(ConfigurationUtil::getValue('application', 'metaKeywords'));
            }
            $this->getView()->title = $this->getPageTitle();
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Sets meta description
     * @param string $description
     * @return void
     */
    public function setMetaDescription($description)
    {
        $this->getView()->registerMetaTag(['name' => 'description', 'content' => $description]);
    }

    /**
     * Sets meta description
     * @param string $keywords
     * @return void
     */
    public function setMetaKeywords($keywords)
    {
        $this->getView()->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
    }
}
?>