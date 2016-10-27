<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\utils;

use common\modules\order\models\Order;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use products\models\Product;
use usni\library\modules\notification\utils\NotificationUtil;
use usni\library\components\UiHtml;
use common\modules\sequence\models\Sequence;
use common\modules\sequence\utils\SequenceUtil;
use common\modules\order\models\Invoice;
use customer\models\Customer;
use common\modules\order\views\LatestOrderGridView;
use usni\library\modules\users\models\User;
use common\modules\order\models\OrderPaymentTransactionMap;
use yii\caching\DbDependency;
use common\modules\order\models\OrderHistory;
use common\modules\order\models\OrderAddressDetails;
use usni\library\modules\users\models\Address;
use usni\library\modules\notification\models\Notification;
use common\modules\order\notifications\OrderReceivedEmailNotification;
use common\modules\order\notifications\OrderCompletionEmailNotification;
use common\modules\order\notifications\OrderUpdateEmailNotification;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
use usni\library\utils\CountryUtil;
use usni\library\utils\TranslationUtil;
/**
 * OrderUtil class file.
 * 
 * @package common\modules\order\utils
 */
class OrderUtil
{
    /**
     * Gets dropdown field select data.
     * @param string $modelClass
     * @return array
     */
    public static function getOrderDropdownList()
    {
        return ArrayUtil::map(Order::find()->indexBy('id')->asArray()->all(), 'id', 'unique_id');
    }
    
    /**
     * Generate 17 digit unique transaction id.
     * @param integer $digitsNeeded
     * @return string
     */
    public static function generateUniqueTransactionId($digitsNeeded)
    {
        $randomNumber='';
        $count=0;
        while ( $count < $digitsNeeded ) 
        {
            $randomDigit = mt_rand(0, 9);

            $randomNumber .= $randomDigit;
            $count++;
        }
        return $randomNumber;
    }
    
    /**
     * Update product quantity after checkout.
     * @param integer $productId.
     * @return void
     */
    public static function reduceProductQuantityAfterCheckout($productId, $qtyToReduce)
    {
        $product =  Product::find()->where('id = :id', [':id' => $productId])->asArray()->one();
        if($product['quantity'] > 0 && $product['quantity'] > $qtyToReduce)
        {
            $quantityAfterCheckout = $product['quantity'] - $qtyToReduce;
            UsniAdaptor::db()->createCommand()
                        ->update(Product::tableName(), ['quantity' => $quantityAfterCheckout],
                                   'id = :id', [':id' => $productId])->execute();
        }
    }
    
