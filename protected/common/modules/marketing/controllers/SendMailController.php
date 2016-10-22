<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\marketing\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use newsletter\utils\NewsletterUtil;
use common\modules\stores\utils\StoreUtil;
use common\modules\marketing\models\SendMailForm;
use common\modules\marketing\views\SendMailEditView;
use common\modules\marketing\utils\MarketingUtil;
use usni\library\utils\FlashUtil;
/**
 * SendMailController class file
 * @package common\modules\marketing\controllers
 */
class SendMailController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model  = new SendMailForm(['scenario' => 'send']);
        if(isset($_POST['SendMailForm']))
        {
            $model->attributes = $_POST['SendMailForm'];
            if($model->validate())
            {
                $this->processSendMail($model);
                FlashUtil::setMessage('sendMail', UsniAdaptor::t('marketing', 'Mail has been sent successfully.'));
                $model = new SendMailForm(['scenario' => 'send']);
            }
        }
        $breadcrumbs      = [
                                [
                                    'label' => UsniAdaptor::t('marketing', 'Send Mail')
                                ]
                            ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        $sendMailView     = SendMailEditView::className();
        $view             = new $sendMailView($model);
        $content          = $this->renderColumnContent([$view]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }
    
    /**
     * Process send mail.
     * @param Model $model
     * @return boolean
     */
    protected function processSendMail($model)
    {
        $user       = UsniAdaptor::app()->user->getUserModel();
        $storeOwner = StoreUtil::getStoreOwner($model->store_id);
        //Notifications for all customers.
        if($model->to == SendMailForm::ALL_CUSTOMERS)
        {
            $toAddressArray = MarketingUtil::getNotificationEmails(SendMailForm::ALL_CUSTOMERS);
            MarketingUtil::processSendMailNotifications($storeOwner, $toAddressArray, $model);
        }
        //Notifications for Selected customer group.
        if($model->to == SendMailForm::CUSTOMER_GROUP)
        {
            $toAddressArray = MarketingUtil::getNotificationEmails(SendMailForm::CUSTOMER_GROUP, $model->group_id);
            MarketingUtil::processSendMailNotifications($storeOwner, $toAddressArray, $model);
        }
        //Notifications for selected customers.
        if($model->to == SendMailForm::CUSTOMERS)
        {
            $toAddressArray       = MarketingUtil::getNotificationEmails(SendMailForm::CUSTOMERS, null, $model->customer_id);
            MarketingUtil::processSendMailNotifications($storeOwner, $toAddressArray, $model);
        }
        //Notifications for selected products.
        if($model->to == SendMailForm::PRODUCTS)
        {
            $toAddressArray       = MarketingUtil::getNotificationEmails(SendMailForm::PRODUCTS, null, null, $model->product_id);
            MarketingUtil::processSendMailNotifications($storeOwner, $toAddressArray, $model);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'    => SendMailForm::getLabel(1)
               ];
    }
}
?>