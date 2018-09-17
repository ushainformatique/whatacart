<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\business;

use cart\dto\CheckoutDTO;
use yii\base\Model;
use common\modules\order\models\Order;
use cart\models\DeliveryOptionsEditForm;
use cart\models\PaymentMethodEditForm;
use products\behaviors\PriceBehavior;
use cart\dto\ReviewDTO;
use common\modules\shipping\dao\ShippingDAO;
use common\modules\localization\modules\orderstatus\dao\OrderStatusDAO;
use usni\library\utils\ArrayUtil;
use customer\models\Customer;
use common\modules\order\dao\OrderDAO;
use usni\library\modules\users\models\Address;
use usni\UsniAdaptor;
use cart\behaviors\CheckoutManagerBehavior;
use common\modules\order\events\ConfirmOrderEvent;
/**
 * AdminCheckoutManager implements the business logic for checkout
 *
 * @package common\modules\order\business
 */
class AdminCheckoutManager extends \common\business\Manager
{
    use \common\modules\payment\traits\PaymentTrait;
    use \common\modules\shipping\traits\ShippingTrait;
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    
    /**
     * @event Event triggered after payment is confirmed
     */
    CONST EVENT_AFTER_CONFIRM = 'afterConfirm';
    
    /**
     * Payment factory class name
     * @var string 
     */
    public $paymentFactoryClassName;
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            PriceBehavior::className(),
            CheckoutManagerBehavior::className()
        ];
    }
    
    /**
     * Process checkout
     * @param CheckoutDTO $checkoutDTO
     */
    public function processCheckout($checkoutDTO)
    {
        $postData   = $checkoutDTO->getPostData();
        $cart       = $checkoutDTO->getCart();
        /* @var $checkout \cart\models\Checkout*/
        $checkout   = $checkoutDTO->getCheckout();
        if(isset($postData['BillingInfoEditForm']))
        {
            $checkout->billingInfoEditForm->attributes = $postData['BillingInfoEditForm'];
            if($cart->isShippingRequired())
            {
                $checkout->deliveryInfoEditForm->attributes = $postData['DeliveryInfoEditForm'];
                $checkout->deliveryOptionsEditForm->attributes = $postData['DeliveryOptionsEditForm'];
            }
            $checkout->paymentMethodEditForm->attributes = $postData['PaymentMethodEditForm'];
            if($cart->isShippingRequired())
            {
                $isValid = Model::validateMultiple([$checkout->billingInfoEditForm, 
                                                    $checkout->deliveryInfoEditForm, 
                                                    $checkout->deliveryOptionsEditForm, 
                                                    $checkout->paymentMethodEditForm]);
            }
            else
            {
                $isValid = Model::validateMultiple([$checkout->billingInfoEditForm, $checkout->paymentMethodEditForm]);
            }
            $checkoutDTO->setCheckout($checkout);
            if($isValid)
            {
                $this->processOrderCreation($checkoutDTO);
            }
        }
        else
        {
            $this->populateCustomerInfoInFormModel($checkoutDTO, Address::TYPE_BILLING_ADDRESS, 'billingInfoEditForm');
            $this->populateCustomerInfoInFormModel($checkoutDTO, Address::TYPE_SHIPPING_ADDRESS, 'deliveryInfoEditForm');
        }
        $checkout->deliveryOptionsEditForm->shipping        = $checkout->order->shipping;
        if(!empty($checkout->order->orderPaymentDetails))
        {
            $checkout->paymentMethodEditForm->payment_method    = $checkout->order->orderPaymentDetails->payment_method;
        }
        
        $shippingMethods    = $this->getShippingMethods();
        $checkoutDTO->setShippingMethods($shippingMethods);
        $paymentMethods     = $this->getPaymentMethodDropdown();
        $checkoutDTO->setPaymentMethods($paymentMethods);
    }
    
    /**
     * Process order creation
     * @param CheckoutDTO $checkoutDTO
     */
    protected function processOrderCreation($checkoutDTO)
    {
        $checkout = $checkoutDTO->getCheckout();
        $checkout->order->store_id    = $this->selectedStoreId;
        $checkout->order->interface   = $checkoutDTO->getInterface();
        $paymentMethod   = $checkout->paymentMethodEditForm->payment_method;
        $shippingMethod  = $checkout->deliveryOptionsEditForm->shipping;
        if($shippingMethod != null)
        {
            $checkout->deliveryOptionsEditForm->shipping_fee = $this->getCalculatedPriceByType($shippingMethod, $checkoutDTO->getCart());
        }
        $paymentFactoryClassName    = $this->paymentFactoryClassName;
        $paymentFactory             = new $paymentFactoryClassName([  
                                                    'type' => $paymentMethod,
                                                    'order' => $checkout->order, 
                                                    'checkoutDetails' => $checkout,
                                                    'cartDetails'     => $checkoutDTO->getCart(),
                                                    'customerId'      => $checkoutDTO->getCustomerId()]);
        $instance           = $paymentFactory->getInstance();
        $result             = $instance->processPurchase();
        $checkoutDTO->setResult($result);
    }
    
    /**
     * Process order completion
     * @param CheckoutDTO $checkoutDTO
     */
    public function processComplete($checkoutDTO)
    {
        /* @var $checkout \cart\models\Checkout*/
        
        $checkout   = $checkoutDTO->getCheckout();
        $order      = $checkout->order;
        $paymentFactoryClassName    = $this->paymentFactoryClassName;
        $paymentFactory             = new $paymentFactoryClassName(['type' => $checkout->paymentMethodEditForm->payment_method,
                                                  'order' => $order,
                                                  'checkoutDetails' => $checkoutDTO->getCheckout()
                                                ]);
        $instance                   = $paymentFactory->getInstance();
        $instance->processConfirm();
        $this->processAfterConfirm($checkoutDTO);
        $checkoutDTO->getCheckout()->deliveryOptionsEditForm  = new DeliveryOptionsEditForm();
        $checkoutDTO->getCheckout()->paymentMethodEditForm    = new PaymentMethodEditForm();
        $checkoutDTO->getCheckout()->order                    = new Order();
    }
    
    /**
     * Populate review dto
     * @param ReviewDTO $reviewDTO
     * @param Checkout $checkout
     * @param Cart $cart
     */
    public function populateReviewDTO($reviewDTO, $checkout, $cart)
    {
        $reviewDTO->setBillingContent($checkout->billingInfoEditForm->getConcatenatedAddress());
        if($cart->isShippingRequired())
        {
            $reviewDTO->setShippingContent($checkout->deliveryInfoEditForm->getConcatenatedAddress());
            $reviewDTO->setShippingName(ShippingDAO::getShippingMethodName($checkout->deliveryOptionsEditForm->shipping,
                                                                           $this->language));
            $shippingMethod  = $checkout->deliveryOptionsEditForm->shipping;
            if($shippingMethod != null)
            {
                $checkout->deliveryOptionsEditForm->shipping_fee = $this->getCalculatedPriceByType($shippingMethod, $cart);
                $order = $checkout->order;
                $order->shipping_fee = $checkout->deliveryOptionsEditForm->shipping_fee;
                $order->save();
            }
        }
        $paymentMethodName = $this->getPaymentMethodName($checkout->paymentMethodEditForm->payment_method);
        $reviewDTO->setPaymentMethodName($paymentMethodName);
        $allStatus      = OrderStatusDAO::getAll(UsniAdaptor::app()->languageManager->selectedLanguage);
        $allStatusMap   = ArrayUtil::map($allStatus, 'id', 'name');
        $reviewDTO->setAllStatus($allStatusMap);
    }
    
    /**
     * Populate customer info in model
     * @param CheckoutDTO $checkoutDTO
     * @param int $type
     * @param string $attribute
     */
    public function populateCustomerInfoInFormModel($checkoutDTO, $type, $attribute)
    {
        $customerId = $checkoutDTO->getCustomerId();
        if($customerId != null && $customerId != Customer::GUEST_CUSTOMER_ID)
        {
            $address = OrderDAO::getLatestOrderAddressByType($customerId, $type);
            if($address !== false)
            {
                $checkoutDTO->getCheckout()->$attribute->attributes = $address;
            }
        }
    }
    
    /**
     * Process after confirm
     * @param CheckoutDTO $checkoutDTO
     */
    public function processAfterConfirm($checkoutDTO)
    {
        $event          = new ConfirmOrderEvent(['checkoutDTO' => $checkoutDTO]);
        $this->trigger(static::EVENT_AFTER_CONFIRM, $event);
    }
}