<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use customer\models\LoginForm;
use customer\views\front\LoginView;
use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
use frontend\views\FrontPageView;
/**
 * LoginPageView class file.
 *
 * @package customer\views\front
 */
class LoginPageView extends FrontPageView
{
    /**
     * Login Form model
     * @var LoginForm
     */
    public $model;
    
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $model        = $this->model;
        $loginView    = new LoginView($model);
        $file         = $this->getSubViewFile();
        return $this->getView()->renderPhpFile($file, ['login' => $loginView->render()]);
    }
    
    /**
     * Get subview file
     * @return string
     */
    protected function getSubViewFile()
    {
        $theme        = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $theme . '/views/customers/login') . '.php';
    }
}
