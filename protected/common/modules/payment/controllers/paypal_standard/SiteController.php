<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\controllers\paypal_standard;

use usni\UsniAdaptor;
use common\modules\payment\components\paypal_standard\Paypal;
use Yii;
use common\modules\payment\business\paypal_standard\Manager;
/**
 * SiteController class file
 *
 * @package common\modules\payment\controllers\paypal_standard
 */
class SiteController extends \usni\library\web\Controller
{
    /**
     * @inheritdoc
     */
    public $paypalManager;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;    
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(parent::beforeAction($action))
        {
            $this->paypalManager = Manager::getInstance();
            return true;
        }
        return false;
    }
    
    /**
     * Return action for the controller.
     * 
     * @return string
     * @see http://stackoverflow.com/questions/22061885/difference-in-paypal-ipn-between-notify-url-and-return-url (VERY CRITICAL)
     */
    public function actionReturn() 
    {
        if (isset($_GET['q']) && $_GET['q'] == 'success' && (isset($_POST["txn_id"]))) 
        {
            $orderId        = $_POST['custom'];
            return $this->redirect(UsniAdaptor::createUrl('cart/checkout/complete-order', ['orderId' => $orderId]));
        }
        return $this->redirect(UsniAdaptor::app()->getHomeUrl());
    }
    
    /**
     * Notify action for the controller.
     * 
     * @return string
     * @see http://stackoverflow.com/questions/22061885/difference-in-paypal-ipn-between-notify-url-and-return-url (VERY CRITICAL)
     * @see https://www.paypal.com/in/cgi-bin/webscr?cmd=p/acc/ipn-info-outside
     */
    /*
     * Array that would be returned in post is of type
     * Array
        (
            [mc_gross] => 10.00
            [protection_eligibility] => Ineligible
            [address_status] => unconfirmed
            [payer_id] => TMWN3S5922WWA
            [tax] => 0.00
            [address_street] => Flat no. 507 Wing A Raheja Residency
        Film City Road, Goregaon East
            [payment_date] => 23:28:07 Oct 16, 2015 PDT
            [payment_status] => Pending
            [charset] => windows-1252
            [address_zip] => 400097
            [first_name] => test
            [address_country_code] => IN
            [address_name] => test buyer
            [notify_version] => 3.8
            [custom] => 2
            [payer_status] => verified
            [address_country] => India
            [address_city] => Mumbai
            [quantity] => 1
            [payer_email] => rajusinghai80-buyer@gmail.com
            [verify_sign] => AFcWxV21C7fd0v3bYYYRCpSSRl31Ay5gQ26wGHt-u4eGSamAtp3XJUgc
            [txn_id] => 8F087547X52761610
            [payment_type] => instant
            [last_name] => buyer
            [address_state] => Maharashtra
            [receiver_email] => rajusinghai80@gmail.com
            [pending_reason] => unilateral
            [txn_type] => web_accept
            [item_name] => Test plugin-1.0.0
            [mc_currency] => USD
            [item_number] => 15
            [residence_country] => IN
            [test_ipn] => 1
            [handling_amount] => 0.00
            [transaction_subject] => 2
            [payment_gross] => 10.00
            [shipping] => 0.00
            [auth] => ADhOr2urFkANIL5xrzzdK0dJVsgXRKI932Z2ZnSHwq.habloCDZ0eFDaVq6jNEKR9nMlISyfH-BGbqDvep2nHFQ
        )
     */
    public function actionNotify() 
    {
        $config         = $this->paypalManager->getPaypalConfig();
        $paypalManager  = new Paypal($config);
        //Check for VALID response
        if ($paypalManager->notify())
        {
            $this->paypalManager->processOrderUpdate($_POST);
        }
        else
        {
            Yii::error('Paypal payment transaction fails with invalid IPN', 'paypal_standard');
        }
    }
    
    /**
     * Cancel action for the controller.
     * 
     * @return string
     */
    public function actionCancel() 
    {
        return $this->redirect(UsniAdaptor::createUrl('cart/checkout/index'));
    }
}