<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\business;

use customer\models\Customer;
use usni\library\modules\users\models\Person;
use usni\library\modules\users\models\Address;
use customer\services\SiteNotificationService;
use usni\library\modules\auth\models\Group;
use customer\dto\FormDTO;
use customer\models\ForgotPasswordForm;
use customer\dao\CustomerDAO;
use usni\library\modules\users\dao\UserDAO;
use usni\UsniAdaptor;
use common\modules\order\models\MyOrderSearch;
use common\modules\order\dto\GridViewDTO as OrderGridViewDTO;
use common\modules\localization\modules\orderstatus\dao\OrderStatusDAO;
use usni\library\utils\ArrayUtil;
use usni\library\dto\GridViewDTO;
use products\models\MyDownloadSearch;
use common\utils\ApplicationUtil;
use common\modules\order\dao\OrderDAO;
use products\dao\DownloadDAO;
use products\models\CustomerDownloadMapping;
use common\modules\order\dto\DetailViewDTO;
use common\modules\shipping\dao\ShippingDAO;
use common\modules\order\events\OrderEvent;
use common\modules\order\behaviors\OrderBehavior;
use common\modules\order\models\Order;
/**
 * Manager class file.
 *
 * @package customer\business
 */
class SiteManager extends Manager
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    use \common\modules\payment\traits\PaymentTrait;
    use \products\traits\DownloadTrait;
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ['notifyService' => SiteNotificationService::className(),
                OrderBehavior::className()];
    }
    
    /**
     * inheritdoc
     */
    public function processAfterUpdate($event)
    {
        $model          = $event->model;
        $activityData   = ['customer_id' => $model->id, 'name' => $this->getFullName($model->person->firstname, $model->person->lastname)];
        $this->addActivity('editprofile', $activityData);
    }
    
    /**
     * inheritdoc
     */
    public function populateFormDTO($formDTO)
    {
        $scenario   = $formDTO->getScenario();
        if($scenario == 'registration')
        {
            $model      = new Customer(['scenario' => $scenario]);
            $person     = new Person(['scenario' => $scenario]);
            $address    = new Address(['scenario' => $scenario]);
        }
        elseif($scenario == 'editprofile')
        {
            $model = Customer::findOne($formDTO->getId());
            $model->scenario = $scenario;
            $person = $model->person;
            $person->scenario = $scenario;
            $address = $model->address;
            $address->scenario = $scenario;
            if($person->profile_image != null)
            {
                $person->savedImage = $person->profile_image;
            }
        }
        $postData = $formDTO->getPostData();
        if(!empty($postData['Customer']))
        {
            $model->load($postData);
            $person->load($postData);
            $address->load($postData);
        }
        $formDTO->setPerson($person);
        $formDTO->setAddress($address);
        $formDTO->setModel($model);
        $userGroups = $this->getGroups();
        $formDTO->setGroups($userGroups);
    }
    
    /**
     * inheritdoc
     */
    public function getGroups()
    {
        $defaultGroup = Group::findByName('General');
        return $defaultGroup['id'];
    }
    
    /**
     * inheritdoc
     */
    public function processLogin($formDTO)
    {
        parent::processLogin($formDTO);
        $model  = $formDTO->getModel();
        if($formDTO->getIsTransactionSuccess() === true)
        {
            $customer       = Customer::findByUsername($model->username);
            $person         = $customer->person;
            $activityData   = ['customer_id' => $customer['id'], 'name' => $this->getFullName($person->firstname, $person->lastname)];
            $this->addActivity('login', $activityData);
        }
    }
    
    /**
     * Process forgot password.
     * @param FormDTO $formDTO
     * @return type
     */
    public function processForgotPassword($formDTO)
    {
        $model      = new ForgotPasswordForm(['scenario' => 'forgotpassword']);
        $postData   = $formDTO->getPostData();
        if ($model->load($postData))
        {
            $person = CustomerDAO::getCustomerByEmail($model->email);
            if ($person != false)
            {
                if ($person['status'] == Customer::STATUS_ACTIVE)
                {
                    $model->user = $person;
                    $model->sendMail();
                    $activityData   = ['customer_id' => $model->user['id'], 'name' => $model->user['firstname'] . ' ' . $model->user['lastname']];
                    $this->addActivity('forgot_password', $activityData);
                    $formDTO->setIsTransactionSuccess(true);
                }
                else
                {
                    $formDTO->setActivationStatusIssue(true);
                }
            }
            else
            {
                $formDTO->setNotRegisteredEmailId(true);
            }
            $model->email = null;
        }
        $formDTO->setModel($model);
    }
    
    /**
     * Process validate email address.
     * @param string $hash
     * @param string $email
     * @return boolean
     */
    public function processValidateEmailAddress($hash, $email)
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'customer';
        $user       = UserDAO::activateUser($tableName, $hash, $email);  
        if ($user !== false)
        {
            $permissions = ['customer.update', 'customer.view', 'customer.changepassword'];
            UsniAdaptor::app()->authorizationManager->addAssignments($permissions, $user['username'], 'customer');
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Process order history.
     * @param OrderGridViewDTO $gridViewDTO
     */
    public function processOrderHistory($gridViewDTO, $getData)
    {
        $filterModel = new MyOrderSearch();
        $filterModel->load($getData, 'MyOrderSearch');
        $gridViewDTO->setSearchModel($filterModel);
        $gridViewDTO->setDataProvider($filterModel->search());
        $gridViewDTO->setStatusData($this->getOrderStatusDropdownData());
    }
    
    /**
     * Process downloads.
     * @param GridViewDTO $gridViewDTO
     * @param array $getData
     */
    public function processDownloads($gridViewDTO, $getData)
    {
        $filterModel = new MyDownloadSearch();
        $filterModel->load($getData, 'MyDownloadSearch');
        $gridViewDTO->setSearchModel($filterModel);
        $gridViewDTO->setDataProvider($filterModel->search());
    }
    
    /**
     * Process download.
     * @param integer $id
     * @param integer $orderId
     * @param integer $storeId
     * @return boolean | String
     */
    public function processDownload($id, $orderId, $storeId)
    {
        $order      = OrderDAO::getById($orderId, $this->language, $storeId);
        $custId     = ApplicationUtil::getCustomerId();
        //If order not belongs to customer or if customer is guest
        if($order['customer_id'] != $custId || $custId == 0)
        {
            return false;
        }
        $download            = DownloadDAO::getById($id, $this->language);
        $isAllowedToDownload = $this->checkIfAllowedToDownload($download, $custId, $order);
        if($isAllowedToDownload === true)
        {
            $mapping = new CustomerDownloadMapping(['scenario' => 'create']);
            $mapping->customer_id = $custId;
            $mapping->download_id = $download['id'];
            $mapping->save();
            $fm   = UsniAdaptor::app()->assetManager->getResourceManager($download['type'], ['model' => (object)$download, 'attribute' => 'file']);
            if(YII_ENV !== 'dev')
            {
                $fm->getUploadedFilePath();
            }
            $fm->download($download['file']);
        }
        else
        {
            return $isAllowedToDownload;
        }
    }
    
    /**
     * Process order view.
     * @param DetailViewDTO $detailViewDTO
     * @param integer $storeId
     */
    public function processOrderView($detailViewDTO, $storeId)
    {
        $orderId    = $detailViewDTO->getId();
        $order      = OrderDAO::getById($orderId, $this->language, $storeId);
        if(empty($order))
        {
            $detailViewDTO->setEmptyOrder(true);
            return;
        }
        if($order['created_by'] == $this->userId)
        {
            //Order products
            $orderProducts  = OrderDAO::getOrderProducts($orderId, $this->language, true);
            $detailViewDTO->setOrderProducts($orderProducts);
            //History records
            $historyRecords = OrderDAO::getOrderHistory($orderId, $this->language);
            if(!empty($historyRecords))
            {
                foreach($historyRecords as $index => $historyRecord)
                {
                    $historyRecord['status_label'] = $this->getOrderStatusLabel($historyRecord['status']);
                    $historyRecords[$index] = $historyRecord;
                }
            }
            $detailViewDTO->setHistoryRecords($historyRecords);
            //Order status
            $allStatus  = OrderStatusDAO::getAll($this->language);
            $statusData = ArrayUtil::map($allStatus, 'id', 'name');
            $detailViewDTO->setStatusData($statusData);
            $order['currency_symbol']       = UsniAdaptor::app()->currencyManager->getCurrencySymbol($order['currency_code']);
            $order['shipping_method_name']  = ShippingDAO::getShippingMethodName($order['shipping'], $this->language);
            $order['status_label']          = $this->getOrderStatusLabel($order['status']);
            $order['billingAddress']        = OrderDAO::getOrderAddress($order['id'], Address::TYPE_BILLING_ADDRESS);
            $order['shippingAddress']       = OrderDAO::getOrderAddress($order['id'], Address::TYPE_SHIPPING_ADDRESS);
            $order['payment_method_name']   = $this->getPaymentMethodName($order['payment_method']);
            $order                          = $this->afterOrderPopulation($order);
            $order['netPayment']            = $this->getAmount($order);
            $detailViewDTO->setBrowseModels($this->getOrderViewBrowseModels($storeId));
            $detailViewDTO->setModel($order);
            $detailViewDTO->setIsValidOrder(true);
        }
        else
        {
            $detailViewDTO->setIsValidOrder(false);
        }
    }
    
    /**
     * Get order view browse models.
     * @param integer $storeId
     * @return array
     */
    public function getOrderViewBrowseModels($storeId)
    {
        return OrderDAO::getStoreOrdersForCustomer($this->userId, $storeId);
    }
    
    /**
     * Process after order population
     * @param array $order
     */
    public function afterOrderPopulation($order)
    {
        $event = new OrderEvent(['order' => $order]);
        $this->trigger(Order::EVENT_AFTER_ORDER_POPULATION, $event);
        return $event->order;
    }
}