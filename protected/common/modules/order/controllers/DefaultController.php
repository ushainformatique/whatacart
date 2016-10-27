<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\controllers;

use common\modules\order\models\Order;
use usni\library\components\UiAdminController;
use common\modules\order\utils\OrderUtil;
use common\modules\order\views\OrderEditView;
use usni\UsniAdaptor;
use products\models\Product;
use usni\library\components\UiHtml;
use yii\helpers\Json;
use common\modules\order\models\CustomerForm;
use cart\utils\CartUtil;
use common\modules\order\models\AdminConfirmOrderEditForm;
use cart\models\AdminCart;
use common\modules\order\models\AdminCheckout;
use common\modules\payment\components\AdminPaymentFactory;
use products\views\DynamicOptionsEditView;
use common\utils\ApplicationUtil;
use cart\views\AdminCartSubView;
use common\modules\shipping\utils\ShippingUtil;
use usni\library\utils\PermissionUtil;
use common\modules\order\views\OrderDetailView;
use common\modules\order\views\OrderProductEditView;
use products\utils\ProductUtil;
use yii\base\Model;
use cart\views\AdminCheckoutView;
use common\modules\order\views\AdminConfirmOrderView;
use usni\library\utils\FlashUtil;
use common\modules\stores\utils\StoreUtil;
use customer\models\Customer;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\order\controllers
 */
