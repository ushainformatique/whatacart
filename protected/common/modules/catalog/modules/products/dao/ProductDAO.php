<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
use products\models\Product;
use products\models\ProductRelatedProductMapping;
use products\models\ProductReview;
/**
 * Implements data access functionality related to products
 *
 * @package products\dao
 */
class ProductDAO extends \yii\base\Component
{
    /**
     * Get product
     * @param int $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $productTable           = UsniAdaptor::tablePrefix(). 'product';
        $productTranslatedTable = UsniAdaptor::tablePrefix(). 'product_translated';
        $productReviewTable     = UsniAdaptor::tablePrefix(). 'product_review';
        $manufacturerTable      = UsniAdaptor::tablePrefix(). 'manufacturer';
        $productRatingTable     = UsniAdaptor::tablePrefix(). 'product_rating';
        
        $sql                    = "SELECT p.* , pt.name, pt.alias, pt.metakeywords, pt.metadescription, pt.description, man.name as manufacturerName,
                                   COUNT(review.id) AS reviewCnt, COUNT(rating.id) AS ratingCnt
                                   FROM $productTable p
                                   INNER JOIN $productTranslatedTable pt ON p.id = pt.owner_id AND pt.language = :lan
                                   LEFT JOIN $manufacturerTable man ON p.manufacturer = man.id
                                   LEFT JOIN $productReviewTable review ON p.id = review.product_id AND review.status = :status
                                   LEFT JOIN $productRatingTable rating ON p.id = rating.product_id
                                   WHERE p.id = :id GROUP BY p.id";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':id' => $id, ':lan' => $language, ':status' => ProductReview::STATUS_APPROVED])->queryOne();
    }
    
    /**
     * Get related products for a product
     * @param int $productId
     * @param string $language
     * @return array
     */
    public static function getRelatedProducts($productId, $language)
    {
        $productTable           = UsniAdaptor::tablePrefix(). 'product';
        $productTranslatedTable = UsniAdaptor::tablePrefix(). 'product_translated';
        $mappingTableName       = UsniAdaptor::tablePrefix(). 'product_related_product_mapping';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $mappingTableName WHERE product_id = :id", 'params' => [':id' => $productId]]);
        $sql                    = "SELECT tp.* , tpt.name, tpt.alias, tpt.metakeywords, tpt.metadescription, tpt.description
                                   FROM $productTable tp, $productTranslatedTable tpt, $mappingTableName tprpm 
                                   WHERE tprpm.product_id = :pid AND tprpm.related_product_id = tp.id AND tp.id = tpt.owner_id AND tpt.language = :lan LIMIT 6";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get related products count
     * @param int $productId
     * @return int
     */
    public static function getRelatedProductsCount($productId)
    {
        return ProductRelatedProductMapping::find()->where('product_id = :pId', [':pId' => $productId])->count();
    }
    
    /**
     * Get all products
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $productTable           = UsniAdaptor::tablePrefix(). 'product';
        $productTrTable         = UsniAdaptor::tablePrefix(). 'product_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $productTable"]);
        $sql                    = "SELECT pr.*, prt.name 
                                   FROM $productTable pr, $productTrTable prt 
                                   WHERE pr.id = prt.owner_id AND prt.language = :lan AND pr.status = :status";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':lan' => $language, ':status' => Product::STATUS_ACTIVE])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get product specials
     * @param int $productId
     * @return array
     */
    public static function getSpecials($productId)
    {
        $specialTable           = UsniAdaptor::tablePrefix(). 'product_special';
        $sql                    = "SELECT * 
                                   FROM $specialTable 
                                   WHERE product_id = :pid";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId])->queryAll();
    }
    
    /**
     * Get product count by attribute
     * @param string $attribute
     * @param mixed $value
     * @return array
     */
    public static function getCountByAttribute($attribute, $value)
    {
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $sql                    = "SELECT COUNT(*) as cnt 
                                   FROM $productTable pr 
                                   WHERE pr." . $attribute  . "= :attr";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':attr' => $value])->queryScalar();
    }
    
    /**
     * Get products by attribute.
     * @param string $attribute
     * @param integer $value
     * @param string $language
     * @return array.
     */
    public static function getProductsByAttribute($attribute, $value, $language)
    {
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $trProductTable         = UsniAdaptor::tablePrefix() . 'product_translated';
        $sql                    = "SELECT p.*, pt.name, pt.alias, pt.description
                                   FROM $productTable p, $trProductTable pt
                                   WHERE p." . $attribute  . "= :tcid AND p.id = pt.owner_id AND pt.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':tcid' => $value, ':lang' => $language];
        $records                = $connection->createCommand($sql, $params)->queryAll();
        return $records;
    }
    
