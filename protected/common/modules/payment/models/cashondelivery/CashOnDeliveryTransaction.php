<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\models\cashondelivery;

use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
use common\modules\payment\utils\PaymentUtil;
/**
 * CashOnDeliveryTransaction class  file.
 *
 * @package common\modules\paypal\models
 */
class CashOnDeliveryTransaction extends ActiveRecord 
{
    /**
     * Total amount for the order
     * @var double 
     */
    public $totalAmount;
    
    /**
     * Already amount amount for the order
     * @var double 
     */
    public $alreadyPaidAmount;
    
    /**
     * Pending amount for the order
     * @var double 
     */
    public $pendingAmount;
    
    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            [['payment_status','transaction_id', 'amount', 'received_date', 'order_id'], 'required'],
            [['amount', 'transaction_fee'], 'number'],
            [['payment_status','transaction_id', 'transaction_fee', 'amount', 'totalAmount', 
                                                       'alreadyPaidAmount', 'pendingAmount', 'received_date', 'order_id'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = ['payment_status', 'transaction_id', 'transaction_fee', 'amount', 'totalAmount', 
                                                       'alreadyPaidAmount', 'pendingAmount', 'received_date', 'order_id'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() 
    {
        return PaymentUtil::getTransactionAttributeLabels();
    }
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return $n == 1 ? UsniAdaptor::t('payment', 'Cash On Delivery Transaction') : UsniAdaptor::t('payment', 'Cash On Delivery Transactions');
    }
}