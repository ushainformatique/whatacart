<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\business;

use usni\UsniAdaptor;
use usni\library\modules\users\models\Address;
use common\modules\order\models\Order;
use common\modules\order\models\OrderPaymentDetails;
use common\modules\localization\modules\currency\dao\CurrencyDAO;
use common\modules\order\dao\OrderDAO;
use products\behaviors\PriceBehavior;
use products\models\Product;
use cart\models\Checkout;
use cart\models\Cart;
use common\modules\order\business\InvoiceManager as InvoiceManager;
use common\modules\order\models\OrderProduct;
/**
 * Base class for payment processor.
 * 
 * @package common\modules\payment\business
 */
abstract class BasePaymentProcessor extends \yii\base\Component
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    
    /**
     * Event triggered on confirmation of order.
     */
    CONST EVENT_ON_ORDER_CONFIRM = "afterConfirm";
    
    /**
     * @var int 
     */
    public $selectedStoreId;
    
    /**
     * @var string 
     */
    public $language;
    
    /**
     * @var string 
     */
    public $selectedCurrency;
    
    /**
     * Order associated with the payment
     * @var Order 
     */
    public $order;
    
    /**
     * Checkout Details
     * @var Checkout 
     */
    public $checkoutDetails;
    
    /**
     * Cart Details
     * @var Cart 
     */
    public $cartDetails;
    
    /**
     * Customer id
     * @var int
     */
    public $customerId;
    
    /**
     * Is new record flag
     * @var bool 
     */
    public $isNewRecord;
    
    /**
     * Order products corresponding to the order
     * @var array 
     */
    public $orderProducts;
    
    /**
     * Order payment detail
     * @var OrderPaymentDetail 
     */
    public $orderPaymentDetail;
    
    /**
     * Send notification.
     * @var bool 
     */
    public $sendNotification = false;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        $this->selectedStoreId  = UsniAdaptor::app()->storeManager->selectedStoreId;
        $this->language = UsniAdaptor::app()->languageManager->selectedLanguage;
        $this->selectedCurrency  = UsniAdaptor::app()->currencyManager->selectedCurrency;
    }
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            PriceBehavior::className()
        ];
    }
    
    /**
     * Process Purchase
     * @return boolean
     */
    public function processPurchase()
    {
        $this->saveInitialPaymentDetails();
        return true;
    }
    
    /**
     * Process payment details on checkout
     */
    public function saveInitialPaymentDetails()
    {
        $this->isNewRecord      = $this->order->isNewRecord;
        $transaction            = UsniAdaptor::db()->beginTransaction();
        try
        {
            if($this->isNewRecord)
            {
                $this->order->scenario = 'create';
            }
            else
            {
                $this->order->scenario = 'update';
            }
            //Save order
            $this->order->currency_code        = $this->selectedCurrency;
            $defaultCurrencyCode               = UsniAdaptor::app()->currencyManager->defaultCurrency;
            if($defaultCurrencyCode != $this->order->currency_code)
            {
                $currRecord = CurrencyDAO::getByCode($this->order->currency_code, $this->language);
                $this->order->currency_conversion_value = $currRecord['value'];
            }
            else
            {
                $this->order->currency_conversion_value = 1.00;
            }
            $this->order->shipping             = $this->checkoutDetails->deliveryOptionsEditForm->shipping;
            $this->order->shipping_comments    = $this->checkoutDetails->deliveryOptionsEditForm->comments;
            $this->order->shipping_fee         = $this->getPriceByCurrency($this->checkoutDetails->deliveryOptionsEditForm->shipping_fee, $this->selectedCurrency);
            $this->order->customer_id          = $this->customerId == null ? 0 : $this->customerId;
            $this->updateOrderStatus();
            $this->order->save();
            if($this->order->scenario == 'create')
            {
                $this->order->saveTranslatedModels();
            }
            
            //Save order address details
            $this->savePaymentAddressDetails(Address::TYPE_BILLING_ADDRESS);
            if($this->order->shipping != null)
            {
                $this->savePaymentAddressDetails(Address::TYPE_SHIPPING_ADDRESS);
            }
            $this->saveOrderPaymentDetails();
            $this->saveOrderProduct();
            $this->saveInvoice();
            $transaction->commit();
        }
        catch(\yii\base\Exception $e)
        {
            $transaction->rollBack();
            throw $e;
        }
    }
    
    /**
     * Save payment address details
     * @param int $type
     */
    public function savePaymentAddressDetails($type)
    {
        $isNewRecord = $this->isNewRecord;
        if($type == Address::TYPE_BILLING_ADDRESS)
        {
            $checkoutAddressFormModel = 'billingInfoEditForm';
        }
        else
        {
            $checkoutAddressFormModel = 'deliveryInfoEditForm';
        }
        $attributes             = $this->checkoutDetails->$checkoutAddressFormModel->attributes;
        if($type == Address::TYPE_SHIPPING_ADDRESS)
        {
            unset($attributes['sameAsBillingAddress']);
        }
        $attributes['order_id'] = $this->order->id;
        $attributes['type']     = $type;
        $tableName              = UsniAdaptor::tablePrefix() . 'order_address_details';
        if($isNewRecord)
        {
            $attributes['created_by'] = $this->customerId;
            $attributes['created_datetime'] = UsniAdaptor::getNow();
            $attributes['modified_by'] = $this->customerId;
            $attributes['modified_datetime'] = UsniAdaptor::getNow();
            UsniAdaptor::app()->db->createCommand()->insert($tableName, $attributes)->execute();
        }
        else
        {
            $attributes['modified_by'] = $this->customerId;
            $attributes['modified_datetime'] = UsniAdaptor::getNow();
            $address    = OrderDAO::getOrderAddress($this->order->id, $type);
            UsniAdaptor::app()->db->createCommand()->update($tableName, $attributes, 'id = :id', [':id' => $address['id']])->execute();
        }
    }
    
    /**
     * Save order payment details
     * @return void
     */
    public function saveOrderPaymentDetails()
    {
        $isNewRecord     = $this->isNewRecord;
        $paymentMethod   = $this->checkoutDetails->paymentMethodEditForm->payment_method;
        
        //Save order payment details
        if($isNewRecord)
        {
            $this->orderPaymentDetail = new OrderPaymentDetails();
            $this->orderPaymentDetail->scenario = 'create';
        }
        else
        {
            $this->orderPaymentDetail = $this->order->orderPaymentDetails;
            $this->orderPaymentDetail->scenario = 'update';
        }
        $this->orderPaymentDetail->comments    = $this->checkoutDetails->paymentMethodEditForm->comments;
        $this->orderPaymentDetail->order_id    = $this->order->id;
        $this->orderPaymentDetail->shipping_fee    = $this->order->shipping_fee;
        $this->orderPaymentDetail->payment_type  = 'instant';
        $this->orderPaymentDetail->total_including_tax  = $this->getPriceByCurrency($this->cartDetails->getAmount(), $this->selectedCurrency);
        $this->orderPaymentDetail->tax  = $this->getPriceByCurrency($this->cartDetails->getTax(), $this->selectedCurrency);
        $this->orderPaymentDetail->payment_method = $paymentMethod;
        $this->orderPaymentDetail->save();
        if($this->orderPaymentDetail->scenario == 'create')
        {
            $this->orderPaymentDetail->saveTranslatedModels();
        }
    }
    
    /**
     * Save order product
     * @return void
     */
    public function saveOrderProduct()
    {
        $modifiedOrderProducts = [];
        $orderProducts = OrderDAO::getOrderProducts($this->order->id, $this->language);
        if(!empty($orderProducts))
        {
            //Go through the products in db for the order and check if product is not in cart than it is removed from cart so should be deleted from db.
            foreach($orderProducts as $index => $data)
            {
                $item = $this->cartDetails->itemsList->get($data['item_code']);
                if($item == null)
                {
                    //Remove from database
                    OrderProduct::deleteAll('id = :id', [':id' => $data['id']]);
                }
                else
                {
                    //Store it so that it can be updated
                    $modifiedOrderProducts[] = $data;
                }
            }
        }
        foreach ($this->cartDetails->itemsList as $itemCode => $item)
        {
            //In case of options
            if(strpos($itemCode, '_') !== false)
            {
                $inputProductId     = $this->cartDetails->getProductIdByItemCode($itemCode);
            }
            else
            {
                $inputProductId     = $itemCode;
            }
            $isNewRecord  = true;
            $orderProduct = [];
            if(!empty($modifiedOrderProducts))
            {
                foreach($modifiedOrderProducts as $data)
                {
                    if($data['item_code'] == $itemCode)
                    {
                        $orderProduct = $data;
                        $isNewRecord  = false;
                        break;
                    }
                }
            }
            $orderProduct['order_id']     = $this->order->id;
            $orderProduct['quantity']     = $item->qty;
            $orderProduct['options']      = $item->inputOptions;
            $orderProduct['displayed_options']  = $item->displayedOptions;
            //Put the prices in actual currency in which order is placed
            $orderProduct['price']        = $this->getPriceByCurrency($item->price, $this->selectedCurrency);
            $orderProduct['options_price']= $this->getPriceByCurrency($item->optionsPrice, $this->selectedCurrency);
            $orderProduct['tax']          = $this->getPriceByCurrency($item->tax, $this->selectedCurrency);
            $orderProduct['total']        = $this->getPriceByCurrency($item->totalPrice, $this->selectedCurrency) * $item->qty;
            $orderProduct['product_id']   = $inputProductId;
            $orderProduct['item_code']    = $itemCode;
            $orderProduct['name']         = $item->name;
            $orderProduct['model']        = $item->model;
            $orderProductTable            = UsniAdaptor::tablePrefix() . 'order_product';
            if($isNewRecord)
            {
                $orderProduct['created_by'] = $this->customerId;
                $orderProduct['created_datetime'] = UsniAdaptor::getNow();
                $orderProduct['modified_by'] = $this->customerId;
                $orderProduct['modified_datetime'] = UsniAdaptor::getNow();
                UsniAdaptor::app()->db->createCommand()->insert($orderProductTable, $orderProduct)->execute();
                $this->reduceProductQuantityAfterCheckout($inputProductId, $item->qty);
            }
            else
            {
                $orderProduct['modified_by'] = $this->customerId;
                $orderProduct['modified_datetime'] = UsniAdaptor::getNow();
                UsniAdaptor::app()->db->createCommand()->update($orderProductTable, $orderProduct, 'id = :id', [':id' => $orderProduct['id']])->execute();
            }
            $this->orderProducts[]      = $orderProduct;
        }
    }
    
    /**
     * Update order status
     */
    public function updateOrderStatus()
    {
        $defaultOrderStatus     = UsniAdaptor::app()->storeManager->getSettingValue('order_status');
        $this->order->status    = $defaultOrderStatus;
    }
    
    /**
     * Save invoice
     * @return void
     */
    public function saveInvoice()
    {
        if($this->isNewRecord)
        {
            InvoiceManager::getInstance()->saveInvoice($this->orderPaymentDetail, $this->cartDetails->itemsList->count());
        }
    }
    
    /**
     * Update product quantity after checkout.
     * @param integer $productId.
     * @return void
     */
    public function reduceProductQuantityAfterCheckout($productId, $qtyToReduce)
    {
        $product =  Product::find()->where('id = :id', [':id' => $productId])->asArray()->one();
        if($product['quantity'] > 0 && $product['quantity'] > $qtyToReduce)
        {
            $quantityAfterCheckout = $product['quantity'] - $qtyToReduce;
            UsniAdaptor::db()->createCommand()
                        ->update(Product::tableName(), ['quantity' => $quantityAfterCheckout],
                                   'id = :id', [':id' => $productId])->execute();
        }
    }
    
    /**
     * Send notification
     * @return void
     */
    public function shouldSendNotification()
    {
        $lastOrderStatus    = OrderDAO::getLastOrderStatus($this->order->id);
        if($lastOrderStatus === false)
        {
            return true;
        }
        else
        {
            $finalStatus        = $this->order->status;
            $completedStatus    = $this->getStatusId(Order::STATUS_COMPLETED, $this->language);
            if($lastOrderStatus['status'] != $finalStatus && ($completedStatus == $finalStatus))
            {
                return true;
            }
        }
        return false;
    }
}