    /**
     * Get product images
     * @param int $productId
     * @param string $language
     * @return array
     */
    public static function getImages($productId, $language)
    {
        $imagesTable    = UsniAdaptor::tablePrefix() . 'product_image';
        $imagesTrTable  = UsniAdaptor::tablePrefix() . 'product_image_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $imagesTable WHERE product_id = :pid", 
                                                'params' => [':pid' => $productId]]);
        $sql            = "SELECT it.*, itr.caption 
                           FROM $imagesTable it, $imagesTrTable itr
                           WHERE product_id = :pid AND it.id = itr.owner_id AND language = :lan";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get customer rating for the product
     * @param int $productId
     * @param int $customerId
     * @return int
     */
    public static function getCustomerRating($productId, $customerId)
    {
        $custTable      = UsniAdaptor::tablePrefix() . 'customer';
        $ratingTable    = UsniAdaptor::tablePrefix() . 'product_rating';
        $sql            = "SELECT rating 
                           FROM $custTable c, $ratingTable pr
                           WHERE product_id = :pid AND pr.created_by = :cid";
        $connection     = UsniAdaptor::app()->getDb();
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $ratingTable"]);
        return $connection->createCommand($sql, [':pid' => $productId, ':cid' => $customerId])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get product categories
     * @param integer $productId
     * @param string $language
     * @return array
     */
    public static function getCategories($productId, $language)
    {
        $categoryTableName  = UsniAdaptor::tablePrefix() . 'product_category';
        $mappingTableName   = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $trTableName        = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $mappingTableName"]);
        $sql                = "SELECT c.*, ct.name 
                                   FROM $categoryTableName c, $mappingTableName cm, $trTableName ct 
                                   WHERE cm.product_id = :pid AND cm.category_id = c.id AND c.id = ct.owner_id AND ct.language = :lan";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Insert hits on product.
     * @param array $product
     */
    public static function insertHitsOnProduct($product)
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'product';
        $hits       = $product['hits'] + 1;
        UsniAdaptor::app()->db->createCommand()->update($tableName, ['hits' => $hits], 'id = :id', [':id' => $product['id']])->execute();
    }
    
    /**
     * Get current store products.
     * @param integer $dataCategoryId
     * @param string $language
     * @param int $status
     * @return array
     */
    public static function getStoreProducts($dataCategoryId, $language, $status = null)
    {
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $trProductTable         = UsniAdaptor::tablePrefix() . 'product_translated';
        $mappingTable           = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $productTable"]);
        $sql                    = "SELECT tp.*, tpt.name, tpt.description 
                                   FROM $mappingTable tpcm, $productTable tp, $trProductTable tpt
                                   WHERE tpcm.data_category_id = :dci AND tpcm.product_id = tp.id";
        $params                 = [];
        if($status != null)
        {
            $sql .= " AND tp.status = :status";
            $params[':status'] = $status;
        }
        $sql .= " AND tp.id = tpt.owner_id AND tpt.language = :lang
                                   GROUP BY tp.id
                                   ORDER BY tp.id DESC";
        $connection         = UsniAdaptor::app()->getDb();
        $params[':dci']     = $dataCategoryId;
        $params[':lang']    = $language;
        return $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get products
     * @param string $idList
     * @param string $language
     * @return array
     */
    public static function getProducts($idList, $language)
    {
        $productTable           = UsniAdaptor::tablePrefix(). 'product';
        $productTranslatedTable = UsniAdaptor::tablePrefix(). 'product_translated';
        $sql                    = "SELECT p.* , pt.name, pt.alias, pt.metakeywords, pt.metadescription, pt.description
                                   FROM $productTable p
                                   INNER JOIN $productTranslatedTable pt ON p.id = pt.owner_id AND pt.language = :lan
                                   WHERE p.id IN ($idList)";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':lan' => $language])->queryAll();
    }
    
    /**
     * Get products by category id.
     * @param integer $categoryId
     * @param string $language
     * @return array
     */
    public static function getByProductCategoryId($categoryId, $language)
    {
        $productTableName   = UsniAdaptor::tablePrefix() . 'product';
        $mappingTableName   = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $trTableName        = UsniAdaptor::tablePrefix() . 'product_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $mappingTableName"]);
        $sql                = "SELECT p.*, pt.name 
                                   FROM $productTableName p, $mappingTableName pcm, $trTableName pt 
                                   WHERE pcm.category_id = :cid AND pcm.product_id = p.id AND p.id = pt.owner_id AND pt.language = :lan";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':cid' => $categoryId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get current store latest products.
     * @param integer $dataCategoryId
     * @param string $language
     * @param int $status
     * @param int $limit
     * @return array
     */
    public static function geLatestStoreProducts($dataCategoryId, $language, $status, $limit)
    {
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $trProductTable         = UsniAdaptor::tablePrefix() . 'product_translated';
        $mappingTable           = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $sql                    = "SELECT tp.*, tpt.name, tpt.description 
                                   FROM $mappingTable tpcm, $productTable tp, $trProductTable tpt
                                   WHERE tpcm.data_category_id = :dci AND tpcm.product_id = tp.id AND tp.status = :status AND tp.id = tpt.owner_id 
                                   AND tpt.language = :lang GROUP BY tp.id ORDER BY tp.id DESC LIMIT $limit";
        $params                 = [':dci' => $dataCategoryId, ':lang' => $language, ':status' => $status];
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->queryAll();
    }
    
    /**
     * Get active store products.
     * @param integer $dataCategoryId
     * @return array
     */
    public static function getActiveStoreProducts($dataCategoryId)
    {
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $mappingTable           = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $productTable"]);
        $sql                    = "SELECT tp.*
                                   FROM $mappingTable tpcm, $productTable tp
                                   WHERE tpcm.data_category_id = :dci AND tpcm.product_id = tp.id AND tp.status = :status 
                                   GROUP BY tp.id 
                                   ORDER BY tp.id DESC";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':dci' => $dataCategoryId, ':status' => Product::STATUS_ACTIVE])->cache(0, $dependency)->queryAll();
    }
}
