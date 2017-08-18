<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\business;

use usni\UsniAdaptor;
use usni\library\utils\FileUploadUtil;
use usni\library\managers\UploadInstanceManager;
use yii\base\Model;
use usni\library\modules\users\models\User;
use common\modules\stores\models\Store;
use common\modules\stores\dto\FormDTO;
use usni\library\utils\ArrayUtil;
use common\modules\dataCategories\dao\DataCategoryDAO;
use usni\library\modules\users\dao\UserDAO;
use usni\library\modules\install\business\InstallManager;
use usni\library\modules\language\business\Manager as LanguageManager;
use common\modules\localization\modules\currency\dao\CurrencyDAO;
use taxes\utils\TaxUtil;
use customer\business\Manager as CustomerManager;
use taxes\models\TaxRule;
use common\modules\order\models\Order;
use common\modules\stores\dao\StoreDAO;
use yii\base\InvalidParamException;
use usni\library\utils\CountryUtil;
use usni\library\modules\language\dao\LanguageDAO;
use common\modules\localization\modules\lengthclass\dao\LengthClassDAO;
use common\modules\localization\modules\weightclass\dao\WeightClassDAO;
use common\modules\localization\modules\orderstatus\dao\OrderStatusDAO;
use usni\library\utils\AdminUtil;
use customer\business\Manager as CustomerBusinessManager;
use usni\library\modules\auth\models\Group;
use usni\library\modules\users\models\Address;
use usni\library\modules\users\models\Person;
use usni\library\utils\TimezoneUtil;
use usni\library\modules\users\dto\UserFormDTO;
use usni\library\modules\users\business\Manager as UserBusinessManager;
use common\modules\localization\modules\currency\business\Manager as CurrencyBusinessManager;
use common\modules\stores\business\ConfigManager;
use usni\library\utils\CacheUtil;
/**
 * Manager class file.
 * 
 * @package common\modules\stores\business
 */
