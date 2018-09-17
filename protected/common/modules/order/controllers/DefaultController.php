<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\controllers;

use common\modules\order\models\Order;
use usni\UsniAdaptor;
use usni\library\utils\Html;
use yii\helpers\Json;
use common\modules\order\models\AdminConfirmOrderEditForm;
use cart\models\AdminCart;
use products\widgets\AdminDynamicOptionsEditView;
use common\utils\ApplicationUtil;
use common\modules\order\widgets\AdminCartSubView;
use usni\library\utils\FlashUtil;
use customer\models\Customer;
use cart\business\Manager as CartManager;
use common\modules\order\dto\AdminCheckoutDTO;
use common\modules\order\business\Manager as OrderBusinessManager;
use usni\library\utils\ArrayUtil;
use products\dao\ProductDAO;
use cart\dto\CartDTO;
use common\modules\order\business\AdminCheckoutManager;
use cart\dto\ReviewDTO;
use yii\filters\AccessControl;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\BulkEditAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\ViewAction;
use common\modules\order\dto\GridViewDTO;
use common\modules\order\dto\DetailViewDTO;
use common\modules\payment\components\AdminPaymentFactory;
use products\dao\OptionDAO;
use common\modules\order\models\CustomerForm;
/**
 * DefaultController class file
 * 
 * @package common\modules\order\controllers
 */
class DefaultController extends \usni\library\web\Controller
{   
    /**
     * @var OrderBusinessManager 
     */
    public $orderManager;
    
    /**
     * @var AdminCheckoutManager 
     */
    public $checkoutManager;
    
