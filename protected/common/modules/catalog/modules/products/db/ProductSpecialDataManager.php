<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\DataManager;
use products\models\ProductSpecial;
use usni\library\modules\auth\models\Group;
use products\models\ProductTranslated;
/**
 * Loads default data related to product special.
 * 
 * @package products\db
 */
class ProductSpecialDataManager extends DataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return ProductSpecial::className();
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
        $startDateTime->sub(new \DateInterval('P5D'));
        $endDateTime    = new \DateTime("now");
        $endDateTime->add(new \DateInterval('P2D'));
        return [
                    [ 
                        'group_id'      => $group['id'],
                        'product_id'    => $product['owner_id'],
                        'priority'      => 1,
                        'price'         => 1,
                        'start_datetime'=> $startDateTime->format('Y-m-d H:i:s'),
                        'end_datetime'  => $endDateTime->format('Y-m-d H:i:s')
                    ],
                    [
                        'group_id'      => $retailerGroup['id'],
                        'product_id'    => $product['owner_id'],
                        'priority'      => 2,
                        'price'         => 2,
                        'start_datetime'=> $startDateTime->format('Y-m-d H:i:s'),
                        'end_datetime'  => $endDateTime->format('Y-m-d H:i:s')
                    ]
                ];
    }
}