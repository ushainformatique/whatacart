<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\utils;

use common\modules\stores\models\Store;
use usni\library\utils\AdminUtil;
use usni\library\modules\users\models\Address;
use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\utils\CacheUtil;
use usni\library\utils\ArrayUtil;
use common\modules\stores\models\StoreTranslated;
use usni\library\modules\auth\models\GroupTranslated;
use usni\library\modules\users\models\Person;
use usni\library\modules\users\models\UserEditForm;
use usni\library\modules\users\models\User;
use usni\library\utils\TimezoneUtil;
use usni\library\modules\users\utils\UserUtil;
use yii\caching\DbDependency;
use common\modules\stores\models\StoreConfiguration;
use usni\library\components\LanguageManager;
use usni\library\utils\TranslationUtil;
/**
 * StoreUtil class file.
 * 
 * @package common\modules\stores\utils
 */
class StoreUtil
{
    /**
     * Gets data category select options.
     * @param User $user
     * @return array
     */
    public static function getDataCategorySelectOptions($modelClassName)
    {
        return AdminUtil::getTranslatableModelSelectOptions($modelClassName::className());
    }
    
    /**
     * Validate and save Store data.
     * @param StoreEditForm $model
     * @param Array  $postData Contains Post data.
     * @param Store $user
     * @return boolean
     */
    public static function validateAndSaveStoreData($model)
    {
        $scenario = $model->scenario;
        if(Model::validateMultiple([$model->store, $model->billingAddress, $model->shippingAddress, $model->storeLocal, $model->storeSettings, $model->storeImage]))
        {
            $isNewRecord = $model->store->isNewRecord;
            $model->store->save(false);
            if($scenario == 'create')
            {
                TranslationUtil::saveTranslatedModels($model->store);
            }
            if($model->billingAddress != null)
            {
                $model->billingAddress->relatedmodel      = 'Store';
                $model->billingAddress->relatedmodel_id   = $model->store->id;
                $model->billingAddress->save(false);
            }
            if($model->shippingAddress != null)
            {
                $model->shippingAddress->relatedmodel      = 'Store';
                $model->shippingAddress->relatedmodel_id   = $model->store->id;
                $model->shippingAddress->save(false);
            }
            if($isNewRecord)
            {
                self::batchInsertStoreConfiguration($model->storeLocal, $model->store, 'storelocal', 'storeconfig');
                self::batchInsertStoreConfiguration($model->storeSettings, $model->store, 'storesettings', 'storeconfig');
                self::batchInsertStoreConfiguration($model->storeImage, $model->store, 'storeimage', 'storeconfig');
            }
            else
            {
                self::updateStoreConfiguration($model->storeLocal, 'storelocal', $model->store->id);
                self::updateStoreConfiguration($model->storeSettings, 'storesettings', $model->store->id);
                self::updateStoreConfiguration($model->storeImage, 'storeimage', $model->store->id);
            }
            return true;
        }
        return false;
    }

    /**
    
     * Get Address options dropdown.
     * @return array
     */
    public static function getAddressOptionsDropdown()
    {
        return [
                    Address::TYPE_BILLING_ADDRESS   => UsniAdaptor::t('customer', 'Billing Address'),
                    Address::TYPE_SHIPPING_ADDRESS  => UsniAdaptor::t('customer', 'Shipping Address'),
               ];
    }
    
