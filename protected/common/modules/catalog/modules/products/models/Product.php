<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use products\models\ProductCategoryMapping;
use backend\components\ExtendedTaggable;
use usni\library\utils\ArrayUtil;
use products\utils\ProductUtil;
use products\models\ProductAttribute;
use products\models\ProductAttributeMapping;
use products\models\ProductOption;
use products\models\ProductOptionMapping;
use products\models\ProductReview;
use products\models\ProductDiscount;
use products\models\ProductSpecial;
use products\models\ProductTagMapping;
use products\models\ProductImage;
use common\modules\manufacturer\models\Manufacturer;
use usni\library\utils\FileUploadUtil;
use products\dao\ProductDAO;
use productCategories\dao\ProductCategoryDAO;
/**
 * Product Active Record
 *
 * @package products\models
 */
class Product extends TranslatableActiveRecord
{
    use \products\traits\DownloadTrait;
    
    /**
     * Type constants 
     */
    const TYPE_DEFAULT = 1;
    const TYPE_DOWNLOADABLE = 2;
    
    //Stock options
    const IN_STOCK          = 1;
    const OUT_OF_STOCK      = 2;
    
    /**
     * Default page size.
     * @var integer
     */
    const DEFAULT_PAGE_SIZE = 10;
    
    /**
     * Upload File Instance.
     * @var string
     */
    public $uploadInstance;

    /**
     * Saved image in database.
     * @var string
     */
    public $savedImage;

    /**
     * Categories associated with the product.
     * @var array
     */
    public $categories = [];
    
    /**
     * List of the categories associated with the product.
     * @var array
     */
    protected $categoriesList = [];

    /**
     * Related products associated with the product.
     * @var array
     */
    public $relatedProducts = [];

    /**
     * Category id
     * @var int
     */
    public $category_id;
    
    /**
     * @var string helper attribute to work with tags
     */
    public $tagNames;

    /**
     * Total price for the product.
     * @var double 
     */
    public $totalPrice;
    
    /**
     * Items per page
     * @var int 
     */
    public $itemPerPage;
    
    /**
     * Sort by column
     * @var string 
     */
    public $sort_by;
    
    /**
     * Discounts applied on product.
     * @var array 
     */
    public $discounts;
    
    /**
     * Specials applied on product.
     * @var array 
     */
    public $specials;
    
    /**
     * Images uploaded.
     * @var array
     */
    public $images = [];
    
    /**
     * $product image data.
     * @var array
     */
    public $productImageData = [];
    
    /**
     * Notification constants
     */
    const NOTIFY_PRODUCTREVIEW    = 'productReview';
    
    /**
     * Downloads applied on product.
     * @var array 
     */
    public $downloads = [];
    
