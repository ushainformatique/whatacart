<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\models;

use usni\library\components\TranslatableActiveRecord;
use usni\UsniAdaptor;
use usni\library\utils\StatusUtil;
use common\modules\dataCategories\models\DataCategory;
use usni\library\components\ImageManager;
/**
 * ProductCategory active record.
 *
 * @package productCategories\models
 */
class ProductCategory extends TranslatableActiveRecord
{
    use \productCategories\traits\ProductCategoryTrait;
    /**
     * Upload File Instance.
     * @var string
     */
    public $uploadInstance;
    /**
     * Upload File Instance.
     * @var string
     */
    public $savedImage;

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
                [['name', 'alias', 'data_category_id', 'code'], 'required'],
                [['image'], 'required', 'on' => 'create'],
                [['uploadInstance'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif'],
                [['parent_id', 'level', 'status'],  'number', 'integerOnly' => true],
                [['name'],                          'string', 'max' => 128],
                ['alias',                           'string', 'max' => 32],
                ['parent_id',                       'default', 'value' => 0],
                ['level',                           'default', 'value' => 0],
                ['status',                          'default', 'value' => StatusUtil::STATUS_ACTIVE],
                ['image',                           'safe'],
                ['image',                           'string', 'max' => 255],
                ['alias',                           'unique', 'targetClass' => ProductCategoryTranslated::className(), 'on' => 'create'],
                ['name',                            'unique', 'targetClass' => ProductCategoryTranslated::className(), 'on' => 'create'],
                ['name', 'unique', 'targetClass' => ProductCategoryTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                ['alias', 'unique', 'targetClass' => ProductCategoryTranslated::className(), 'targetAttribute' => ['alias', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                [['name', 'alias', 'image', 'parent_id', 'status', 'displayintopmenu', 'data_category_id', 'metakeywords', 'metadescription', 'description', 'level', 'code'], 'safe'],
            ];
        }
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario                = parent::scenarios();
        $scenario['create']      = $scenario['update'] = ['name', 'alias', 'image', 'parent_id', 'status', 'displayintopmenu', 'data_category_id', 'metakeywords', 'metadescription', 'description', 'level', 'code'];
        $scenario['bulkedit']    = ['status'];
        $scenario['deleteimage'] = ['image'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
                    'parent_id'         => UsniAdaptor::t('application', 'Parent'),
                    'name'              => UsniAdaptor::t('application', 'Name'),
                    'description'       => UsniAdaptor::t('application', 'Description'),
                    'status'            => UsniAdaptor::t('application', 'Status'),
                    'alias'             => UsniAdaptor::t('application', 'Alias'),
                    'image'             => UsniAdaptor::t('application', 'Image'),
                    'metakeywords'      => UsniAdaptor::t('application', 'Meta Keywords'),
                    'metadescription'   => UsniAdaptor::t('application', 'Meta Description'),
                    'displayintopmenu'  => UsniAdaptor::t('productCategories', 'Display in top menu'),
                    'data_category_id'  => DataCategory::getLabel(1),
                    'code'              => UsniAdaptor::t('application', 'Code'),
                ];
        return parent::getTranslatedAttributeLabels($labels);
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('productCategories', 'Product Category') : UsniAdaptor::t('productCategories', 'Product Categories');
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            $this->level = $this->getLevel($this->parent_id);
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
            if($this->image != null)
            {
                //Delete image if exist
                $config = [
                            'model'             => $this, 
                            'attribute'         => 'image', 
                            'uploadInstance'    => null, 
                            'savedFile'         => null
                          ];
                $fileManagerInstance = new ImageManager($config);
                $fileManagerInstance->delete();
            }
            $prefix = UsniAdaptor::db()->tablePrefix;
            //Delete productCategory mapping with its associated products.
            UsniAdaptor::db()->createCommand()
                ->delete($prefix .  'product_category_mapping', 'category_id = :cId', [':cId' => $this->id]);
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
        $this->updateChildrensLevel();
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name', 'alias', 'description', 'metakeywords', 'metadescription'];
    }
}