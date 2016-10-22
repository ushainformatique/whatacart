<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\UsniAdaptor;
use cart\utils\CartUtil;
use cart\views\BillingEditView;
use usni\library\modules\users\models\Address;
use cart\views\DeliveryEditView;
use cart\views\DeliveryOptionsEditView;
use common\utils\ApplicationUtil;
/**
 * AdminCheckoutView class file.
 * 
 * @package cart\views
 */
class AdminCheckoutView extends \usni\library\extensions\bootstrap\views\UiBootstrapEditView
{
    /**
     * Form for the view
     * @var ActiveForm 
     */
    public $form;
    
    /**
     * Model containing billing info
     * @var Model 
     */
    public $billingInfoEditForm;
    
    /**
     * Model containing delivery info
     * @var Model 
     */
    public $deliveryInfoEditForm;
    
    /**
     * Model containing delivery options
     * @var Model 
     */
    public $deliveryOptionsEditForm;
    
    /**
     * Model containing payment options
     * @var Model 
     */
    public $paymentMethodEditForm;
    
    /**
     * Get view file
     * @return string
     */
    public function resolveFormViewPath()
    {
        return '@cart/views/checkout';
    }
    
    /**
     * Renders billing view
     * @return string
     */
    protected function renderBillingView()
    {
        $billingInfoEditForm    = $this->billingInfoEditForm;
        //This would just check if data is there in session or not
        if($billingInfoEditForm->firstname == null)
        {
            CartUtil::populateCustomerInfoInFormModel($billingInfoEditForm, Address::TYPE_BILLING_ADDRESS, $this->getCustomerId());
        }
        //BillingInfoEditForm should be submodel/relation of customer
        $billingView            = new BillingEditView(['model' => $billingInfoEditForm, 
                                                       'form' => $this->form
                                                      ]);
        return $billingView->render();
    }
    
    /**
     * Renders delivery view
     * @return string
     */
    protected function renderDeliveryView()
    {
        $deliveryInfoEditForm    = $this->deliveryInfoEditForm;
        //This would just check if data is there in session or not
        if($deliveryInfoEditForm->firstname == null)
        {
            CartUtil::populateCustomerInfoInFormModel($deliveryInfoEditForm, Address::TYPE_SHIPPING_ADDRESS, $this->getCustomerId());
        }
        $deliveryView            = new DeliveryEditView(['model' => $deliveryInfoEditForm, 
                                                         'form' => $this->form,
                                                         'source' => $this->getSource()
                                                        ]);
        return $deliveryView->render();
    }
    
    /**
     * Renders shipping options view
     * @return string
     */
    protected function renderShippingView()
    {
        $deliveryOptionsEditForm    = $this->deliveryOptionsEditForm;
        $deliveryView            = new DeliveryOptionsEditView(['model' => $deliveryOptionsEditForm, 
                                                                'form' => $this->form,
                                                                'source' => $this->getSource()
                                                               ]);
        return $deliveryView->render();
    }
    
    /**
     * Renders payment options view
     * @return string
     */
    protected function renderPaymentView()
    {
        $paymentMethodEditForm  = $this->paymentMethodEditForm;
        $viewHelper             = UsniAdaptor::app()->getModule('cart')->viewHelper;
        $paymentView            = $viewHelper->getInstance('paymentMethodEditView', ['model' => $paymentMethodEditForm, 
                                                             'form' => $this->form, 
                                                             'source' => $this->getSource()]);
        return $paymentView->render();
    }
        
    /**
     * Source into which page is loaded
     * @return string
     */
    protected function getSource()
    {
        return 'admin';
    }
    
    /**
     * @inheritdoc
     */
    public static function getFormId()
    {
        return 'admin-checkout-form';
    }
    
    /**
     * Get customer id.
     * @return integer
     */
    protected function getCustomerId()
    {
        return UsniAdaptor::app()->customer->customerId;
    }
        
    /**
     * @inheritdoc
     */
    protected function getDefaultAttributeOptions()
    {
        $options = parent::getDefaultAttributeOptions();
        $options['labelOptions'] = ['class' => 'control-label'];
        return $options;
    }
    
    /**
     * @inheritdoc
     */
    public function resolveOutputData()
    {
        /*
         * Executing the form begin widget so that form object is created and
         * could be passed to the subviews.
         * @see usni\library\modules\users\views\ProfileEditView::renderSubView
         */
        $begin    = $this->renderBegin();
        $billingContent     = $this->renderBillingView();
        $cart               = ApplicationUtil::getCart();
        if($cart->isShippingRequired())
        {
            $deliveryContent    = $this->renderDeliveryView();
            $shippingContent    = $this->renderShippingView();
        }
        else
        {
            $deliveryContent    = null;
            $shippingContent    = null;
        }
        $paymentContent     = $this->renderPaymentView();
        return array(
            'begin'       => $begin,
			'billingContent' => $billingContent,
            'deliveryContent' => $deliveryContent,
            'shippingContent' => $shippingContent,
            'paymentContent'  => $paymentContent,
            'end'         => $this->renderEnd()
		);
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('order', 'Checkout');
    }
    
    /**
     * @inheritdoc
     */
    public static function getFormLayout()
    {
        return 'default';
    }
}