    /**
     * Register continue action script.
     * @param string $url
     * @param string $formId
     * @param string $tab
     * @return string
     */
    public static function registerContinueActionScript($url, $formId, $tab)
    {
        $addProductText = UsniAdaptor::t('order', 'Please add product to continue');
        $script         = "$('body').on('beforeSubmit', '#{$formId}',
                                     function(event, jqXHR, settings)
                                     {
                                        var formId  = '{$formId}';
                                        if(formId == 'orderproducteditview')
                                        {
                                            var items = $('#order-cart-products').html().trim();
                                            if(items == '')
                                            {
                                                alert('{$addProductText}');
                                                return false;
                                            }
                                            $('.nav-tabs a[href=\'#{$tab}\']').tab('show');
                                            return false;
                                        }
                                        var form    = $(this);
                                        if(form.find('.has-error').length) {
                                                return false;
                                        }
                                        
                                        $.ajax({
                                                    url: '{$url}',
                                                    type: 'post',
                                                    data: form.serialize(),
                                                    success: function(json) {
                                                            if(formId == 'orderpaymenteditview')
                                                            {
                                                                $('#shopping-cart-container').html(json);
                                                            }
                                                            $('.nav-tabs a[href=\'#{$tab}\']').tab('show');
                                                        }
                                                });
                                        event.stopImmediatePropagation();
                                        return false;
                                     })";
        return $script;
    }
    
    /**
     * Add order product script.
     * @return string
     */
    public static function addOrderProductScript()
    {
        $url = UsniAdaptor::createUrl('order/default/add-product');
        $productError = UsniAdaptor::t('products', 'Product can not be blank');
        $qtyError     = UsniAdaptor::t('order', 'Input Quantity should be >= minimum quantity');
        $js = "     
                    var dataString = '';
                    $('body').on('click', '#addproduct-button', function(e){
                    var productId = $('#orderproductform-product_id').val();
                    if(productId == '')
                    {
                        var container = $('#orderproductform-product_id').closest('.form-group');
                        $(container).find('.help-block').html('{$productError}');
                        $(container).removeClass('has-error');
                        $(container).removeClass('has-success');
                        $(container).addClass('has-error');   
                        return false;
                    }
                    $.ajax({
                            url: '{$url}',
                            type: 'post',
                            data: $('#orderproducteditview').serialize(),
                            dataType: 'json',
                            beforeSend: function()
                                        {
                                            $.fn.attachLoader('#addproduct-button');
                                        },
                            success: function(json) 
                            {
                                $.fn.removeLoader('#addproduct-button');
                                if (json['success']) 
                                {
                                    $('#order-cart-products').html(json['data']);
                                    $('#orderproductform-product_id').val('').change();
                                    $('#orderproductform-quantity').val('1');
                                    $('#order-product-options').html('');
                                }
                                else
                                {
                                    if(json['qtyError'])
                                    {
                                        $('.field-orderproductform-quantity').addClass('has-error');
                                        $('.field-orderproductform-quantity').find('.help-block-error').html('{$qtyError}');
                                    }
                                    else
                                    {
                                        $.fn.renderOptionErrors(json['errors'], 'field-productoptionmapping', 'has-error',
                                                                                                      'has-success');
                                    }
                                }
                            }
                        });
                    e.stopImmediatePropagation();
                    return false;
               })";
        return $js;
    }
    
    /**
     * Render option fields script
     * @return string
     */
    public static function renderOptionFieldsScript()
    {
        $url                = UsniAdaptor::createUrl('order/default/render-option-form');
        $script             = "$('#orderproductform-product_id').on('change',
                            function(event, jqXHR, settings)
                            {
                                var dropDown    = $(this);
                                var value       = $(this).val();
                                if(value == '')
                                {
                                    return false;
                                }
                                else
                                {
                                    $.ajax({
                                            url: '{$url}',
                                            type: 'get',
                                            data: 'productId=' + value,
                                            beforeSend: function()
                                                        {
                                                            $.fn.attachLoader('#orderproductform-product_id');
                                                        },
                                            success: function(data){
                                                $.fn.removeLoader('#orderproductform-product_id');
                                                $('#order-product-options').html(data);
                                            }
                                        });
                                }
                            }
                        )";
        return $script;
    }
    
    /**
     * Register remove from cart script.
     * 
     * @return void
     */
    public static function registerRemoveFromCartScript()
    {
        $removeClass    = 'order-cart-remove';
        $removeUrl      = UsniAdaptor::createUrl('order/default/remove');
        $js = "$('body').on('click', '.{$removeClass}', function(e){
                    var itemCode    = $(this).data('itemcode');
                    $.ajax({
                            url: '{$removeUrl}',
                            type: 'post',
                            data: 'item_code=' + itemCode,
                            dataType: 'json',
                            success: function(json) {
                                if (json['data']) {
                                    $('#order-cart-products').html(json['data']);
                                }	
                            }
                        });
                e.stopImmediatePropagation();
                return false;
              })";
        return $js;
    }
    
    /**
     * Register previous button cart script.
     * 
     * @param $id string
     * @return void
     */
    public static function registerPreviousButtonScript($id, $tab)
    {
        $url    = UsniAdaptor::createUrl('order/default/previous'); 
        $js     = "$('body').on('click', '#{$id}', function(e){
                    $('.nav-tabs a[href=\'#{$tab}\']').tab('show');
              })";
        return $js;
    }
    
    /**
     * Prepare and add cart item
     * @param Order $order
     * @param int $qty
     * @param array $inputOptions
     */
    public static function prepareAndAddCartItems($order, $cart)
    {
        $orderProducts = $order->orderProducts;
        foreach($orderProducts as $orderProduct)
        {
            $cart->addOrderProductItem($orderProduct, $order);
        }
    }
    
    /**
     * Get option string by option data
     * @param array $optionData
     */
    public static function getOptionStringByOptionData($optionData)
    {
        $optionStr  = null;
        if(!empty($optionData))
        {
            $keys = array_keys($optionData);
            foreach($keys as $key)
            {
                $value = $optionData[$key];
                $optionName = key($value);
                $optionStr .= $optionName . ": " . implode(',', $value[$optionName]) . "<br/>";
            }
        }
        return $optionStr;
    }
    
    /**
     * Get unique id based on column.
     * @return string
     */
    public static function getUniqueId($columnName)
    {
        $sequence       = Sequence::find()->one();
        return intval($sequence->$columnName) + 1;
    }
    
    /**
     * Save invoice details.
     * @param Order $order
     * @return void
     */
    public static function saveInvoice($paymentDetails, $quantity)
    { 
        $invoice        = new Invoice(['scenario' => 'create']);
        $invoice->unique_id             = self::getUniqueId('invoice_sequence_no');
        $invoice->order_id              = $paymentDetails->order_id;
        $invoice->tax                   = $paymentDetails->tax;
        $invoice->shipping_fee          = $paymentDetails->shipping_fee;
        $invoice->total_items           = $quantity;
        $invoice->price_excluding_tax   = $paymentDetails->total_including_tax - $paymentDetails->tax;
        if($invoice->save())
        {
            SequenceUtil::updateSequenceNumber('invoice_sequence_no');
        }
    }
    
    /**
     * Get customer.
     * @param mixed $data the data model
     * @return string
     */
    public static function getDisplayedCustomer($data)
    {
        if(empty($data) || $data['id'] == Customer::GUEST_CUSTOMER_ID)
        {
            return 'guest';
        }
        if(!empty($data))
        {
             return $data['username'];
        }
        return null;
    }
    
    /**
     * Get dashboard content for order module.
     * @return string
     */
    public static function getDashboardContent()
    {
        $user = UsniAdaptor::app()->user->getUserModel();
        if($user->type === 'system' || $user->id == User::SUPER_USER_ID)
        {
            $model      = new Order();
            $view       = new LatestOrderGridView(['model' => $model]);
            $content    = UiHtml::panelContent($view->render(), ['class' => 'panel-dashboard']);
            return UiHtml::tag('div', $content, ['class' => 'col-sm-6 col-xs-12']);
        }
    }
    
    /**
     * Get total amount
     * @param Order $order
     * @return double
     */
    public static function getTotalAmount($order)
    {
        return $order['total_including_tax'] + $order['shipping_fee'];
    }
    
    /**
     * Get already paid amount for the order
     * @param integer $orderId
     * @return double
     */
    public static function getAlreadyPaidAmountForOrder($orderId)
    {
        $orderPaymentMethodMap = OrderPaymentTransactionMap::find()->where('order_id = :oid', [':oid' => $orderId])->asArray()->all();
        $total = 0;
        if(!empty($orderPaymentMethodMap))
        {
            foreach($orderPaymentMethodMap as $record)
            {
                $total        += $record['amount'];
            }
        }
        return $total;
    }
    
    /**
     * Get order details
     * @param int $orderId
     * @param string $language
     * @return array
     */
    public static function getOrder($orderId, $language = null)
    {
        if($language == null)
        {
            $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $orderTrTable           = UsniAdaptor::tablePrefix() . 'order_translated';
        $orderPaymentTable      = UsniAdaptor::tablePrefix() . 'order_payment_details';
        $orderPaymentTrTable    = UsniAdaptor::tablePrefix() . 'order_payment_details_translated';
        $orderAddressTable      = UsniAdaptor::tablePrefix() . 'order_address_details';
        $storeTable             = UsniAdaptor::tablePrefix() . 'store';
        $storeTrTable           = UsniAdaptor::tablePrefix() . 'store_translated';
        $currentStore           = UsniAdaptor::app()->storeManager->getCurrentStore();
        $sql                    = "SELECT o.*, otr.shipping_comments, 
                                   op.payment_method, op.total_including_tax, op.tax, op.payment_type,
                                   optr.comments, 
                                   toad.firstname, toad.lastname, toad.email, toad.mobilephone, 
                                   str.name as store_name
                                   FROM $orderTable o, $orderTrTable otr, $orderPaymentTable op, 
                                    $orderPaymentTrTable optr, $orderAddressTable toad,
                                    $storeTable st, $storeTrTable str
                                   WHERE o.id = :id AND o.store_id = :sid AND o.id = otr.owner_id
                                   AND o.id = op.order_id 
                                   AND op.id = optr.owner_id AND otr.language = :lan1 
                                   AND optr.language = :lan2 
                                   AND o.id = toad.order_id AND toad.type = :type 
                                   AND o.store_id = st.id AND st.id = str.owner_id
                                   AND str.language = :lan3";
        $params                 = [':sid' => $currentStore->id, ':id' => $orderId, ':lan1' => $language, ':lan2' => $language, ':lan3' => $language, ':type' => Address::TYPE_BILLING_ADDRESS];
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Add  order history.
     * @param Model|array $order
     * @param array $attributes
     * @param boolean $fromHistory From add history screen
     * @return boolean
     */
    public static function addOrderHistory($order, $attributes = [], $fromHistory = false)
    {
        $sentStatus = 0;
        //Save order history
        $orderHistory = new OrderHistory(['scenario' => 'create']);
        $orderHistory->attributes = $attributes;
        if($orderHistory->save())
        {
            TranslationUtil::saveTranslatedModels($orderHistory);
        }
        $notifyCustomer = ArrayUtil::getValue($attributes, 'notify_customer', false);
        if($notifyCustomer)
        {
            $sentStatus = OrderUtil::sendMail($order['id'], $orderHistory, $fromHistory);
        }
    }
    
    /**
     * Get order product details
     * @param int $orderId
     * @return array
     */
    public static function getOrderProducts($orderId, $requireProductCols = false)
    {
        $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        $orderProductTable      = UsniAdaptor::tablePrefix() . 'order_product';
        $prTable                = UsniAdaptor::tablePrefix() . 'product';
        $prtTable               = UsniAdaptor::tablePrefix() . 'product_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $orderProductTable"]);
        $sql                    = "SELECT op.*";
        if($requireProductCols)
        {
            $sql                .= ", pr.sku, pr.image";
        }
        $sql                    .= " FROM $orderProductTable op, $prTable pr, $prtTable prt
                                   WHERE op.order_id = :oid AND op.product_id = pr.id AND pr.id = prt.owner_id AND prt.language = :lan";
        $params                 = [':oid' => $orderId, ':lan' => $language];
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Check if transaction id exist
     * @param string $inputTransactionId
     * @param string $table
     * @return boolean
     */
    public static function doesTransactionIdExist($inputTransactionId, $table)
    {
        $sql        = "SELECT COUNT(*) AS cnt 
                      FROM $table 
                      WHERE transaction_id = :tid";
        $connection = UsniAdaptor::app()->getDb();
        $cnt        = $connection->createCommand($sql, [':tid' => $inputTransactionId])->queryScalar();
        if($cnt == 0)
        {
            return false;
        }
        return true;
    }
    
    /**
     * Get unique transaction id
     * @param string $table
     * @return boolean
     */
    public static function getUniqueTransactionId($table)
    {
        $transactionId = null;
        while (true)
        {
            $rawTransactionId   = OrderUtil::generateUniqueTransactionId(17);
            $transactionId      = $rawTransactionId;
            if(!self::doesTransactionIdExist($transactionId, $table))
            {
                break;
            }
        }
        return $transactionId;
    }
    
    /**
     * Get order address by type
     * @param int $orderId
     * @param int $type
     * @return array
     */
    public static function getOrderAddress($orderId, $type)
    {
        $orderAddressTable      = OrderAddressDetails::tableName();
        $sql                    = "SELECT *
                                   FROM $orderAddressTable
                                   WHERE order_id = :id AND type = :type";
        $params                 = [':id' => $orderId, ':type' => $type];
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get invoice.
     * @param integer $invoiceId
     * @param string $language
     * @return Invoice $record
     */
    public static function getInvoice($invoiceId, $language = null)
    {
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $tableName          = UsniAdaptor::tablePrefix() . 'invoice';
        $trTableName        = UsniAdaptor::tablePrefix() . 'invoice_translated';
        $orderTable         = UsniAdaptor::tablePrefix() . 'order';
        $userTable          = UsniAdaptor::tablePrefix() . 'user';
        $storeTable         = UsniAdaptor::tablePrefix() . 'store';
        $trStoreTable       = UsniAdaptor::tablePrefix() . 'store_translated';
        $personTable        = UsniAdaptor::tablePrefix() . 'person';
        $addressTable       = UsniAdaptor::tablePrefix() . 'address';
        $orderPaymentTable  = UsniAdaptor::tablePrefix() . 'order_payment_details';
        $orderAddressDetailsTable   = UsniAdaptor::tablePrefix() . 'order_address_details';
        $sql              = "SELECT ti.*, tit.terms, 
                             ot.store_id, ot.unique_id AS order_unique_id, ot.currency_code,
                             pt.email, pt.mobilephone, 
                             at.country, 
                             stt.name AS store_name,
                             opt.shipping_fee, opt.tax, opt.total_including_tax, opt.payment_method, opt.payment_type,
                             oadt.email AS customer_email, oadt.mobilephone AS customer_mobilephone
                             FROM $tableName ti, $trTableName tit, "
                              . "$orderTable ot, $userTable ut, "
                              . "$storeTable st, $trStoreTable stt, $personTable pt, "
                              . "$addressTable at, $orderPaymentTable opt, "
                              . "$orderAddressDetailsTable oadt
                             WHERE ti.id = :id AND ti.id = tit.owner_id AND tit.language = :lan 
                             AND ti.order_id = ot.id AND ot.store_id = st.id
                             AND st.id = stt.owner_id AND stt.language = :slang
                             AND st.owner_id = ut.id AND ut.person_id = pt.id 
                             AND pt.id = at.relatedmodel_id AND at.relatedmodel = :rm AND at.type = :type 
                             AND ot.id = opt.order_id AND ot.id = oadt.order_id AND oadt.type = :oadtype";
        $params             = [':id' => $invoiceId, ':lan' => $language, ':slang' => $language, ':rm' => 'Person', ':type' => Address::TYPE_DEFAULT, 
                               ':oadtype' => Address::TYPE_BILLING_ADDRESS];
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Sends order emails
     * @param int $orderId
     * @param array|Model $history Order history
     * @param bool $fromHistory From add history screen
     * @return boolean
     */
    public static function sendMail($orderId, $history, $fromHistory = false)
    {
        //Receive complete order details in a single query for email
        $order              = self::getOrder($orderId);
        $status             = OrderStatusUtil::getLabel($order['status']);
        if($status != Order::STATUS_COMPLETED)
        {
            if($fromHistory)
            {
                $emailNotification = new OrderUpdateEmailNotification(['order' => $order, 'history' => $history]);
            }
            else
            {
                $emailNotification = new OrderReceivedEmailNotification(['order' => $order]);
            }
        }
        else
        {
            $emailNotification = new OrderCompletionEmailNotification(['order' => $order]);
        }
        $toAddress          = $order['email'];
        $mailer             = UsniAdaptor::app()->mailer;
        $mailer->emailNotification = $emailNotification;
        $message            = $mailer->compose();
        list($fromName, $fromAddress) = NotificationUtil::getSystemFromAddressData();
        $isSent             = $message->setFrom([$fromAddress => $fromName])
                            ->setTo($toAddress)
                            ->setSubject($emailNotification->getSubject())
                            ->send();
        $data               = serialize(array(
                                'fromName'    => $fromName,
                                'fromAddress' => $fromAddress,
                                'toAddress'   => $toAddress,
                                'subject'     => $emailNotification->getSubject(),
                                'body'        => $message->toString()));
        $sentStatus         = $isSent === true ? Notification::STATUS_SENT : Notification::STATUS_PENDING;
        //Save notification
        NotificationUtil::saveEmailNotification($emailNotification, $sentStatus, $data);
        return $sentStatus;
    }
    
    /**
     * Get store's orders.
     * 
     * @param $sid int
     * @return array
     */
    public static function getStoreOrders($sid = null)
    {
        if($sid == null)
        {
            $currentStore  = UsniAdaptor::app()->storeManager->getCurrentStore();
            $sid           = $currentStore->id;
        }
        $currentStore           = UsniAdaptor::app()->storeManager->getCurrentStore();
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $orderTable"]);
        $sql                    = "SELECT ot.*
                                   FROM $orderTable ot
                                   WHERE ot.store_id = :sid";
        $connection             = UsniAdaptor::app()->getDb();
        $records                = $connection->createCommand($sql, [':sid' => $sid])->cache(0, $dependency)->queryAll();
        return $records;
    }
    
    /**
     * Get concatenated address
     * @param Object|Array $addressModel
     * @return string
     */
    public static function getConcatenatedAddress($addressModel)
    {
        if(is_array($addressModel))
        {
            $addressModel = (object)$addressModel;
        }
        $address = "$addressModel->firstname $addressModel->lastname <br>";
        if($addressModel->address1 != null)
        {
            $address .= "$addressModel->address1 <br>";
        }
        if($addressModel->address2 != null)
        {
            $address .= "$addressModel->address2 <br>";
        }
        if($addressModel->city != null)
        {
            $address .= "$addressModel->city <br>";
        }
        if($addressModel->postal_code != null)
        {
            $address .= "$addressModel->postal_code <br>";
        }
        if($addressModel->state != null)
        {
            $address .= "$addressModel->state <br>";
        }
        if($addressModel->country != null)
        {
            $country = CountryUtil::getCountryName($addressModel->country);
            $address .= "$country <br>";
        }
        return $address;
    }
    
    /**
     * Get current store's orders for the customer
     * 
     * @param int $cid
     * @param int $sid
     * @return array
     */
    public static function getStoreOrdersForCustomer($cid, $sid = null)
    {
        if($sid == null)
        {
            $currentStore  = UsniAdaptor::app()->storeManager->getCurrentStore();
            $sid           = $currentStore->id;
        }
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $orderTable"]);
        $sql                    = "SELECT ot.*
                                   FROM $orderTable ot
                                   WHERE ot.store_id = :sid AND ot.customer_id = :cid";
        $connection             = UsniAdaptor::app()->getDb();
        $records                = $connection->createCommand($sql, [':sid' => $sid, ':cid' => $cid])->cache(0, $dependency)->queryAll();
        return $records;
    }
    
    /**
     * Get last order status
     * @param int $orderId
     * @return mixed
     */
    public static function getLastOrderStatus($orderId)
    {
        $historyTable           = UsniAdaptor::tablePrefix() . 'order_history';
        $sql                    = "SELECT *
                                   FROM $historyTable
                                   WHERE order_id = :oid ORDER BY created_datetime DESC";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':oid' => $orderId])->queryOne();
    }
    
    /**
     * Send notification
     * @return void
     */
    public static function shouldSendNotification($order)
    {
        $lastOrderStatus    = OrderUtil::getLastOrderStatus($order['id']);
        if($lastOrderStatus === false)
        {
            return true;
        }
        else
        {
            $finalStatus        = $order['status'];
            $completedStatus    = OrderStatusUtil::getStatusId(Order::STATUS_COMPLETED);
            if($lastOrderStatus['status'] != $finalStatus && ($completedStatus == $finalStatus))
            {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get latest order address by type.
     * @param integer $customerId
     * @param integer $type
     * @return array.
     */
    public static function getLatestOrderAddressByType($customerId, $type)
    {
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $orderAddressTable      = UsniAdaptor::tablePrefix() . 'order_address_details';
        $sql                    = "SELECT oad.*
                                   FROM $orderTable ot, $orderAddressTable oad
                                   WHERE ot.customer_id = :cid AND ot.id = oad.order_id AND oad.type = :type ORDER BY ot.created_datetime DESC LIMIT 1";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':cid' => $customerId, ':type' => $type];
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get transaction table to payment method map.
     * @param type $paymentMethod
     * @return string
     */
    public static function getTransactionTableToPaymentMethodMap($paymentMethod)
    {
        switch ($paymentMethod)
        {
            case 'paypal_standard' :
                return UsniAdaptor::tablePrefix() . 'paypal_standard_transaction';
            case 'cashondelivery' :
                return UsniAdaptor::tablePrefix() . 'cash_on_delivery_transaction';
        }
    }
    
    /**
     * Get order history.
     * @param integer $orderId
     * @return array.
     */
    public static function getOrderHistory($orderId, $language = null)
    {
        if($language == null)
        {
            $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $orderHistoryTable      = UsniAdaptor::tablePrefix() . 'order_history';
        $trOrderHistoryTable    = UsniAdaptor::tablePrefix() . 'order_history_translated';
        $sql                    = "SELECT oht.*, ohtt.owner_id, ohtt.comment
                                   FROM $orderHistoryTable oht, $trOrderHistoryTable ohtt
                                   WHERE oht.order_id = :oid AND oht.id = ohtt.owner_id AND ohtt.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':oid' => $orderId, ':lang' => $language];
        return $connection->createCommand($sql, $params)->queryAll();
    }
    
    /**
     * Get orders by attribute.
     * @param string $attribute
     * @param string $value
     * @param string $language
     * @return array.
     */
    public static function getOrdersByAttribute($attribute, $value, $language = null)
    {
        if($language == null)
        {
            $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $trOrderTable           = UsniAdaptor::tablePrefix() . 'order_translated';
        $sql                    = "SELECT ot.*
                                   FROM $orderTable ot, $trOrderTable ott
                                   WHERE ot." . $attribute  . "= :attr AND ot.id = ott.owner_id AND ott.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':attr' => $value, ':lang' => $language];
        $records                = $connection->createCommand($sql, $params)->queryAll();
        return $records;
    }
    
    /**
     * Get price in base currency.
     * @param float $price
     * @param  string $currencyCode
     * @return float
     */
    public static function getPriceByInBaseCurrency($price, $currencyCode, $conversionValue)
    {
        $defaultCurrencyCode    = UsniAdaptor::app()->currencyManager->getDefault();
        if($defaultCurrencyCode != $currencyCode)
        {
            $price              = $price / $conversionValue;
        }
        return number_format($price, 2, ".", "");
    }
    
    /**
     * Check if order allowed to perform action
     * @param integer $orderId
     * @return boolean
     */
    public static function checkIfOrderAllowedToPerformAction($orderId)
    {
        $orderIdArray   = [];
        $records        = self::getStoreOrders();
        foreach ($records as $records)
        {
            $orderIdArray[] = $records['id'];
        }
        if(!in_array($orderId, $orderIdArray))
        {
            return false;
        }
        return true;
    }
}
