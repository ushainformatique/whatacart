<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\views;

use usni\library\views\ArrayRecordDetailView;
use common\modules\order\views\OrderAddressDetailView;
use usni\UsniAdaptor;
use usni\library\views\UiTabbedView;
use common\modules\shipping\utils\ShippingUtil;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
use common\modules\order\utils\OrderUtil;
use usni\library\modules\users\models\Address;
use common\modules\order\views\OrderBrowseModelView;
use customer\utils\CustomerUtil;
use usni\library\modules\users\utils\UserUtil;
use products\utils\ProductUtil;
/**
 * OrderDetailView class file.
 * 
 * @package common\modules\order\views
 */
class OrderDetailView extends ArrayRecordDetailView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                   'unique_id',
                   [
                       'label'      => UsniAdaptor::t('customer', 'Customer'),
                       'attribute'  => 'customer_id',
                       'value'      => $this->getCustomer()
                   ],
                   [
                       'attribute' => 'status', 
                       'value'     => $this->getStatusLabel(), 
                       'format'    => 'raw' 
                   ],
                   [
                       'attribute' => 'shipping', 
                       'value'     => ShippingUtil::getShippingMethodName($this->model['shipping']), 
                       'format'    => 'raw' 
                   ],
                   [
                        'attribute'  => 'shipping_fee',
                        'value'      => ProductUtil::getFormattedPrice($this->model['shipping_fee'])
                    ],
                   [
                       'label'      => UsniAdaptor::t('stores', 'Store'),
                       'attribute'  => 'store_id',
                       'value'      => $this->model['store_name']
                   ],
                   'shipping_comments'
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('order', 'Order') . '  '. '#' .$this->model['id'];
    }
    
    /**
     * Should render shipping address
     * @return boolean
     */
    protected function shouldRenderShippingAddress()
    {
        return true;
    }
    
    /**
     * Should render billing address
     * @return boolean
     */
    protected function shouldRenderBillingAddress()
    {
        return true;
    }
    
    /**
     * Should render order history
     * @return boolean
     */
    protected function shouldRenderOrderHistory()
    {
        return true;
    }


    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $viewHelper     = UsniAdaptor::app()->getModule('order')->viewHelper;
        $content        = null;
        $infoContent    = parent::renderContent();
        $billingAddress   = OrderUtil::getOrderAddress($this->model['id'], Address::TYPE_BILLING_ADDRESS);
        $shippingAddress  = OrderUtil::getOrderAddress($this->model['id'], Address::TYPE_SHIPPING_ADDRESS);
        if($billingAddress !== false)
        {
            $billingAddressViewClass        = OrderAddressDetailView::className();
            $billingAddressViewInstance     = new $billingAddressViewClass($this->getDetailViewConfiguration($billingAddress));
            $billingAddressView             = $billingAddressViewInstance->render();
        }
        else
        {
            $billingAddressView = null;
        }
        if($shippingAddress !== false)
        {
            $shippingAddressViewClass       = OrderAddressDetailView::className();
            $shippingAddressViewInstance    = new $shippingAddressViewClass($this->getDetailViewConfiguration($shippingAddress));
            $shippingAddressView            = $shippingAddressViewInstance->render();
        }
        else
        {
            $shippingAddressView = null;
        }
        $paymentViewClass       = OrderPaymentDetailsView::className();
        $paymentViewInstance    = new $paymentViewClass($this->getDetailViewConfiguration($this->model));
        $paymentView            = $paymentViewInstance->render();

        $orderProductClass      = $viewHelper->orderProductView;
        $productViewInstance    = new $orderProductClass($this->getDetailViewConfiguration($this->model));
        $productView            = $productViewInstance->render();
        
        //Order History content.
        $orderHistoryClass          = $viewHelper->orderHistoryView;
        $orderHistoryInstance       = new $orderHistoryClass(['model' => $this->model]);
        $orderHistoryView           = $orderHistoryInstance->render();
        $tabs['orderInfo']          = ['label'   => UsniAdaptor::t('application', 'General'),
                                           'content' => $infoContent,
                                           'active'  => true];
        if($this->shouldRenderBillingAddress())
        {
            $tabs['billingInfo']    = ['label'   => UsniAdaptor::t('customer', 'Billing Address'),
                                           'content' => $billingAddressView];
        }
        
        if($this->shouldRenderShippingAddress())
        {
            $tabs['shippingInfo']   = ['label'   => UsniAdaptor::t('customer', 'Shipping Address'),
                                           'content' => $shippingAddressView];
        }
        $tabs['paymentInfo']        = ['label'   => UsniAdaptor::t('order', 'Payment Details'),
                                           'content' => $paymentView];
        $tabs['productInfo']        = ['label'   => UsniAdaptor::t('products', 'Product Details'),
                                           'content' => $productView];
        if($this->shouldRenderOrderHistory())
        {
            $tabs['orderHistoryInfo']   = ['label'   => UsniAdaptor::t('order', 'Order History'),
                                                'content' => $orderHistoryView];
        }
        $tabbedView  = new UiTabbedView($tabs);
        $content    .= $tabbedView->render();
        return $content;
    }
    
    /**
     * Get configuration for rendering detail view.
     * @param Model $model
     * @return array
     */
    protected function getDetailViewConfiguration($model)
    {
        return [
                    'model'       => $model,
                    'controller'  => $this->controller
               ];
    }
    
    /**
     * Get customer
     * @return string name
     */
    protected function getCustomer()
    {
        return $this->model['firstname'] . ' ' . $this->model['lastname'];
    }
    
    /**
     * @inheritdoc
     */
    protected static function resolveBrowseModelViewClassName()
    {
        return OrderBrowseModelView::className();
    }
    
    /**
     * Get status label
     * @return string
     */
    protected function getStatusLabel()
    {
        return OrderStatusUtil::renderLabel($this->model);
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveCreatedBy()
    {
        if($this->model['created_by'] == 0)
        {
            return 'guest';
        }
        elseif($this->model['interface'] == 'admin')
        {
            $data = UserUtil::getUserById($this->model['created_by']);
            return $data['username'];
        }
        elseif($this->model['interface'] == 'front')
        {
            $data = CustomerUtil::getCustomerById($this->model['created_by']);
            return $data['username'];
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function getPermissionPrefix()
    {
        return 'order';
    }
}