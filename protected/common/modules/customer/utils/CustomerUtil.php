<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\utils;

use usni\library\modules\auth\managers\AuthManager;
use customer\models\Customer;
use usni\library\modules\users\models\ChangePasswordForm;
use usni\library\utils\FlashUtil;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\modules\users\models\Address;
use yii\base\Model;
use usni\library\utils\CacheUtil;
use customer\utils\CustomerPermissionUtil;
use usni\library\utils\FileUploadUtil;
use usni\library\managers\UploadInstanceManager;
use common\modules\sequence\models\Sequence;
use yii\caching\DbDependency;
use usni\library\modules\auth\models\Group;
use usni\library\modules\auth\models\GroupTranslated;
use taxes\utils\TaxUtil;
use usni\library\utils\TimezoneUtil;
use usni\library\modules\users\models\User;
use taxes\managers\ZoneDataManager;
use customer\models\CustomerEditForm;
use usni\library\modules\users\models\Person;
use products\utils\ProductUtil;
/**
 * Contains utility functions related to Customer.
 *
 * @package customer\utils
 */
class CustomerUtil
{
    /**
     * Gets customer groups.
     * @param int $customerId
     * @return array
     */
    public static function getCustomerGroups($customerId)
    {
        return AuthManager::getUserGroups($customerId, Customer::className());
    }
    
