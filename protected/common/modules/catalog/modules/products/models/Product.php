<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\models;

use usni\library\components\TranslatableActiveRecord;
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
use usni\library\components\ImageManager;
use common\modules\manufacturer\models\Manufacturer;
/**
 * Product Active Record
 *
 * @package products\models
 */
class Product extends TranslatableActiveRecord
{
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
     * Upload File Instance.
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
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = ['class' => ExtendedTaggable::className()];
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
        $categories = ProductUtil::getProductCategories($this->id);
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
        $this->relatedProducts = ProductUtil::getRelatedProductIds($this->id);
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
                            'savedFile'         => null
                          ];
                $fileManagerInstance = new ImageManager($config);
                $fileManagerInstance->delete();
            }
            //Delete productCategory
            ProductCategoryMapping::deleteAll('product_id = :pid', [':pid' => $this->id]);
            //Delete related product
            ProductRelatedProductMapping::deleteAll('product_id = :pid', [':pid' => $this->id]);
            //Delete tags
            ProductTagMapping::deleteAll('product_id = :pid', [':pid' => $this->id]);
            //Delete product attribute mapping
            ProductAttributeMapping::deleteAll('product_id = :pid', [':pid' => $this->id]);
            //Delete product attribute mapping
            ProductOptionMapping::deleteAll('product_id = :pid', [':pid' => $this->id]);
            //Delete product images
            $prImages = $this->productImages;
            if(!empty($prImages))
            {
                foreach($prImages as $prImage)
                {
                    $prImage->delete();
                }
            }
            //Delete product reviews
            $prReviews = $this->productReviews;
            if(!empty($prReviews))
            {
                foreach($prReviews as $prReview)
                {
                    $prReview->delete();
                }
            }
            //Delete product discount
            ProductDiscount::deleteAll('product_id = :pid', [':pid' => $this->id]);
            
            //Delete product special
            ProductSpecial::deleteAll('product_id = :pid', [':pid' => $this->id]);
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
                [['name', 'alias', 'sku', 'price', 'quantity', 'categories'], 'required', 'except'=>'search'],
                [['image'], 'required', 'on' => 'create'],
                [['uploadInstance'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif, jpeg'],
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
                [['location', 'length', 'width', 'height', 'date_available', 'weight', 'length_class', 'weight_class'],  'safe'],
                [['name', 'description', 'metakeywords', 'metadescription', 'tagNames', 'minimum_quantity', 
                  'subtract_stock', 'requires_shipping', 'manufacturer', 'alias', 'categories', 
                  'image', 'is_featured', 'relatedProducts', 'model', 'sku', 'price', 'quantity', 'status', 'tax_class_id', 'stock_status', 
                  'length_class', 'weight_class', 'buy_price', 'initial_quantity'], 'safe'],
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
                                                            'buy_price', 'initial_quantity'];
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
     * Renders categories for the product.
     * @return string
     */
    public function renderCategories()
    {
        $categories = $this->categoriesList;
        if(empty($categories))
        {
            $rows           = ProductUtil::getProductCategories($this->id);
            $categoryArray  = [];
            foreach ($rows as $row)
            {
                $categoryArray[] = $row['name'];
            }
            if (count($categoryArray) > 0)
            {
                return implode(',', $categoryArray);
            }
            else
            {
                return '';
            }
        }
        else
        {
            return implode(',', array_values($categories));
        }
    }

    /**
     * Renders relatedProduct for the product.
     * @return string
     */
    public function renderRelatedProducts()
    {
        $rows = self::getRelatedProduct($this->id);
        $relatedProductsArray = array();
        foreach ($rows as $row)
        {
            $relatedProduct = Product::findOne($row['related_product_id']);
            if ($relatedProduct != null)
            {
                $relatedProductsArray[] = $relatedProduct->name;
            }
        }
        if (count($relatedProductsArray) > 0)
        {
            return implode(', ', $relatedProductsArray);
        }
        else
        {
            return '';
        }
    }

    /**
     * Get categories for the product.
     * @param integer $id ID of product Category.
     * @return array
     */
    public static function getRelatedProduct($id)
    {
        $tableName = ProductRelatedProductMapping::tableName();
        $relatedProduct = UsniAdaptor::db()->createCommand('select * FROM ' . $tableName . ' WHERE product_id = :productid')->bindValue(':productid', $id)
                          ->queryAll();
        return $relatedProduct;
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
            ProductUtil::saveProductCategoryMapping($this);
            ProductUtil::saveProductDiscounts($this);
            ProductUtil::saveProductSpecials($this);
            ProductUtil::saveRelatedProductsMapping($this);
            ProductUtil::saveProductImages($this);
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
}