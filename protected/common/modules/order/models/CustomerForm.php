<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */ 
namespace common\modules\order\models;

use yii\base\Model;
use usni\UsniAdaptor;
use common\modules\order\models\Order;
/**
 * CustomerForm class file
 *
 * @package common\modules\order\models
 */
class CustomerForm extends Model
{
    /**
     * Associated customer id
     * @var int 
     */
    public $customerId;
    
    /**
     * Associated store id
     * @var int 
     */
    public $storeId;
    
    /**
     * Associated currency code
     * @var string 
     */
    public $currencyCode;
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customerId'    => UsniAdaptor::t('customer', 'Customer'),
            'storeId'       => UsniAdaptor::t('stores', 'Store'),
            'currencyCode'  => UsniAdaptor::t('currency', 'Currency')
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerId', 'storeId', 'currencyCode'], 'required'],
            [['customerId', 'storeId', 'currencyCode'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios                  = parent::scenarios();
        $scenarios['create']        = $scenarios['update'] = ['customerId', 'storeId', 'currencyCode'];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return Order::getLabel($n);
    }
}