    /**
     * Validate and save Customer data.
     * @param CustomerEditForm $model
     * @return boolean
     */
    public static function validateAndSaveCustomerData($model)
    {
        if(Model::validateMultiple([$model->customer, $model->person, $model->address]))
        {
            $transaction = UsniAdaptor::app()->db->beginTransaction();
            try
            {
                $model->person->savedImage = $model->person->profile_image;
                $config = [
                                'model'             => $model->person,
                                'attribute'         => 'profile_image',
                                'uploadInstanceAttribute' => 'uploadInstance',
                                'type'              => 'image',
                                'savedAttribute'    => 'savedImage',
                                'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                          ];
                $uploadInstanceManager = new UploadInstanceManager($config);
                $result = $uploadInstanceManager->processUploadInstance();
                if($result === false)
                {
                    return false;
                }
                if($model->person->save(false))
                {
                    if($model->person->profile_image != null)
                    {
                        $config = [
                                        'model'             => $model->person, 
                                        'attribute'         => 'profile_image', 
                                        'uploadInstance'    => $model->person->uploadInstance, 
                                        'savedFile'         => $model->person->savedImage
                                  ];
                        FileUploadUtil::save('image', $config);
                    }
                    $model->customer->person_id             = $model->person->id;
                    if($model->customer->groups != null && !is_array($model->customer->groups))
                    {
                        $model->customer->groups = [$model->customer->groups];
                    }
                    if($model->customer->isNewRecord)
                    {
                        $model->customer->setPasswordHash($model->customer->password);
                        $model->customer->generateAuthKey();
                    }
                    if($model->customer->save(false))
                    {
                        if($model->address != null)
                        {
                            $model->address->relatedmodel       = 'Person';
                            $model->address->relatedmodel_id    = $model->person->id;
                            if($model->address->save(false))
                            {
                                $transaction->commit();
                                return true;
                            }
                            else
                            {
                                $transaction->rollBack();
                                return false;
                            }
                        }
                        $transaction->commit();
                        return true;
                    }
                    else
                    {
                        $transaction->rollBack();
                        return false; 
                    }
                }
                else
                {
                    $transaction->rollBack();
                    return false; 
                }
            }
            catch (yii\db\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
        }
        return false;
    }
    
    /**
     * Process change password action.
     * @param int $id
     * @param Array $postData
     */
    public static function processChangePasswordAction($id, $postData, $loggedInUserModel, $interface = 'admin')
    {
        $customer       = Customer::findOne($id);
        $isPermissible  = CustomerPermissionUtil::doesUserHavePermissionToPerformAction($customer, $loggedInUserModel, 'customer.change-password');
        if($isPermissible)
        {
            $model           = new ChangePasswordForm(['user' => $customer]);
            if ($model->load($postData) && $model->validate() && $model->resetPassword())
            {
                if($interface == 'admin')
                {
                    $model->sendMail();
                }
                FlashUtil::setMessage('changepassword', UsniAdaptor::t('userflash', 'Password changed successfully.'));
                //Set to null
                $model->newPassword     = null;
                $model->confirmPassword = null;
            }
            return $model;
        }
        return false;
    }
    
    /**
     * Get metadata items for the customer.
     * @param string $key
     * @return array
     */
    public static function getMetadataItems($key)
    {
        $customer         = UsniAdaptor::app()->user->getUserModel();
        $customerMetadata = $customer->metadata;
        $metadata         = UsniAdaptor::app()->guest->$key;
        $itemsList        = $metadata->itemsList;
        //Populate cart info
        if($customerMetadata != null)
        {
            if(!empty($customerMetadata->$key))
            {
                $itemsList = unserialize($customerMetadata->$key);
            }
            $itemsList = ArrayUtil::merge($itemsList, $metadata->itemsList);
        }
        return $itemsList;
    }
    
    /**
     * Get default customer group title.
     * @return string
     */
    public static function getDefaultGroupTitle()
    {
        return Customer::getLabel(1);
    }
    
    /**
     * Get address type dropdown.
     * @return array
     */
    public static function getAddressTypeDropdown()
    {
        return [
                    Address::TYPE_SHIPPING_ADDRESS  => UsniAdaptor::t('customer', 'Shipping Address'),
                    Address::TYPE_BILLING_ADDRESS   => UsniAdaptor::t('customer', 'Billing Address'),
                    Address::TYPE_DEFAULT           => UsniAdaptor::t('customer', 'Default Address')
               ];
    }
    
    /**
     * Get address by type.
     * @param Customer $customer
     * @param string $type
     * @return ActiveQuery
     */
    public static function getAddressByType($customer, $type)
    {
        $table  = UsniAdaptor::tablePrefix() . 'address';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql    = "SELECT * FROM $table WHERE relatedmodel_id = :rid AND type = :type AND relatedmodel = :rmodel";
        $params = [':rid' => $customer->person->id, ':type' => $type, ':rmodel' => 'Person'];
        return UsniAdaptor::app()->db->createCommand($sql, $params)->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Gets dropdown field select data.
     * @return array
     */
    public static function getDropdownDataBasedOnModel()
    {
        $key    = 'CustomerDropdownList';
        $data   = CacheUtil::get($key);
        if($data === false)
        {
            $data = ArrayUtil::map(Customer::find()->asArray()->indexBy('username')->all(), 'id', 'username');
            CacheUtil::set($key, $data);
            CacheUtil::setModelCache('Customer', $key);
        }
        return $data;
    }
    
    /**
     * Get customer id.
     * @return string
     */
    public static function getUniqueId()
    {
        $sequence       = Sequence::find()->one();
        return intval($sequence->customer_sequence_no) + 1;
    }
    
    /**
     * Get child customer groups
     * @return array
     */
    public static function getChildCustomerGroups()
    {
        $groupTable     = UsniAdaptor::tablePrefix() . 'group';
        $groupTrTable   = UsniAdaptor::tablePrefix() . 'group_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $groupTable"]);
        $sql            = "SELECT tg.*, tgt.name FROM $groupTable tg, $groupTrTable tgt
                            WHERE tg.id = tgt.owner_id AND tg.parent_id = (SELECT tgt2.owner_id FROM tbl_group_translated tgt2 WHERE tgt2.name = :name
                            AND tgt2.language = :lan)";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':lan' => 'en-US', ':name' => CustomerUtil::getDefaultGroupTitle()])->cache(0, $dependency)->queryAll(); 
    }
    
    /**
     * Get customer group by name
     * @param string $name
     * @param string $language
     * @return array
     */
    public static function getCustomerGroupByName($name, $language = null)
    {
        if($language == null)
        {
            $language = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $groupTable     = UsniAdaptor::tablePrefix() . 'group';
        $groupTrTable   = UsniAdaptor::tablePrefix() . 'group_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $groupTable"]);
        $sql            = "SELECT tg.*, tgt.name FROM $groupTable tg, $groupTrTable tgt
                            WHERE tgt.name = :name AND tgt.language = :lan AND tgt.owner_id = tg.id";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':lan' => $language, ':name' => $name])->cache(0, $dependency)->queryOne(); 
    }
    
    /**
     * Get customer by email
     * @param string $email
     * @return array
     */
    public static function getCustomerByEmail($email)
    {
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = $connection->tablePrefix . 'customer';
        $peTableName            = $connection->tablePrefix . 'person';
        $adTableName            = $connection->tablePrefix . 'address';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                    = "SELECT u.*, pe.firstname, pe.lastname, pe.email, pe.mobilephone, pe.profile_image,
                                   ad.address1, ad.address2, ad.city, ad.state, ad.country, ad.postal_code
                                   FROM $tableName u, $peTableName pe, $adTableName ad 
                                   WHERE pe.email = :email AND pe.id = u.person_id AND pe.id = ad.relatedmodel_id AND ad.relatedmodel = :rm 
                                   AND ad.type = :type";
        return $connection->createCommand($sql, [':email' => $email, ':rm' => 'Person', ':type' => Address::TYPE_DEFAULT])
                          ->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get customer by email
     * @param int $id
     * @return array
     */
    public static function getCustomerById($id)
    {
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = $connection->tablePrefix . 'customer';
        $peTableName            = $connection->tablePrefix . 'person';
        $adTableName            = $connection->tablePrefix . 'address';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                    = "SELECT u.*, pe.firstname, pe.lastname, pe.email, pe.mobilephone, pe.profile_image,
                                   ad.address1, ad.address2, ad.city, ad.state, ad.country, ad.postal_code
                                   FROM $tableName u, $peTableName pe, $adTableName ad 
                                   WHERE u.id = :id AND pe.id = u.person_id AND pe.id = ad.relatedmodel_id AND ad.relatedmodel = :rm 
                                   AND ad.type = :type";
        return $connection->createCommand($sql, [':id' => $id, ':rm' => 'Person', ':type' => Address::TYPE_DEFAULT])
                          ->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Gets customer and Guest drop down data.
     * @return array
     */
    public static function getCustomerAndGuestDropdownData()
    {
        $data       = ArrayUtil::map(Customer::find()->asArray()->indexBy('username')->all(), 'id', 'username');
        $data[0]    = 'guest';
        return $data;
    }
    
    /**
     * Get customer group dropdown data.
     * @return array
     */
    public static function getCustomerGroupDropdownData()
    {
        $key    = 'CustomerGroupDropdownList';
        $data   = CacheUtil::get($key);
        if($data === false)
        {
            $data           = [];
            $customerGroup  = Group::findByName('Customer', UsniAdaptor::app()->language);
            if(!empty($customerGroup))
            {
                $records        = Group::find()->where('parent_id = :pid', [':pid' => $customerGroup->id])->all();
                foreach ($records as $record)
                {
                    $data[$record->id] = $record->name;
                }
                CacheUtil::set($key, $data);
                CacheUtil::setModelCache('Group', $key);
            }
        }
        return $data;
    }
    
    /**
     * Get customer group. 
     * @param int $groupId
     * @return string
     */
    public static function getCustomerGroupById($groupId)
    {
        $language = UsniAdaptor::app()->languageManager->getContentLanguage();
        $group    = GroupTranslated::find()->where('owner_id = :id AND language = :lang',  [':id' => $groupId, ':lang' => $language])->asArray()->one();
        if(!empty($group))
        {
            return $group['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get customer by group id.
     * @param integer $groupId
     * @return array
     */
    public static function getCustomerByGroupId($groupId)
    {
        $groupMemberTable   = UsniAdaptor::tablePrefix() . 'group_member';
        $customerTable      = UsniAdaptor::tablePrefix() . 'customer';
        $personTable        = UsniAdaptor::tablePrefix() . 'person';
        $addressTable       = UsniAdaptor::tablePrefix() . 'address';
        $sql                = "SELECT ct.*, pt.firstname, pt.lastname, pt.email, pt.mobilephone, pt.profile_image,
                               at.address1, at.address2, at.city, at.state, at.country, at.postal_code
                               FROM $customerTable ct, $personTable pt, $addressTable at, $groupMemberTable gmt "
                             . "WHERE gmt.group_id = :gid AND gmt.member_type = :mtype AND gmt.member_id = ct.id AND ct.person_id = pt.id AND pt.id = at.relatedmodel_id AND at.                                   relatedmodel = :rm AND at.type = :type";
        $params             = [':gid' => $groupId, ':mtype' => 'customer', ':rm' => 'Person', ':type' => Address::TYPE_DEFAULT];
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->queryAll();
    }
    
    /**
     * Check if customer group is allowed to delete.
     * @param Group $model
     * @return boolean
     */
    public static function checkIfCustomerGroupAllowedToDelete($model)
    {
        $taxRules           = TaxUtil::getTaxRuleByAttribute('customer_group_id', $model['id']);
        $customer           = self::getCustomerByGroupId($model['id']);
        $productDiscounts   = ProductUtil::getProductDiscountByAttribute('group_id', $model['id']);
        $productSpecial     = ProductUtil::getProductSpecialByAttribute('group_id', $model['id']);
        if(empty($taxRules) && empty($customer) && empty($productDiscounts) && empty($productSpecial))
        {
            return true;
        }
        return false;
    }
    
    /**
     * Create customer.
     * @param string $username
     * @param Group $group
     * @param mixed $password
     * @param string $email
     * @param string $scenario
     * @return Customer model
     */
    public static function createCustomer($username, $group, $password, $email = null, $scenario = 'create')
    {
        $customerData   = [
                            'username'        => $username,
                            'password'        => $password,
                            'confirmPassword' => $password,
                            'timezone'        => TimezoneUtil::getCountryTimezone('IN'),
                            'status'          => User::STATUS_ACTIVE,
                            'groups'          => [$group->id]
                          ];
        $personData = ['email'           => self::getEmail($username, $email),
                       'firstname'       => ucfirst($username),
                       'lastname'        => $username . 'last'];
        $addressData = ['address1'        => 'address', 
                        'address2'        => 'address2', 
                        'city'            => 'Delhi', 
                        'country'         => 'IN',
                        'state'           => '',
                        'postal_code'     => ZoneDataManager::PIN_CODE_DELHI];
        $model              = new CustomerEditForm(['scenario' => 'create']);
        $model->customer    = new Customer(['scenario' => 'create']);
        $model->person      = new Person(['scenario' => 'create']);
        $model->address     = new Address(['scenario' => 'create']);
        $model->customer->attributes    = $customerData;
        $model->person->attributes      = $personData;
        $model->address->attributes     = $addressData;
        $model->customer->setPasswordHash($password);
        if(self::validateAndSaveCustomerData($model))
        {
           return $model->customer; 
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Get email for the user.
     * @param string $username
     * @param string $email
     * @return string
     */
    public static function getEmail($username, $email)
    {
        if ($email == null)
        {
            return $username . '@whatacart.com';
        }
        else
        {
            return $email;
        }
    }
}