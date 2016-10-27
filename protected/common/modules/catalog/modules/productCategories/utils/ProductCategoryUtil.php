<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\utils;

use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use yii\caching\DbDependency;
/**
 * ProductCategoryUtil class file.
 * 
 * @package productCategories\utils
 */
class ProductCategoryUtil
{
    /**
     * Get items per page options.
     * @return Array
     */
    public static function getItemsPerPageOptions()
    {
        return [
                    9   => 9,
                    18  => 18,
                    27  => 27,
                    36  => 36,
                    45  => 45,
                    54  => 54,
                    63  => 63
               ];
    }
    
    /**
     * Get sorting options for products.
     * @return Array
     */
    public static function getSortingOptions()
    {
        return [
                    ''          => UiHtml::getDefaultPrompt(),
                    'nameasc'   => UsniAdaptor::t('products', 'Name(A-Z)'),
                    'namedesc'  => UsniAdaptor::t('products', 'Name(Z-A)'),
                    'priceasc'  => UsniAdaptor::t('products', 'Price(Low > High)'),
                    'pricedesc' => UsniAdaptor::t('products', 'Price(High > Low)'),
               ];
    }
    
    /**
     * Get product categpry by id
     * @param int $id
     * @param string $language
     * @return array
     */
    public static function getCategoryById($id, $language = null)
    {
        if($language == null)
        {
            $language  = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = UsniAdaptor::tablePrefix() . 'product_category';
        $peTableName            = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                    = "SELECT pc.*, pct.name, pct.alias, pct.metakeywords, pct.metadescription, pct.description
                                   FROM $tableName pc, $peTableName pct 
                                   WHERE pc.id = :id AND pc.id = pct.owner_id AND pct.language = :lan";
        return $connection->createCommand($sql, [':id' => $id, ':lan' => $language])
                          ->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get product categpry by id
     * @param int $parentId
     * @param int $storeDataCategory
     * @param string $language
     * @return array
     */
    public static function getTopMenuCategoriesByParent($parentId, $storeDataCategory, $language = null)
    {
        if($language == null)
        {
            $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = UsniAdaptor::tablePrefix() . 'product_category';
        $peTableName            = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                    = "SELECT pc.*, pct.name, pct.alias, pct.metakeywords, pct.metadescription, pct.description
                                   FROM $tableName pc, $peTableName pct 
                                   WHERE pc.data_category_id = :id AND pc.parent_id = :pid AND pc.displayintopmenu = :dtm 
                                   AND pc.id = pct.owner_id AND pct.language = :lan";
        return $connection->createCommand($sql, [':id' => $storeDataCategory, ':pid' => $parentId, ':lan' => $language, ':dtm' => 1])
                          ->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get current store's product category.
     * @return array
     */
    public static function getStoreProductCategories()
    {
        $currentStore           = UsniAdaptor::app()->storeManager->getCurrentStore();
        $categoryTable          = UsniAdaptor::tablePrefix() . 'product_category';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $categoryTable"]);
        $sql                    = "SELECT ct.*
                                   FROM $categoryTable ct
                                   WHERE ct.data_category_id = :dci";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':dci' => $currentStore->data_category_id])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get display in  top menu.
     * @param boolean $displayInTopMenu
     * @return string
     */
    public static function getDisplayInTopMenu($displayInTopMenu)
    {
        if($displayInTopMenu == true)
        {
            return UsniAdaptor::t('application', 'Yes');
        }
        return UsniAdaptor::t('application', 'No');
    }
    
    /**
     * Get data category id.
     * @param integer $catId
     * @return integer
     */
    public static function getDataCategoryId($catId)
    {
        $pcRecord     = (new \yii\db\Query())
                            ->select('data_category_id')
                            ->from(UsniAdaptor::tablePrefix() . 'product_category')
                            ->where(['id' => $catId])
                            ->one();
        return $pcRecord['data_category_id'];
    }
    
    /**
     * Check if product category allowed to perform action.
     * @param integer $productCategoryId
     * @return boolean
     */
    public static function checkIfProductCategoryAllowedToPerformAction($productCategoryId)
    {
        $categoryIdArray    =  [];
        $records            = self::getStoreProductCategories();
        foreach ($records as $record)
        {
            $categoryIdArray[] = $record['id'];
        }
        if(!in_array($productCategoryId, $categoryIdArray))
        {
            return false;
        }
        return true;
    }
}