<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use customer\models\Customer;
use usni\library\modules\users\models\Address;
use common\modules\stores\models\Store;
use common\modules\order\models\Invoice;
use common\modules\order\business\Manager as OrderManager;
use yii\db\Exception;
use usni\library\modules\users\models\User;
/**
 * Order active record.
 *
 * @package common\modules\Order\models
 */
class Order extends TranslatableActiveRecord 
{
    use \common\modules\sequence\traits\SequenceTrait;
    use \common\modules\order\traits\OrderTrait;
    
    /**
     * Order status constants
     */
    const STATUS_CANCELLED              = 'Cancelled';
    const STATUS_CANCELLED_REVERSAL     = 'Canceled_Reversal';
    const STATUS_CHARGEBACK             = 'Chargeback';
    const STATUS_COMPLETED              = 'Completed';
    const STATUS_DENIED                 = 'Denied';
    const STATUS_EXPIRED                = 'Expired';
    const STATUS_FAILED                 = 'Failed';
    const STATUS_PENDING                = 'Pending';
    const STATUS_PROCESSED              = 'Processed';
    const STATUS_PROCESSING             = 'Processing';
    const STATUS_REFUNDED               = 'Refunded';
    const STATUS_REVERSED               = 'Reversed';
    const STATUS_SHIPPED                = 'Shipped';
    const STATUS_VOIDED                 = 'Voided';
    
    /**
     * Notification constants
     */
    const NOTIFY_ORDERCOMPLETION    = 'orderCompletion';
    const NOTIFY_ORDERRECEIVED      = 'orderReceived';
    const NOTIFY_ORDERUPDATE        = 'orderUpdate';
    
    /**
     * Events
     */
    CONST EVENT_NEW_ORDER_CREATED   = 'newOrderCreated';
    CONST EVENT_ORDER_STATUS_UPDATE = 'orderStatusUpdated';
    CONST EVENT_ORDER_COMPLETED     = 'orderCompleted';
    CONST EVENT_AFTER_ADDING_HISTORY = 'afterAddingOrderHistory';
    CONST EVENT_AFTER_ORDER_POPULATION = "afterOrderPopulation";
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['status', 'store_id'], 'number', 'integerOnly' => true],
                    ['shipping_fee', 'default', 'value' => 0],
                    [['id', 'customer_id', 'shipping', 'shipping_comments', 'status', 'store_id', 'shipping_fee', 'unique_id'],   'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = $scenarios['update'] = ['customer_id', 'shipping', 'shipping_comments', 'status', 'store_id', 'shipping_fee', 'unique_id'];
        $scenarios['bulkedit'] = ['status'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                     'customer_id'          => UsniAdaptor::t('customer', 'Customer'),
                     'shipping'             => UsniAdaptor::t('shipping', 'Shipping'),
                     'shipping_comments'    => UsniAdaptor::t('shipping', 'Shipping Comments'),
                     'shipping_fee'        => UsniAdaptor::t('shipping', 'Shipping Fees'),
                     'status'               => UsniAdaptor::t('application', 'Status'),
                     'store_id'             => UsniAdaptor::t('stores', 'Store')
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('order', 'Order') : UsniAdaptor::t('order', 'Orders');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['shipping_comments'];
    }
    
    /**
     * Get customer for the order.
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
    
    /**
     * Get billing address for the order.
     * @return \OrderAddressDetails
     */
    public function getBillingAddress()
    {
        return $this->hasOne(OrderAddressDetails::className(), ['order_id' => 'id'])
                    ->where('type = :type', [':type' => Address::TYPE_BILLING_ADDRESS]);
    }
    
    /**
     * Get shipping address for the order.
     * @return \OrderAddressDetails
     */
    public function getShippingAddress()
    {
        return $this->hasOne(OrderAddressDetails::className(), ['order_id' => 'id'])
                    ->where('type = :type', [':type' => Address::TYPE_SHIPPING_ADDRESS]);
    }
    
    /**
     * Get order payment details for the order.
     * @return \OrderPaymentDetails
     */
    public function getOrderPaymentDetails()
    {
        return $this->hasOne(OrderPaymentDetails::className(), ['order_id' => 'id']);
    }
    
    /**
     * Get store for the order.
     * @return \Store
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }
    
    /**
     * Get products for the order.
     * @return \OrderProducts
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->unique_id == 0 || $this->unique_id == null)
            {
                $this->unique_id = $this->getUniqueId('order_sequence_no');
                $this->updateSequenceNumber('order_sequence_no');
            }
            return true;
        }
        return false;
    }
    
    /**
     * Get invoices for the order.
     * @return \OrderProducts
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['order_id' => 'id']);
    }
    
    /**
     * Add  order history.
     * @param string $comment
     * @param boolean $notifyCustomer
     */
    public function addHistory($comment, $notifyCustomer = true)
    {
        $this->saveOrderHistory($this, $comment, $notifyCustomer);
    }
    
    /**
     * inheritdoc
     */
    public function beforeDelete()
    {
        $isValidOrder   = OrderManager::getInstance()->isValidOrderId($this->id);
        if($isValidOrder == false)
        {
            throw new Exception('this order is not valid.');
        }
        return parent::beforeDelete();
    }
    
    /**
     * @inheritdoc
     */
    public function updateAuthorField($userField)
    {
        //If interface is admin then created_by and modified_by should not be logged in user. it should be customer.
        $isInstalled    = UsniAdaptor::app()->installed;
        if(!$isInstalled)
        {
           $this->$userField = User::SUPER_USER_ID;
        }
        else
        {
            $this->$userField = $this->customer_id;
        }
    }
}