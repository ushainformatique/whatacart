<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views\invoice;

use usni\UsniAdaptor;
use usni\library\views\UiView;
use usni\library\utils\DateTimeUtil;
use common\modules\order\models\Invoice;
use common\modules\order\utils\OrderUtil;
use usni\library\utils\CountryUtil;
use common\modules\stores\utils\StoreUtil;
use usni\library\modules\users\models\Address;
use common\modules\payment\utils\PaymentUtil;
/**
 * InvoiceView class file.
 * @package common\modules\order\views\invoice
 */
class InvoiceView extends UiView
{
    /**
     * Invoice id
     * @var int 
     */
    public $invoiceId;
    
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
     * @inheritdoc
     */
    protected function renderContent()
    {
        $this->invoice  = OrderUtil::getInvoice($this->invoiceId);
        $prefix         = StoreUtil::getSettingValue('invoice_prefix', $this->invoice['store_id']);
        $this->invoiceDisplayedId = $prefix . $this->invoice['unique_id'];
        $title          = UsniAdaptor::t('order', 'Invoice ' . $this->invoiceDisplayedId);
        $filePath       = $this->getFilePath();
        return $this->getView()->renderPhpFile($filePath, 
                                                    [
                                                        'title'             => $title,
                                                        'invoiceSummary'    => $this->getInvoiceSummary(),
                                                        'companyAddress'    => $this->getCompanyAddress(),
                                                        'billToAddress'     => $this->getBillToAddress(),
                                                        'shipToAddress'     => $this->getShipToAddress(),
                                                        'personDetails'     => $this->getPerson(),
                                                        'orderDetails'      => $this->getOrderDetails(),
                                                        'paymentDetails'    => $this->getPaymentDetails(),
                                                        'invoiceId'         => $this->invoiceId
                                                    ]);
    }
    
    /**
     * Get invoice summary
     * @return string
     */
    protected function getInvoiceSummary()
    {
        $issueDate          = DateTimeUtil::getFormattedDate($this->invoice['created_datetime']);
        $filePath           = UsniAdaptor::getAlias("@common/modules/order/views/invoice/_invoicesummary") . ".php";
        return $this->getView()->renderPhpFile($filePath, 
                                                    [
                                                        'invoiceNo' => $this->invoiceDisplayedId,
                                                        'orderNo'   => $this->invoice['order_unique_id'],
                                                        'issueDate' => $issueDate,
                                                        'terms'     => $this->invoice['terms'],
                                                        'paymentMethod' => PaymentUtil::getPaymentMethodName($this->invoice['payment_method'])
                                                    ]);
    }

    /**
     * Get company address
     * @return string
     */
    protected function getCompanyAddress()
    {
        $country        = CountryUtil::getCountryName($this->invoice['country']);
        $filePath       = UsniAdaptor::getAlias("@common/modules/order/views/invoice/_companyaddress") . ".php";
        return $this->getView()->renderPhpFile($filePath, 
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
        $billingAddress = OrderUtil::getOrderAddress($this->invoice['order_id'], Address::TYPE_BILLING_ADDRESS);
        $country        = CountryUtil::getCountryName($billingAddress['country']);
        $filePath       = UsniAdaptor::getAlias("@common/modules/order/views/invoice/_billtoaddress") . ".php";
        return $this->getView()->renderPhpFile($filePath, 
                                                    [
                                                        'billingAddress' => $billingAddress,
                                                        'country'        => $country,
                                                    ]);
    }
    
    /**
     * Get ship to address
     * @return string
     */
    protected function getShipToAddress()
    {
        $shippingAddress    = OrderUtil::getOrderAddress($this->invoice['order_id'], Address::TYPE_SHIPPING_ADDRESS);
        $country            = CountryUtil::getCountryName($shippingAddress['country']);
        $filePath           = UsniAdaptor::getAlias("@common/modules/order/views/invoice/_shiptoaddress") . ".php";
        return $this->getView()->renderPhpFile($filePath, 
                                                    [
                                                        'shippingAddress'   => $shippingAddress,
                                                        'country'           => $country
                                                    ]);
    }
    
    /**
     * Get person
     * @return string
     */
    protected function getPerson()
    {
        $filePath  = UsniAdaptor::getAlias("@common/modules/order/views/invoice/_person") . ".php";
        return $this->getView()->renderPhpFile($filePath, 
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
        $orderProducts  = OrderUtil::getOrderProducts($this->invoice['order_id'], true);
        $filePath       = UsniAdaptor::getAlias("@common/modules/order/views/invoice/_orderdetails") . ".php";
        return $this->getView()->renderPhpFile($filePath, 
                                                    [
                                                        'orderProducts'   => $orderProducts,
                                                        'currencyCode'    => $this->invoice['currency_code']
                                                    ]);
    }
    
    /**
     * Get payment details
     * @return string
     */
    protected function getPaymentDetails()
    {
        $filePath   = UsniAdaptor::getAlias("@common/modules/order/views/invoice/_paymentdetails") . ".php";
        return $this->getView()->renderPhpFile($filePath, 
                                                    [
                                                        'orderPayment'   => $this->invoice,
                                                        'orderId'        => $this->invoice['order_id'],
                                                        'currencyCode'   => $this->invoice['currency_code']
                                                    ]);
    }
    
    /**
     * Get file path.
     * @return string
     */
    protected function getFilePath()
    {
        return UsniAdaptor::getAlias("@common/modules/order/views/invoice/_printInvoice") . ".php";
    }
}
?>