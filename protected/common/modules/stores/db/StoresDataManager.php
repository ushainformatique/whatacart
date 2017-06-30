<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\db;

use usni\library\db\DataManager;
use common\modules\stores\models\Store;
use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
use common\modules\dataCategories\models\DataCategoryTranslated;
use common\models\ShippingAddress;
use common\models\BillingAddress;
use common\modules\stores\models\StoreLocal;
use common\modules\stores\models\StoreSettings;
use taxes\models\TaxRule;
use common\modules\order\models\Order;
use common\modules\stores\models\StoreImage;
use common\modules\localization\modules\lengthclass\models\LengthClass;
use common\modules\localization\modules\weightclass\models\WeightClass;
use common\modules\localization\modules\orderstatus\models\OrderStatusTranslated;
use usni\library\modules\auth\models\Group;
use usni\library\modules\users\models\User;
use common\modules\stores\business\ConfigManager;
use common\modules\stores\business\Manager as StoreBusinessManager;
use common\modules\localization\modules\currency\business\Manager as CurrencyBusinessManager;
/**
 * Loads default data related to stores.
 * 
 * @package common\modules\stores\db
 */
class StoresDataManager extends DataManager
{
    /**
     * @var ConfigManager 
     */
    public $storeConfigManager;
    
    /**
     * @var StoreBusinessManager 
     */
    public $storeBusinessManager;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        $this->storeConfigManager   = ConfigManager::getInstance(['userId' => User::SUPER_USER_ID]);
        $this->storeBusinessManager = StoreBusinessManager::getInstance(['userId' => User::SUPER_USER_ID]);
    }
    /**
     * @inheritdoc
     */
    public function getDefaultDataSet()
    {        
        $dataCategory = DataCategoryTranslated::find()->where('name = :name AND language = :lan', 
                                                             [':name' => 'Root Category',':lan' => 'en-US'])->asArray()->one();
        $storeOwner   = User::find()->where('username = :un', [':un' => 'storeowner'])->asArray()->one();
        return [
                    [
                        'id'           => Store::DEFAULT_STORE_ID,
                        'name'         => UsniAdaptor::t('stores', 'Default'), 
                        'description'  => UsniAdaptor::t('stores', 'This is test store set up with the application'),
                        'url'          => 'http://teststore.org',
                        'is_default'   => true,
                        'status'       => ActiveRecord::STATUS_ACTIVE,
                        'data_category_id' => $dataCategory['owner_id'],
                        'theme'        => null,
                        'owner_id'     => $storeOwner['id']
                    ]
                ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Store::className();
    }
    
    /**
     * @inheritdoc
     */
    public function loadDefaultDependentData()
    {
        $this->storeBusinessManager->createStoreOwner();
    }
    
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        if(parent::loadDefaultData())
        {
            $this->createStoreBillingAddress();
            $this->createStoreShippingAddress();
			$this->addStoreSettings();
            $this->addStoreLocalInformation();
            $this->addStoreImageInfo();
            return true;
        }
        return false;
    }
    
    /**
     * Create store shipping address
     */
    public function createStoreShippingAddress()
    {
        //Shipping address
        $addressData = ['address1'        => 'Shipping address', 
                        'address2'        => 'shipping address2', 
                        'city'            => 'Delhi', 
                        'country'         => 'IN',
                        'state'           => '',
                        'postal_code'     => '110005',
                        'relatedmodel'    => 'Store',
                        'relatedmodel_id' => Store::DEFAULT_STORE_ID];
        $shippingAddress = new ShippingAddress(['scenario' => 'create']);
        $shippingAddress->setAttributes($addressData);
        $shippingAddress->save();
    }
    
    /**
     * Create store billing address
     */
    public function createStoreBillingAddress()
    {
        //Billing Address
        $addressData = ['address1'        => 'Billing address', 
                        'address2'        => 'billing address2', 
                        'city'            => 'Delhi', 
                        'country'         => 'IN',
                        'state'           => '',
                        'postal_code'     => '110005',
                        'relatedmodel'    => 'Store',
                        'relatedmodel_id' => Store::DEFAULT_STORE_ID];
        $billingAddress = new BillingAddress(['scenario' => 'create']);
        $billingAddress->setAttributes($addressData);
        $billingAddress->save();
    }
    
    /**
     * Add store local information
     */
    public function addStoreLocalInformation()
    {
        $storeLocal     = new StoreLocal(['scenario' => 'create']);
        $language       = UsniAdaptor::app()->language;
        $currencyCode   = CurrencyBusinessManager::getInstance()->getDefault();
        $lengthClass    = LengthClass::find()->asArray()->one();
        $weightClass    = WeightClass::find()->asArray()->one();
        //Local data
        $localData = ['country'       => 'IN', 
                      'timezone'      => 'Asia/Kolkata', 
                      'state'         => 'Haryana', 
                      'language'      => $language,
                      'currency'      => $currencyCode,
                      'length_class'  => $lengthClass['id'],
                      'weight_class'  => $weightClass['id']
                    ];
        $storeLocal->setAttributes($localData);
        $this->storeConfigManager->batchInsertStoreConfiguration($storeLocal, Store::DEFAULT_STORE_ID, 'storelocal', 'storeconfig');
    }
    
    /**
     * Add store settings
     * @param Store $store
     */
    public function addStoreSettings()
    {
        $storeSettings      = new StoreSettings(['scenario' => 'create']);
        $group              = Group::find()->where('name = :name', [':name' => 'General'])->asArray()->one();
        $defaultStatus      = OrderStatusTranslated::find()->where('name = :name', [':name' => Order::STATUS_PENDING])->asArray()->one();
        //Local data
        $localData      = ['catalog_items_per_page'         => '8', 
                           'list_description_limit'         => '100',
                           'invoice_prefix'                 => '#', 
                           'display_price_with_tax'         => 1,
                           'tax_calculation_based_on'       => TaxRule::TAX_BASED_ON_BILLING,
                           'customer_online'                => 1,
                           'default_customer_group'         => $group['id'],
                           'guest_checkout'                 => 0,
                           'order_status'                   => $defaultStatus['owner_id'],
                           'display_stock'                  => 0,
                           'allow_reviews'                  => 1,
                           'allow_guest_reviews'            => 1,
                           'allow_wishlist'                 => 1,
                           'allow_compare_products'         => 1,
                           'customer_prefix'                => '#',
                           'order_prefix'                   => '#',
                           'display_weight'                 => 1,
                           'display_dimensions'             => 1,
                           'show_out_of_stock_warning'      => 1,
                           'allow_out_of_stock_checkout'    => 1,
                          ];
        $storeSettings->setAttributes($localData);
        $this->storeConfigManager->batchInsertStoreConfiguration($storeSettings, Store::DEFAULT_STORE_ID, 'storesettings', 'storeconfig');
    }
    
    /**
     * Add store image info
     */
    public function addStoreImageInfo()
    {
        $storeImage     = new StoreImage(['scenario' => 'create']);
        //Image data
        $imageData      = $this->storeBusinessManager->getDefaultImageDataSet();
        $storeImage->setAttributes($imageData);
        $this->storeConfigManager->batchInsertStoreConfiguration($storeImage, Store::DEFAULT_STORE_ID, 'storeimage', 'storeconfig');
    }
}