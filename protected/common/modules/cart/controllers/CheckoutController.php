<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use cart\models\Cart;
use common\utils\ApplicationUtil;
use usni\library\utils\FlashUtil;
use cart\business\CheckoutManager;
use cart\dto\CheckoutDTO;
use cart\dto\ReviewDTO;
use common\modules\payment\components\PaymentFactory;
/**
 * CheckoutController class file
 *
 * @package cart\controllers
 */
class CheckoutController extends BaseController
{
    /**
     * @var CheckoutManager 
     */
    public $checkoutManager;
    
    /**
     * inheritdoc
     */
    public function beforeAction($action)
    {
        if(parent::beforeAction($action))
        {
            $this->checkoutManager  = CheckoutManager::getInstance(['paymentFactoryClassName' => PaymentFactory::className()]);
            return true;
        }
        return false;
    }
    
    /**
     * Index action for checkout
     * @return string
     */
    public function actionIndex()
    {
        $this->checkAndRedirectIfCartEmpty();
        $guestCheckoutSetting       = UsniAdaptor::app()->storeManager->getSettingValue('guest_checkout');
        if(!$guestCheckoutSetting && UsniAdaptor::app()->user->isGuest === true)
        {
            return $this->redirect(UsniAdaptor::createUrl('customer/site/login'));
        }
        else
        {
            $cart = ApplicationUtil::getCart();
            if($cart->shouldProceedForCheckout() === false)
            {
                FlashUtil::setMessage('warning', UsniAdaptor::t('cartflash', "Either products in the cart are not in stock or out of stock checkout is not allowed. Please contact system admin."));
                return $this->redirect(UsniAdaptor::createUrl('cart/default/view'));
            }
            $checkoutDTO    = new CheckoutDTO();
            $checkoutDTO->setCustomerId(ApplicationUtil::getCustomerId());
            $checkoutDTO->setPostData($_POST);
            $checkoutDTO->setCheckout(ApplicationUtil::getCheckout());
            $checkoutDTO->setCart(ApplicationUtil::getCart());
            $checkoutDTO->setInterface('front');
            $this->checkoutManager->processCheckout($checkoutDTO);
            if($checkoutDTO->getResult() === true)
            {
                $checkoutDTO->getCheckout()->updateSession();
                return $this->redirect(UsniAdaptor::createUrl('cart/checkout/review-order'));
            }
            return $this->render('/checkout', ['formDTO' => $checkoutDTO]);
        }
    }
    
    /**
     * Review order
     * @return string
     */
    public function actionReviewOrder()
    {
        $cart       = ApplicationUtil::getCart();
        $checkout   = ApplicationUtil::getCheckout();
        if($cart->itemsList->count() == 0)
        {
            return $this->goHome();
        }
        //Each time on review order screen check if currency is changed then redirect to home page.
        $selectedCurrency = UsniAdaptor::app()->currencyManager->selectedCurrency;
        if($selectedCurrency != $checkout->order->currency_code)
        {
            return $this->goHome();
        }
        if($cart->shouldProceedForCheckout() === false)
        {
            FlashUtil::setMessage('warning', UsniAdaptor::t('cartflash', "Either products in the cart are not in stock or out of stock checkout is not allowed. Please contact system admin."));
            return $this->redirect(UsniAdaptor::createUrl('cart/default/view'));
        }
        $reviewDTO      = new ReviewDTO();
        $this->checkoutManager->populateReviewDTO($reviewDTO, $checkout, $cart);
        //If new items are added to cart, shipping cost would be updated see issue https://github.com/ushainformatique/whatacart/issues/27
        $checkout->updateSession();
        $type           = ApplicationUtil::getCheckout()->paymentMethodEditForm->payment_method;
        $confirmRoute   = "payment/$type/confirm";
        $formContent    = UsniAdaptor::app()->runAction($confirmRoute);
        $reviewDTO->setPaymentFormContent($formContent);
        return $this->render('/revieworder', ['reviewDTO' => $reviewDTO]);
    }
    
    /**
     * Complete order
     * @return string
     */
    public function actionCompleteOrder()
    {
        $checkout       = ApplicationUtil::getCheckout();
        $order          = $checkout->order;
        if(empty($order) || $order->isNewRecord)
        {
            return $this->goHome();
        }
        $checkoutDTO    = new CheckoutDTO();
        $checkoutDTO->setCheckout(ApplicationUtil::getCheckout());
        $checkoutDTO->setCart(ApplicationUtil::getCart());
        $checkoutDTO->setCustomerId(ApplicationUtil::getCustomerId());
        $checkoutDTO->setInterface('front');
        $this->checkoutManager->processComplete($checkoutDTO);
        //Reinstantiate the components
        if(UsniAdaptor::app()->user->isGuest)
        {
            UsniAdaptor::app()->guest->updateSession('cart', new Cart());
        }
        else
        {
            UsniAdaptor::app()->customer->updateSession('cart', new Cart());
        }
        $checkoutDTO->getCheckout()->updateSession();
        return $this->render('/completeorder', ['order' => $order]);
    }
    
    /**
     * Check and redirect if cart empty
     * @return void
     */
    protected function checkAndRedirectIfCartEmpty()
    {
        $cart = ApplicationUtil::getCart();
        if($cart->itemsList->count() == 0)
        {
            return $this->redirect(UsniAdaptor::createUrl('cart/default/view'));
        }
    }
}