    /**
     * Download options for product
     * @var string 
     */
    public $download_option;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->scenario == 'create')
        {
            $this->type = self::TYPE_DEFAULT;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [['class' => ExtendedTaggable::className()]];
        return ArrayUtil::merge($behaviors, parent::behaviors());
    }
    
    /**
     * After find processing for the product. Sets the categories for the product.
     * @return void
     */
    public function afterFind()
    {
        $categoryArray  = [];
        parent::afterFind();
        $categories = ProductDAO::getCategories($this->id, $this->language);
        foreach ($categories as $category)
        {
            $categoryArray[$category['id']] = $category['name'];
        }
        $this->categories = array_keys($categoryArray);
        $this->categoriesList = $categoryArray;
        $tags   = $this->tags;
        if(!empty($tags))
        {
            $tagNames = [];
            foreach($tags as $tag)
            {
                $tagNames[] = $tag->name;
            }
            $this->tagNames = implode(', ' , $tagNames);
        }
        $relatedProducts        = ProductDAO::getRelatedProducts($this->id, $this->language);
        $relatedProductsIds     = [];
        foreach($relatedProducts as $relatedProduct)
        {
            $relatedProductsIds[] = $relatedProduct['id'];
        }
        $this->relatedProducts  = $relatedProductsIds;
        $this->downloads        = $this->getDownloadIds($this->id);
        $this->download_option  = $this->getDownloadOption($this->id);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete())
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
            //Delete product images.
            foreach($this->productImages as $productImage)
            {
                $productImage->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * @return array validation rules for model attributes.
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
                [['name', 'alias', 'sku', 'price', 'quantity', 'categories', 'type'], 'required', 'except'=>'search'],
                [['image'], 'required', 'on' => 'create'],
                ['downloads', 'required', 
                    'whenClient' => "function(attribute, value){
                        return $('#product-type').val() === '2';
                     }", 
                    'when' => [$this, 'validateDownloads'], 
                    'message' => UsniAdaptor::t('products', 'Downloads are required')],
                [['image', 'uploadInstance'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif, jpeg'],
                ['name', 'unique', 'targetClass' => ProductTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                ['alias', 'unique', 'targetClass' => ProductTranslated::className(), 'targetAttribute' => ['alias', 'language'], 'on' => 'create'],
                ['name', 'unique', 'targetClass' => ProductTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                ['alias', 'unique', 'targetClass' => ProductTranslated::className(), 'targetAttribute' => ['alias', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                [['quantity', 'status', 'minimum_quantity'],         'number', 'integerOnly' => true],
                ['minimum_quantity', 'default', 'value' => 1],
                ['price',                                            'match', 'pattern'=>'/^[0-9]{1,12}(\.[0-9]{0,4})?$/'],
                ['name',                                             'string', 'max' => 128],
                ['alias',                                            'string', 'max' => 128],
                ['model',                                            'string', 'max' => 64],
                ['relatedProducts',                                  'safe'],
                ['type',                                             'default', 'value' => self::TYPE_DEFAULT],
                ['hits',                                             'number'],
                [['length', 'width', 'height', 'weight'], 'number'],
                [['location', 'length', 'width', 'height', 'date_available', 'weight', 'length_class', 'weight_class'],  'safe'],
                [['name', 'description', 'metakeywords', 'metadescription', 'tagNames', 'minimum_quantity', 
                  'subtract_stock', 'requires_shipping', 'manufacturer', 'alias', 'categories', 
                  'image', 'is_featured', 'relatedProducts', 'model', 'sku', 'price', 'quantity', 'status', 'tax_class_id', 'stock_status', 
                  'length_class', 'weight_class', 'buy_price', 'initial_quantity', 'type', 'downloads', 'hits', 'upc',  'ean', 'jan', 'isbn', 
                  'mpn', 'download_option'], 'safe'],
            ];
        }
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
            $scenarios               = parent::scenarios();
            $scenarios['create']     = $scenarios['update'] = ['name', 'description', 'metakeywords', 'metadescription', 'tagNames', 
                                                            'minimum_quantity', 'subtract_stock', 'requires_shipping', 'manufacturer', 
                                                            'alias', 'categories', 'image', 'is_featured', 'relatedProducts',
                                                            'model', 'sku', 'price', 'quantity', 'status', 'tax_class_id', 'stock_status', 'location', 
                                                            'length', 'width', 'height', 'date_available', 'weight', 'length_class', 'weight_class',
                                                            'buy_price', 'initial_quantity', 'downloads', 'type', 'hits', 'upc',  'ean', 'jan', 
                                                            'isbn', 'mpn', 'download_option'];
            $scenarios['bulkedit']    = ['status'];
            $scenarios['search']      = ['name', 'category_id'];
            $scenarios['deleteimage'] = ['image'];
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
            return $configInstance->attributeLabels();
        }
        else
        {
            $labels = ProductUtil::getProductLabels();
            return parent::getTranslatedAttributeLabels($labels);
        }
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
            return ProductUtil::getProductHints();
        }
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('products', 'Product') : UsniAdaptor::t('products', 'Products');
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->scenario == 'update')
        {
            ProductCategoryMapping::deleteAll('product_id = :pid', [':pid' => $this->id]);
        }
        if ($this->scenario == 'create' || $this->scenario == 'update')
        {
            $this->saveProductCategoryMapping();
            $this->saveProductDiscounts();
            $this->saveProductSpecials();
            $this->saveRelatedProductsMapping();
            $this->saveProductImages();
            $this->saveDownloadMapping();
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
     * Get tags.
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
       return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable(ProductTagMapping::tableName(), ['product_id' => 'id']);
    }
    
    /**
     * Get product attributes.
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributes()
    {
       return $this->hasMany(ProductAttribute::className(), ['id' => 'attribute_id'])
                ->viaTable(ProductAttributeMapping::tableName(), ['product_id' => 'id']);
    }
    
    /**
     * Get product options.
     * @return \yii\db\ActiveQuery
     */
    public function getProductOptions()
    {
       return $this->hasMany(ProductOption::className(), ['id' => 'option_id'])
                ->viaTable(ProductOptionMapping::tableName(), ['product_id' => 'id'])
                ->orderBy(['sort_order' => SORT_ASC]);
    }
    
    /**
     * Get product reviews.
     * @return \yii\db\ActiveQuery
     */
    public function getProductReviews()
    {
       return $this->hasMany(ProductReview::className(), ['product_id' => 'id']);
    }
    
    /**
     * Get product discounts.
     * @return \yii\db\ActiveQuery
     */
    public function getProductDiscounts()
    {
       return $this->hasMany(ProductDiscount::className(), ['product_id' => 'id'])->orderBy(['quantity' => SORT_DESC, 'priority' => SORT_ASC]);
    }
    
    /**
     * Get product specials.
     * @return \yii\db\ActiveQuery
     */
    public function getProductSpecials()
    {
       return $this->hasMany(ProductSpecial::className(), ['product_id' => 'id'])->orderBy(['priority' => SORT_ASC]);
    }
    
    /**
     * Get product images.
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }
    
    /**
     * Get product manufacturer
     * @return \yii\db\ActiveQuery
     */
    public function getProductManufacturer()
    {
        return $this->hasOne(Manufacturer::className(), ['id' => 'manufacturer']);
    }
    
    /**
     * Validate downloads
     * @param Product $model
     * @param string $attribute
     * @return boolean
     */
    public function validateDownloads($model, $attribute)
    {
        return $model->type == self::TYPE_DOWNLOADABLE;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->type == self::TYPE_DOWNLOADABLE)
            {
                $this->requires_shipping = 0;
            }
            return true;
        }
        return false;
    }
    
    /**
     * Save product category mapping
     * @return void
     */
    public function saveProductCategoryMapping()
    {
        $data = [];
        $data['product_id']  = $this->id;
        $data['category_id'] = $this->categories;
        if(is_array($data['category_id']))
        {
            $productCategoryMappingData = [];
            foreach ($data['category_id'] as $catId)
            {
                $productCategory                = ProductCategoryDAO::getById($catId, $this->language);
                $productCategoryMappingData[]   = [$this->id, $catId, $productCategory['data_category_id'], $this->getUserId(), date('Y-m-d H:i:s'), $this->getUserId(), date('Y-m-d H:i:s')];
            }
            $columns    = ['product_id', 'category_id', 'data_category_id', 'created_by', 'created_datetime', 'modified_by', 'modified_datetime'];
            $table      = UsniAdaptor::tablePrefix() . 'product_category_mapping';
            try
            {
                UsniAdaptor::app()->db->createCommand()->batchInsert($table, $columns, $productCategoryMappingData)->execute();
            }
            catch (\yii\db\Exception $e)
            {
                throw $e;
            }
        }
        else
        {
            $productCategoryMapping = new ProductCategoryMapping(['scenario' => 'create']);
            $productCategoryMapping->product_id         = $this->id;
            $productCategoryMapping->category_id        = $this->categories;
            $productCategory                            = ProductCategoryDAO::getById($this->categories, $this->language);
            $productCategoryMapping->data_category_id   = $productCategory['data_category_id'];
            $productCategoryMapping->save();
        }
    }
    
    /**
     * Save product discounts
     * @return void
     */
    public function saveProductDiscounts()
    {
        ProductDiscount::deleteAll('product_id = :pid', [':pid' => $this->id]);
        $discounts  = $this->discounts;
        if(!empty($discounts))
        {
            foreach($discounts as $discount)
            {
                $prDiscount = new ProductDiscount(['scenario' => 'create']);
                $prDiscount->setAttributes($discount);
                $prDiscount->product_id = $this->id;
                $prDiscount->save();
            }
        }
    }
    
    /**
     * Save product specials
     * @return void
     */
    public function saveProductSpecials()
    {
        ProductSpecial::deleteAll('product_id = :pid', [':pid' => $this->id]);
        $specials  = $this->specials;
        if(!empty($specials))
        {
            foreach($specials as $special)
            {
                $prSpecial = new ProductSpecial(['scenario' => 'create']);
                $prSpecial->setAttributes($special);
                $prSpecial->product_id = $this->id;
                $prSpecial->save();
            }
        }
    }
    
    /**
     * Saves related products mapping
     */
    public function saveRelatedProductsMapping()
    {
        ProductRelatedProductMapping::deleteAll('product_id = :pid', [':pid' => $this->id]);
        if(!empty($this->relatedProducts) && is_array($this->relatedProducts))
        {
            $relatedProductMappingData =  [];
            foreach ($this->relatedProducts as $relatedProductId)
            {
                $relatedProductMappingData[] = [$this->id, $relatedProductId, $this->getUserId(), date('Y-m-d H:i:s'), $this->getUserId(), date('Y-m-d H:i:s')];
            }
            $table      = UsniAdaptor::tablePrefix() . 'product_related_product_mapping';
            $columns    = ['product_id', 'related_product_id', 'created_by', 'created_datetime', 'modified_by', 'modified_datetime'];
            try
            {
                UsniAdaptor::app()->db->createCommand()->batchInsert($table, $columns, $relatedProductMappingData)->execute();
            }
            catch (\yii\db\Exception $e)
            {
                throw $e;
            }
        }
    }
    
    /**
     * Save product images.
     * @return void
     */
    public function saveProductImages()
    {
        $images             = $this->images;
        if(!empty($images))
        {
            foreach($images as $index => $productImage)
            {
                $savedFile  = null;
                if($productImage->isNewRecord)
                {
                    $productImage->product_id = $this->id;
                }
                else
                {
                    $productImage->scenario = 'update';
                    $savedFile = $productImage->image;
                }
                if($productImage->save())
                {
                    $config = [
                        'model'             => $productImage, 
                        'attribute'         => 'image', 
                        'uploadInstance'    => $productImage->uploadInstance,
                        'savedFile'         => $savedFile,
                        'createThumbnail'   => true
                      ];
                    FileUploadUtil::save('image', $config);
                }
            }
        }   
    }
    
    /**
     * Saves related downloads mapping
     */
    public function saveDownloadMapping()
    {
        ProductDownloadMapping::deleteAll('product_id = :pid', [':pid' => $this->id]);
        if(!empty($this->downloads) && is_array($this->downloads))
        {
            $relatedDownloadMappingData =  [];
            foreach ($this->downloads as $downloadId)
            {
                $relatedDownloadMappingData[] = [$this->id, $downloadId, $this->download_option, $this->getUserId(), date('Y-m-d H:i:s'), $this->getUserId(), date('Y-m-d H:i:s')];
            }
            $table      = UsniAdaptor::tablePrefix() . 'product_download_mapping';
            $columns    = ['product_id', 'download_id', 'download_option', 'created_by', 'created_datetime', 'modified_by', 'modified_datetime'];
            try
            {
                UsniAdaptor::app()->db->createCommand()->batchInsert($table, $columns, $relatedDownloadMappingData)->execute();
            }
            catch (\yii\db\Exception $e)
            {
                throw $e;
            }
        }
    }
}