    /**
     * Get default store. False is returned if no result found
     * 
     * @param string $language
     * @return array
     */
    public static function getDefault($language = null)
    {
        if($language == null)
        {
            $language         = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $tableName        = Store::tableName();
        $trTableName      = StoreTranslated::tableName();
        $query            = (new \yii\db\Query());
        $record           = $query->select('s.*, str.name, str.description')->from($tableName . ' s')
                            ->innerJoin($trTableName . ' str', 's.id = str.owner_id')
                            ->where('s.is_default = :default AND str.language = :lan', [':default' => 1, ':lan' => $language])->one();
        if($record !== false)
        {
            return (object)$record;
        }
        return false;
    }
    
    /**
     * Gets dropdown field select data.
     * @return array
     */
    public static function getDropdownDataBasedOnModel()
    {
        $modelClass = Store::className();
        $key    = $modelClass . 'DropdownList';
        $data   = CacheUtil::get($key);
        if($data === false)
        {
            $data = ArrayUtil::map(Store::find()->where('status = :status', [':status' => Store::STATUS_ACTIVE])->indexBy('name')->all(), 'id', 'name');
            CacheUtil::set($key, $data);
            CacheUtil::setModelCache($modelClass, $key);
        }
        return $data;
    }
    
    /**
     * Get address by type
     * @param int $storeId
     * @param int $type
     * @return type
     */
    public static function getAddressByType($storeId, $type)
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'address';
        $sql        = "SELECT * FROM $tableName WHERE relatedmodel = :rm AND relatedmodel_id = :rmid AND type = :type";
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        return UsniAdaptor::app()->db->createCommand($sql, [':rm' => 'Store', ':rmid' => $storeId, ':type' => $type])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get store settings value.
     * @param string $key
     * @return string
     */
    public static function getSettingValue($key, $storeId = null)
    {
        if($storeId == null)
        {
            $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
            $storeId        = $currentStore->id;
        }
        $storeSettings  = self::getSettings($storeId, 'storesettings');
        return $storeSettings[$key];
    }
    
    /**
     * Get settings for the store
     * @param integer $storeId
     * @param string $code
     * @return array
     */
    public static function getSettings($storeId, $code)
    {
        $storeConfigTable   = UsniAdaptor::tablePrefix(). 'store_configuration';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $storeConfigTable"]);
        $sql                = "SELECT tc.key, tc.value 
                                   FROM $storeConfigTable tc
                                   WHERE tc.store_id = :sid AND tc.code = :code";
        $connection         = UsniAdaptor::app()->getDb();
        $records            = $connection->createCommand($sql, [':sid' => $storeId, ':code' => $code])->cache(0, $dependency)->queryAll();
        return ArrayUtil::map($records, 'key', 'value');
    }
    
    /**
     * Get store images value.
     * @param string $key
     * @param string $defaultValue
     * @return string
     */
    public static function getImageSetting($key, $defaultValue = null, $storeId = null)
    {
        if($storeId == null)
        {
            $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
            $storeId        = $currentStore->id;
        }
        $storeImageSettings     = self::getSettings($storeId, 'storeimage');
        $value = ArrayUtil::getValue($storeImageSettings, $key);
        if($value == null)
        {
            $value = $defaultValue;
        }
        return $value;
    }
    
    /**
     * Gets language dropdown data.
     * @return array
     */
    public static function getLanguageDropdownData()
    {
        return LanguageManager::getList();
    }
    
    /**
     * Create store owner.
     * @return boolean|Model
     */
    public static function createStoreOwner()
    {
        $owner              = User::find()->where('username = :un', [':un' => 'storeowner'])->asArray()->one();
        if(!empty($owner))
        {
            return $owner;
        }
        $group              = GroupTranslated::find()->where('name = :name', [':name' => 'Administrators'])->asArray()->one();
        
        $model              = new UserEditForm(['scenario' => 'create']);
        $model->user        = new User(['scenario' => 'create']);
        $model->person      = new Person(['scenario' => 'create']);
        $model->address     = new Address(['scenario' => 'create']);
        
        $email     = 'mayank@mayankstore.com';
        $password  = 'abcd123!@#';
        $username  = 'storeowner';
        $timezone  = TimezoneUtil::getCountryTimezone('IN');
        $firstname = 'Store';
        $lastname  = 'Owner';
        $groups    = [$group['owner_id']];
        
        $userData       = ['username' => $username, 'timezone' => $timezone, 'groups' => $groups,'status' => User::STATUS_ACTIVE, 
                           'password' => $password, 'confirmPassword' => $password,'type' => 'system'];
        $personData     = ['email' => $email, 'firstname' => $firstname, 'lastname' => $lastname];
        $addressData    = ['country' => 'IN', 'state' => 'Delhi', 'address1' => '302', 'address2' => '9A/1, W.E.A, Karol Bagh', 'city' => 'New Delhi', 
                           'postal_code' => 110005, 'status' => User::STATUS_ACTIVE];
        $model->user->attributes    = $userData;
        $model->person->attributes  = $personData;
        $model->address->attributes = $addressData;
        $model->user->setPasswordHash($password);
        if(UserUtil::validateAndSaveUserData($model))
        {
            return $model->user;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Register same as billing address script
     * @param View $view
     */
    public static function registerSameAsBillingAddressScript($view)
    {
        $sameAsBillingScript = "$('#shippingaddress-usebillingaddress').change(function(){
                                    var attributes = ['firstname', 'lastname', 'address1', 'city', 'country', 'postal_code', 'state', 'address2', 'email', 'mobilephone'];
                                    var c = this.checked;
                                    if(c)
                                    {
                                          $.each(attributes, function(index, value){
                                            if(value == 'country')
                                            {
                                                var inputValue = $('#billingaddress-' + value).select2('val');
                                                $('#shippingaddress-' + value).select2('val', inputValue);
                                            }
                                            else
                                            {
                                                var inputValue = $('#billingaddress-' + value).val();
                                                $('#shippingaddress-' + value).val(inputValue);
                                            }
                                          });
                                    }
                                })";
        $view->registerJs($sameAsBillingScript);
    }
    
    /**
     * Get default image data set
     * @return array
     */
    public static function getDefaultImageDataSet()
    {
        return [
                'category_image_width'   => 90, 
                'category_image_height'  => 90,
                'product_list_image_width' => 150,
                'product_list_image_height' => 150,
                'related_product_image_width' => 80,
                'related_product_image_height' => 80,
                'compare_image_width' => 90,
                'compare_image_height' => 90,
                'cart_image_width' => 47,
                'cart_image_height' => 47,
                'wishlist_image_width' => 47,
                'wishlist_image_height' => 47,
                'store_image_width' => 47,
                'store_image_height' => 47
                ];
    }
    
    /**
     * Get store local value.
     * @param string $key
     * @return string
     */
    public static function getLocalValue($key, $storeId = null)
    {
        if($storeId == null)
        {
            $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
            $storeId        = $currentStore->id;
        }
        $storeSettings  = self::getSettings($storeId, 'storelocal');
        return ArrayUtil::getValue($storeSettings, $key);
    }
    
    /**
     * Get stroe by id
     * @param int $id
     * @param string $language
     * @return array
     */
    public static function getStoreById($id, $language = null)
    {
        $connection       = UsniAdaptor::app()->db;
        if($language == null)
        {
            $language         = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $tableName        = UsniAdaptor::tablePrefix() . 'store';
        $trTableName      = UsniAdaptor::tablePrefix() . 'store_translated';
        $sql              = "select s.*, str.name, str.description FROM $tableName s, $trTableName str
                             where s.id = :id AND s.id = str.owner_id AND str.language = :lan";
        return $connection->createCommand($sql, [':id' => $id, ':lan' => $language])->queryOne();
    }
    
    /**
     * Get store's orders.
     * 
     * @param $sid int
     * @return array
     */
    public static function getStoreOwner($sid = null)
    {
        if($sid == null)
        {
            $currentStore  = UsniAdaptor::app()->storeManager->getCurrentStore();
            $sid           = $currentStore->id;
        }
        $storeTable     = UsniAdaptor::tablePrefix() . 'store';
        $userTable      = UsniAdaptor::tablePrefix() . 'user';
        $personTable    = UsniAdaptor::tablePrefix() . 'person';
        $sql                = "SELECT tp.*, ut.username, ut.status, ut.timezone, ut.type
                               FROM $userTable ut,  $personTable tp, $storeTable st
                               WHERE st.id = :sid AND st.owner_id = ut.id AND ut.person_id = tp.id";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':sid' => $sid])->queryOne();
    }
    
    /**
     * Insert store configuration
     * @param Model|Array $model
     * @param Store $store
     * @param string $code
     * @param string $category
     */
    public static function batchInsertStoreConfiguration($model, $store, $code, $category)
    {
        $user   = UsniAdaptor::app()->user->getUserModel();
        if($user == null)
        {
            //Install time
            $createdBy = $modifiedBy = User::SUPER_USER_ID;
        }
        else
        {
            $createdBy = $modifiedBy = $user->id;
        }
        $createdDateTime = $modifiedDateTime = date('Y-m-d H:i:s');
        $table       = UsniAdaptor::tablePrefix(). 'store_configuration';
        if(is_object($model))
        {
            $attributes  = $model->getAttributes();
        }
        else
        {
            $attributes  = $model;
        }
        $data        = [];
        $columns     = ['store_id', 'category', 'code', 'key', 'value', 'created_by', 'created_datetime', 'modified_by', 'modified_datetime'];
        $excludedAttributes = static::getExcludedAttributesFromStoreConfig();
        foreach($attributes as $key => $value)
        {
            if(!in_array($key, $excludedAttributes))
            {
                $data[] = [$store->id, $category, $code, $key, $value, $createdBy, $createdDateTime, $modifiedBy, $modifiedDateTime];
            }
        }
        UsniAdaptor::app()->db->createCommand()->batchInsert($table, $columns, $data)->execute();
    }
    
    /**
     * Insert store configuration
     * @param string $code
     * @param string $category
     * @param string $key
     * @param string $value
     * @param int $storeId
     */
    public static function insertStoreConfiguration($code, $category, $key, $value, $storeId = null)
    {
        if($storeId == null)
        {
            $currentStore  = UsniAdaptor::app()->storeManager->getCurrentStore();
            $storeId       = $currentStore->id;
        }
        $user   = UsniAdaptor::app()->user->getUserModel();
        if($user == null)
        {
            //Install time
            $createdBy = $modifiedBy = User::SUPER_USER_ID;
        }
        else
        {
            $createdBy = $modifiedBy = $user->id;
        }
        $createdDateTime = $modifiedDateTime = date('Y-m-d H:i:s');
        $table       = UsniAdaptor::tablePrefix(). 'store_configuration';
        $columns     = ['store_id' => $storeId, 'code' => $code, 'category' => $category, 'key' => $key, 'value' => $value, 'created_by' => $createdBy, 
                        'created_datetime' => $createdDateTime, 'modified_by' => $modifiedBy, 'modified_datetime' => $modifiedDateTime];
        UsniAdaptor::app()->db->createCommand()->insert($table, $columns)->execute();
    }
    
    /**
     * Update store configuration
     * @param Model|Array $model
     * @param int $storeId
     * @param string $code
     */
    public static function updateStoreConfiguration($model, $code, $storeId = null)
    {
        $user   = UsniAdaptor::app()->user->getUserModel();
        if($user == null)
        {
            $modifiedBy = User::SUPER_USER_ID;
        }
        else
        {
            $modifiedBy = $user->id;
        }
        $modifiedDateTime = date('Y-m-d H:i:s');
        if($storeId == null)
        {
            $currentStore  = UsniAdaptor::app()->storeManager->getCurrentStore();
            $storeId       = $currentStore->id;
        }
        $table       = UsniAdaptor::tablePrefix(). 'store_configuration';
        if(is_array($model))
        {
            $attributes = $model;
        }
        else
        {
            $attributes  = $model->getAttributes();
        }
        $excludedAttributes = static::getExcludedAttributesFromStoreConfig();
        foreach($attributes as $key => $value)
        {
            if(!in_array($key, $excludedAttributes))
            {
                $sql         = "UPDATE $table tc SET value = :value, modified_by = :mid, modified_datetime = :mdt WHERE tc.store_id = :sid AND tc.code = :code AND tc.key = :key";
                UsniAdaptor::app()->db->createCommand($sql, [':sid' => $storeId, ':code' => $code, ':key' => $key, ':value' => $value,
                                                            ':mid' => $modifiedBy, ':mdt' => $modifiedDateTime])->execute();
            }
        }
    }
    
    /**
     * Get excluded attributes from store configuration
     * @return array
     */
    public static function getExcludedAttributesFromStoreConfig()
    {
        return ['logoUploadInstance', 'logoSavedImage', 'iconUploadInstance', 'iconSavedImage'];
    }
    
    /**
     * Get store confguration attributes by code for store
     * @param string $code
     * @param string $category
     * @param int $storeId
     * @return array
     */
    public static function getStoreConfgurationAttributesByCodeForStore($code, $category, $storeId = null)
    {
        if($storeId == null)
        {
            $currentStore  = UsniAdaptor::app()->storeManager->getCurrentStore();
            $storeId       = $currentStore->id;
        }
        $records = StoreConfiguration::find()->where('store_id = :sid AND category = :cat AND code = :code', [':sid' => $storeId, ':code' => $code, ':cat' => $category])->asArray()->all();
        if(!empty($records))
        {
            return ArrayUtil::map($records, 'key', 'value');
        }
        return [];
    }
    
    /**
     * Get store value by key for store
     * @param string $key
     * @param string $code
     * @param string $category
     * @param int $storeId
     * @return array
     */
    public static function getStoreValueByKey($key, $code, $category, $storeId = null)
    {
        $storeConfig = self::getStoreConfgurationAttributesByCodeForStore($code, $category, $storeId);
        return ArrayUtil::getValue($storeConfig, $key, null);
    }
    
    /**
     * Checks if configuration exist.
     * @param string $code
     * @param string $category
     * @param string $key
     * @param int $storeId
     * @return array
     */
    public static function checkAndGetConfigurationIfExist($code, $category, $key, $storeId = null)
    {
        if($storeId == null)
        {
            $currentStore  = UsniAdaptor::app()->storeManager->getCurrentStore();
            $storeId       = $currentStore->id;
        }
        $tableName = StoreConfiguration::tableName();
        $sql       = "SELECT * FROM $tableName tc WHERE tc.store_id = :sid AND tc.category = :cat AND tc.code = :code AND tc.key = :key";
        return UsniAdaptor::app()->db->createCommand($sql, [':sid' => $storeId, ':key' => $key, ':code' => $code, ':cat' => $category])->queryOne();
    }
    
    /**
     * Insert or update store configuration
     * @param string $code
     * @param string $category
     * @param string $key
     * @param string $value
     * @param int $storeId
     */
    public static function insertOrUpdateConfiguration($code, $category, $key, $value, $storeId = null)
    {
        $record = self::checkAndGetConfigurationIfExist($code, $category, $key, $storeId);
        try
        {
            if($record === false)
            {
                self::insertStoreConfiguration($code, $category, $key, $value, $storeId);
            }
            else
            {
                self::updateStoreConfiguration([$key => $value], $code, $storeId);
            }
            return null;
        }
        catch (\yii\db\Exception $e)
        {
            return $e->getMessage();
        }
    }
    
    /**
     * Process insert or update configuration.
     * @param Model|Array $model
     * @param string $code
     * @param string $category
     * @return void
     */
    public static function processInsertOrUpdateConfiguration($model, $code, $category, $storeId = null)
    {
        if($storeId == null)
        {
            $currentStore  = UsniAdaptor::app()->storeManager->getCurrentStore();
            $storeId       = $currentStore->id;
        }
        if(is_array($model))
        {
            $attributes = $model;
        }
        else
        {
            $attributes  = $model->getAttributes();
        }
        foreach($attributes as $key => $value)
        {
            self::insertOrUpdateConfiguration($code, $category, $key, $value, $storeId);
        }
    }
    
    /**
     * Gets store count by language
     * @param string $language
     * @return int
     */
    public static function getStoreCountByLanguage($language)
    {
        $connection       = UsniAdaptor::app()->db;
        $tableName        = UsniAdaptor::tablePrefix() . 'store';
        $trTableName      = UsniAdaptor::tablePrefix() . 'store_translated';
        $dependency       = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql              = "select COUNT(s.id) AS cnt FROM $tableName s, $trTableName str
                             where s.id = str.owner_id AND str.language = :lan";
        return $connection->createCommand($sql, [':lan' => $language])->cache(0, $dependency)->queryScalar();
    }
}