<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use products\models\Product;
use common\modules\stores\utils\StoreUtil;
use usni\UsniAdaptor;
use yii\caching\DbDependency;
use usni\library\utils\ArrayUtil;
/**
 * ProductDimensionManager class file. This class would covert the dimesions of the product, if in different unit than store, in unit of the store.
 * So for example if unit of store is m and product dimesions are in cm, they would be converted in m and displayed in front end.
 * 
 * @package products\managers
 */
class ProductDimensionManager extends \yii\base\Component
{
    /**
     * Get product dimensions.
     * @param integer $productId
     * @return mixed
     */
    public function getProductDimensions($productId)
    {
        $currentStoreLengthClassId  = StoreUtil::getLocalValue('length_class');
        $product                    = Product::find()->where('id = :id', [':id' => $productId])->asArray()->one();
        $currentStoreLengthClass    = self::getLengthClass($currentStoreLengthClassId);
        $dimensions                 = self::getDimensions($currentStoreLengthClass['name'], $product, $currentStoreLengthClassId);
        return $dimensions;
    }
    
    /**
     * Get dimensions
     * @param string $currentStoreLengthClassName
     * @param Product $product
     * @param integer $currentStoreLengthClassId
     * @return mixed
     */
    public static function getDimensions($currentStoreLengthClassName, $product, $currentStoreLengthClassId)
    {
        $dimensions = null;
        $length     = ArrayUtil::getValue($product, 'length', 0);
        $width      = ArrayUtil::getValue($product, 'width', 0);
        $height     = ArrayUtil::getValue($product, 'height', 0);
        if($length == null)
        {
            $length = 0;
        }
        if($width == null)
        {
            $width = 0;
        }
        if($height == null)
        {
            $height = 0;
        }
        if($length == 0 || $width == 0 || $height == 0)
        {
            return null;
        }
        if($currentStoreLengthClassId !== $product['length_class'])
        {
            switch($currentStoreLengthClassName)
            {
                case 'Meter':
                    $dimensions = self::getCalculatedDimension('Meter', $product);
                    break;
                case 'Centimeter':
                    $dimensions = self::getCalculatedDimension('Centimeter', $product);
                    break;
                case 'Inch':
                    $dimensions = self::getCalculatedDimension('Inch', $product);
                    break;
                case 'Millimeter':
                    $dimensions = self::getCalculatedDimension('Millimeter', $product);
                    break;
            }
        }
        else
        {
            $dimensions = "$length x $width x $height";
        }
        switch($currentStoreLengthClassName)
        {
            case 'Meter':
                $dimensions = UsniAdaptor::t('products', 'Dimensions'). '(m): ' . $dimensions;
                break;
            case 'Centimeter':
                $dimensions = UsniAdaptor::t('products', 'Dimensions'). '(cm): ' . $dimensions;
                break;
            case 'Inch':
                $inchLabel  = UsniAdaptor::t('lengthclass', 'inch');
                $dimensions = UsniAdaptor::t('products', 'Dimensions'). '(' . $inchLabel . '): ' . $dimensions;
                break;
            case 'Millimeter':
                $dimensions = UsniAdaptor::t('products', 'Dimensions'). '(mm): ' . $dimensions;
                break;
        }
        return $dimensions;
    }
    
