<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing\models;

use yii\base\Model;
use usni\UsniAdaptor;
/**
 * SendMailForm class file.
 * 
 * @package common\modules\marketing\models
 */
class SendMailForm extends Model
{
    /**
     * Send mail To constant used in SendMail screen dropdown.
     */
    const ALL_CUSTOMERS                 = 1;
    const CUSTOMER_GROUP                = 2;
    const CUSTOMERS                     = 3;
    const PRODUCTS                      = 4;
    
    /**
     * Notification constants
     */
    const NOTIFY_SENDMAIL = 'sendMail';
    
    /**
     * Send mail event
     */
    const EVENT_SENDMAIL = 'sendMail';
    
    /**
     * Store customer id.
     * @var array
     */
    public $customer_id = [];
    
    /**
     * Store product id.
     * @var array
     */
    public $product_id  = [];
    
    /**
     * Store group id.
     * @var array
     */
    public $group_id  = [];
    
    /**
     * Contain mail subject
     * @var string
     */
    public $subject;
    
    /**
     * Contain mail content
     * @var string 
     */
    public $content;
    
    /**
     * Contain store id
     * @var int 
     */
    public $store_id;
    
    /**
     * Contain to email address.
     * @var int 
     */
    public $to;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['subject', 'content', 'store_id'],                'required'],
                    [['customer_id', 'group_id', 'product_id'],         'safe'],
                    [['id', 'subject', 'content', 'store_id', 'to'],    'safe'],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios          = parent::scenarios();
        $scenarios['send']  = ['subject', 'content', 'store_id', 'to', 'customer_id', 'group_id', 'product_id'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels =   [
                        'subject'       => UsniAdaptor::t('application', 'Subject'),
                        'content'       => UsniAdaptor::t('cms', 'Content'),
                        'store_id'      => UsniAdaptor::t('application', 'From'),
                        'to'            => UsniAdaptor::t('application', 'To'),
                        'customer_id'   => UsniAdaptor::t('customer', 'Customer'),
                        'group_id'      => UsniAdaptor::t('customer', 'Customer Group'),
                        'product_id'    => UsniAdaptor::t('products', 'Products'),
                    ];
        return $labels;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeHints()
	{
		$hints = [
                     'subject'  => UsniAdaptor::t('marketinghint', 'Set subject for the mail.'),
                     'store_id' => UsniAdaptor::t('marketinghint', 'Select store to send mail.'),
                 ];
        return $hints;
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('marketing', 'Send Mail') : UsniAdaptor::t('marketing', 'Send Mails');
    }
}
