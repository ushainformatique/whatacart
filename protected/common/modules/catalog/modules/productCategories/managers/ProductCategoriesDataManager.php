<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\managers;

use usni\library\components\UiDataManager;
use productCategories\models\ProductCategory;
use usni\UsniAdaptor;
use usni\library\utils\FileUtil;
use usni\library\utils\FileUploadUtil;
use common\modules\dataCategories\managers\DataCategoriesDataManager;
/**
 * Loads default data related to product categories.
 * 
 * @package productCategories\managers
 */
class ProductCategoriesDataManager extends UiDataManager
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        return [
                    [
                        'name'              => UsniAdaptor::t('productCategories', 'Desktops'),
                        'alias'             =>  UsniAdaptor::t('productCategories', 'desktops'),
                        'data_category_id'  => 1,
                        'displayintopmenu'  => 1,
                        'description'       => UsniAdaptor::t('productCategories', 'Shop Desktop feature only the best desktop deals on the market'),
                        'code'              => 'DT',
                        'image'             => self::getProductCategoryImage('Desktops')
                    ],
                    [
                        'name'              =>  UsniAdaptor::t('productCategories', 'Laptops & Notebooks'),
                        'alias'             =>  UsniAdaptor::t('productCategories', 'laptops-notebooks'),
                        'data_category_id'  => 1,
                        'displayintopmenu'  => 1,
                        'description'       => UsniAdaptor::t('productCategories', 'Shop Laptop feature only the best laptop deals on the market'),
                        'code'              => 'LTNB',
                        'image'             => self::getProductCategoryImage('Laptops & Notebooks')
                    ],
                    [
                        'name'              =>  UsniAdaptor::t('productCategories', 'Camera'),
                        'alias'             =>  UsniAdaptor::t('productCategories', 'camera'),
                        'data_category_id'  => 1,
                        'displayintopmenu'  => 1,
                        'description'       => UsniAdaptor::t('productCategories', 'Shop Camera feature only the best laptop deals on the market'),
                        'code'              => 'CM',
                        'image'             => self::getProductCategoryImage('Camera')
                    ]
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return ProductCategory::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
    
    /**
     * Get product category image.
     * @param string $catName
     * @return string
     */
    public static function getProductCategoryImage($catName)
    {
        $imageBasePath      = FileUtil::normalizePath(APPLICATION_PATH . '/data/images/category');
        $resourceBasePath   = static::getResourceImagesBasePath();
        if(is_dir($imageBasePath) && is_dir($resourceBasePath))
        {
            if ($dh = opendir($imageBasePath . DS . $catName))
            {
                while (($file = readdir($dh)) !== false)
                {
                    if($file != '.' && $file != '..')
                    {
                        $encryptedFileName  = FileUploadUtil::getEncryptedFileName($file);
                        if(YII_ENV != YII_ENV_TEST)
                        {
                            $sourcePath         = FileUtil::normalizePath($imageBasePath . DS . $catName . DS . $file);
                            $destPath           = FileUtil::normalizePath($resourceBasePath . DS . $encryptedFileName);
                            if(file_exists($destPath))
                            {
                                @unlink($destPath);
                            }
                            if(copy($sourcePath, $destPath))
                            {
                                return $encryptedFileName;
                            }
                        }
                        else
                        {
                            return $encryptedFileName;
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Get resources images base path
     * @return string
     */
    public static function getResourceImagesBasePath()
    {
        return FileUtil::normalizePath(UsniAdaptor::app()->assetManager->imageUploadPath);
    }
    
    /**
     * @inheritdoc
     */
    protected static function loadDefaultDependentData()
    {
        DataCategoriesDataManager::loadDefaultData(); 
    }
}