    /**
     * Get length class.
     * @param integer $id
     * @return array
     */
    public static function getLengthClass($id)
    {
        $language               = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $lengthClassTableName   = UsniAdaptor::tablePrefix() . 'length_class';
        $trLengthClassTableName = UsniAdaptor::tablePrefix() . 'length_class_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $lengthClassTableName"]);
        $connection             = UsniAdaptor::app()->db;
        $sql                    = "SELECT lc.*, lct.name FROM $lengthClassTableName lc, $trLengthClassTableName lct
                                   WHERE lc.id = :id AND lc.id = lct.owner_id AND lct.language = :lan";
        return $connection->createCommand($sql, [':id' => $id, ':lan' => $language])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get calculated dimensions.
     * @param string $currentStoreLengthClassName
     * @param Product $product
     * @return mixed
     */
    public static function getCalculatedDimension($currentStoreLengthClassName, $product)
    {
        $calculatedDimensions   = null;
        $productLengthClass     = self::getLengthClass($product['length_class']);
        if($currentStoreLengthClassName === 'Meter')
        {
            $calculatedDimensions = self::calculateDimensionsForMeter($productLengthClass, $product);
        }
        if($currentStoreLengthClassName === 'Centimeter')
        {
            $calculatedDimensions = self::calculateDimensionsForCentimeter($productLengthClass, $product);
        }
        if($currentStoreLengthClassName === 'Inch')
        {
            $calculatedDimensions = self::calculateDimensionsForInch($productLengthClass, $product);
        }
        if($currentStoreLengthClassName === 'Millimeter')
        {
            $calculatedDimensions = self::calculateDimensionsForMillimeter($productLengthClass, $product);
        }
        return $calculatedDimensions;
    }
    
    /**
     * Calculate dimensions for meter.
     * @param array $productLengthClass
     * @param Product $product
     * @return mixed
     */
    public static function calculateDimensionsForMeter($productLengthClass, $product)
    {
        if($productLengthClass['name'] === 'Centimeter')
        {
            $length     = $product['length']/100;
            $width      = $product['width']/100;
            $height     = $product['height']/100;
            return "$length * $width * $height";
        }
        if($productLengthClass['name'] === 'Inch')
        {
            $length     = $product['length'] * 0.0254;
            $width      = $product['width'] * 0.0254;
            $height     = $product['height'] * 0.0254;
            return "$length * $width * $height";
        }
        if($productLengthClass['name'] === 'Millimeter')
        {
            $length     = $product['length']/1000;
            $width      = $product['width']/1000;
            $height     = $product['height']/1000;
            return "$length * $width * $height";
        }
    }
    
    /**
     * Calculate dimensions for centimeter.
     * @param array $productLengthClass
     * @param Product $product
     * @return mixed
     */
    public static function calculateDimensionsForCentimeter($productLengthClass, $product)
    {
        if($productLengthClass['name'] === 'Meter')
        {
            $length     = $product['length'] * 100;
            $width      = $product['width'] * 100;
            $height     = $product['height'] * 100;
            return "$length * $width * $height";
        }
        if($productLengthClass['name'] === 'Inch')
        {
            $length     = $product['length'] * 2.54;
            $width      = $product['width'] * 2.54;
            $height     = $product['height'] * 2.54;
            return "$length * $width * $height";
        }
        if($productLengthClass['name'] === 'Millimeter')
        {
            $length     = $product['length']/10;
            $width      = $product['width']/10;
            $height     = $product['height']/10;
            return "$length * $width * $height";
        }
    }
    
    /**
     * Calculate dimension for inch.
     * @param array $productLengthClass
     * @param  Product $product
     * @return mixed
     */
    public static function calculateDimensionsForInch($productLengthClass, $product)
    {
        if($productLengthClass['name'] === 'Meter')
        {
            $length     = $product['length']/0.0254;
            $width      = $product['width']/0.0254;
            $height     = $product['height']/0.0254;
            return "$length * $width * $height";
        }
        if($productLengthClass['name'] === 'Centimeter')
        {
            $length     = $product['length']/2.54;
            $width      = $product['width']/2.54;
            $height     = $product['height']/2.54;
            return "$length * $width * $height";
        }
        if($productLengthClass['name'] === 'Millimeter')
        {
            $length     = $product['length']/25.4;
            $width      = $product['width']/25.4;
            $height     = $product['height']/25.4;
            return "$length * $width * $height";
        }
    }
    
    /**
     * Calculate Dimensions for millimeter.
     * @param array $productLengthClass
     * @param  Product $product
     * @return mixed
     */
    public static function calculateDimensionsForMillimeter($productLengthClass, $product)
    {
        if($productLengthClass['name'] === 'Meter')
        {
            $length     = $product['length'] * 1000;
            $width      = $product['width'] * 1000;
            $height     = $product['height'] * 1000;
            return "$length * $width * $height";
        }
        if($productLengthClass['name'] === 'Centimeter')
        {
            $length     = $product['length'] * 10;
            $width      = $product['width'] * 10;
            $height     = $product['height'] * 10;
            return "$length * $width * $height";
        }
        if($productLengthClass['name'] === 'Inch')
        {
            $length     = $product['length'] * 25.4;
            $width      = $product['width'] * 25.4;
            $height     = $product['height'] * 25.4;
            return "$length * $width * $height";
        }
    }
}