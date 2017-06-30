<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\traits;

use products\models\Product;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\weightclass\dao\WeightClassDAO;
/**
 * WeightBehavior class file. This class would covert the weight of the product, if in different unit than store, in unit of the store.
 * So for example if unit of store is kg and product dimensions are in g, they would be converted in kg and displayed in front end. 
 * 
 * @package products\traits
 */
trait WeightTrait
{
    /**
     * Get product weight.
     * @param integer $productId
     * @param boolean $returnWithLabel
     * @return mixed
     */
    public function getWeight($productId, $returnWithLabel = true)
    {
        $displayWeightSettings = UsniAdaptor::app()->storeManager->getSettingValue('display_weight');
        if ($displayWeightSettings)
        {
            $currentStoreWeightClassId  = UsniAdaptor::app()->storeManager->getLocalValue('weight_class');
            $product                    = Product::find()->where('id = :id', [':id' => $productId])->asArray()->one();
            $currentStoreWeightClass    = WeightClassDAO::getById($currentStoreWeightClassId, $this->owner->language);
            return $this->getConvertedWeight($currentStoreWeightClass['name'], $product, $currentStoreWeightClassId, $returnWithLabel);
        }
        return null;
    }
    
    /**
     * Get converted weight
     * @param string $currentStoreWeightClassName
     * @param Product $product
     * @param integer $currentStoreWeightClassId
     * @param string $returnWithLabel
     * @return mixed
     */
    public function getConvertedWeight($currentStoreWeightClassName, $product, $currentStoreWeightClassId, $returnWithLabel = true)
    {
        $weight     = ArrayUtil::getValue($product, 'weight', 0);
        if($weight == 0)
        {
            return null;
        }
        if($currentStoreWeightClassId !== $product['weight_class'])
        {
            $productLengthClass = WeightClassDAO::getById($product['weight_class'], $this->owner->language);
            $weight         = $this->convertWeightToUnit($productLengthClass['name'], $currentStoreWeightClassName, $product);
        }
        if($returnWithLabel)
        {
            switch($currentStoreWeightClassName)
            {
                case 'Kilogram':
                    $weight = $weight . ' ' . UsniAdaptor::t('weightclass', 'Kg');
                    break;
                case 'Gram':
                    $weight = $weight . ' ' . UsniAdaptor::t('weightclass', 'g');
                    break;
                case 'Ounce':
                    $weight = $weight . ' ' . UsniAdaptor::t('weightclass', 'oz');
                    break;
                case 'Pound':
                    $weight = $weight . ' ' . UsniAdaptor::t('weightclass', 'lb');
                    break;
            }
        }
        return $weight;
    }
    
    /**
     * Apply operator
     * @param float $value
     * @param string $operator
     * @param float $modifier
     * @return float
     */
    public function applyWeightOperator($value, $operator, $modifier)
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
     * Calculate weight from source unit to conversion unit.
     * @param string $sourceUnit
     * @param string $conversionUnit
     * @param Product $product
     * @return string
     */
    public function convertWeightToUnit($sourceUnit, $conversionUnit, $product)
    {
        $unitMap        = self::getWeightUnitMap();
        $operatorMap    = $unitMap[$sourceUnit][$conversionUnit];
        return $this->applyWeightOperator($product['weight'], $operatorMap[0], $operatorMap[1]);
    }
    
    /**
     * Get unit map
     * @return array
     */
    public static function getWeightUnitMap()
    {
        return [
                'Kilogram' => [
                                'Gram' => ['*', 1000],
                                'Ounce' => ['*', 35.274],
                                'Pound' => ['*', 2.20]
                            ],
                'Gram' => [
                                    'Kilogram' => ['/', 1000],
                                    'Ounce'  => ['*', 0.0035],
                                    'Pound' => ['*', 0.0022]
                                ],
                'Ounce' =>   [
                                    'Kilogram' => ['*', .0283],
                                    'Gram' => ['*', 28.34],
                                    'Pound' => ['*', 0.0625]
                                ],
                'Pound' =>   [
                                    'Kilogram' => ['*', .453],
                                    'Gram' => ['*', 453.592],
                                    'Ounce' => ['*', 0.0352]
                                ],
                ];
    }
}