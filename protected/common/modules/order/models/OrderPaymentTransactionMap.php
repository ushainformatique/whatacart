<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;

use usni\UsniAdaptor;
/**
 * OrderPaymentTransactionMap active record.
 * 
 * @package common\modules\order\models
 */
class OrderPaymentTransactionMap extends \usni\library\db\ActiveRecord 
{   
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['order_id', 'amount', 'transaction_record_id', 'payment_method'],  'required'],
                    [['order_id', 'amount', 'transaction_record_id', 'payment_method'],  'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = $scenarios['update'] = ['order_id', 'amount', 'transaction_record_id', 'payment_method'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                     'order_id'         => UsniAdaptor::t('order', 'Order'),
                     'amount'           => UsniAdaptor::t('order', 'Amount'),
                     'transaction_record_id'    => UsniAdaptor::t('order', 'Transaction Record'),
                     'payment_method'   => UsniAdaptor::t('payment', 'Payment Method')
                  ];
        return $labels;
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('order', 'Order Payment Transaction Map');
    }
}