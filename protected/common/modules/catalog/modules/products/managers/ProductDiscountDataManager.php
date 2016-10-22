<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiDataManager;
use products\models\ProductDiscount;
use common\managers\AuthDataManager;
use usni\library\modules\auth\models\GroupTranslated;
use products\models\ProductTranslated;
/**
 * Loads default data related to product discount.
 * 
 * @package products\managers
 */
class ProductDiscountDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return ProductDiscount::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        $product        = ProductTranslated::find()->where('alias = :alias AND language = :lan', [':lan' => 'en-US', ':alias' => 'apple-cinema-20"'])->asArray()->one();
        $group          = GroupTranslated::find()->where('name = :name AND language = :lan', [':lan' => 'en-US', ':name' => 'Wholesale'])->asArray()->one();
        $retailerGroup  = GroupTranslated::find()->where('name = :name AND language = :lan', [':lan' => 'en-US', ':name' => 'Retailer'])->asArray()->one();
        $startDateTime  = new \DateTime("now");
        $startDateTime->add(new \DateInterval('P3D'));
        $endDateTime    = new \DateTime("now");
        $endDateTime->add(new \DateInterval('P7D'));
        return [
                    [ 
                        'group_id'      => $group['owner_id'],
                        'quantity'      => 2,
                        'product_id'    => $product['owner_id'],
                        'priority'      => 1,
                        'price'         => 1,
                        'start_datetime'=> $startDateTime->format('Y-m-d H:i:s'),
                        'end_datetime'  => $endDateTime->format('Y-m-d H:i:s')
                    ],
                    [
                        'group_id'      => $retailerGroup['owner_id'],
                        'quantity'      => 5,
                        'product_id'    => $product['owner_id'],
                        'priority'      => 2,
                        'price'         => 2,
                        'start_datetime'=> $startDateTime->format('Y-m-d H:i:s'),
                        'end_datetime'  => $endDateTime->format('Y-m-d H:i:s')
                    ]
                ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function loadDefaultDependentData()
    {
        AuthDataManager::loadDefaultData();
        AuthDataManager::loadDemoData();
        ProductsDataManager::loadDefaultData();
    }
}