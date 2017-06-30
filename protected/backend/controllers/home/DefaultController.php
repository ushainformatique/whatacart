<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\controllers\home;

use usni\UsniAdaptor;
use backend\dto\DashboardDTO;
/**
 * DefaultController class file.
 * 
 * @package backend\controllers\home
 */
class DefaultController extends \usni\library\modules\home\controllers\DefaultController
{
    /**
     * @inheritdoc
     */
    public function actionDashboard()
    {
        if (UsniAdaptor::app()->user->getIsGuest())
        {
            UsniAdaptor::app()->user->loginRequired();
        }
        else
        {
            $dashboardDTO   = new DashboardDTO();
            //Latest products
            $latestProducts = UsniAdaptor::app()->runAction('catalog/products/default/latest');
            $dashboardDTO->setLatestProducts($latestProducts);
            //Latest users
            $latestUsers = UsniAdaptor::app()->runAction('users/default/latest');
            $dashboardDTO->setLatestUsers($latestUsers);
            //Latest customers
            $latestCustomers = UsniAdaptor::app()->runAction('customer/default/latest');
            $dashboardDTO->setLatestCustomers($latestCustomers);
            //Latest orders
            $latestOrders = UsniAdaptor::app()->runAction('order/default/latest');
            $dashboardDTO->setLatestOrders($latestOrders);
            return $this->render('//site/dashboard', ['dashboardDTO' => $dashboardDTO]);
        }
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
            return $this->render('//error', ['exception' => $exception, 'handler' => \Yii::$app->errorHandler]);
        }
    }
}