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
use customer\utils\CustomerUtil;
use common\modules\sequence\utils\SequenceUtil;
use usni\library\modules\users\utils\UserUtil;
use common\modules\order\models\Order;
/**
 * Customer is the base class for table tbl_customer.
 *
 * @package customer\models
 */
class Customer extends User
{
    const AUTH_IDENTITY_TYPE_CUSTOMER  = 'customer';
    
    /**
     * Notification constants
     */
    const NOTIFY_CREATECUSTOMER    = 'createCustomer';
    
    /**
     * Guest customer id
     */
    const GUEST_CUSTOMER_ID        = 0;
    
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
            $rules = [
                        [['username'],          'required',  'except' => 'bulkedit'],
                        [['groups'],            'required',  'except' => ['bulkedit', 'editprofile']],
                        ['username',            'trim'],
                        ['username',            'unique', 'targetClass' => static::getTargetClassForUniqueUsername(), 'on' => ['create', 'registration']],
                        ['username', 'unique', 'targetClass' => static::getTargetClassForUniqueUsername(), 'filter' => ['!=', 'id', $this->id], 'on' => 'update'],
                        ['username',                        'match', 'pattern' => '/^[A-Z0-9._]+$/i'],
                        //@see http://www.zorched.net/2009/05/08/password-strength-validation-with-regular-expressions/
                        ['password',                        'match', 'pattern' => '/^((?=.*\d)(?=.*[a-zA-Z])(?=.*\W).{6,20})$/i'],
                        ['password',                        'required', 'on' => ['create', 'registration']],
                        ['timezone',                        'required', 'except' => ['registration', 'default']],
                        ['confirmPassword',                 'required', 'on' => ['create', 'registration']],
                        ['status',                          'default', 'value' => User::STATUS_PENDING],
                        ['groups',                          'safe'],
                        [['confirmPassword'], 'compare', 'compareAttribute' => 'password', 'on' => ['create', 'registration']],
                        ['unique_id', 'safe'],
                     ];
            return $rules;
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
    public static function getScenarioToNotificationKeyMapping()
    {
        $mappingData = [
                            'create'            => Customer::NOTIFY_CREATECUSTOMER,
                            'registration'      => Customer::NOTIFY_CREATECUSTOMER,
                            'changepassword'    => Customer::NOTIFY_CHANGEPASSWORD,
                            'forgotpassword'    => Customer::NOTIFY_FORGOTPASSWORD
                       ];
        return $mappingData;
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
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $customerMetadata = CustomerMetadata::find()->where('customer_id = :cId', [':cId' => $this->id])->one();
        $currency         = UsniAdaptor::app()->currencyManager->getDisplayCurrency();
        $language         = UsniAdaptor::app()->languageManager->getContentLanguage();
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
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->scenario == 'create' || $this->scenario == 'registration')
            {
                $this->unique_id = CustomerUtil::getUniqueId();
                SequenceUtil::updateSequenceNumber('customer_sequence_no');
            }
            return true;
        }
        return false;
    }
    
    /**
     * Get address for the customer.
     * @return ActiveQuery
     */
    public function getAddress()
    {
        //Read it as select * from address, person where address.relatedmodel_id = person.id  AND person.id = customer.person_id
        //Thus when via is used second param in the link correspond to via column in the relation.
        return $this->hasOne(Address::className(), ['relatedmodel_id' => 'id'])
                    ->where('relatedmodel = :rm AND type = :type', [':rm' => 'Person', ':type' => Address::TYPE_DEFAULT])
                    ->via('person');
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        if($this->checkIfExtendedConfigExists())
        {
            $configInstance = $this->getExtendedConfigClassInstance();
            return $configInstance->attributeLabels();
        }
        else
        {
            return parent::attributeLabels();
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        if($this->checkIfExtendedConfigExists())
        {
            $configInstance = $this->getExtendedConfigClassInstance();
            return $configInstance->attributeHints();
        }
        else
        {
            return parent::attributeHints();
        }
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            UserUtil::deleteGroupsForUser($this);
            $person     = $this->person;
            $address    = $this->address;
            $person->delete();
            $address->delete();
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
        else
        {
            return false;
        }
    }
}
?>