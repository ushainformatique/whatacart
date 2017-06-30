<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
use customer\models\CustomerMetadata;
use usni\library\modules\users\models\Address;
use usni\library\utils\ArrayUtil;
use common\modules\order\models\Order;
use usni\library\db\ActiveRecord;
use usni\library\modules\auth\web\IAuthIdentity;
/**
 * Customer is the base class for table tbl_customer.
 *
 * @package customer\models
 */
class Customer extends ActiveRecord implements IAuthIdentity
{
    use \common\modules\sequence\traits\SequenceTrait;
    use \usni\library\modules\users\traits\AuthIdentityTrait;
    
    const AUTH_IDENTITY_TYPE_CUSTOMER  = 'customer';
    
    /**
     * Misc constants.
     */
    const STATUS_PENDING    = 2;
    
    /**
     * Notification constants
     */
    const NOTIFY_CREATECUSTOMER    = 'createCustomer';
    const NOTIFY_CHANGEPASSWORD    = 'changepassword';
    const NOTIFY_FORGOTPASSWORD    = 'forgotpassword';
    
    /**
     * Guest customer id
     */
    const GUEST_CUSTOMER_ID        = 0;
    
    /**
     * Change password event
     */
    const EVENT_CHANGE_PASSWORD = 'changePassword';
    
    /**
     * @var string 
     */
    public $groupType = 'customer';
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('customer', 'Customer') : UsniAdaptor::t('customer', 'Customers');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        if($this->checkIfExtendedConfigExists())
        {
            $configInstance = $this->getExtendedConfigClassInstance();
            $rules          = $configInstance->rules();
            return $rules;
        }
        else
        {
            return [
                            [['username'],          'required',  'except' => 'bulkedit'],
                            [['groups'],            'required',  'except' => ['bulkedit', 'editprofile']],
                            ['username',            'trim'],
                            ['username',            'unique', 'targetClass' => get_class($this), 'on' => ['create', 'registration']],
                            ['username', 'unique', 'targetClass' => get_class($this), 'filter' => ['!=', 'id', $this->id], 'on' => 'update'],
                            ['username',                        'match', 'pattern' => '/^[A-Z0-9._]+$/i'],
                            //@see http://www.zorched.net/2009/05/08/password-strength-validation-with-regular-expressions/
                            ['password',                        'match', 'pattern' => '/^((?=.*\d)(?=.*[a-zA-Z])(?=.*\W).{6,20})$/i'],
                            ['password',                        'required', 'on' => ['create', 'registration']],
                            ['timezone',                        'required', 'except' => ['registration', 'default', 'bulkedit']],
                            ['confirmPassword',                 'required', 'on' => ['create', 'registration']],
                            ['status',                          'default', 'value' => User::STATUS_PENDING],
                            ['groups',                          'safe'],
                            [['confirmPassword'], 'compare', 'compareAttribute' => 'password', 'on' => ['create', 'registration']],
                            ['unique_id', 'safe'],
                         ];        
        }
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        if($this->checkIfExtendedConfigExists())
        {
            $configInstance = $this->getExtendedConfigClassInstance();
            $scenarios      = $configInstance->scenarios();
            return $scenarios;
        }
        else
        {
            $scenarios                  = parent::scenarios();
            $commonAttributes           = ['username','timezone', 'status', 'groups'];
            $scenarios['create']        = $scenarios['registration'] = ArrayUtil::merge($commonAttributes, ['password', 'confirmPassword']);
            $scenarios['update']        = $scenarios['editprofile']  = $commonAttributes;
            $scenarios['bulkedit']      = ['timezone', 'status', 'groups'];
            return $scenarios;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthType()
    {
        return self::AUTH_IDENTITY_TYPE_CUSTOMER;
    }
    
    /**
     * Get billing address for the person.
     * @return \Address
     */
    public function getBillingAddress()
    {
        return $this->hasOne(Address::className(), ['relatedmodel_id' => 'person_id'])
                    ->where('relatedmodel = :rm AND type = :type', [':rm' => 'Person', ':type' => Address::TYPE_BILLING_ADDRESS]);
    }
    
    /**
     * Get shipping address for the person.
     * @return \Address
     */
    public function getShippingAddress()
    {
        return $this->hasOne(Address::className(), ['relatedmodel_id' => 'person_id'])
                    ->where('relatedmodel = :rm AND type = :type', [':rm' => 'Person', ':type' => Address::TYPE_SHIPPING_ADDRESS]);
    }
    
    /**
     * Get metadata for the customer.
     * @return CustomerMetadata
     */
    public function getMetadata()
    {
        return $this->hasOne(CustomerMetadata::className(), ['customer_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->scenario == 'create' || $this->scenario == 'registration')
            {
                $this->unique_id = $this->getUniqueId('customer_sequence_no');
                $this->updateSequenceNumber('customer_sequence_no');
            }
            return true;
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            $this->processBeforeDelete();
            CustomerMetadata::deleteAll('customer_id = :cid', [':cid' => $this->id]);
            $orders = Order::find()->where('customer_id = :cid', [':cid' => $this->id])->all();
            if(!empty($orders))
            {
                foreach($orders as $order)
                {
                    $order->delete();
                }
            }
            return true;
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->saveGroups($this->groupType);
        $customerMetadata = CustomerMetadata::find()->where('customer_id = :cId', [':cId' => $this->id])->one();
        $currency         = UsniAdaptor::app()->currencyManager->selectedCurrency;
        $language         = UsniAdaptor::app()->languageManager->selectedLanguage;
        if($customerMetadata == null)
        {
            $customerMetadata = new CustomerMetadata();
            $customerMetadata->customer_id  = $this->id;
            $customerMetadata->cart         = serialize([]);
            $customerMetadata->wishlist     = serialize([]);
            $customerMetadata->compareproducts      = serialize([]);
            $customerMetadata->language             = $language;
            $customerMetadata->currency             = $currency;
            $customerMetadata->save();
        }
    }
}