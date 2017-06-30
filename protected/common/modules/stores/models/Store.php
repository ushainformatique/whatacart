<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use usni\library\modules\users\models\Address;
use common\models\BillingAddress;
use common\models\ShippingAddress;
use common\modules\stores\models\StoreConfiguration;
use yii\db\Exception;
/**
 * Store active record.
 *
 * @package common\modules\stores\models
 */
class Store extends TranslatableActiveRecord
{
    /**
     * Default store id at the time of install
     */
    const DEFAULT_STORE_ID = 1;
    
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'owner_id', 'data_category_id', 'status'],  'required'],
                    ['name',  'unique', 'targetClass' => StoreTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name', 'unique', 'targetClass' => StoreTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['name',                                'string', 'max'=>64],
                    ['url',                                 'string', 'max'=>255],
                    ['url',                                 'url'],
                    ['status',                              'default', 'value' => self::STATUS_ACTIVE],
                    ['is_default',                          'boolean'],
                    ['data_category_id',                    'integer'],
                    [['name', 'url', 'status', 'is_default', 'description', 'metakeywords', 'metadescription', 'owner_id', 'theme', 'data_category_id'],  'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['name', 'url', 'data_category_id', 'status', 'metakeywords', 'metadescription', 'description',
                                                         'owner_id', 'theme'];
        $scenario['bulkedit']   = ['status'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'id'                => UsniAdaptor::t('application','Id'),
                        'name'				=> UsniAdaptor::t('application','Name'),
                        'url'				=> UsniAdaptor::t('stores', 'Store Url'),
                        'is_default'        => UsniAdaptor::t('stores', 'Is Default'),
                        'data_category_id'  => UsniAdaptor::t('dataCategories', 'Data Category'),
                        'metakeywords'      => UsniAdaptor::t('application', 'Meta Keywords'),
                        'metadescription'   => UsniAdaptor::t('application', 'Meta Description'),
                        'description'       => UsniAdaptor::t('application','Description'),
                        'theme'             => UsniAdaptor::t('application','Theme'),
                        'owner_id'          => UsniAdaptor::t('users','Owner'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
	public function attributeHints()
	{
		$hints = [
                        'name'				=> UsniAdaptor::t('storehint','Name of the store'),
                        'url'				=> UsniAdaptor::t('storehint', 'Web url for the store'),
                        'is_default'        => UsniAdaptor::t('storehint', 'Is store default for the application') .  '?',
                        'data_category_id'  => UsniAdaptor::t('storehint', 'Data Category associated with the store. The entities for example products associated with the datacategory would be associated to the store.'),
                        'metakeywords'      => UsniAdaptor::t('applicationhint', 'Meta Keywords'),
                        'metadescription'   => UsniAdaptor::t('applicationhint', 'Meta Description'),
                        'description'       => UsniAdaptor::t('applicationhint','Description'),
                        'theme'             => UsniAdaptor::t('storehint','Theme for this store')
                  ];
        return $hints;
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return $n == 1 ? UsniAdaptor::t('stores', 'Store'):UsniAdaptor::t('stores', 'Stores');
    }

    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name', 'description', 'metakeywords', 'metadescription'];
    }
    
    /**
     * Get shipping address for the store.
     * @return \Address
     */
    public function getShippingAddress()
    {
        return $this->hasOne(ShippingAddress::className(), ['relatedmodel_id' => 'id'])
                    ->where('relatedmodel = :rm AND type = :type', [':rm' => 'Store', ':type' => Address::TYPE_SHIPPING_ADDRESS]);
    }
    
    /**
     * Get billing address for the store.
     * @return \Address
     */
    public function getBillingAddress()
    {
        return $this->hasOne(BillingAddress::className(), ['relatedmodel_id' => 'id'])
                    ->where('relatedmodel = :rm AND type = :type', [':rm' => 'Store', ':type' => Address::TYPE_BILLING_ADDRESS]);
    }
    
    /**
     * Get local for the store.
     * @return \Local
     */
    public function getStoreLocal()
    {
        $allRecords = StoreConfiguration::find()->where('store_id = :sid AND code = :code', [':sid' => $this->id, ':code' => 'storelocal'])->asArray()->all();
        $storeLocal = new StoreLocal();
        foreach($allRecords as $record)
        {
            $key    = $record['key'];
            $value  = $record['value'];
            $storeLocal->$key = $value;
        }
        return $storeLocal;
    }
    
    /**
     * Get Settings for the store.
     * @return \StoreSettings
     */
    public function getStoreSettings()
    {
        $allRecords = StoreConfiguration::find()->where('store_id = :sid AND code = :code', [':sid' => $this->id, ':code' => 'storesettings'])->asArray()->all();
        $storeSettings = new StoreSettings();
        foreach($allRecords as $record)
        {
            $key    = $record['key'];
            $value  = $record['value'];
            $storeSettings->$key = $value;
        }
        return $storeSettings;
    }
    
    /**
     * Get image settings for the store.
     * @return \StoreImage
     */
    public function getStoreImage()
    {
        $allRecords = StoreConfiguration::find()->where('store_id = :sid AND code = :code', [':sid' => $this->id, ':code' => 'storeimage'])->asArray()->all();
        $storeImage = new StoreImage();
        foreach($allRecords as $record)
        {
            $key    = $record['key'];
            $value  = $record['value'];
            $storeImage->$key = $value;
        }
        return $storeImage;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            if($this->is_default || ($this->id == self::DEFAULT_STORE_ID))
            {
                throw new Exception("<strong>the default store can not be deleted</strong>");
            }
            //Delete store logo.
            if($this->storeImage->store_logo != null)
            {
                //Delete store_logo if exist
                $config = [
                            'model'             => $this->storeImage,
                            'attribute'         => 'store_logo', 
                            'uploadInstance'    => null, 
                            'savedFile'         => null,
                            'createThumbnail'   => true
                          ];
                $fileManagerInstance = UsniAdaptor::app()->assetManager->getResourceManager('image', $config);
                $fileManagerInstance->delete();
            }
            
            //Delete store icon.
            if($this->storeImage->icon != null)
            {
                //Delete icon if exist
                $config = [
                            'model'             => $this->storeImage, 
                            'attribute'         => 'icon', 
                            'uploadInstance'    => null, 
                            'savedFile'         => null
                          ];
                $fileManagerInstance = UsniAdaptor::app()->assetManager->getResourceManager('image', $config);
                $fileManagerInstance->delete();
            }
            
            //Delete Billing/Shipping address.
            Address::deleteAll('relatedmodel = :rm AND relatedmodel_id = :rmi', [':rm' => 'Store', ':rmi' => $this->id]);
            //Delete store local.
            StoreConfiguration::deleteAll('store_id = :sid AND code = :code', [':sid' => $this->id, ':code' => 'storelocal']);
            //Delete store settings.
            StoreConfiguration::deleteAll('store_id = :sid AND code = :code', [':sid' => $this->id, ':code' => 'storesettings']);
            //Delete store image
            StoreConfiguration::deleteAll('store_id = :sid AND code = :code', [':sid' => $this->id, ':code' => 'storeimage']);
            return true;
        }
        return false;
    }
}