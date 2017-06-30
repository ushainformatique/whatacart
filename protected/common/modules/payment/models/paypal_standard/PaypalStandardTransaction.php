<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\models\paypal_standard;

use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
use common\modules\payment\utils\PaymentUtil;
/**
 * PaypalStandardTransaction class  file.
 *
 * @package common\modules\payment\models\paypal_standard
 */
class PaypalStandardTransaction extends ActiveRecord 
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
            [['payment_status','transaction_id', 'amount', 'received_date', 'order_id', 'transaction_fee'], 'required'],
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
        $scenario['create']     = $scenario['update'] = ['payment_status', 'transaction_id', 'transaction_fee', 'amount', 'totalAmount', 
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
        return $n == 1 ? UsniAdaptor::t('paypal', 'Paypal Transaction') : UsniAdaptor::t('paypal', 'Paypal Transactions');
    }
}