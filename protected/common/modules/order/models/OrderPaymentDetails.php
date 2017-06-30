<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;

use usni\UsniAdaptor;
/**
 * OrderPaymentDetails active record.
 *
 * @package common\modules\Order\models
 */
class OrderPaymentDetails extends \usni\library\db\TranslatableActiveRecord 
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['payment_method'],                            'required'],
                    [['order_id', 'payment_method', 'total_including_tax', 'tax', 'payment_type', 'comments', 'shipping_fee'],   'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = $scenarios['update'] = ['order_id', 'payment_method', 'total_including_tax', 'tax', 'payment_type', 'comments', 'shipping_fee'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                     'order_id'         => UsniAdaptor::t('order', 'Order'),
                     'payment_method'   => UsniAdaptor::t('payment', 'Payment Method'),
                     'total_including_tax'  => UsniAdaptor::t('order', 'Total Including Tax'),
                     'tax'              => UsniAdaptor::t('tax', 'Tax'),
                     'payment_type'     => UsniAdaptor::t('payment', 'Payment Type'),
                     'comments'         => UsniAdaptor::t('order', 'Comments'),
                     'shipping_fee'     => UsniAdaptor::t('shipping', 'Shipping Fee'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('order', 'Order Payment') : UsniAdaptor::t('order', 'Order Payments');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['comments'];
    }
}