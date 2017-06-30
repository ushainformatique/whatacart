<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\models\paypal_standard;

use usni\library\validators\EmailValidator;
use usni\UsniAdaptor;
/**
 * PaypalSetting class file.
 *
 * @package common\modules\payment\models\paypal_standard
 */
class PaypalSetting extends \yii\base\Model
{
    /**
     * @var string 
     */
    public $business_email;
    /**
     * @var string 
     */
    public $return_url;
    /**
     * @var string 
     */
    public $cancel_url;
    /**
     * @var string 
     */
    public $notify_url;
    /**
     * @var boolean 
     */
    public $sandbox;
    
    /**
     * Transaction type for paypal which could be sale or authorization
     * @var type 
     */
    public $transactionType;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_email', 'return_url', 'cancel_url', 'notify_url', 'transactionType'], 'required'],
            ['business_email',  EmailValidator::className()],
            [['business_email'], 'string', 'max' => 128],
            [['sandbox'], 'boolean'],
            [['return_url', 'cancel_url'], 'string', 'max' => 256],
            [['business_email', 'sandbox', 'return_url', 'cancel_url', 'notify_url', 'transactionType'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'business_email'    => UsniAdaptor::t('paypal', 'Business Email'),
                    'sandbox'           => UsniAdaptor::t('paypal', 'Sandbox Environment'),
                    'return_url'        => UsniAdaptor::t('paypal', 'Return Url'),
                    'cancel_url'        => UsniAdaptor::t('paypal', 'Cancel Url'),
                    'notify_url'        => UsniAdaptor::t('paypal', 'Notify Url'),
                    'transactionType'   => UsniAdaptor::t('paypal', 'Transaction Type'),
               ];
    }
    
    /**
     * Gets attribute hints.
     * @return array
     */
    public function attributeHints()
    {
        return [
                    'business_email'    => UsniAdaptor::t('paypalhint', 'Business email for the paypal account'),
                    'sandbox'           => UsniAdaptor::t('paypalhint', 'Enable sandbox'),
                    'return_url'        => UsniAdaptor::t('paypalhint', 'Return Url after the order is successfully placed'),
                    'cancel_url'        => UsniAdaptor::t('paypalhint', 'Cancel Url after the order is cancelled'),
                    'notify_url'        => UsniAdaptor::t('paypalhint', 'Notify Url where IPN response messages would be sent'),
                    'transactionType'   => UsniAdaptor::t('paypalhint', 'Transaction type for paypal Sale or Authorization')
               ];
    }
}
