<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace newsletter\controllers;

use newsletter\models\Newsletter;
use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use newsletter\views\NewsletterEditView;
use newsletter\utils\NewsletterUtil;
use common\modules\stores\utils\StoreUtil;
/**
 * DefaultController class file
 * 
 * @package newsletter\controllers
 */
class DefaultController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Newsletter::className();
    }
    
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model  = new Newsletter(['scenario' => 'send']);
        if(isset($_POST['Newsletter']))
        {
            $model->attributes = $_POST['Newsletter'];
            if($model->validate() && $model->save())
            {
                $this->afterModelSave($model);
                return $this->redirect(UsniAdaptor::createUrl('marketing/newsletter/default/manage'));
            }
        }
        $breadcrumbs      = [
                                [
                                    'label' => UsniAdaptor::t('application', 'Manage') . ' ' . Newsletter::getLabel(2),
                                    'url'   => UsniAdaptor::createUrl('marketing/newsletter/default/manage')
                                ],
                                [
                                    'label' => UsniAdaptor::t('newsletter', 'Send Newsletter')
                                ]
                            ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        $newsletterView     = NewsletterEditView::className();
        $view               = new $newsletterView($model);
        $content            = $this->renderColumnContent([$view]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }
    
    /**
     * @inheritdoc
     */
    protected function afterModelSave($model)
    {
        $user       = UsniAdaptor::app()->user->getUserModel();
        $storeOwner = StoreUtil::getStoreOwner($model->store_id);
        //Notifications for all all newsletter subscribers.
        if($model->to == Newsletter::ALL_SUBSCRIBERS)
        {
            $toAddressArray = NewsletterUtil::getNewsletterNotificationEmails(Newsletter::ALL_SUBSCRIBERS);
            NewsletterUtil::processNewsletterNotifications($storeOwner, $toAddressArray, $model);
        }
        //Notification for all customers except guest.
        if($model->to == Newsletter::ALL_CUSTOMERS)
        {
            $toAddressArray = NewsletterUtil::getNewsletterNotificationEmails(Newsletter::ALL_CUSTOMERS);
            NewsletterUtil::processNewsletterNotifications($storeOwner, $toAddressArray, $model);
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . Newsletter::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . Newsletter::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Newsletter::getLabel(2)
               ];
    }
}