    /**
     * inheritdoc
     */
    public function beforeAction($action)
    {
        if(parent::beforeAction($action))
        {
            $this->orderManager = OrderBusinessManager::getInstance();
            $this->checkoutManager = AdminCheckoutManager::getInstance(['paymentFactoryClassName' => AdminPaymentFactory::className()]);
            return true;
        }
        return false;
    }
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['order.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'add-order-history'],
                        'roles' => ['order.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['order.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add-to-cart', 'add-product', 'review-order', 'complete-order', 'checkout', 'remove', 
                                      'render-option-form', 'checkout'],
                        'roles' => ['order.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit'],
                        'roles' => ['order.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['order.delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['latest']
                    ],
                ],
            ],
        ];
    }
    
    /**
     * inheritdoc
     */
    public function actions()
    {
        return [
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Order::className(),
                         'dtoClass' => GridViewDTO::className(),
                         'viewFile' => '/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Order::className(),
                         'detailViewDTOClass' => DetailViewDTO::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => Order::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'order.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => Order::className()
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => Order::className()
                        ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $checkoutDTO        = new AdminCheckoutDTO();
        $checkoutDTO->setCheckout(ApplicationUtil::getCheckout());
        $checkoutDTO->getCheckout()->order = new Order();
        $checkoutDTO->getCheckout()->customerForm->scenario = 'create';
        $checkoutDTO->setInterface('admin');
        $postData           = UsniAdaptor::app()->request->post();
        $checkoutDTO->setPostData($postData);
        $this->orderManager->processOrderEdit($checkoutDTO);
        //Set the currency cookie
        UsniAdaptor::app()->cookieManager->setCurrencyCookie($checkoutDTO->getCheckout()->customerForm->currencyCode);
        if($checkoutDTO->getResult() === true)
        {
            $checkoutDTO->getCheckout()->updateSession();
            UsniAdaptor::app()->customer->updateSession('customerId', $checkoutDTO->getCheckout()->customerForm->customerId);
            return $this->redirect(UsniAdaptor::createUrl('order/default/add-to-cart'));
        }
        return $this->render('/create', ['formDTO' => $checkoutDTO]);
    }
    
    /**
     * Update order
     * @param int $id
     */
    public function actionUpdate($id)
    {
        $order  = Order::findOne($id);
        if(empty($order))
        {
            return $this->redirect(UsniAdaptor::createUrl('order/default/index'));
        }
        if($order->created_by != UsniAdaptor::app()->user->getId() && !UsniAdaptor::app()->user->can('order.updateother'))
        {
            throw new \yii\web\ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        $checkoutDTO        = new AdminCheckoutDTO();
        $checkoutDTO->setCheckout(ApplicationUtil::getCheckout());
        $checkoutDTO->setCart(ApplicationUtil::getCart());
        $checkoutDTO->setInterface('admin');
        $postData           = UsniAdaptor::app()->request->post();
        $checkoutDTO->setPostData($postData);
        $checkoutDTO->getCheckout()->order = $order;
        $checkoutDTO->getCheckout()->customerForm->scenario = 'update';
        if($checkoutDTO->getCheckout()->customerForm->customerId == null)
        {
            $checkoutDTO->getCheckout()->customerForm->customerId = $order->customer_id;
        }
        $checkoutDTO->getCheckout()->customerForm->storeId = $order->store_id;
        if($checkoutDTO->getCheckout()->customerForm->currencyCode == null)
        {
            $checkoutDTO->getCheckout()->customerForm->currencyCode = $order->currency_code;
        }
        $this->orderManager->processOrderEdit($checkoutDTO);
        //Set the currency cookie
        UsniAdaptor::app()->cookieManager->setCurrencyCookie($checkoutDTO->getCheckout()->customerForm->currencyCode);
        if($checkoutDTO->getResult() === true)
        {
            $checkoutDTO->getCheckout()->updateSession();
            UsniAdaptor::app()->customer->updateSession('customerId', $checkoutDTO->getCheckout()->customerForm->customerId);
            return $this->redirect(UsniAdaptor::createUrl('order/default/add-to-cart'));
        }
        return $this->render('/update', ['formDTO' => $checkoutDTO]);
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
        $guestCheckoutSetting   = UsniAdaptor::app()->storeManager->getSettingValue('guest_checkout', $storeId);
        if(!$guestCheckoutSetting && $customerId == Customer::GUEST_CUSTOMER_ID)
        {
            return false;
        }
        return true;
    }

    /**
     * Add items to cart
     * @return string
     */
    public function actionAddToCart()
    {
        $isAllowed = $this->checkGuestCheckout();
        if($isAllowed === false)
        {
            $this->redirectOnNonGuestCheckout();
        }
        else
        {
            $checkoutDTO        = new AdminCheckoutDTO();
            $checkoutDTO->setCheckout(ApplicationUtil::getCheckout());
            $checkoutDTO->setInterface('admin');
            $postData           = UsniAdaptor::app()->request->post();
            if($checkoutDTO->getCheckout()->orderProductForm->load($postData))
            {
                $cart           = UsniAdaptor::app()->customer->cart;
                if($cart->itemsList->count() > 0)
                {
                    return $this->redirect(UsniAdaptor::createUrl('order/default/checkout'));
                }
                else
                {
                    FlashUtil::setMessage('warning', UsniAdaptor::t('cartflash', "There should be atleast one item in the cart before you proceed for checkout."));
                }
            }
            $products = ProductDAO::getAll(UsniAdaptor::app()->languageManager->selectedLanguage);
            $productsMap = ArrayUtil::map($products, 'id', 'name');
            $checkoutDTO->setProducts($productsMap);
            return $this->render('/orderproductedit', ['formDTO' => $checkoutDTO]);
        }
    }
    
    /**
     * Checkout action for the order
     * @return string
     */
    public function actionCheckout()
    {
        $isAllowed = $this->checkGuestCheckout();
        if($isAllowed === false)
        {
            $this->redirectOnNonGuestCheckout();
        }
        else
        {
            $cart = ApplicationUtil::getCart();
            if($cart->shouldProceedForCheckout() === false)
            {
                FlashUtil::setMessage('error', UsniAdaptor::t('cartflash', "Either products in the cart are not in stock or out of stock checkout is not allowed. Please contact system admin."));
                return $this->redirect(UsniAdaptor::createUrl('order/default/add-to-cart'));
            }
            $checkoutDTO    = new AdminCheckoutDTO();
            $checkout       = ApplicationUtil::getCheckout();
            $checkoutDTO->setCustomerId(UsniAdaptor::app()->customer->customerId);
            $checkoutDTO->setPostData($_POST);
            $checkoutDTO->setCheckout($checkout);
            $checkoutDTO->setCart(ApplicationUtil::getCart());
            $checkoutDTO->setInterface('admin');
            $this->checkoutManager->processCheckout($checkoutDTO);
            if($checkoutDTO->getResult() === true)
            {
                $checkoutDTO->getCheckout()->updateSession();
                return $this->redirect(UsniAdaptor::createUrl('order/default/review-order'));
            }
            return $this->render('/checkout', ['formDTO' => $checkoutDTO]);
        }
    }
    
    /**
     * Render product option form.
     * @return string.
     */
    public function actionRenderOptionForm()
    {
        $fieldOptions   = [
                            'inputOptions'  => ['class' => 'form-control'],
                            'labelOptions'  => ['class' => 'control-label col-xs-2'],
                            'inputContainerOptions' => ['class' => 'input-group'],
                            'fieldContainerOptions' => ['class' => 'form-group'],
                            'checkboxContainerOptions' => ['class' => 'checkbox checkbox-admin']
                          ];
        $assignedOptions    = OptionDAO::getAssignedOptions($_GET['productId'], UsniAdaptor::app()->languageManager->selectedLanguage);
        $options            = AdminDynamicOptionsEditView::widget(['productId' => $_GET['productId'], 'fieldOptions' => $fieldOptions, 'assignedOptions' => $assignedOptions]);
        $title      = null;
        if(!empty($options))
        {
            $title      = Html::tag('h4', UsniAdaptor::t('products', 'Available Option(s)'));
        }
        echo $title . $options;
    }
    
    /**
     * Add product to admin cart
     * @return string json result
     */
    public function actionAddProduct()
    {
        $cart           = ApplicationUtil::getCart();      
        //Populate dtos
        $cartDTO        = new CartDTO();
        $postData       = $_POST['OrderProductForm'];
        if(isset($_POST['ProductOptionMapping']['option']))
        {
            $postData['ProductOptionMapping']['option'] = $_POST['ProductOptionMapping']['option'];
        }
        $checkout   = ApplicationUtil::getCheckout();
        $cartDTO->setPostData($postData);
        $cartDTO->setCart($cart);
        $cartDTO->setCustomerId($checkout->customerForm->customerId);
        CartManager::getInstance()->addItem($cartDTO);
        $result = $cartDTO->getResult();
        if($result['success'] === true)
        {
            $cartDTO->getCart()->updateSession();
            $data       = AdminCartSubView::widget();
            $result['data'] = $data;
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
            $cart       = ApplicationUtil::getCart();
            $cartDTO    = new CartDTO();
            $cartDTO->setCart($cart);
            CartManager::getInstance()->removeItem($_POST['item_code'], $cartDTO);
            $cartDTO->getCart()->updateSession();
            $data    = AdminCartSubView::widget();
            return Json::encode(['data' => $data]);
        }
        return Json::encode([]);
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
            FlashUtil::setMessage('warning', UsniAdaptor::t('cartflash', "Either products in the cart are not in stock or out of stock checkout is not allowed. Please contact system admin."));
            return $this->redirect(UsniAdaptor::createUrl('cart/default/view'));
        }
        $checkout                       = ApplicationUtil::getCheckout();
        $model                          = new AdminConfirmOrderEditForm();
        if(isset($_POST['AdminConfirmOrderEditForm']))
        {
            $model->attributes = $_POST['AdminConfirmOrderEditForm'];
            if($model->validate())
            {
                $checkout->confirmOrderEditForm = $model;
                $checkout->updateSession();
                return $this->redirect(UsniAdaptor::createUrl('order/default/complete-order'));
            }
        }
        $model->status  = $checkout->order->status;
        $reviewDTO      = new ReviewDTO();
        $this->checkoutManager->populateReviewDTO($reviewDTO, $checkout, ApplicationUtil::getCart());
        //If new items are added to cart, shipping cost would be updated see issue https://github.com/ushainformatique/whatacart/issues/27
        $checkout->updateSession();
        return $this->render('/revieworder', ['model' => $model, 'reviewDTO' => $reviewDTO]);
    }
    
    /**
     * Complete order
     * @return void
     */
    public function actionCompleteOrder()
    {
        $checkout       = ApplicationUtil::getCheckout();   
        $order          = $checkout->order;
        if(empty($order) || $order->isNewRecord)
        {
            return $this->redirect(UsniAdaptor::app()->createUrl('order/default/index'));
        }
        $checkoutDTO    = new AdminCheckoutDTO();
        $checkoutDTO->setCustomerId(UsniAdaptor::app()->customer->customerId);
        $checkoutDTO->setCheckout(ApplicationUtil::getCheckout());
        $checkoutDTO->setInterface('admin');
        $this->checkoutManager->processComplete($checkoutDTO);
        //Reinstantiate the components
        UsniAdaptor::app()->customer->updateSession('cart', new AdminCart());
        $checkoutDTO->getCheckout()->customerForm = new CustomerForm();
        $checkoutDTO->getCheckout()->updateSession();
        return $this->redirect(UsniAdaptor::createUrl('order/default/index'));
    }
        
    /**
     * Add order history.
     * @return void
     */
    public function actionAddOrderHistory()
    {
        if(isset($_POST['OrderHistory']))
        {
            $this->orderManager->processOrderHistory($_POST['OrderHistory']);
        }
    }
    
    /**
     * Get the latest products
     * @return string
     */
    public function actionLatest()
    {
        $gridViewDTO = new GridViewDTO();
        $this->orderManager->processLatestOrders($gridViewDTO);
        return $this->renderPartial('/_latestordersgrid', ['gridViewDTO' => $gridViewDTO]);
    }
    
    /**
     * Redirect browser when guest checkout is not allowed.
     * @return string
     */
    private function redirectOnNonGuestCheckout()
    {
        $checkout = ApplicationUtil::getCheckout();
        FlashUtil::setMessage('warning', UsniAdaptor::t('cartflash', "The guest checkout is not allowed for the selected store."));
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