<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
/**
 * OrderHistory class file.
 *
 * @package common\modules\Order\models
 */
class OrderHistory extends TranslatableActiveRecord 
{
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['order_id', 'status'],   'required'],
                    [['order_id', 'status', 'notify_customer', 'comment'],   'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = $scenarios['update'] = ['order_id', 'status', 'notify_customer', 'comment'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                     'order_id'         => UsniAdaptor::t('order', 'Order'),
                     'status'           => UsniAdaptor::t('orderstatus', 'Order Status'),
                     'notify_customer'  => UsniAdaptor::t('customer', 'Notify Customer'),
                     'comment'          => UsniAdaptor::t('application', 'Comment'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'notify_customer'   => UsniAdaptor::t('orderhint', 'Customer would be notified if status is completed.'),
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('order', 'Order History');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
       return ['comment'];
    }
}