class Manager extends \common\business\Manager
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    
    /**
     * Process edit.
     * @param FormDTO $formDTO
     */
    public function processEdit($formDTO) 
    {
        $model      = $formDTO->getModel();
        $scenario   = $model->scenario;
        $postData   = $formDTO->getPostData();
        if (!empty($postData['Store']))
        {
            $this->beforeAssigningPostData($model);
            if ($model->store->load($postData) 
                && $model->billingAddress->load($postData)
                    && $model->storeLocal->load($postData) 
                        && $model->storeSettings->load($postData)
                            && $model->storeImage->load($postData)
                                && $model->shippingAddress->load($postData)
            )
            {
                if($this->beforeModelSave($model))
                {
                    $transaction    = UsniAdaptor::db()->beginTransaction();
                    try
                    {
                        $result = $this->validateAndSaveStoreData($model);
                        $formDTO->setIsTransactionSuccess($result);
                        if($result)
                        {
                            $transaction->commit();
                            $this->afterModelSave($model);
                        }
                    }
                    catch(\Exception $e)
                    {
                        $transaction->rollback();
                        throw $e;
                    }
                }
                else
                {
                    $formDTO->setIsTransactionSuccess(false);
                }
            }
            $formDTO->setModel($model);
        }
        $this->populateDTO($formDTO);
        if($scenario != 'create')
        {
            $formDTO->setBrowseModels($this->getBrowseModels(Store::className()));
        }
    }
    
    /**
     * Validate and save Store data.
     * @param StoreEditForm $model
     * @return boolean
     */
    public function validateAndSaveStoreData($model)
    {
        $storeConfigManager = ConfigManager::getInstance();
        $scenario       = $model->scenario;
        if(Model::validateMultiple([$model->store, $model->billingAddress, $model->shippingAddress, 
                                    $model->storeLocal, $model->storeSettings, $model->storeImage]))
        {
            $isNewRecord = $model->store->isNewRecord;
            $model->store->save(false);
            if($scenario == 'create')
            {
                $model->store->saveTranslatedModels();
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
                $storeConfigManager->batchInsertStoreConfiguration($model->storeLocal, $model->store->id, 'storelocal', 'storeconfig');
                $storeConfigManager->batchInsertStoreConfiguration($model->storeSettings, $model->store->id, 'storesettings', 'storeconfig');
                $storeConfigManager->batchInsertStoreConfiguration($model->storeImage, $model->store->id, 'storeimage', 'storeconfig');
            }
            else
            {
                $storeConfigManager->updateStoreConfiguration($model->storeLocal, 'storelocal', $model->store->id);
                $storeConfigManager->updateStoreConfiguration($model->storeSettings, 'storesettings', $model->store->id);
                $storeConfigManager->updateStoreConfiguration($model->storeImage, 'storeimage', $model->store->id);
            }
            CacheUtil::delete($model->store->id . '_store_config');
            return true;
        }
        return false;
    }
    
    /**
     * inheritdoc
     */
    public function beforeAssigningPostData($model)
    {
        $model->storeImage->logoSavedImage = $model->storeImage->store_logo;
        $model->storeImage->iconSavedImage = $model->storeImage->icon;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeModelSave($model)
    {
        if(parent::beforeModelSave($model))
        {
            //For store logo
            $config = [
                            'model'             => $model->storeImage,
                            'attribute'         => 'store_logo',
                            'uploadInstanceAttribute' => 'logoUploadInstance',
                            'type'              => 'image',
                            'savedAttribute'    => 'logoSavedImage',
                            'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                      ];
            $logoUploadInstanceManager = new UploadInstanceManager($config);
            $logoResult = $logoUploadInstanceManager->processUploadInstance();
            if($logoResult === false)
            {
                return false;
            }
            //for store  icon
            $config = [
                           'model'             => $model->storeImage,
                           'attribute'         => 'icon',
                           'type'              => 'image',
                           'uploadInstanceAttribute' => 'iconUploadInstance',
                           'savedAttribute'    => 'iconSavedImage',
                           'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                     ];
           $iconUploadInstanceManager = new UploadInstanceManager($config);
           $iconResult = $iconUploadInstanceManager->processUploadInstance();
           if($iconResult === false)
           {
               return false;
           }
           return true;
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function afterModelSave($model)
    {
        if($model->storeImage->store_logo != '')
        {
            $config = [
                        'model'             => $model->storeImage, 
                        'attribute'         => 'store_logo', 
                        'uploadInstance'    => $model->storeImage->logoUploadInstance, 
                        'savedFile'         => $model->storeImage->logoSavedImage
                      ];
            FileUploadUtil::save('image', $config);
        }
        if($model->storeImage->icon != '')
        {
            $config = [
                        'model'             => $model->storeImage, 
                        'attribute'         => 'icon', 
                        'uploadInstance'    => $model->storeImage->iconUploadInstance, 
                        'savedFile'         => $model->storeImage->iconSavedImage
                      ];
            FileUploadUtil::save('image', $config);
        }
        return true;
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return $this->getAll();
    }
    
    /**
     * Populate dropdown options
     * @param FormDTO $formDTO
     */
    public function populateDTO($formDTO)
    {
        //Set datacategories
        $dataCategories = DataCategoryDAO::getAll($this->language);
        $formDTO->setDataCategories(ArrayUtil::map($dataCategories, 'id', 'name'));
        //Set users
        $users          = UserDAO::getAll();
        $formDTO->setOwners(ArrayUtil::map($users, 'id', 'username'));
        //set themes
        $installManager = new InstallManager();
        $formDTO->setThemes($installManager->getAvailableThemes());
        //set Languages
        $formDTO->setLanguages(LanguageManager::getInstance()->getList());
        //set currencies
        $currencyBusinessManager = CurrencyBusinessManager::getInstance();
        $formDTO->setCurrencies($currencyBusinessManager->getDropdownByKey('code'));
        //set length classes
        $lengthClasses = ArrayUtil::map(LengthClassDAO::getAll($this->language), 'id', 'name');
        $formDTO->setLengthClasses($lengthClasses);
        //set weight classes
        $weightClasses = ArrayUtil::map(WeightClassDAO::getAll($this->language), 'id', 'name');
        $formDTO->setWeightClasses($weightClasses);
        //Set tax class options
        $formDTO->setTaxBasedOnOptions(TaxUtil::getBasedOnDropdown());
        //Set customer group options
        $formDTO->setCustomerGroupOptions(CustomerManager::getInstance()->getCustomerGroupDropdownData());
        //set order status
        $orderStatusRecords = ArrayUtil::map(OrderStatusDAO::getAll($this->language), 'id', 'name');
        $formDTO->setOrderStatusOptions($orderStatusRecords);
        //Set currency symbol
        $defaultCurrencyCode    = UsniAdaptor::app()->currencyManager->defaultCurrency;
        $currencySymbol         = UsniAdaptor::app()->currencyManager->getCurrencySymbol($defaultCurrencyCode);
        $formDTO->setCurrencySymbol($currencySymbol);
        $this->setDefaultSettings($formDTO);
        $this->setDefaultImageSettings($formDTO);
    }
    
    /**
     * Set default settings for store
     * @param FormDTO $formDTO
     */
    public function setDefaultSettings($formDTO)
    {
        $model = $formDTO->getModel()->storeSettings;
        if($model->catalog_items_per_page == null)
        {
            $model->catalog_items_per_page = 9;
        }
        if($model->list_description_limit == null)
        {
            $model->list_description_limit = 100;
        }
        if($model->invoice_prefix == null)
        {
            $model->invoice_prefix = '#';
        }
        if($model->customer_prefix == null)
        {
            $model->customer_prefix = '#';
        }
        if($model->order_prefix == null)
        {
            $model->order_prefix = '#';
        }
        if($model->tax_calculation_based_on == null)
        {
            $model->tax_calculation_based_on = TaxRule::TAX_BASED_ON_BILLING;
        }
        if($model->order_status == null)
        {
            $model->order_status = $this->getStatusId(Order::STATUS_PENDING, $this->language);
        }
        $yesNoAttributes = self::getYesNoAttributes();
        foreach($yesNoAttributes as $attribute)
        {
            if($model->$attribute == null)
            {
                $model->$attribute = 1;
            }
        }
        $formDTO->getModel()->storeSettings = $model;
    }
    
    /**
     * Set default image settings for store
     * @param FormDTO $formDTO
     */
    public function setDefaultImageSettings($formDTO)
    {
        $model = $formDTO->getModel()->storeImage;
        $defaultImageDataSet = self::getDefaultImageDataSet();
        foreach($defaultImageDataSet as $key => $value)
        {
            if($model->$key == null)
            {
                $model->$key = $value;
            }
        }
        $formDTO->getModel()->storeImage = $model;
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $record = StoreDAO::getById($id, $this->language);
        if (empty($record))
        {
            throw new InvalidParamException("Object not found: $id");
        }
        $owner  = StoreDAO::getOwner($id);
        $record['fullName'] = $owner['firstname'] . ' ' . $owner['lastname'];
        //Local data
        $config = ConfigManager::getInstance()->getConfiguration($id);
        $record['country']  = CountryUtil::getCountryName($config['storeconfig']['storelocal']['country']);
        $record['currency'] = $this->getCurrency($config['storeconfig']['storelocal']);
        $record['language'] = $this->getLanguage($config['storeconfig']['storelocal']);
        $record['lengthClass']  = $this->getLengthClass($config['storeconfig']['storelocal']);
        $record['weightClass']  = $this->getWeightClass($config['storeconfig']['storelocal']);
        $record['state']        = $config['storeconfig']['storelocal']['state'];
        $record['timezone']     = $config['storeconfig']['storelocal']['timezone'];
        
        //populate settings data
        $this->populateSettingsData($record, $config);
        $record['imageSettings'] = $config['storeconfig']['storeimage'];
        $this->populateAddressData($id, $record);
        return $record;
    }
    
    /**
     * Populate address data
     * @param int $id
     * @param array $record
     */
    public function populateAddressData($id, & $record)
    {
        $billingAddress = Address::find()->where('relatedmodel = :rm AND relatedmodel_id = :id AND type =:type',
                               [':rm' => 'Store', ':id' => $id, ':type' => Address::TYPE_BILLING_ADDRESS])->asArray()->one();
        $record['billingAddress'] = $billingAddress;
        //Shipping address
        $shippingAddress = Address::find()->where('relatedmodel = :rm AND relatedmodel_id = :id AND type =:type',
                               [':rm' => 'Store', ':id' => $id, ':type' => Address::TYPE_SHIPPING_ADDRESS])->asArray()->one();
        $record['shippingAddress'] = $shippingAddress;
    }
    
    /**
     * Populate settings data for detail view
     * @param array $record
     * @param array $config
     */
    public function populateSettingsData(& $record, $config)
    {
        $settings   = $config['storeconfig']['storesettings'];
        $yesNoAttributes = self::getYesNoAttributes();
        foreach($yesNoAttributes as $attribute)
        {
            $record[$attribute] = AdminUtil::getYesNoOptionDisplayText($settings[$attribute]);
            unset($settings[$attribute]);
        }
        $record['tax_calculation_based_on'] = TaxUtil::getBasedOnDisplayValue($settings['tax_calculation_based_on']);
        $record['default_customer_group']   = CustomerBusinessManager::getInstance()->getGroupName($settings['default_customer_group']);
        $record['order_status']             = $this->getOrderStatusLabel($settings['order_status'], $this->language);
        unset($settings['tax_calculation_based_on']);
        unset($settings['default_customer_group']);
        unset($settings['order_status']);
        foreach ($settings as $key => $value)
        {
            $record[$key]   = $value;
        }
    }
    
    /**
     * Get all stores.
     * @param integer $status
     * @return array
     */
    public function getAll($status = null)
    {
        return StoreDAO::getAll($this->language, $status);
    }
    
    /**
     * Get default store. False is returned if no result found
     * 
     * @return array
     */
    public function getDefault()
    {
        return StoreDAO::getDefault($this->language);
    }
    
    /**
     * Get default image data set
     * @return array
     */
    public static function getDefaultImageDataSet()
    {
        return [
                'store_logo'    => '',
                'icon'          => '',
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
     * Get currency.
     * @param array $record
     * @return string
     */
    public function getCurrency($record)
    {
        $currency = CurrencyDAO::getByCode($record['currency'], $this->language);
        if(!empty($currency))
        {
            return $currency['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get language.
     * @param array $record
     * @return string
     */
    public function getLanguage($record)
    {
        $language = LanguageDAO::getLanguageName($record['language']);
        if(!empty($language))
        {
            return $language['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get length class
     * @param array $record
     * @return string
     */
    public function getLengthClass($record)
    {
        $lengthClass = LengthClassDAO::getById($record['length_class'], $this->language);
        if(!empty($lengthClass))
        {
            return $lengthClass['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get weight class
     * @param array $record
     * @return string
     */
    public function getWeightClass($record)
    {
        $weightClass = WeightClassDAO::getById($record['weight_class'], $this->language);
        if(!empty($weightClass))
        {
            return $weightClass['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get yes no attributes
     * @return array
     */
    public static function getYesNoAttributes()
    {
        return ['display_price_with_tax', 'customer_online', 'guest_checkout', 'display_stock',
                'show_out_of_stock_warning', 'allow_out_of_stock_checkout', 'allow_reviews',
                'allow_guest_reviews', 'allow_wishlist', 'allow_compare_products', 'display_dimensions',
                'display_weight'];
    }
    
    /**
     * Get selected store data category
     * @return string
     */
    public function getSelectedStoreDataCategory()
    {
        $store = $this->getCurrentStore();
        return $store['data_category_id'];
    }
    
    /**
     * Create store owner.
     * @return boolean|Model
     */
    public function createStoreOwner()
    {
        $owner              = User::find()->where('username = :un', [':un' => 'storeowner'])->asArray()->one();
        if(!empty($owner))
        {
            return $owner;
        }
        $group              = Group::find()->where('name = :name', [':name' => Group::ADMINISTRATORS])->asArray()->one();
        
        $user       = new User(['scenario' => 'create']);
        $person     = new Person(['scenario' => 'create']);
        $address    = new Address(['scenario' => 'create']);
        
        $email     = 'mayank@mayankstore.com';
        $password  = 'abcd123!@#';
        $username  = 'storeowner';
        $timezone  = TimezoneUtil::getCountryTimezone('IN');
        $firstname = 'Store';
        $lastname  = 'Owner';
        $groups    = [$group['id']];
        
        $userData       = ['username' => $username, 'timezone' => $timezone, 'groups' => $groups,'status' => User::STATUS_ACTIVE, 
                           'password' => $password, 'confirmPassword' => $password,'type' => 'system'];
        $personData     = ['email' => $email, 'firstname' => $firstname, 'lastname' => $lastname];
        $addressData    = ['country' => 'IN', 'state' => 'Delhi', 'address1' => '302', 'address2' => '9A/1, W.E.A, Karol Bagh', 'city' => 'New Delhi', 
                           'postal_code' => 110005, 'status' => User::STATUS_ACTIVE];
        $user->attributes    = $userData;
        $person->attributes  = $personData;
        $address->attributes = $addressData;
        $user->setPasswordHash($password);
        $formDTO = new UserFormDTO();
        $formDTO->setModel($user);
        $formDTO->setPerson($person);
        $formDTO->setAddress($address);
        $formDTO->setScenario('create');
        $instance = UserBusinessManager::getInstance(['userId' => $this->userId]);
        if ($instance->processInputData($formDTO))
        {
            return $user;
        }
        else
        {
            return false;
        }
    }
}