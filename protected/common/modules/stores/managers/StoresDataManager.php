<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\managers;

use usni\library\components\UiDataManager;
use common\modules\stores\models\Store;
use usni\library\components\UiBaseActiveRecord;
use common\modules\dataCategories\managers\DataCategoriesDataManager;
use common\modules\localization\modules\weightclass\managers\WeightClassDataManager;
use common\modules\localization\modules\lengthclass\managers\LengthClassDataManager;
use usni\UsniAdaptor;
use common\modules\dataCategories\models\DataCategoryTranslated;
use common\modules\localization\modules\currency\managers\CurrencyDataManager;
use common\models\ShippingAddress;
use common\models\BillingAddress;
use common\modules\stores\models\StoreLocal;
use common\modules\stores\models\StoreSettings;
use usni\library\components\LanguageManager;
use taxes\models\TaxRule;
use common\managers\AuthDataManager;
use common\modules\localization\modules\orderstatus\managers\OrderStatusDataManager;
use common\modules\order\models\Order;
use common\modules\stores\models\StoreImage;
use common\modules\localization\modules\lengthclass\models\LengthClass;
use common\modules\localization\modules\weightclass\models\WeightClass;
use usni\library\utils\ConfigurationUtil;
use common\modules\localization\modules\orderstatus\models\OrderStatusTranslated;
use usni\library\modules\auth\models\GroupTranslated;
use common\modules\stores\utils\StoreUtil;
use usni\library\modules\users\models\User;
/**
 * Loads default data related to stores.
 * 
 * @package common\modules\stores\managers
 */
class StoresDataManager extends UiDataManager
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {        
        $dataCategory = DataCategoryTranslated::find()->where('name = :name AND language = :lan', 
                                                             [':name' => 'Root Category',':lan' => 'en-US'])->asArray()->one();
        $storeOwner   = User::find()->where('username = :un', [':un' => 'storeowner'])->asArray()->one();
        return [
                    [   
                        'name'         => UsniAdaptor::t('stores', 'Default'), 
                        'description'  => UsniAdaptor::t('stores', 'This is test store set up with the application'),
                        'url'          => 'http://teststore.org',
                        'is_default'   => true,
                        'status'       => UiBaseActiveRecord::STATUS_ACTIVE,
                        'data_category_id' => $dataCategory['owner_id'],
                        'theme'        => ConfigurationUtil::getValue('application', 'frontTheme'),
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
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    protected static function loadDefaultDependentData()
    {
        StoreUtil::createStoreOwner();
        CurrencyDataManager::loadDefaultData();
        DataCategoriesDataManager::loadDefaultData();
        WeightClassDataManager::loadDefaultData();
        LengthClassDataManager::loadDefaultData();
        AuthDataManager::loadDefaultData();
        AuthDataManager::loadDemoData();
        OrderStatusDataManager::loadDefaultData();
    }
    
    /**
     * @inheritdoc
     */
    protected static function loadDemoDependentData()
    {
        CurrencyDataManager::loadDemoData();
        DataCategoriesDataManager::loadDemoData();
        WeightClassDataManager::loadDemoData();
        LengthClassDataManager::loadDemoData();
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDefaultData()
    {
        if(parent::loadDefaultData())
        {
            $store  = Store::find()->innerJoinWith('translations')->where('name = :name AND language = :lan', 
                                                                                [':lan' => 'en-US', ':name' => 'Default'])->one();
            static::createStoreBillingAddress($store);
            static::createStoreShippingAddress($store);
			static::addStoreSettings($store);
            static::addStoreLocalInformation($store);
            static::addStoreImageInfo($store);
            return true;
        }
        return false;
    }
    
    /**
     * Create store shipping address
     * @param Store $store
     */
    public static function createStoreShippingAddress($store)
    {
        //Shipping address
        $addressData = ['address1'        => 'Shipping address', 
                        'address2'        => 'shipping address2', 
                        'city'            => 'Delhi', 
                        'country'         => 'IN',
                        'state'           => '',
                        'postal_code'     => '110005',
                        'relatedmodel'    => 'Store',
                        'relatedmodel_id' => $store->id];
        $shippingAddress = new ShippingAddress(['scenario' => 'create']);
        $shippingAddress->setAttributes($addressData);
        $shippingAddress->save();
    }
    
    /**
     * Create store billing address
     * @param Store $store
     */
    public static function createStoreBillingAddress($store)
    {
        //Billing Address
        $addressData = ['address1'        => 'Billing address', 
                        'address2'        => 'billing address2', 
                        'city'            => 'Delhi', 
                        'country'         => 'IN',
                        'state'           => '',
                        'postal_code'     => '110005',
                        'relatedmodel'    => 'Store',
                        'relatedmodel_id' => $store->id];
        $billingAddress = new BillingAddress(['scenario' => 'create']);
        $billingAddress->setAttributes($addressData);
        $billingAddress->save();
    }
    
    /**
     * Add store local information
     * @param Store $store
     */
    public static function addStoreLocalInformation($store)
    {
        $storeLocal = new StoreLocal(['scenario' => 'create']);
        $language       = LanguageManager::getDefault();
        $currencyCode   = UsniAdaptor::app()->currencyManager->getDefault();
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
        StoreUtil::batchInsertStoreConfiguration($storeLocal, $store, 'storelocal', 'storeconfig');
    }
    
    /**
     * Add store settings
     * @param Store $store
     */
    public static function addStoreSettings($store)
    {
        $storeSettings      = new StoreSettings(['scenario' => 'create']);
        $group              = GroupTranslated::find()->where('name = :name', [':name' => 'Default'])->asArray()->one();
        $defaultStatus      = OrderStatusTranslated::find()->where('name = :name', [':name' => Order::STATUS_PENDING])->asArray()->one();
        //Local data
        $localData      = ['catalog_items_per_page'  => '8', 
                           'list_description_limit'  => '100',
                           'invoice_prefix'          => '#', 
                           'display_price_with_tax'  => 1,
                           'tax_calculation_based_on' => TaxRule::TAX_BASED_ON_BILLING,
                           'customer_online'          => 1,
                           'default_customer_group'   => $group['owner_id'],
                           'guest_checkout'           => 0,
                           'order_status'             => $defaultStatus['owner_id'],
                           'display_stock'            => 0,
                           'allow_reviews'            => 1,
                           'allow_guest_reviews'      => 1,
                           'allow_wishlist'           => 1,
                           'allow_compare_products'   => 1,
                           'customer_prefix'          => '#',
                           'order_prefix'             => '#',
                           'display_weight'           => 1,
                           'display_dimensions'       => 1,
                           'show_out_of_stock_warning' => 1,
                           'allow_out_of_stock_checkout' => 1
                          ];
        $storeSettings->setAttributes($localData);
        StoreUtil::batchInsertStoreConfiguration($storeSettings, $store, 'storesettings', 'storeconfig');
    }
    
    /**
     * Add store image info
     * @param Store $store
     */
    public static function addStoreImageInfo($store)
    {
        $storeImage     = new StoreImage(['scenario' => 'create']);
        //Image data
        $imageData      = StoreUtil::getDefaultImageDataSet();
        $storeImage->setAttributes($imageData);
        StoreUtil::batchInsertStoreConfiguration($storeImage, $store, 'storeimage', 'storeconfig');
    }
}