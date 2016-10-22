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
 * ProductWeightManager class file.
 * @package products\managers
 */
class ProductWeightManager extends \yii\base\Component
{
    /**
     * Get product weight.
     * @param integer $productId
     * @return mixed
     */
    public function getProductWeight($productId)
    {
        $currentStoreWeightClassId  = StoreUtil::getLocalValue('weight_class');
        $product                    = Product::find()->where('id = :id', [':id' => $productId])->asArray()->one();
        $currentStoreWeightClass    = self::getWeightClass($currentStoreWeightClassId);
        $weight                     = self::getWeight($currentStoreWeightClass['name'], $product, $currentStoreWeightClassId);
        return $weight;
    }
    
    /**
     * Get weight.
     * @param string $currentStoreWeightClassName
     * @param Product $product
     * @param integer $currentStoreWeightClassId
     * @return mixed
     */
    public static function getWeight($currentStoreWeightClassName, $product, $currentStoreWeightClassId)
    {
        $weight = null;
        if($currentStoreWeightClassId !== $product['weight_class'])
        {
            switch($currentStoreWeightClassName)
            {
                case 'Kilogram':
                    $weight = self::getCalculatedWeight('Kilogram', $product) . ' ' . UsniAdaptor::t('weightclass', 'Kg');
                    break;
                case 'Gram':
                    $weight = self::getCalculatedWeight('Gram', $product) . ' ' . UsniAdaptor::t('weightclass', 'g');
                    break;
                case 'Ounce':
                    $weight = self::getCalculatedWeight('Ounce', $product) . ' ' . UsniAdaptor::t('weightclass', 'oz');
                    break;
                case 'Pound':
                    $weight = self::getCalculatedWeight('Pound', $product) . ' ' . UsniAdaptor::t('weightclass', 'lb');
                    break;
            }
        }
        else
        {
            $weight = ArrayUtil::getValue($product, 'weight', 0);
            if($weight == null)
            {
                $weight = 0;
            }
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
     * Get Weight class.
     * @param integer $id
     * @return array
     */
    public static function getWeightClass($id)
    {
        $language               = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $weightClassTableName   = UsniAdaptor::tablePrefix() . 'weight_class';
        $trWeightClassTableName = UsniAdaptor::tablePrefix() . 'weight_class_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $weightClassTableName"]);
        $connection             = UsniAdaptor::app()->db;
        $sql                    = "SELECT wc.*, wct.name FROM $weightClassTableName wc, $trWeightClassTableName wct
                                   WHERE wc.id = :id AND wc.id = wct.owner_id AND wct.language = :lan";
        return $connection->createCommand($sql, [':id' => $id, ':lan' => $language])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get calculated weight.
     * @param string $currentStoreWeightClassName
     * @param Product $product
     * @return mixed
     */
    public static function getCalculatedWeight($currentStoreWeightClassName, $product)
    {
        $calculatedWeight   = null;
        $productWeightClass = self::getWeightClass($product['weight_class']);
        if($currentStoreWeightClassName === 'Kilogram')
        {
            $calculatedWeight = self::calculateWeightForKilogram($productWeightClass, $product['weight']);
        }
        if($currentStoreWeightClassName === 'Gram')
        {
            $calculatedWeight = self::calculateWeightForGram($productWeightClass, $product['weight']);
        }
        if($currentStoreWeightClassName === 'Ounce')
        {
            $calculatedWeight = self::calculateWeightForOunce($productWeightClass, $product['weight']);
        }
        if($currentStoreWeightClassName === 'Pound')
        {
            $calculatedWeight = self::calculateWeightForPound($productWeightClass, $product['weight']);
        }
        return $calculatedWeight;
    }
    
    /**
     * Calculate weight for kilogram.
     * @param array $productWeightClass
     * @param mixed $productWeight
     * @return mixed
     */
    public static function calculateWeightForKilogram($productWeightClass, $productWeight)
    {
        if($productWeightClass['name'] === 'Gram')
        {
            return $productWeight/1000;
        }
        if($productWeightClass['name'] === 'Ounce')
        {
            // 1 ounce (oz) is equal to 0.02834952 kilograms (kg).
            return $productWeight * 0.02834952;
        }
        if($productWeightClass['name'] === 'Pound')
        {
            // 1 pound (lb) is equal to 0.45359237 kilograms (kg).
            return $productWeight * 0.45359237;
        }
    }
    
    /**
     * Calculate weight for gram.
     * @param array $productWeightClass
     * @param mixed $productWeight
     * @return mixed
     */
    public static function calculateWeightForGram($productWeightClass, $productWeight)
    {
        if($productWeightClass['name'] === 'Kilogram')
        {
            return $productWeight * 1000;
        }
        if($productWeightClass['name'] === 'Ounce')
        {
            // 1 ounce (oz) is equal to 28.34952 grams (g).
            return $productWeight * 28.34952;
        }
        if($productWeightClass['name'] === 'Pound')
        {
            // 1 pound (lb) is equal to 453.59237 grams (g).
            return $productWeight * 453.59237;
        }
    }
    
    /**
     * Calculate weight for ounce.
     * @param array $productWeightClass
     * @param  mixed $productWeight
     * @return mixed
     */
    public static function calculateWeightForOunce($productWeightClass, $productWeight)
    {
        if($productWeightClass['name'] === 'Kilogram')
        {
            // 1 kilogram (kg) is equal to 0.02834952 ounces (oz).
            return $productWeight / 0.02834952;
        }
        if($productWeightClass['name'] === 'Gram')
        {
            // 1 gram (g) is equal to 28.34952 ounces (oz)..
            return $productWeight / 28.34952;
        }
        if($productWeightClass['name'] === 'Pound')
        {
            // 1 pound (lb) is equal to 16 Ounces (oz).
            return $productWeight * 16;
        }
    }
    
    /**
     * Calculate weight for pound.
     * @param array $productWeightClass
     * @param  mixed $productWeight
     * @return mixed
     */
    public static function calculateWeightForPound($productWeightClass, $productWeight)
    {
        if($productWeightClass['name'] === 'Kilogram')
        {
            // 1 kilogram (kg) is equal to 0.45359237 pounds (lbs).
            return $productWeight / 0.45359237;
        }
        if($productWeightClass['name'] === 'Gram')
        {
            // 1 gram (g) is equal to 453.59237 pounds (lbs).
            return $productWeight / 453.59237;
        }
        if($productWeightClass['name'] === 'Ounce')
        {
            // 1 ounce (oz) is equal to 16 pounds (lb).
            return $productWeight / 16;
        }
    }
}
?>