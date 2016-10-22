<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiDataManager;
use products\models\ProductReview;
use products\models\ProductTranslated;
/**
 * Loads default data related to product review.
 *
 * @package products\managers
 */
class ProductReviewDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return ProductReview::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        $product    = ProductTranslated::find()->where('alias = :alias AND language = :lan', 
                                                                            [':lan' => 'en-US', ':alias' => 'apple-cinema-20"'])->asArray()->one();
        return [
                    [
                        'name'          => 'Test Customer',
                        'review'        => 'This is my first review',
                        'status'        => ProductReview::STATUS_APPROVED,
                        'product_id'    => $product['owner_id']
                    ],
                    [
                        'name'          => 'Test Customer',
                        'review'        => 'This is my second review',
                        'status'        => ProductReview::STATUS_APPROVED,
                        'product_id'    => $product['owner_id'] 
                    ],
                    [
                        'name'          => 'Test Customer',
                        'review'        => 'This is my third review',
                        'status'        => ProductReview::STATUS_APPROVED,
                        'product_id'    => $product['owner_id']
                    ],
                    [
                        'name'          => 'Test Customer',
                        'review'        => 'This is my fourth review',
                        'status'        => ProductReview::STATUS_APPROVED,
                        'product_id'    => $product['owner_id'] 
                    ],
                ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
}