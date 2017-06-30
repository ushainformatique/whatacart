<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\notifications;

use common\modules\order\models\Order;
use usni\library\notifications\EmailNotification;
use common\modules\order\models\OrderAddressDetails;
use usni\library\modules\users\models\Address;
use usni\library\modules\notification\models\Notification;
use usni\library\utils\DateTimeUtil;
use common\modules\order\widgets\front\OrderEmailProductSubView;
use usni\UsniAdaptor;
use common\modules\shipping\dao\ShippingDAO;
use common\modules\order\dao\OrderDAO;
/**
 * OrderReceivedEmailNotification class file.
 *
 * @package common\modules\order\notifications
 */
class OrderReceivedEmailNotification extends EmailNotification
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    use \common\modules\payment\traits\PaymentTrait;
    /**
     * Order id
     * @var int
     */
    public $order;
    
    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return Order::NOTIFY_ORDERRECEIVED;
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'order';
    }
    
    /**
     * @inheritdoc
     */
    public function getDeliveryPriority()
    {
        return Notification::PRIORITY_HIGH;
    }

    /**
     * @inheritdoc
     */
    protected function getTemplateData()
    {
        $orderLink  = null;
        if($this->order['customer_id'] != 0)
        {   
            $orderUrlContent = '<p style="margin-top: 0px; margin-bottom: 20px;">To view your order click on the link below:</p>
                                <p style="margin-top: 0px; margin-bottom: 20px;"><a href="{orderLink}">{{orderLink}}</a></p>';
            $orderUrl   = UsniAdaptor::app()->getFrontUrl() . '/customer/site/order-view?id=' . $this->order['id'];
            $orderUrl   = "<a href='$orderUrl'>$orderUrl</a>";
            $orderLink  = str_replace('{{orderLink}}', $orderUrl, $orderUrlContent);
        }
        list($shippingAddressTitle, $shippingMethod, $shippingContent) = $this->getShippingVariables();
        return [
                    '{{orderProducts}}'         => $this->getOrderProducts(), 
                    '{{orderId}}'               => $this->order['unique_id'], 
                    '{{dateAdded}}'             => DateTimeUtil::getFormattedDateTime($this->order['created_datetime']),
                    '{{paymentMethod}}'         => $this->getPaymentMethodName($this->order['payment_method']), 
                    '{{email}}'                 => $this->order['email'], 
                    '{{telephone}}'             => $this->order['mobilephone'], 
                    '{{orderStatus}}'           => $this->getOrderStatusLabel($this->order['status']), 
                    '{{paymentAddress}}'        => $this->getBillingAddress(), 
                    '{{shippingAddressTitle}}'  => $shippingAddressTitle, 
                    '{{shippingAddress}}'       => $shippingContent, 
                    '{{shippingMethod}}'        => $shippingMethod, 
                    '{{storeName}}'             => $this->order['store_name'], 
                    '{{orderLink}}'             => $orderLink
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getLayoutData($data)
    {
        return array('{{####content####}}' => $data['templateContent']);
    }
    
    /**
     * Get order products
     * @return string
     */
    protected function getOrderProducts()
    {
        $orderProducts  = OrderDAO::getOrderProducts($this->order['id'], UsniAdaptor::app()->languageManager->selectedLanguage, true);
        return OrderEmailProductSubView::widget([
                                            'language' => UsniAdaptor::app()->languageManager->selectedLanguage,
                                            'order'    => $this->order,
                                            'orderProducts' => $orderProducts
                                        ]);
    }
    
    /**
     * Get billing address
     * @return string
     */
    protected function getBillingAddress()
    {
        $billingAddress = OrderDAO::getOrderAddress($this->order['id'], Address::TYPE_BILLING_ADDRESS);
        return $this->getConcatenatedAddress($billingAddress);
    }
    
    /**
     * Get billing address
     * @return string
     */
    protected function getShippingAddress()
    {
        $billingAddress = OrderDAO::getOrderAddress($this->order['id'], Address::TYPE_SHIPPING_ADDRESS);
        return $this->getConcatenatedAddress($billingAddress);
    }
    
    /**
     * Get concatenated address
     * @return string
     */
    protected function getConcatenatedAddress($attributes)
    {
        $orderAddressDetails = new OrderAddressDetails();
        $orderAddressDetails->setAttributes($attributes);
        return $orderAddressDetails->getConcatenatedDisplayedAddress();
    }
    
    /**
     * Get shipping variables
     * @return string
     */
    protected function getShippingVariables()
    {
        $shippingAddressTitle   = null;
        $shippingMethod         = null;
        $shippingContent        = null;
        if($this->order['shipping_fee'] > 0)
        {
            $shippingMethodName = ShippingDAO::getShippingMethodName($this->order['shipping'], $this->language);
            $shippingAddress = $this->getShippingAddress($this->order);
            $shippingContent = '<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">' . $shippingAddress . '</td>';
            $shippingAddressTitle = '<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">' . UsniAdaptor::t('order', 'Shipping Address') . '</td>';
            $shippingMethod = '<b>' . UsniAdaptor::t('order', 'Shipping') . ':</b> ' . $shippingMethodName  . '<br />';
        }
        return [$shippingAddressTitle, $shippingMethod, $shippingContent];
    }
}