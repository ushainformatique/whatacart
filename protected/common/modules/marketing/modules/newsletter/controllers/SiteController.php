<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace newsletter\controllers;

use frontend\controllers\BaseController;
use newsletter\models\NewsletterCustomers;
use usni\UsniAdaptor;
use customer\utils\CustomerUtil;
use newsletter\views\UnsubscribeView;
use frontend\components\Breadcrumb;
use frontend\utils\FrontUtil;
/**
 * SiteController class file.
 * 
 * @package newsletter\controllers
 */
class SiteController extends BaseController
{   
    /**
     * Send newsletter.
     */
    public function actionSend()
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            $model  = new NewsletterCustomers(['scenario' => 'send']);
            if(isset($_POST['NewsletterCustomers']['email']))
            {           
                $model->attributes  = $_POST['NewsletterCustomers'];
                $model->customer_id = 0;
            }
            elseif($_POST['NewsletterCustomers']['is_subscribe'] == true)
            {
                $user       = UsniAdaptor::app()->user->getUserModel();
                $customer   = CustomerUtil::getCustomerById($user->id);
                $model->email       = $customer['email'];
                $model->customer_id = $user->id;
            }
            if($model->validate())
            {
                $model->save();
            }
        }
    }
    
    /**
     * Unsubscribe newsletter.
     * @param string $email
     * @return mixed
     */
    public function actionUnsubscribeNewsletter($email)
    {
        NewsletterCustomers::deleteAll('email = :email', [':email' => $email]);
        $breadcrumbView     = new Breadcrumb(['page' => UsniAdaptor::t('newsletter', 'Unsubscribe Newsletter')]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $view       = new UnsubscribeView();
        $content    = $this->renderInnerContent([$view]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
}