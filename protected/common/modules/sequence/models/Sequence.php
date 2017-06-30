<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\sequence\models;

use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
/**
 * Sequence active record.
 * 
 * @package common\modules\Order\models
 */
class Sequence extends ActiveRecord 
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['invoice_sequence_no', 'customer_sequence_no', 'order_sequence_no'],      'required'],
                    ['invoice_sequence_no', 'string'],
                    [['invoice_sequence_no', 'customer_sequence_no', 'order_sequence_no'],      'safe']
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios              = parent::scenarios();
        $scenarios['create']     = ['invoice_sequence_no', 'customer_sequence_no', 'order_sequence_no'];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                     'invoice_sequence_no'		=> UsniAdaptor::t('sequence', 'Invoice Sequence Number'),
                     'customer_sequence_no'		=> UsniAdaptor::t('sequence', 'Customer Sequence Number'),
                     'order_sequence_no'		=> UsniAdaptor::t('sequence', 'Order Sequence Number'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('sequence', 'Sequence') : UsniAdaptor::t('sequence', 'Sequences');
    }
}