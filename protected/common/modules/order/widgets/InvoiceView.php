<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\widgets;

use usni\UsniAdaptor;
use usni\library\utils\DateTimeUtil;
use common\modules\order\models\Invoice;
use usni\library\utils\CountryUtil;
/**
 * InvoiceView renders the invoice
 * 
 * @package common\modules\order\widgets
 */
class InvoiceView extends \yii\bootstrap\Widget
{
    /**
     * Invoice model
     * @var Invoice 
     */
    public $invoice;
    
    /**
     * Invoice id displayed to user
     * @var string 
     */
    public $invoiceDisplayedId;
    
    /**
     * Invoice view file
     * @var string 
     */
    public $viewFile = '/invoice/_printInvoice';
    
    /**
     * @var array 
     */
    public $orderProducts;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $prefix         = UsniAdaptor::app()->storeManager->getSettingValue('invoice_prefix', $this->invoice['store_id']);
        $this->invoiceDisplayedId = $prefix . $this->invoice['unique_id'];
        $title          = UsniAdaptor::t('order', 'Invoice ' . $this->invoiceDisplayedId);
        return $this->getView()->render($this->viewFile, 
                                        [
                                            'title'             => $title,
                                            'invoiceSummary'    => $this->getInvoiceSummary(),
                                            'companyAddress'    => $this->getCompanyAddress(),
                                            'billToAddress'     => $this->getBillToAddress(),
                                            'shipToAddress'     => $this->getShipToAddress(),
                                            'personDetails'     => $this->getPerson(),
                                            'orderDetails'      => $this->getOrderDetails(),
                                            'paymentDetails'    => $this->getPaymentDetails(),
                                            'invoiceId'         => $this->invoice['id']
                                        ]);
    }
    
    /**
     * Get invoice summary
     * @return string
     */
    protected function getInvoiceSummary()
    {
        $issueDate          = DateTimeUtil::getFormattedDate($this->invoice['created_datetime']);
        $orderPrefix        = UsniAdaptor::app()->storeManager->getSettingValue('order_prefix', $this->invoice['store_id']);
        return $this->getView()->render('/invoice/_invoicesummary', 
                                                    [
                                                        'invoiceNo' => $this->invoiceDisplayedId,
                                                        'orderNo'   => $orderPrefix . $this->invoice['order_unique_id'],
                                                        'issueDate' => $issueDate,
                                                        'terms'     => $this->invoice['terms'],
                                                        'paymentMethod' => $this->invoice['payment_method_name']
                                                    ]);
    }

    /**
     * Get company address
     * @return string
     */
    protected function getCompanyAddress()
    {
        $country        = CountryUtil::getCountryName($this->invoice['country']);
        return $this->getView()->render('/invoice/_companyaddress', 
                                                    [
                                                        'country'   => $country,
                                                        'email'     => $this->invoice['email'],
                                                        'mobile'    => $this->invoice['mobilephone'],
                                                        'storeName' => $this->invoice['store_name']
                                                    ]);
    }
    
    /**
     * Get bill to address
     * @return string
     */
    protected function getBillToAddress()
    {
        return $this->getView()->render('/invoice/_billtoaddress', 
                                                    [
                                                        'billingAddress' => $this->invoice['billing_address']
                                                    ]);
    }
    
    /**
     * Get ship to address
     * @return string
     */
    protected function getShipToAddress()
    {
        return $this->getView()->render('/invoice/_shiptoaddress', 
                                                    [
                                                        'shippingAddress'   => $this->invoice['shipping_address']
                                                    ]);
    }
    
    /**
     * Get person
     * @return string
     */
    protected function getPerson()
    {
        return $this->getView()->render('/invoice/_person', 
                                                    [
                                                        'email'         => $this->invoice['customer_email'],
                                                        'mobilephone'   => $this->invoice['customer_mobilephone']
                                                    ]);
    }
    
    /**
     * Get order details
     * @return string
     */
    protected function getOrderDetails()
    {
        $orderProducts  = $this->orderProducts;
        return $this->getView()->render('/invoice/_orderdetails', 
                                                    [
                                                        'orderProducts'   => $orderProducts,
                                                        'currencySymbol'    => $this->invoice['currency_symbol']
                                                    ]);
    }
    
    /**
     * Get payment details
     * @return string
     */
    protected function getPaymentDetails()
    {
        return $this->getView()->render('/invoice/_paymentdetails', 
                                                    [
                                                        'orderPayment'   => $this->invoice,
                                                        'orderId'        => $this->invoice['order_id'],
                                                        'currencySymbol' => $this->invoice['currency_symbol']
                                                    ]);
    }
}