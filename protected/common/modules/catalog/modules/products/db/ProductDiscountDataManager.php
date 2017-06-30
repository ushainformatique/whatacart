<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\DataManager;
use products\models\ProductDiscount;
use usni\library\modules\auth\models\Group;
use products\models\ProductTranslated;
/**
 * Loads default data related to product discount.
 * 
 * @package products\db
 */
class ProductDiscountDataManager extends DataManager
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
    public function getDefaultDataSet()
    {
        $product        = ProductTranslated::find()->where('alias = :alias AND language = :lan', [':lan' => 'en-US', ':alias' => 'apple-cinema-20"'])->asArray()->one();
        $group          = Group::find()->where('name = :name', [':name' => 'Wholesale'])->asArray()->one();
        $retailerGroup  = Group::find()->where('name = :name', [':name' => 'Retailer'])->asArray()->one();
        $startDateTime  = new \DateTime("now");
        $startDateTime->add(new \DateInterval('P3D'));
        $endDateTime    = new \DateTime("now");
        $endDateTime->add(new \DateInterval('P7D'));
        return [
                    [ 
                        'group_id'      => $group['id'],
                        'quantity'      => 2,
                        'product_id'    => $product['owner_id'],
                        'priority'      => 1,
                        'price'         => 1,
                        'start_datetime'=> $startDateTime->format('Y-m-d H:i:s'),
                        'end_datetime'  => $endDateTime->format('Y-m-d H:i:s')
                    ],
                    [
                        'group_id'      => $retailerGroup['id'],
                        'quantity'      => 5,
                        'product_id'    => $product['owner_id'],
                        'priority'      => 2,
                        'price'         => 2,
                        'start_datetime'=> $startDateTime->format('Y-m-d H:i:s'),
                        'end_datetime'  => $endDateTime->format('Y-m-d H:i:s')
                    ]
                ];
    }
}