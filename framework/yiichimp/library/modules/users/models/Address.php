<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\models;

use usni\library\db\ActiveRecord;
use usni\library\utils\CountryUtil;
use usni\UsniAdaptor;
use usni\library\modules\users\utils\UserUtil;
use common\modules\localization\modules\country\models\Country;
use usni\library\utils\ArrayUtil;
/**
 * This is the model class for table "tbl_address".
 * 
 * @package usni\library\modules\users\models
 */
class Address extends ActiveRecord
{
    const TYPE_DEFAULT          = 1;
    const TYPE_SHIPPING_ADDRESS = 2;
    const TYPE_BILLING_ADDRESS  = 3;

    /**
     * Store verifyCode for person model.
     * @var mixed
     */
    public $verifyCode;
    
    /**
     * Store shipping address as billing address.
     * @var boolean
     */
    public $useBillingAddress;
    
    /**
     * Address in concatenated format.
     * @var string
     */
    public $concatenatedAddress;


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
                        //Address rules
                        [['address1', 'city', 'country', 'postal_code'],    'required', 'except' => 'bulkedit'],
                        [['address1', 'address2', 'relatedmodel'],          'string', 'max' => 128],
                        [['city', 'state', 'country'],                      'string', 'max' => 64],
                        [['relatedmodel_id', 'status'],                     'number', 'integerOnly' => true],
                        ['type',                                            'default', 'value' => static::getType()],
                        ['status',                                          'default', 'value' => self::STATUS_ACTIVE],
                        [['country', 'postal_code', 'state', 'address1', 'address2', 'relatedmodel_id', 'type', 'status', 'city', 'relatedmodel'],  'safe'],
                    ];
        }
    }
    
    /**
     * Get type of address.
     * @return int
     */
    public static function getType()
    {
        return Address::TYPE_DEFAULT;
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
            $commonAttributes           = ['country', 'postal_code', 'state', 'address1', 'address2', 'relatedmodel_id', 'type', 'status', 'city', 'relatedmodel'];
            $scenarios['create']        = $commonAttributes;
            $scenarios['update']        = $commonAttributes;
            $scenarios['supercreate']   = $scenarios['registration'] = $scenarios['editprofile'] = $commonAttributes;
            $scenarios['bulkedit']      = ['city', 'country', 'postal_code', 'state'];
            return $scenarios;
        }
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
        if($this->checkIfExtendedConfigExists())
        {
            $configInstance = $this->getExtendedConfigClassInstance();
            $labels         = $configInstance->attributeLabels();
        }
        else
        {
            $labels = ArrayUtil::merge(parent::attributeLabels(), UserUtil::getAddressLabels());
        }
        return parent::getTranslatedAttributeLabels($labels);
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
            return [
                        'address1'      => UsniAdaptor::t('users', 'Address first line'),
                        'address2'      => UsniAdaptor::t('users', 'Address second line'),
                        'city'          => UsniAdaptor::t('city', 'City'),
                        'country'       => UsniAdaptor::t('country', 'Country'),
                        'postal_code'   => UsniAdaptor::t('users', 'Postal Code'),
                        'state'         => UsniAdaptor::t('state', 'State'),
                        'status'        => UsniAdaptor::t('users', 'Status for the address i.e. if it is valid or not.'),
                    ];
        }
    }
    
    /**
     * Get country model
     * @return \Country
     */
    public function getCountryModel()
    {
        return $this->hasOne(Country::className(), ['iso_code_2' => 'country']);
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('users', 'Address') : UsniAdaptor::t('users', 'Addresses');
    }
    
    /**
     * Get concatenated displayed address
     * @return string
     */
    public function getConcatenatedDisplayedAddress()
    {
        $address = "$this->address1 <br>";
        if($this->address2 != null)
        {
            $address .= "$this->address2 <br>";
        }
        if($this->city != null)
        {
            $address .= "$this->city <br>";
        }
        if($this->postal_code != null)
        {
            $address .= "$this->postal_code <br>";
        }
        if($this->state != null)
        {
            $address .= "$this->state <br>";
        }
        if($this->country != null)
        {
            $country = CountryUtil::getCountryName($this->country);
            $address .= "$country <br>";
        }
        return $address;
    }
}