class DefaultController extends UiAdminController
{    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Order::className();
    }
    
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $checkout           = ApplicationUtil::getCheckout();
        //Scenario in which we go for update and than again from manage do create. Thus order id should be -1 in session else previous link wont work.
        $order      = new Order();
        $this->setModelInSession($order, 'order');
        $model              = ApplicationUtil::getCheckoutFormModel('customerForm');
        $model->scenario    = 'create';
        $this->setBreadCrumbs($model);
        $postData           = UsniAdaptor::app()->request->post();
        if($model->load($postData))
        {
            UsniAdaptor::app()->currencyManager->setCookie($model->currencyCode);
            UsniAdaptor::app()->customer->updateSession('customerId', $model->customerId);
            $this->setModelInSession($model, 'customerForm');
            return $this->redirect(UsniAdaptor::createUrl('order/default/add-to-cart'));
        }
        $view               = new OrderEditView($model);
        $content            = $this->renderColumnContent([$view]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }
    
    /**
     * Check for guest checkout condition
     * @return string
     */
    protected function checkGuestCheckout()
    {
        $checkout               = ApplicationUtil::getCheckout();
        $storeId                = $checkout->customerForm->storeId;
        $customerId             = $checkout->customerForm->customerId;
        $guestCheckoutSetting   = StoreUtil::getSettingValue('guest_checkout', $storeId);
        if(!$guestCheckoutSetting && $customerId == Customer::GUEST_CUSTOMER_ID)
        {
            FlashUtil::setMessage('guestCheckoutNowAllowed', UsniAdaptor::t('cartflash', "The guest checkout is not allowed for the selected store."));
            if($checkout->order->id == null)
            {
                return $this->redirect(UsniAdaptor::createUrl('order/default/create'));
            }
            else
            {
                return $this->redirect(UsniAdaptor::createUrl('order/default/update', ['id' => $checkout->order->id]));
            }
        }
    }


    /**
     * Add items to cart
     * @return string
     */
    public function actionAddToCart()
    {
        $this->checkGuestCheckout();
        $checkout   = ApplicationUtil::getCheckout();
        $model      = $checkout->orderProductForm;
        $this->getView()->params['breadcrumbs']  = [
                        [
                            'label' => UsniAdaptor::t('application', 'Manage') . ' ' . Order::getLabel(2),
                            'url'   => UsniAdaptor::createUrl('order/default/manage')
                        ],
                        [
                            'label' => UsniAdaptor::t('cart', 'Add to Cart')
                        ]
                    ];
        $postData           = UsniAdaptor::app()->request->post();
        if($model->load($postData))
        {
            $cart           = UsniAdaptor::app()->customer->cart;
            if($cart->getCount() > 0)
            {
                return $this->redirect(UsniAdaptor::createUrl('order/default/checkout'));
            }
            else
            {
                FlashUtil::setMessage('needMinProducts', UsniAdaptor::t('cartflash', "There should be atleast one item in the cart before you proceed for checkout."));
            }
        }
        $view               = new OrderProductEditView(['model' => $model, 'order' => $checkout->order]);
        $content            = $this->renderColumnContent([$view]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }
    
    /**
     * Checkout action for the order
     * @return string
     */
    public function actionCheckout()
    {
        $this->checkGuestCheckout();
        $cart = ApplicationUtil::getCart();
        if($cart->shouldProceedForCheckout() === false)
        {
            FlashUtil::setMessage('outOfStockCheckoutNowAllowed', UsniAdaptor::t('cartflash', "Either products in the cart are not in stock or out of stock checkout is not allowed. Please contact system admin."));
            return $this->redirect(UsniAdaptor::createUrl('order/default/add-to-cart'));
        }
        $billingInfoEditForm        = ApplicationUtil::getCheckoutFormModel('billingInfoEditForm');
        $deliveryInfoEditForm       = ApplicationUtil::getCheckoutFormModel('deliveryInfoEditForm');
        $deliveryOptionsEditForm    = ApplicationUtil::getCheckoutFormModel('deliveryOptionsEditForm');
        $paymentMethodEditForm      = ApplicationUtil::getCheckoutFormModel('paymentMethodEditForm');
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
                return $this->redirect(UsniAdaptor::createUrl('order/default/confirm-order'));
            }
        }
        $this->getView()->params['breadcrumbs']  = [
                        [
                            'label' => UsniAdaptor::t('application', 'Manage') . ' ' . Order::getLabel(2),
                            'url'   => UsniAdaptor::createUrl('order/default/manage')
                        ],
                        [
                            'label' => UsniAdaptor::t('order', 'Checkout')
                        ]
                    ];
        $checkoutView   = new AdminCheckoutView(['billingInfoEditForm' => $billingInfoEditForm,
                                                'deliveryInfoEditForm'=> $deliveryInfoEditForm,
                                                'deliveryOptionsEditForm' => $deliveryOptionsEditForm,
                                                'paymentMethodEditForm' => $paymentMethodEditForm]);
        $content            = $this->renderColumnContent([$checkoutView]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }
    
    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $order  = Order::findOne($id);
        if(empty($order))
        {
            return $this->redirect(UsniAdaptor::createUrl('order/default/manage'));
        }
        if(OrderUtil::checkIfOrderAllowedToPerformAction($id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        $orderStatus    = OrderStatusUtil::getStatusId(Order::STATUS_COMPLETED);
        if($order->status == $orderStatus)
        {
            return $this->redirect(UsniAdaptor::createUrl('order/default/manage'));
        }
        $user           = UsniAdaptor::app()->user->getUserModel();
        $isPermissible  = PermissionUtil::doesUserHavePermissionToPerformAction($order, $user, 'order.updateother');
        if(!$isPermissible)
        {
            throw new \yii\web\ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        $postData           = UsniAdaptor::app()->request->post();
        $model              = new CustomerForm(['scenario' => 'update']);
        if($model->load($postData))
        {
            UsniAdaptor::app()->currencyManager->setCookie($model->currencyCode);
            $cart       = ApplicationUtil::getCart();
            OrderUtil::prepareAndAddCartItems($order, $cart);
            UsniAdaptor::app()->customer->updateSession('customerId', $model->customerId);
            $this->setModelInSession($model, 'customerForm');
            return $this->redirect(UsniAdaptor::createUrl('order/default/add-to-cart'));
        }
        
        UsniAdaptor::app()->customer->updateSession('customerId', $order->customer_id);
        UsniAdaptor::app()->customer->checkout = new AdminCheckout();
        UsniAdaptor::app()->customer->cart = new AdminCart();
        
        $model->customerId = $order->customer_id;
        $model->storeId = $order->store_id;
        $model->currencyCode = $order->currency_code;
        $this->setModelInSession($model, 'customerForm');
        
        //Get checkout
        $checkout   = ApplicationUtil::getCheckout();
        $checkout->billingInfoEditForm->attributes = $order->billingAddress->attributes;
        if(!empty($order->shippingAddress))
        {
            $checkout->deliveryInfoEditForm->attributes = $order->shippingAddress->attributes;
        }
        //Delivery options
        $checkout->deliveryOptionsEditForm->shipping = $order->shipping;
        $checkout->deliveryOptionsEditForm->comments = $order->shipping_comments;
        $checkout->deliveryOptionsEditForm->shipping_fee = $order->shipping_fee;
        //Payment options
        $checkout->paymentMethodEditForm->payment_method = $order->orderPaymentDetails->payment_method;
        $checkout->paymentMethodEditForm->comments       = $order->orderPaymentDetails->comments;
        //Update session order
        $checkout->order = $order;
        $checkout->updateSession();
        $this->setBreadCrumbs($model);
        $view               = new OrderEditView(['model' => $model]);
        $content            = $this->renderColumnContent([$view]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }
    
    /**
     * Render product option form.
     * @return string.
     */
    public function actionRenderOptionForm()
    {
        $product        = Product::find()->where('id = :id', [':id' => $_GET['productId']])->asArray()->one();
        $fieldOptions   = [
                            'inputOptions'  => ['class' => 'form-control'],
                            'labelOptions'  => ['class' => 'control-label col-xs-2'],
                            'inputContainerOptions' => ['class' => 'input-group'],
                            'fieldContainerOptions' => ['class' => 'form-group'],
                            'checkboxContainerOptions' => ['class' => 'checkbox checkbox-admin']
                          ];
        $optionsEditView    = new DynamicOptionsEditView(['product' => $product, 'fieldOptions' => $fieldOptions]);
        $options            = $optionsEditView->render();
        $title      = null;
        if($options != null)
        {
            $title      = UiHtml::tag('h4', UsniAdaptor::t('products', 'Available Option(s)'));
        }
        echo $title . $options;
    }
    
    /**
     * Add product to admin cart
     * @return string json result
     */
    public function actionAddProduct()
    {
        $postData       = $_POST['OrderProductForm'];
        $product        = ProductUtil::getProduct($postData['product_id']);
        $cart           = UsniAdaptor::app()->customer->cart;
        $inputOptions   = [];
        if(isset($_POST['ProductOptionMapping']['option']))
        {
            $inputOptions = $_POST['ProductOptionMapping']['option'];
        }
        $result = CartUtil::processAddToCartItem($cart, $product, $postData['quantity'], $inputOptions);
        if($result['success'] === true)
        {
            $cartSubView    = new AdminCartSubView();
            $result['data'] = $cartSubView->render();
        }
        echo Json::encode($result);
    }
    
    /**
     * Remove item from cart.
     * @return string
     */
    public function actionRemove()
    {
        if(UsniAdaptor::app()->request->getIsAjax())
        {
            $cart   = UsniAdaptor::app()->customer->cart;
            $cart->removeItem($_POST['item_code']);
            $cartSubView    = new AdminCartSubView();
            $data           = $cartSubView->render();
            return Json::encode(['data' => $data]);
        }
        return Json::encode([]);
    }
        
    /**
     * Confirm order
     * @return string
     */
    public function actionConfirmOrder()
    {
        $this->checkGuestCheckout();
        $cart = ApplicationUtil::getCart();
        if($cart->shouldProceedForCheckout() === false)
        {
            FlashUtil::setMessage('outOfStockCheckoutNowAllowed', UsniAdaptor::t('cartflash', "Either products in the cart are not in stock or out of stock checkout is not allowed. Please contact system admin."));
            return $this->redirect(UsniAdaptor::createUrl('order/default/add-to-cart'));
        }
        $checkout   = ApplicationUtil::getCheckout();
        $model      = new AdminConfirmOrderEditForm();
        if(isset($_POST['AdminConfirmOrderEditForm']))
        {
            $model->attributes = $_POST['AdminConfirmOrderEditForm'];
            if($model->validate())
            {
                //Set the store id in order
                $checkout->order->store_id  = $checkout->customerForm->storeId;
                $checkout->order->interface = 'admin';
                $paymentMethod      = $checkout->paymentMethodEditForm->payment_method;
                $shippingMethod     = $checkout->deliveryOptionsEditForm->shipping;
                if($shippingMethod != null)
                {
                    $checkout->deliveryOptionsEditForm->shipping_fee = ShippingUtil::getCalculatedPriceByType($shippingMethod, UsniAdaptor::app()->customer->cart);
                }
                $checkout->confirmOrderEditForm = $model;
                $checkout->updateSession();
                $paymentFactoryClassName = $this->getPaymentFactoryClassName();
                $paymentFactory     = new $paymentFactoryClassName([  'type' => $paymentMethod,
                                                            'order' => $checkout->order, 
                                                            'checkoutDetails' => UsniAdaptor::app()->customer->checkout,
                                                            'cartDetails'     => UsniAdaptor::app()->customer->cart,
                                                            'customerId'      => UsniAdaptor::app()->customer->customerId]);
                $instance           = $paymentFactory->getInstance();
                if($instance->processPurchase())
                {
                    //Reinstantiate the components
                    UsniAdaptor::app()->customer->updateSession('cart', new AdminCart());
                    UsniAdaptor::app()->customer->updateSession('checkout', new AdminCheckout());
                    return $this->redirect(UsniAdaptor::createUrl('order/default/manage'));
                }
            }
        }
        $this->getView()->params['breadcrumbs']  = [
                                                        [
                                                            'label' => UsniAdaptor::t('application', 'Manage') . ' ' . Order::getLabel(2),
                                                            'url'   => UsniAdaptor::createUrl('order/default/manage')
                                                        ],
                                                        [
                                                            'label' => UsniAdaptor::t('order', 'Confirm Order')
                                                        ]
                                                    ];
        $model->status      = $checkout->order->status;
        $view               = new AdminConfirmOrderView($model);
        $content            = $this->renderColumnContent([$view]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }
    
    /**
     * Sets model in session and forward request
     * @param Model $model
     * @param string $checkoutViewModelForm
     */
    protected function setModelInSession($model, $checkoutViewModelForm)
    {
        $checkout = UsniAdaptor::app()->customer->checkout;
        $checkout->$checkoutViewModelForm = $model;
        $checkout->updateSession();
    }
    
    /**
     * Get payment factory class name
     * @return string
     */
    protected function getPaymentFactoryClassName()
    {
        return AdminPaymentFactory::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveGridViewClassName($model)
    {
        $viewHelper = UsniAdaptor::app()->getModule('order')->viewHelper;
        return $viewHelper->orderGridView;
    }
    
    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        if(OrderUtil::checkIfOrderAllowedToPerformAction($id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        $order              = OrderUtil::getOrder($id);
        $user               = UsniAdaptor::app()->user->getUserModel();
        $isPermissible      = PermissionUtil::doesUserHavePermissionToPerformAction($order, $user, 'order.viewother');
        if(!$isPermissible)
        {
            throw new \yii\web\ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        else
        {
            $detailView     = new OrderDetailView(['model' => $order, 'controller' => $this]);
        }
        if(UsniAdaptor::getRequest()->getIsAjax())
        {
            $content  = $detailView->render();
            return $this->renderAjax('@usni/themes/bootstrap/views/layouts/ajaxview', ['content' => $content]);
        }
        else
        {
            $this->getView()->params['breadcrumbs'] = $this->getDetailViewBreadcrumb(new Order());
            $content  = $this->renderColumnContent($detailView->render());
            return $this->render($this->getDefaultLayout(), ['content' => $content]);
        }
    }
    
    /**
     * Add order history.
     * @return void
     */
    public function actionAddOrderHistory()
    {
        if(isset($_POST['OrderHistory']))
        {
            $table      = UsniAdaptor::tablePrefix() . 'order';
            $data       = ['status' => $_POST['OrderHistory']['status'], 
                           'modified_by' => UsniAdaptor::app()->user->getUserModel()->id,
                           'modified_datetime' => UsniAdaptor::getNow()
                          ];
            $result     = UsniAdaptor::app()->db->createCommand()->update($table, $data, 'id = :id', [':id' => $_POST['OrderHistory']['order_id']])->execute();
            if($result != false)
            {
                $postData   = UsniAdaptor::app()->request->post();
                $order      = OrderUtil::getOrder($_POST['OrderHistory']['order_id']);
                OrderUtil::addOrderHistory($order, $postData['OrderHistory'], true);
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . Order::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . Order::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . Order::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Order::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getActionToPermissionsMap()
    {
        $permissionsMap                         = parent::getActionToPermissionsMap();
        $permissionsMap['add-to-cart']          = 'order.manage';
        $permissionsMap['add-product']          = 'order.manage';
        $permissionsMap['render-option-form']   = 'order.manage';
        $permissionsMap['checkout']             = 'order.manage';
        $permissionsMap['checkout']             = 'order.manage';
        $permissionsMap['confirm-order']        = 'order.manage';
        return $permissionsMap;
    }
    
    /**
     * @inheritdoc
     */
    public function actionDelete($id)
    {
        if(OrderUtil::checkIfOrderAllowedToPerformAction($id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        return parent::actionDelete($id);
    }
}
?>