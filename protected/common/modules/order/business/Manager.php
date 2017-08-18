<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\business;

use common\modules\order\dto\AdminCheckoutDTO;
use common\modules\order\models\Order;
use common\modules\order\dto\GridViewDTO;
use common\modules\localization\modules\orderstatus\dao\OrderStatusDAO;
use usni\library\utils\ArrayUtil;
use customer\business\Manager as CustomerBusinessManager;
use common\modules\shipping\dao\ShippingDAO;
use common\modules\order\models\OrderPaymentTransactionMap;
use common\modules\order\dao\OrderDAO;
use yii\base\InvalidParamException;
use usni\library\modules\users\models\Address;
use common\modules\order\dto\DetailViewDTO;
use products\dao\ProductDAO;
use cart\models\Item;
use cart\business\Manager as CartManager;
use usni\UsniAdaptor;
use common\modules\order\models\LatestOrderSearch;
use common\modules\order\services\NotificationService;
use common\modules\order\events\OrderEvent;
use common\modules\localization\modules\orderstatus\models\OrderStatusTranslated;
use yii\db\Exception;
use products\behaviors\PriceBehavior;
use common\modules\order\behaviors\OrderBehavior;
/**
 * Implements business logic for order
 *
 * @package common\modules\order\business
 */
class Manager extends \common\business\Manager
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    use \common\modules\payment\traits\PaymentTrait;
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            NotificationService::className(),
            PriceBehavior::className(),
            OrderBehavior::className()
        ];
    }
    
    /**
     * Process order creation
     * @param AdminCheckoutDTO $checkoutDTO
     */
    public function processOrderEdit($checkoutDTO)
    {
        $order = $checkoutDTO->getCheckout()->order;
        if($order->scenario == 'update' && !($this->isValidOrderId($order->id)))
        {
            throw new InvalidParamException(UsniAdaptor::t('stores', 'Invalid Order'));
        }
        $model  = $checkoutDTO->getCheckout()->customerForm;
        if($model->scenario == 'update')
        {
            $completedOrderStatus   = OrderStatusTranslated::find()->where('name = :name AND language = :lang', 
                                                                           [':name' => Order::STATUS_COMPLETED, ':lang' => $this->language])
                                                                           ->asArray()->one();
            if($order->status == $completedOrderStatus['owner_id'])
            {
                throw new Exception(UsniAdaptor::t('order', 'Order could not be updated.'));
            }

        }
        if($model->load($checkoutDTO->getPostData()))
        {
            $checkoutDTO->getCheckout()->customerForm = $model;
            if($model->scenario == 'update')
            {
                $this->prepareAndAddCartItems($checkoutDTO);
            }
            $checkoutDTO->setResult(true);
        }
        $dropdownData = CustomerBusinessManager::getInstance()->getCustomerAndGuestDropdownData();
        $checkoutDTO->setCustomers($dropdownData);
        if($model->scenario == 'update')
        {
            $checkoutDTO->setBrowseModels($this->getBrowseModels(null));
        }
    }
    
    /**
     * Prepare and add cart item
     * @param AdminCheckoutDTO $checkoutDTO
     */
    public function prepareAndAddCartItems($checkoutDTO)
    {
        $order          = $checkoutDTO->getCheckout()->order;
        $orderProducts  = $order->orderProducts;
        foreach($orderProducts as $orderProduct)
        {
            $this->addOrderProductItem($orderProduct, $checkoutDTO);
        }
    }
    
    /**
     * inheritdoc
     * @param GridViewDTO $gridViewDTO
     */
    public function processList($gridViewDTO)
    {
        parent::processList($gridViewDTO);
        $allStatus  = OrderStatusDAO::getAll($this->language);
        $statusData = ArrayUtil::map($allStatus, 'id', 'name');
        $gridViewDTO->setStatusData($statusData);
        $customerFilterData = CustomerBusinessManager::getInstance()->getCustomerAndGuestDropdownData();
        $gridViewDTO->setCustomerFilterData($customerFilterData);
        $paymentMethods = $this->getPaymentMethodDropdown();
        $gridViewDTO->setPaymentMethods($paymentMethods);
        $shippingMethods = ShippingDAO::getMethods($this->language);
        $gridViewDTO->setShippingMethods(ArrayUtil::map($shippingMethods, 'code', 'name'));
    }
    
    /**
     * Get already paid amount for the order
     * @param integer $orderId
     * @return double
     */
    public function getAlreadyPaidAmountForOrder($orderId)
    {
        $orderPaymentMethodMap = OrderPaymentTransactionMap::find()->where('order_id = :oid', [':oid' => $orderId])->asArray()->all();
        $total = 0;
        if(!empty($orderPaymentMethodMap))
        {
            foreach($orderPaymentMethodMap as $record)
            {
                $total += $record['amount'];
            }
        }
        return $total;
    }
    
    /**
     * inheritdoc
     * @param DetailViewDTO $detailViewDTO
     */
    public function processDetail($detailViewDTO)
    {
        $orderId = $detailViewDTO->getId();
        if($this->isValidOrderId($orderId))
        {
            parent::processDetail($detailViewDTO);
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
        }
        else
        {
            throw new InvalidParamException(UsniAdaptor::t('stores', 'Invalid Order'));
        }
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $order  = OrderDAO::getById($id, $this->language, $this->selectedStoreId);
        if ($order === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        $order['currency_symbol']       = UsniAdaptor::app()->currencyManager->getCurrencySymbol($order['currency_code']);
        $order['shipping_method_name']  = ShippingDAO::getShippingMethodName($order['shipping'], $this->language);
        $order['status_label']          = $this->getOrderStatusLabel($order['status']);
        $order['billingAddress']        = OrderDAO::getOrderAddress($order['id'], Address::TYPE_BILLING_ADDRESS);
        $order['shippingAddress']       = OrderDAO::getOrderAddress($order['id'], Address::TYPE_SHIPPING_ADDRESS);
        $order['payment_method_name']   = $this->getPaymentMethodName($order['payment_method']);
        $order                          = $this->afterOrderPopulation($order);
        $order['netPayment']            = $this->getAmount($order);
        return $order;
    }
    
    /**
     * Check if order allowed to perform action
     * @param integer $orderId
     * @return boolean
     */
    public function isValidOrderId($orderId)
    {
        $orderIdArray   = [];
        $records        = OrderDAO::getStoreOrders($this->selectedStoreId);
        foreach ($records as $records)
        {
            $orderIdArray[] = $records['id'];
        }
        if(!in_array($orderId, $orderIdArray))
        {
            return false;
        }
        return true;
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return OrderDAO::getStoreOrders($this->selectedStoreId);
    }
    
    /**
     * Process order history 
     * @param array $postData
     */
    public function processOrderHistory($postData)
    {
        $orderId            = $postData['order_id'];
        $order              = Order::findOne($orderId);
        $completedStatus    = $this->getStatusId("Completed", "en-US");
        $order->scenario    = 'update';
        $order->status      = $postData['status'];
        $order->save();
        $order->addHistory($postData['comment'], $postData['notify_customer']);
        $this->trigger(Order::EVENT_AFTER_ADDING_HISTORY, new OrderEvent(['order' => $order]));
        if($postData['notify_customer'])
        {
           if($postData['status'] == $completedStatus)
            {
                $order = OrderDAO::getById($order['id'], $this->language, $this->selectedStoreId);
                $this->trigger(Order::EVENT_ORDER_COMPLETED, new OrderEvent(['order' => $order]));
            }
        }
    }
    
    /**
     * Adds order product item to the cart.
     * @param OrderProduct $orderProduct
     * @param AdminCheckoutDTO $checkoutDTO
     */
    public function addOrderProductItem($orderProduct, $checkoutDTO)
    {
        $order                  = $checkoutDTO->getCheckout()->order;
        $productPrice           = $this->getPriceByInBaseCurrency($orderProduct['price'], $order->currency_conversion_value);
        $productTax             = $this->getPriceByInBaseCurrency($orderProduct['tax'], $order->currency_conversion_value);
        $productOptionsPrice    = $this->getPriceByInBaseCurrency($orderProduct['options_price'], $order->currency_conversion_value);
        $dbProduct              = ProductDAO::getById($orderProduct['product_id'], $this->language);
        //get the input options
        $inputOptions   = unserialize($orderProduct['options']);
        $optionData     = CartManager::getInstance()->prepareOptionsData($inputOptions, $productOptionsPrice, $productPrice);
        //Prepare cart item
        $item   = new Item();
        $item->setItemCode($orderProduct['item_code']);
        $item->setOptionsPrice($productOptionsPrice);
        $item->setPrice($productPrice);
        $item->setName($orderProduct['name']);
        $item->setRequireShipping($dbProduct['requires_shipping']);
        $item->setDisplayedOptions($orderProduct['displayed_options']);
        $item->setOptionsData(serialize($optionData));
        $item->setInputOptions($orderProduct['options']);
        $item->setProductId($orderProduct['product_id']);
        $item->setModel($orderProduct['model']);
        $item->setTax($productTax);
        $item->setTotalPrice($productPrice + $productTax);
        $item->setThumbnail($dbProduct['image']);
        $item->setStockStatus($dbProduct['stock_status']);
        $item->setType($dbProduct['type']);
        $item->setQty($orderProduct['quantity']);
        $checkoutDTO->getCart()->itemsList->add($item);
    }
    
    /**
     * Process latest orders
     * @param \common\modules\order\dto\GridViewDTO $gridViewDTO
     */
    public function processLatestOrders($gridViewDTO)
    {
        $orderSearch = new LatestOrderSearch();
        $gridViewDTO->setDataProvider($orderSearch->search());
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