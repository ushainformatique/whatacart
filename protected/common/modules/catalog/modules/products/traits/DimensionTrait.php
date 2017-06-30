<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\traits;

use products\models\Product;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\lengthclass\dao\LengthClassDAO;
/**
 * DimensionBehavior class file. This class would covert the dimensions of the product, if in different unit than store, in unit of the store.
 * So for example if unit of store is m and product dimensions are in cm, they would be converted in m and displayed in front end.
 * 
 * @package products\traits
 */
trait DimensionTrait
{
    /**
     * Get product dimensions.
     * @param integer $productId
     * @param boolean $returnWithLabel
     * @return mixed
     */
    public function getDimensions($productId, $returnWithLabel = true)
    {
        $displayDimensionSettings = UsniAdaptor::app()->storeManager->getSettingValue('display_dimensions');
        if ($displayDimensionSettings)
        {
            $currentStoreLengthClassId  = UsniAdaptor::app()->storeManager->getLocalValue('length_class');
            $product                    = Product::find()->where('id = :id', [':id' => $productId])->asArray()->one();
            $currentStoreLengthClass    = LengthClassDAO::getById($currentStoreLengthClassId, $this->owner->language);
            return $this->getConvertedDimensions($currentStoreLengthClass['name'], $product, $currentStoreLengthClassId, $returnWithLabel);
        }
        return null;
    }
    
    /**
     * Get converted dimensions
     * @param string $currentStoreLengthClassName
     * @param Product $product
     * @param integer $currentStoreLengthClassId
     * @param string $returnWithLabel
     * @return mixed
     */
    public function getConvertedDimensions($currentStoreLengthClassName, $product, $currentStoreLengthClassId, $returnWithLabel = true)
    {
        $dimensions = null;
        $length     = ArrayUtil::getValue($product, 'length', 0);
        $width      = ArrayUtil::getValue($product, 'width', 0);
        $height     = ArrayUtil::getValue($product, 'height', 0);
        if($length == 0 || $width == 0 || $height == 0)
        {
            return null;
        }
        if($currentStoreLengthClassId !== $product['length_class'])
        {
            $productLengthClass = LengthClassDAO::getById($product['length_class'], $this->owner->language);
            $dimensions         = $this->convertDimensionsToUnit($productLengthClass['name'], $currentStoreLengthClassName, $product);
        }
        else
        {
            $dimensions = "$length x $width x $height";
        }
        if($returnWithLabel)
        {
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
        }
        return $dimensions;
    }
    
    /**
     * Apply operator
     * @param float $value
     * @param string $operator
     * @param float $modifier
     * @return float
     */
    public function applyOperator($value, $operator, $modifier)
    {
        if($operator == '/')
        {
            return $value / $modifier;
        }
        elseif($operator == '*')
        {
            return $value * $modifier;
        }
        return $value;
    }
    
    /**
     * Convert dimensions from source unit to conversion unit.
     * @param string $sourceUnit
     * @param string $conversionUnit
     * @param Product $product
     * @return string
     */
    public function convertDimensionsToUnit($sourceUnit, $conversionUnit, $product)
    {
        //Source Unit - Centimeter
        //Target unit - Meter
        $unitMap        = self::getDimensionUnitMap();
        $operatorMap    = $unitMap[$sourceUnit][$conversionUnit];
        $length         = $this->applyOperator($product['length'], $operatorMap[0], $operatorMap[1]);
        $width          = $this->applyOperator($product['width'], $operatorMap[0], $operatorMap[1]);
        $height         = $this->applyOperator($product['height'], $operatorMap[0], $operatorMap[1]);;
        return "$length x $width x $height"; 
    }
    
    /**
     * Get unit map
     * @return array
     */
    public static function getDimensionUnitMap()
    {
        return [
                'Meter' => [
                                'Centimeter' => ['*', 100],
                                'Inch'      => ['*', 39.37],
                                'Millimeter' => ['*', 1000]
                            ],
                'Centimeter' => [
                                    'Meter' => ['/', 100],
                                    'Inch'  => ['*', 0.3937],
                                    'Millimeter' => ['*', 10]
                                ],
                'Inch' =>   [
                                    'Meter' => ['*', .0254],
                                    'Centimeter' => ['*', 2.54],
                                    'Millimeter' => ['*', 25.4]
                                ],
                'Millimeter' =>   [
                                    'Meter' => ['/', 1000],
                                    'Centimeter'  => ['/', 10],
                                    'Inch' => ['*', .03937]
                                ],
                ];
    }
}