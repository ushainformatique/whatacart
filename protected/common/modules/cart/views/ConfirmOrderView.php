<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\UsniAdaptor;
use usni\library\components\UiActiveForm;
use usni\library\utils\ButtonsUtil;
use common\modules\shipping\utils\ShippingUtil;
use common\utils\ApplicationUtil;
use common\modules\payment\utils\PaymentUtil;
/**
 * ConfirmOrderView class file.
 * 
 * @package cart\views
 */
class ConfirmOrderView extends \frontend\views\FrontEditView
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $file = UsniAdaptor::getAlias($this->resolveFormViewPath()) . '.php';
        return $this->getView()->renderPhpFile($file, $this->resolveOutputData());
    }
    
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = array(
                    '<div class="row">',
                    $this->getBillingAddress(),
                    $this->getShippingAddress(),
                    $this->getShippingMethod(),
                    $this->getPaymentMethod(),
                    '</div>',
                    '<br/>',
                    'content'   => array('type' => UiActiveForm::INPUT_RAW, 'value' => $this->getCartContent()),
                    $this->getFormVariables()
        );
        $metadata = array(
            'elements'    => $elements,
            'buttons'     => $this->getButtons()
        );
        return $metadata;
    }
    
    /**
     * Get billing address
     * @return string
     */
    protected function getBillingAddress()
    {
        $billingInfoEditForm    = ApplicationUtil::getCheckoutFormModel('billingInfoEditForm');
        $content                = '<div class="col-sm-3"><legend>' . UsniAdaptor::t('customer', 'Billing Address') . 
                                            '</legend>' . $billingInfoEditForm->getConcatenatedAddress() . '</div>';
        return $content;
    }
    
    /**
     * Get shipping address
     * @return string
     */
    protected function getShippingAddress()
    {
        $content    = null;
        $cart       = ApplicationUtil::getCart();
        if($cart->isShippingRequired())
        {
            $deliveryInfoEditForm    = ApplicationUtil::getCheckoutFormModel('deliveryInfoEditForm');
            $content                = '<div class="col-sm-3"><legend>' . UsniAdaptor::t('customer', 'Shipping Address') . 
                                                '</legend>' . $deliveryInfoEditForm->getConcatenatedAddress() . '</div>';
        }
        return $content;
    }
    
    /**
     * Get shipping method
     * @return string
     */
    protected function getShippingMethod()
    {
        $content    = null;
        $cart       = ApplicationUtil::getCart();
        if($cart->isShippingRequired())
        {
            $deliveryOptionsEditForm    = ApplicationUtil::getCheckoutFormModel('deliveryOptionsEditForm');
            $shippingName               = ShippingUtil::getShippingMethodName($deliveryOptionsEditForm->shipping);
            $content                    = '<div class="col-sm-3"><legend>' . UsniAdaptor::t('shipping', 'Shipping Method') . 
                                                '</legend>' . $shippingName . '</div>';
        }
        return $content;
    }
    
    /**
     * Get payment method
     * @return string
     */
    protected function getPaymentMethod()
    {
        $paymentMethodEditForm      = ApplicationUtil::getCheckoutFormModel('paymentMethodEditForm');
        $paymentName                = PaymentUtil::getPaymentMethodName($paymentMethodEditForm->payment_method);
        $content                    = '<div class="col-sm-3"><legend>' . UsniAdaptor::t('payment', 'Payment Method') . 
                                            '</legend>' . $paymentName . '</div>';
        return $content;
    }

    /**
     * @inheritdoc
     */
    protected function getCartContent()
    {
        $viewHelper    = UsniAdaptor::app()->getModule('cart')->viewHelper;
        $cartSubView   = $viewHelper->getInstance('confirmCartSubView');
        return '<div class="row"><div class="col-sm-12">' . $cartSubView->render() . '</div></div>';
    }
    
    /**
     * @inheritdoc
     */
    public static function getAction()
    {
        return UsniAdaptor::createUrl('/cart/checkout/complete-order');
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('cart', 'Confirm Order');
    }
    
    /**
     * Get form variables
     * return string
     */
    protected function getFormVariables()
    {
        return null;
    }
    
    /**
     * Get buttons
     * @return array
     */
    protected function getButtons()
    {
        $buttons = [];
        if($this->getSubmitButton() != null)
        {
            $buttons['confirm'] = $this->getSubmitButton();
        }
        $buttons['previous']    = array(
                                          'type'  => 'link',
                                          'label' => UsniAdaptor::t('cart', 'Back'),
                                          'url'   => UsniAdaptor::createUrl('cart/checkout/index')
                                      );
        $buttons['cart']        =  array(
                                          'type'  => 'link',
                                          'label' => UsniAdaptor::t('cart', 'Edit Cart'),
                                          'url'   => UsniAdaptor::createUrl('cart/default/view')
                                      );
        return $buttons;
    }
    
    /**
     * Get submit button
     * @return string
     */
    protected function getSubmitButton()
    {
        return ButtonsUtil::getSubmitButton(UsniAdaptor::t('cart','Confirm Order'), 'confirm-order-btn');
    }
}