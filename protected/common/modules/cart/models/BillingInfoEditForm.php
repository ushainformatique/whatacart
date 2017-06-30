<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\validators\EmailValidator;
use usni\library\modules\users\models\Address;
use usni\library\modules\users\models\Person;
use usni\library\utils\ArrayUtil;
use usni\library\modules\users\utils\UserUtil;
use common\modules\order\models\OrderAddressDetails;
/**
 * BillingInfoEditForm class file
 * 
 * @package cart\models
 */
class BillingInfoEditForm extends Model
{
    //Person fields
    public $email;
    public $firstname;
    public $lastname;
    public $mobilephone;
    public $officephone;
    //Address fields
    public $address1;
    public $city;
    public $country;
    public $postal_code;
    public $address2;
    public $state;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array(
            //Person rules
            [['firstname', 'lastname'],         'string', 'max' => 32],
            ['email',                           'required'],
            ['email',                           EmailValidator::className()],
            ['mobilephone',                     'number'],
            //Address rules
            [['address1', 'city', 'country', 'postal_code', 'firstname', 'lastname', 'mobilephone'], 'required'],
            [['address1', 'address2'],          'string', 'max' => 128],
			[['city', 'state', 'country'],      'string', 'max' => 64],
			[['firstname', 'lastname', 'address1', 'city', 'country', 'postal_code', 'state', 'address2', 'email', 'officephone', 'mobilephone'],  'safe'],
        );
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('cart', 'Billing Details');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayUtil::merge(UserUtil::getPersonLabels(), UserUtil::getAddressLabels());
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        $person     = new Person();
        $address    = new Address();
        return ArrayUtil::merge($person->attributeHints(), $address->attributeHints());
    }
    
    /**
     * Get concatenated address
     * @return string
     */
    public function getConcatenatedAddress()
    {
        $orderAddressDetails = new OrderAddressDetails();
        $orderAddressDetails->attributes = $this->getAttributes();
        return $orderAddressDetails->getConcatenatedDisplayedAddress();
    }
}