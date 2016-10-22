<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\managers;

use usni\UsniAdaptor;
use usni\library\modules\users\models\Address;
use common\modules\order\utils\OrderUtil;
use common\modules\order\models\Order;
use common\modules\order\models\OrderPaymentDetails;
use common\modules\order\models\OrderProduct;
use cart\utils\CartUtil;
use common\utils\ApplicationUtil;
use usni\library\utils\TranslationUtil;
use products\utils\ProductUtil;
use common\modules\stores\utils\StoreUtil;
use common\modules\localization\modules\currency\utils\CurrencyUtil;
/**
 * Base class for payment manager.
 * 
 * @package common\modules\payment\managers
 */
abstract class BasePaymentManager extends \yii\base\Component
{
    /**
     * Order associated with the payment
     * @var Order 
     */
    public $order;
    
    /**
     * Checkout Details
     * @var Component 
     */
    public $checkoutDetails;
    
    /**
     * Cart Details
     * @var Component 
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
        $this->isNewRecord     = $this->order->isNewRecord;
        $transaction     = UsniAdaptor::db()->beginTransaction();
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
            $this->order->currency_code        = UsniAdaptor::app()->currencyManager->getDisplayCurrency();
            $defaultCurrencyCode               = UsniAdaptor::app()->currencyManager->getDefault();
            if($defaultCurrencyCode != $this->order->currency_code)
            {
                $currRecord = CurrencyUtil::getCurrencyByCode($this->order->currency_code);
                $this->order->currency_conversion_value = $currRecord['value'];
            }
            else
            {
                $this->order->currency_conversion_value = 1.00;
            }
            $this->order->shipping             = $this->checkoutDetails->deliveryOptionsEditForm->shipping;
            $this->order->shipping_comments    = $this->checkoutDetails->deliveryOptionsEditForm->comments;
            $this->order->shipping_fee         = $this->checkoutDetails->deliveryOptionsEditForm->shipping_fee;
            $this->order->customer_id          = $this->customerId;
            $this->updateOrderStatus();
            $this->order->save();
            if($this->order->scenario == 'create')
            {
                TranslationUtil::saveTranslatedModels($this->order);
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
            $attributes['created_by'] = ApplicationUtil::getCustomerId();
            $attributes['created_datetime'] = UsniAdaptor::getNow();
            $attributes['modified_by'] = ApplicationUtil::getCustomerId();
            $attributes['modified_datetime'] = UsniAdaptor::getNow();
            UsniAdaptor::app()->db->createCommand()->insert($tableName, $attributes)->execute();
        }
        else
        {
            $attributes['modified_by'] = ApplicationUtil::getCustomerId();
            $attributes['modified_datetime'] = UsniAdaptor::getNow();
            $address    = OrderUtil::getOrderAddress($this->order->id, $type);
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
        $this->orderPaymentDetail->total_including_tax  = $this->cartDetails->getAmount();
        $this->orderPaymentDetail->tax  = $this->cartDetails->getTax();
        $this->orderPaymentDetail->payment_method = $paymentMethod;
        $this->orderPaymentDetail->save();
        if($this->orderPaymentDetail->scenario == 'create')
        {
            TranslationUtil::saveTranslatedModels($this->orderPaymentDetail);
        }
    }
    
    /**
     * Save order product
     * @return void
     */
    public function saveOrderProduct()
    {
        $orderProducts = OrderUtil::getOrderProducts($this->order->id);
        foreach ($this->cartDetails->itemsList as $itemCode => $detail)
        {
            //In case of options
            if(strpos($itemCode, '_') !== false)
            {
                list($inputProductId, $options) = CartUtil::getProductAndOptionsByItemCode($itemCode);
            }
            else
            {
                $inputProductId   = $itemCode;
            }
            $isNewRecord  = true;
            $orderProduct = [];
            if(!empty($orderProducts))
            {
                foreach($orderProducts as $data)
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
            $orderProduct['quantity']     = $detail['qty'];
            $orderProduct['options']      = $detail['options'];
            $orderProduct['displayed_options']  = $detail['selectedOptions'];
            //Put the prices in actual currency in which order is placed
            $orderProduct['price']        = ProductUtil::getPriceByCurrency($detail['price']);
            $orderProduct['options_price']= ProductUtil::getPriceByCurrency($detail['options_price']);
            $orderProduct['tax']          = ProductUtil::getPriceByCurrency($detail['tax']);
            $orderProduct['total']        = ProductUtil::getPriceByCurrency($detail['total_price']) * $detail['qty'];
            $orderProduct['product_id']   = $inputProductId;
            $orderProduct['item_code']    = $itemCode;
            $orderProduct['name']         = $detail['name'];
            $orderProduct['model']        = $detail['model'];
            if($isNewRecord)
            {
                $orderProduct['created_by'] = ApplicationUtil::getCustomerId();
                $orderProduct['created_datetime'] = UsniAdaptor::getNow();
                $orderProduct['modified_by'] = ApplicationUtil::getCustomerId();
                $orderProduct['modified_datetime'] = UsniAdaptor::getNow();
                UsniAdaptor::app()->db->createCommand()->insert(OrderProduct::tableName(), $orderProduct)->execute();
                OrderUtil::reduceProductQuantityAfterCheckout($inputProductId, $detail['qty']);
            }
            else
            {
                $orderProduct['modified_by'] = ApplicationUtil::getCustomerId();
                $orderProduct['modified_datetime'] = UsniAdaptor::getNow();
                UsniAdaptor::app()->db->createCommand()->update(OrderProduct::tableName(), $orderProduct, 'id = :id', [':id' => $orderProduct['id']])->execute();
            }
            $this->orderProducts[]      = $orderProduct;
        }
    }
    
    /**
     * Update order status
     */
    public function updateOrderStatus()
    {
        $defaultOrderStatus     = StoreUtil::getSettingValue('order_status');
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
            OrderUtil::saveInvoice($this->orderPaymentDetail, $this->cartDetails->getCount());
        }
    }
}