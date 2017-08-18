<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\business;

use common\modules\order\models\Invoice;
use common\modules\order\models\Order;
use common\modules\order\dao\OrderDAO;
use yii\base\InvalidParamException;
use usni\library\modules\users\models\Address;
use usni\UsniAdaptor;
use common\modules\order\utils\OrderUtil;
use common\modules\order\dto\InvoiceDetailViewDTO;
use common\modules\order\business\Manager as OrderBusinessManager;
use common\modules\order\behaviors\InvoiceManagerBehavior;
use usni\library\utils\ArrayUtil;
/**
 * Implements business logic for invoice
 *
 * @package common\modules\order\business
 */
class InvoiceManager extends \common\business\Manager
{
    use \common\modules\sequence\traits\SequenceTrait;
    use \common\modules\payment\traits\PaymentTrait;
    
    public function behaviors()
    {
        return ArrayUtil::merge(parent::behaviors(), [InvoiceManagerBehavior::className()]);
    }
    
    /**
     * Save invoice details.
     * @param Order $order
     * @return void
     */
    public function saveInvoice($paymentDetails, $quantity)
    { 
        $invoice                        = new Invoice(['scenario' => 'create']);
        $invoice->unique_id             = $this->getUniqueId('invoice_sequence_no');
        $invoice->order_id              = $paymentDetails->order_id;
        $invoice->tax                   = $paymentDetails->tax;
        $invoice->shipping_fee          = $paymentDetails->shipping_fee;
        $invoice->total_items           = $quantity;
        $invoice->price_excluding_tax   = $paymentDetails->total_including_tax - $paymentDetails->tax;
        if($invoice->save())
        {
            $this->updateSequenceNumber('invoice_sequence_no');
        }
    }
    
    /**
     * inheritdoc
     * @param InvoiceDetailViewDTO $detailViewDTO
     */
    public function processDetail($detailViewDTO)
    {
        $invoice        = OrderDAO::getInvoice($detailViewDTO->getId(), $this->language);
        $orderId        = $invoice['order_id'];
        $order          = OrderDAO::getById($orderId, $this->language, $this->selectedStoreId);
        $isValidOrder   = OrderBusinessManager::getInstance()->isValidOrderId($orderId);
        if($isValidOrder)
        {
            parent::processDetail($detailViewDTO);
            $orderProducts  = OrderDAO::getOrderProducts($orderId, $this->language, true);
            $detailViewDTO->setOrderProducts($orderProducts);
            $this->populateExtraAttributesInModel($detailViewDTO, $order);
        }
        else
        {
            throw new InvalidParamException(UsniAdaptor::t('stores', 'Invalid Order'));
        }
    }
    
    /**
     * inheritdoc
     */
    public function processDetailAccess($detailViewDTO, $model)
    {
        $isPermissible  = true;
        if($this->userId != $model['created_by'])
        {
            $isPermissible      = UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, 'order.viewother');
        }
        return $isPermissible;
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = OrderDAO::getInvoice($id, $this->language);
        $model['payment_method_name'] = $this->getPaymentMethodName($model['payment_method']);
        $billingAddressRecord       = OrderDAO::getOrderAddress($model['order_id'], Address::TYPE_BILLING_ADDRESS);
        $model['billing_address']   = OrderUtil::getConcatenatedAddress($billingAddressRecord);
        $shippingAddressRecord      = OrderDAO::getOrderAddress($model['order_id'], Address::TYPE_SHIPPING_ADDRESS);
        $model['shipping_address']  = OrderUtil::getConcatenatedAddress($shippingAddressRecord);
        $model['currency_symbol']   = UsniAdaptor::app()->currencyManager->getCurrencySymbol($model['currency_code']);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        return $model;
    }
}