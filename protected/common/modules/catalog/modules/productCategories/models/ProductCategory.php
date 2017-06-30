<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use usni\library\utils\StatusUtil;
use common\modules\dataCategories\models\DataCategory;
use products\dao\ProductDAO;
use yii\db\Exception;
use productCategories\dao\ProductCategoryDAO;
use common\modules\dataCategories\business\Manager;
/**
 * ProductCategory active record.
 *
 * @package productCategories\models
 */
class ProductCategory extends TranslatableActiveRecord
{
    use \usni\library\traits\TreeModelTrait;
    
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
     * @var integer 
     */
    public $savedDataCategoryId;

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
                [['image', 'uploadInstance'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif'],
                [['parent_id', 'level', 'status'],  'number', 'integerOnly' => true],
                [['name'],                          'string', 'max' => 128],
                ['alias',                           'string', 'max' => 128],
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
            $this->level                = $this->getLevel($this->parent_id);
            $category                   = ProductCategoryDAO::getById($this->id, $this->language);
            $this->savedDataCategoryId  = $category['data_category_id'];
            return true;
        }
       return false;
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        $isAllowedToDelete = $this->checkIfAllowedToDelete();
        if($isAllowedToDelete == false)
        {
            throw new Exception('products are associated to category.');
        }
        if(parent::beforeDelete())
        {
            if($this->image != null)
            {
                //Delete image if exist
                $config = [
                            'model'             => $this, 
                            'attribute'         => 'image', 
                            'uploadInstance'    => null, 
                            'savedFile'         => null,
                            'createThumbnail'   => true
                          ];
                $fileManagerInstance = UsniAdaptor::app()->assetManager->getResourceManager('image', $config);
                $fileManagerInstance->delete();
                //Delete 50_50 image as well on index page
                $config['thumbWidth']   = 50;
                $config['thumbHeight']  = 50;
                $fileManagerInstance = UsniAdaptor::app()->assetManager->getResourceManager('image', $config);
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
        $this->updatePath();
        // Update mapping table with changed data category.
        if($this->scenario === 'update' && $this->data_category_id !== $this->savedDataCategoryId)
        {
            $table      = UsniAdaptor::tablePrefix() . 'product_category_mapping';
            $columns    = ['data_category_id' => $this->data_category_id];
            UsniAdaptor::app()->db->createCommand()->update($table, $columns, 'category_id = :cid', [':cid' => $this->id])->execute();
        }
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name', 'alias', 'description', 'metakeywords', 'metadescription'];
    }
    
    /**
     * Check if allowed to delete.
     * @return boolean
     */
    public function checkIfAllowedToDelete()
    {
       $products = ProductDAO::getByProductCategoryId($this->id, $this->language);
       if(empty($products))
       {
           return true;
       }
       return false;
    }
    
    /**
     * inheritdoc
     * This method has been overridden to make sure that children of group would not be displayed in parent dropdown when that group would be updated.
     */
    public function getMultiLevelSelectOptions($textFieldName,
                                               $accessOwnedModelsOnly = false,
                                               $valueFieldName = 'id')
    {
        $childrens      = array_keys($this->getTreeRecordsInHierarchy());
        $itemsArray     = [];
        if($this->nodeList === null)
        {
            $this->nodeList  = $this->descendants(0, false);
        }
        $items   = static::flattenArray($this->nodeList);
        foreach($items as $item)
        {
            $row = $item['row'];
            if($this->$valueFieldName != $row[$valueFieldName])
            {
                if(($accessOwnedModelsOnly === true && $this->created_by == $row['created_by']) || ($accessOwnedModelsOnly === false))
                {
                    if(!in_array($row['id'], $childrens))
                    {
                        $itemsArray[$row[$valueFieldName]] = str_repeat('-', $row['level']) . $row[$textFieldName];
                    }
                }
            }
        }
        return $itemsArray;
    }
    
    /**
     * Get descendants based on a parent.
     * @param int $parentId
     * @param int $onlyChildren If only childrens have to be fetched
     * @return boolean
     */
    public function descendants($parentId = 0, $onlyChildren = false)
    {
        $recordsData    = [];
        $records        = ProductCategoryDAO::getChildrens($parentId, $this->language, $this->data_category_id);
        if(!$onlyChildren)
        {
            foreach($records as $record)
            {
                $hasChildren    = false;
                $childrens      = $this->descendants($record['id'], $onlyChildren);
                if(count($childrens) > 0)
                {
                    $hasChildren = true;
                }
                $recordsData[]  = ['row'         => $record,
                                   'hasChildren' => $hasChildren, 
                                   'children'    => $childrens];
            }
            return $recordsData;
        }
        else
        {
            foreach($records as $record)
            {
                $recordsData[]  = ['row'         => $record,
                                   'hasChildren' => false, 
                                   'children'    => []];
            }
            return $recordsData;
        }
    }
}