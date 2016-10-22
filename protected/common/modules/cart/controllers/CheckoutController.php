<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\controllers;

use frontend\controllers\BaseController;
use cart\views\CheckoutView;
use cart\models\DeliveryOptionsEditForm;
use cart\models\PaymentMethodEditForm;
use frontend\utils\FrontUtil;
use common\modules\order\models\Order;
use usni\UsniAdaptor;
use common\modules\payment\components\PaymentFactory;
use cart\models\Cart;
use frontend\components\Breadcrumb;
use yii\base\Model;
use cart\views\ReviewOrderView;
use common\modules\shipping\utils\ShippingUtil;
use common\utils\ApplicationUtil;
use common\modules\stores\utils\StoreUtil;
use usni\library\utils\FlashUtil;
use cart\models\ConfirmOrderForm;

/**
 * CheckoutController class file
 *
 * @package cart\controllers
 */
class CheckoutController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->checkAndRedirectIfCartEmpty();
    }
    
    /**
     * Index action for checkout
     * @return string
     */
    public function actionIndex()
    {
        $guestCheckoutSetting       = StoreUtil::getSettingValue('guest_checkout');
        if(!$guestCheckoutSetting && UsniAdaptor::app()->user->isGuest === true)
        {
            return $this->redirect(UsniAdaptor::createUrl('customer/site/login'));
        }
        else
        {
            $cart = ApplicationUtil::getCart();
            if($cart->shouldProceedForCheckout() === false)
            {
                FlashUtil::setMessage('outOfStockCheckoutNowAllowed', UsniAdaptor::t('cartflash', "Either products in the cart are not in stock or out of stock checkout is not allowed. Please contact system admin."));
                return $this->redirect(UsniAdaptor::createUrl('cart/default/view'));
            }
            $billingInfoEditForm    = ApplicationUtil::getCheckoutFormModel('billingInfoEditForm');
            $deliveryInfoEditForm   = ApplicationUtil::getCheckoutFormModel('deliveryInfoEditForm');
            $deliveryOptionsEditForm    = ApplicationUtil::getCheckoutFormModel('deliveryOptionsEditForm');
            $paymentMethodEditForm  = ApplicationUtil::getCheckoutFormModel('paymentMethodEditForm');
            if(isset($_POST['BillingInfoEditForm']))
            {
                $billingInfoEditForm->attributes = $_POST['BillingInfoEditForm'];
                if($cart->isShippingRequired())
                {
                    $deliveryInfoEditForm->attributes = $_POST['DeliveryInfoEditForm'];
                    $deliveryOptionsEditForm->attributes = $_POST['DeliveryOptionsEditForm'];
                }
                $paymentMethodEditForm->attributes = $_POST['PaymentMethodEditForm'];
                if($cart->isShippingRequired())
                {
                    $isValid = Model::validateMultiple([$billingInfoEditForm, $deliveryInfoEditForm, $deliveryOptionsEditForm, $paymentMethodEditForm]);
                }
                else
                {
                    $isValid = Model::validateMultiple([$billingInfoEditForm, $paymentMethodEditForm]);
                }
                if($isValid)
                {
                    $this->setModelInSession($billingInfoEditForm, 'billingInfoEditForm');
                    if($cart->isShippingRequired())
                    {
                        $this->setModelInSession($deliveryInfoEditForm, 'deliveryInfoEditForm');
                        $this->setModelInSession($deliveryOptionsEditForm, 'deliveryOptionsEditForm');
                    }
                    $this->setModelInSession($paymentMethodEditForm, 'paymentMethodEditForm');
                    $this->processOrderCreation();
                    return $this->redirect(UsniAdaptor::createUrl('cart/checkout/review-order'));
                }
            }
            $breadcrumbView = new Breadcrumb(['page' => UsniAdaptor::t('cart', 'Checkout')]);
            $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
            $this->getView()->title                 = UsniAdaptor::t('cart', 'Checkout');
            $checkoutView   = new CheckoutView(['billingInfoEditForm' => $billingInfoEditForm,
                                                'deliveryInfoEditForm'=> $deliveryInfoEditForm,
                                                'deliveryOptionsEditForm' => $deliveryOptionsEditForm,
                                                'paymentMethodEditForm' => $paymentMethodEditForm]);
            $content        = $this->renderInnerContent([$checkoutView]);
            return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
        }
    }
    
    /**
     * Sets model in session and forward request
     * @param Model $model
     * @param string $checkoutViewModelForm
     */
    protected function setModelInSession($model, $checkoutViewModelForm)
    {
        $checkout = ApplicationUtil::getCheckout();
        $checkout->$checkoutViewModelForm = $model;
        $checkout->updateSession();
    }
    
    /**
     * Review order
     * @return string
     */
    public function actionReviewOrder()
    {
        $cart = ApplicationUtil::getCart();
        if($cart->shouldProceedForCheckout() === false)
        {
            FlashUtil::setMessage('outOfStockCheckoutNowAllowed', UsniAdaptor::t('cartflash', "Either products in the cart are not in stock or out of stock checkout is not allowed. Please contact system admin."));
            return $this->redirect(UsniAdaptor::createUrl('cart/default/view'));
        }
        $model          = new ConfirmOrderForm();
        $breadcrumbView = new Breadcrumb(['page' => UsniAdaptor::t('cart', 'Review Order')]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $this->getView()->title                 = UsniAdaptor::t('cart', 'Review Order');
        $checkoutView   = new ReviewOrderView(['model' => $model]);
        $content        = $this->renderInnerContent([$checkoutView]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
    
    /**
     * Process order creation
     * @return Order
     */
    protected function processOrderCreation()
    {
        $checkout = ApplicationUtil::getCheckout();
        $store    = UsniAdaptor::app()->storeManager->getCurrentStore();
        $order    = $checkout->order;
        $order->store_id    = $store->id;
        $order->interface   = 'front';
        $paymentMethod   = $checkout->paymentMethodEditForm->payment_method;
        $shippingMethod  = $checkout->deliveryOptionsEditForm->shipping;
        if($shippingMethod != null)
        {
            if($checkout->deliveryOptionsEditForm->shipping_fee == null)
            {
                $checkout->deliveryOptionsEditForm->shipping_fee = ShippingUtil::getCalculatedPriceByType($shippingMethod, ApplicationUtil::getCart());
            }
        }
        $checkout->updateSession();
        $paymentFactoryClassName = $this->getPaymentFactoryClassName();
        $paymentFactory     = new $paymentFactoryClassName([  'type' => $paymentMethod,
                                                    'order' => $order, 
                                                    'checkoutDetails' => ApplicationUtil::getCheckout(),
                                                    'cartDetails'     => ApplicationUtil::getCart(),
                                                    'customerId'      => ApplicationUtil::getCustomerId()]);
        $instance           = $paymentFactory->getInstance();
        $instance->processPurchase();
        $this->setModelInSession($order, 'order');
    }


    /**
     * Complete order
     * @param string $orderId
     * @return string
     */
    public function actionCompleteOrder()
    {
        $checkout      = ApplicationUtil::getCheckout();
        $order         = $checkout->order;
        if(empty($order) || $order->isNewRecord)
        {
            return $this->goHome();
        }
        $paymentFactoryClassName = $this->getPaymentFactoryClassName();
        $paymentFactory     = new $paymentFactoryClassName([  'type' => $checkout->paymentMethodEditForm->payment_method,
                                                              'order' => $order]);
        $instance           = $paymentFactory->getInstance();
        $instance->processConfirm();
        $breadcrumbLinks = [
                                [
                                    'label' => UsniAdaptor::t('cart', 'Shopping Cart'),
                                    'url'   => UsniAdaptor::createUrl('cart/default/view')
                                ],
                                [
                                    'label' => UsniAdaptor::t('cart', 'Checkout'),
                                    'url'   => UsniAdaptor::createUrl('cart/checkout/index')
                                ],
                                [
                                    'label' => UsniAdaptor::t('cart', 'Completed Order')
                                ]
                            ];
        $this->getView()->params['breadcrumbs'] = $breadcrumbLinks;
        $this->getView()->title                 = UsniAdaptor::t('cart', 'Checkout');
        $viewHelper    = UsniAdaptor::app()->getModule('cart')->viewHelper;
        $completeView  = $viewHelper->getInstance('completeOrderView', ['order' => $order]);
        //Reinstantiate the components
        if(UsniAdaptor::app()->user->isGuest)
        {
            UsniAdaptor::app()->guest->updateSession('cart', new Cart());
        }
        else
        {
            UsniAdaptor::app()->customer->updateSession('cart', new Cart());
        }
        $checkout->deliveryOptionsEditForm  = new DeliveryOptionsEditForm();
        $checkout->paymentMethodEditForm    = new PaymentMethodEditForm();
        $checkout->order                    = new Order();
        $checkout->updateSession();
        $content       = $this->renderInnerContent([$completeView]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
    
    /**
     * @inheritdoc
     */
    protected function getPaymentFactoryClassName()
    {
        return PaymentFactory::className();
    }
    
    /**
     * Check and redirect if cart empty
     * @return void
     */
    protected function checkAndRedirectIfCartEmpty()
    {
        $isEmpty = ApplicationUtil::isCartEmpty();
        if($isEmpty)
        {
            return $this->redirect(UsniAdaptor::createUrl('cart/default/view'));
        }
    }
}