<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\DataManager;
use products\models\Product;
use usni\library\utils\StatusUtil;
use taxes\models\ProductTaxClassTranslated;
use productCategories\models\ProductCategoryTranslated;
use products\db\ProductAttributeGroupDataManager;
use products\db\ProductAttributeDataManager;
use products\db\ProductOptionDataManager;
use common\modules\manufacturer\models\Manufacturer;
use products\db\ProductReviewDataManager;
use products\db\ProductDiscountDataManager;
use products\db\ProductSpecialDataManager;
use usni\UsniAdaptor;
use usni\library\utils\FileUploadUtil;
use usni\library\utils\FileUtil;
use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\lengthclass\models\LengthClassTranslated;
use common\modules\localization\modules\weightclass\models\WeightClassTranslated;
use products\models\ProductTranslated;
use products\models\ProductAttributeMapping;
use products\models\ProductAttributeTranslated;
use products\models\ProductOption;
use products\business\ProductOptionManager;
use usni\library\modules\users\models\User;
/**
 * Loads default data related to product.
 * 
 * @package products\db
 */
class ProductsDataManager extends DataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Product::className();
    }
    
    /**
     * Get product array.
     * @return array
     */
    public static function getProductArray()
    {
        if(YII_ENV == YII_ENV_TEST)
        {
            return ['Apple Cinema' => UsniAdaptor::t('products', 'Apple Cinema'), 
                'Sony Vaio' => UsniAdaptor::t('products', 'Sony Vaio')];
        }
        else
        {
            return ['Apple Cinema' => UsniAdaptor::t('products', 'Apple Cinema'), 'Canon EOS' => UsniAdaptor::t('products', 'Canon EOS'), 
                'Sony Vaio' => UsniAdaptor::t('products', 'Sony Vaio')];
        }
    }
    
    /**
     * Get product base.
     * @return array
     */
    public static function getProductBase()
    {
        return ['Apple Cinema' => 20, 'Canon EOS' => 5, 'Sony Vaio' => 20];
    }
    
    /**
     * Get product suffix.
     * @return array
     */
    public static function getProductSuffix()
    {
        return ['Apple Cinema' => '"', 'Canon EOS' => ['D, S, LX'], 'Sony Vaio' => '"'];
    }
    
    /**
     * Get product category mapping.
     * @return array.
     */
    public static function getProductToCategoryMapping()
    {
        $categoryD          = ProductCategoryTranslated::find()->where('name = :name AND language = :ln', 
                                                                      [':name' => 'Desktops', ':ln' => static::getDefaultLanguage()])->asArray()->one();
        $categoryL          = ProductCategoryTranslated::find()->where('name = :name AND language = :ln', 
                                                                     [':name' => 'Camera', ':ln' => static::getDefaultLanguage()])->asArray()->one();
        $categoryC          = ProductCategoryTranslated::find()->where('name = :name AND language = :ln', 
                                                                      [':name' => 'Laptops & Notebooks', ':ln' => static::getDefaultLanguage()])->asArray()->one();
        return ['Apple Cinema' => $categoryD['owner_id'], 'Canon EOS' => $categoryL['owner_id'], 'Sony Vaio' => $categoryC['owner_id']];
    }
    
    /**
     * Get product manufacturer mapping.
     * @return array
     */
    public static function getProductToManufacturerMapping()
    {
        $apple          = Manufacturer::find()->where('name = :name', [':name' => 'Apple'])->asArray()->one();
        $canon          = Manufacturer::find()->where('name = :name', [':name' => 'Canon'])->asArray()->one();
        $sony           = Manufacturer::find()->where('name = :name', [':name' => 'Sony'])->asArray()->one();
        return ['Apple Cinema' => $apple['id'], 'Canon EOS' => $canon['id'], 'Sony Vaio' => $sony['id']];
    }
    
    /**
     * Get product counter
     * @return int
     */
    public  static function getProductCounter()
    {
        if(YII_ENV_DEV)
        {
            return 3;
        }
        elseif(YII_ENV == 'test')
        {
            return 1;
        }
        else
        {
            return 10;
        }
    }

    /**
     * @inheritdoc
     */
    public function getDefaultDataSet()
    {
        $products                       = static::getProductArray();
        $productToCategoryMapping       = static::getProductToCategoryMapping();
        $productToManufacturerMapping   = static::getProductToManufacturerMapping();
        $productBaseMapping             = static::getProductBase();
        $productSuffixMapping           = static::getProductSuffix();
        $productTempData                = [];
        $productCounter                 = static::getProductCounter();
        $productImages                  = [];
        foreach($products as $product => $trValue)
        {
            $productBase = $productBaseMapping[$product];
            $productSuffix = $productSuffixMapping[$product];
            for($i = $productBase; $i <= $productBase + $productCounter; $i++)
            {
                if(!is_array($productSuffix))
                {
                    $productName = $trValue . ' ' . $i . $productSuffix;
                    $productTempData[$product][] = $productName;
                }
                else
                {
                    foreach ($productSuffix as $pSuffix)
                    {
                        $productSuffixArray = explode(',' , $pSuffix);
                        foreach($productSuffixArray as $suffix)
                        {
                            $productName = $trValue . ' ' . $i . $suffix;
                            $productTempData[$product][] = $productName;
                        }
                    }
                }
            }
        }
        $imageBasePath      = FileUtil::normalizePath(APPLICATION_PATH . '/data/images');
        $resourceBasePath   = static::getResourceImagesBasePath();
        if(is_dir($imageBasePath) && is_dir($resourceBasePath))
        {
            foreach ($productTempData as $key => $val)
            {
                if ($dh = opendir($imageBasePath . DS . $key))
                {
                    while (($file = readdir($dh)) !== false)
                    {
                        if($file != '.' && $file != '..')
                        {
                            $encryptedFileName  = FileUploadUtil::getEncryptedFileName($file);
                            if(YII_ENV != 'test')
                            {
                                $sourcePath         = FileUtil::normalizePath($imageBasePath . DS . $key . DS . $file);
                                $destPath           = FileUtil::normalizePath($resourceBasePath . DS . $encryptedFileName);
                                if(file_exists($destPath))
                                {
                                    @unlink($destPath);
                                }
                                if(copy($sourcePath, $destPath))
                                {
                                    $productImages[$key][] = $encryptedFileName;
                                }
                            }
                            else
                            {
                                $productImages[$key][] = $encryptedFileName;
                            }
                        }
                    }
                }
            }
        }
        $basePrice  = 10;
        $dataSet    = [];
        $productTaxClass   = ProductTaxClassTranslated::find()->where('name = :name AND language = :ln', 
                                                                     [':name' => 'taxable goods', ':ln' => static::getDefaultLanguage()])->asArray()->one();
        $lengthClass       = LengthClassTranslated::find()->where('name = :name AND language = :ln', 
                                                            [':name' => 'Centimeter', ':ln' => static::getDefaultLanguage()])->asArray()->one();
        $weightClass       = WeightClassTranslated::find()->where('name = :name AND language = :ln', 
                                                            [':name' => 'Gram', ':ln' => static::getDefaultLanguage()])->asArray()->one();
        //The data would as as
        /*Array
            (
                [Apple Cinema] => Array
                    (
                        [0] => Apple Cinema 20"
                        [1] => Apple Cinema 21"
                    )

                [Canon EOS] => Array
                    (
                        [0] => Canon EOS 5D
                        [1] => Canon EOS 5 S
                        [2] => Canon EOS 5 LX
                        [3] => Canon EOS 6D
                        [4] => Canon EOS 6 S
                        [5] => Canon EOS 6 LX
                    )

                [Sony Vaio] => Array
                    (
                        [0] => Sony Vaio 20"
                        [1] => Sony Vaio 21"
                    )

            )*/
        foreach($productTempData as $product => $data)
        {
            //Images for each product type for e.g. Apple
            $images = ArrayUtil::getValue($productImages, $product, null);
            $imagesCount = $images == null ? 0 : count($images);
            foreach ($data as $index => $nVal)
            {
                $imageIndex = null;
                $image      = null;
                if($imagesCount != 0)
                {
                    if($index >= $imagesCount)
                    {
                        $imageIndex = ($index - $imagesCount) % $imagesCount;
                    }
                    else
                    {
                        $imageIndex = $index;
                    }
                    $image = $images[$imageIndex];
                }
                $categoryId     = $productToCategoryMapping[$product];
                $alias          = strtolower(str_replace(' ', '-', $nVal));
                $manId          = $productToManufacturerMapping[$product];
                $dataSet[] = [
                                'name'              => $nVal,
                                'type'              => Product::TYPE_DEFAULT,
                                'alias'             => $alias,
                                'description'       => "This is description for product $nVal",
                                'status'            => StatusUtil::STATUS_ACTIVE,
                                'tax_class_id'      => $productTaxClass['owner_id'],
                                'minimum_quantity'  => '1',
                                'stock_status'      => Product::IN_STOCK,
                                'subtract_stock'    => 1,
                                'requires_shipping' => 1,
                                'is_featured'       => 1,
                                'model'             => $nVal . ' Model',
                                'sku'               => $nVal,
                                'price'             => $basePrice * ($index + 1),
                                'buy_price'         => $basePrice * ($index + 1),
                                'quantity'          => 10,
                                'initial_quantity'  => 10,
                                'manufacturer'      => $manId,
                                'categories'        => $categoryId,
                                'image'             => $image,
                                'date_available'    => date("Y-m-d"),
                                'length'            => 1.00,
                                'width'             => 2.00,
                                'height'            => 3.00,
                                'weight'            => 10,
                                'length_class'      => $lengthClass['owner_id'],
                                'weight_class'      => $weightClass['owner_id']
                        ];
            }
        }
        return $dataSet;
    }
    
    /**
     * @inheritdoc
     */
    public function loadDefaultDependentData()
    {
        ProductAttributeGroupDataManager::getInstance()->loadDefaultData();
        ProductAttributeDataManager::getInstance()->loadDefaultData();
        ProductOptionDataManager::getInstance()->loadDefaultData();
    }
    
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        if(parent::loadDefaultData())
        {
            ProductReviewDataManager::getInstance()->loadDefaultData();
            ProductDiscountDataManager::getInstance()->loadDefaultData();
            ProductSpecialDataManager::getInstance()->loadDefaultData();
            $this->assignOptionValuesToProducts();
            $this->assignAttributesToProducts();
            //Save notification template.
            $this->saveNotificationTemplate();
            return true;
            
        }
        return false;
    }
    
    /**
     * inheritdoc
     */
    public function getNotificationDataSet()
    {
        $filePath = UsniAdaptor::app()->getModule('catalog/products')->basePath . '/email/_productReview.php';
        return  [
                    [
                        'type'      => 'email',
                        'notifykey' => Product::NOTIFY_PRODUCTREVIEW,
                        'subject'   => UsniAdaptor::t('products', 'Product Review')  . ' | {{productName}}',
                        'content'   => file_get_contents($filePath)
                    ]
                ];
    }
    
    /**
     * Assign product option values to product
     */
    public function assignOptionValuesToProducts()
    {
        $productOptionManager = ProductOptionManager::getInstance(['userId' => User::SUPER_USER_ID]);
        $options        = ProductOption::find()->asArray()->all();
        $postData['required']       = 1;
        $postData['option_value_id']    = [1,2];
        $postData['quantity']           = [1,1];
        $postData['subtract_stock']     = [1,1];
        $postData['price_prefix']       = ['+','+'];
        $postData['price']              = [5,10];
        $postData['weight_prefix']      = ['+','+'];
        $postData['weight']             = ['',''];
        $product        = ProductTranslated::find()->where('alias = :alias AND language = :lan', [':lan' => 'en-US', ':alias' => 'apple-cinema-20"'])->asArray()->one();
        $postData['product_id']         = $product['owner_id'];
        $postData['option_id']          = $options[0]['id'];
        $productOptionManager->saveOptionMappingDetails($postData);
        
        //Sony vaio
        $postData['option_value_id']    = [4,5];
        $postData['price']              = [10,15];
        $product        = ProductTranslated::find()->where('alias = :alias AND language = :lan', [':lan' => 'en-US', ':alias' => 'sony-vaio-20"'])->asArray()->one();
        $postData['product_id']         = $product['owner_id'];
        $postData['option_id']          = $options[1]['id'];
        $productOptionManager->saveOptionMappingDetails($postData);
        
        //Sony vaio
        $postData['option_value_id']    = [8,9];
        $postData['price']              = [20,25];
        $product        = ProductTranslated::find()->where('alias = :alias AND language = :lan', [':lan' => 'en-US', ':alias' => 'canon-eos-5d'])->asArray()->one();
        $postData['product_id']         = $product['owner_id'];
        $postData['option_id']          = $options[2]['id'];
        $productOptionManager->saveOptionMappingDetails($postData);
    }
    
    /**
     * Assign attributes to product
     */
    public function assignAttributesToProducts()
    {
        $attribute      = ProductAttributeTranslated::find()->where('name = :name AND language = :lan', [':lan' => 'en-US', ':name' => 'Fan Speed'])->asArray()->one();;
        $product        = ProductTranslated::find()->where('alias = :alias AND language = :lan', [':lan' => 'en-US', ':alias' => 'apple-cinema-20"'])->asArray()->one();
        $prAttributeMapping = new ProductAttributeMapping();
        $prAttributeMapping->product_id = $product['id'];
        $prAttributeMapping->attribute_value   = '300 RPM';
        $prAttributeMapping->attribute_id = $attribute['owner_id'];
        $prAttributeMapping->save();
    }
    
    /**
     * Get resources images base path
     * @return string
     */
    public static function getResourceImagesBasePath()
    {
        return FileUtil::normalizePath(UsniAdaptor::app()->assetManager->imageUploadPath);
    }
}