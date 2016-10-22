<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use customer\views\front\ForgotPasswordFormView;
use frontend\views\FrontPageView;
/**
 * ForgotPasswordView class file.
 *
 * @package customer\views\front
 */
class ForgotPasswordView extends FrontPageView
{
    /**
     * Form model associated.
     * @var CustomerEditForm 
     */
    public $model;
    
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $view   = new ForgotPasswordFormView($this->model);
        return $view->render();        
    }    
}
