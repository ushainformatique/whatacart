<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\traits;

use products\models\ProductRating;
use usni\library\utils\ArrayUtil;
use usni\library\utils\NumberUtil;
/**
 * Implement utility functions related to rating
 *
 * @package products\traits
 */
trait RatingTrait
{
    /**
     * Get Overall rating of products.
     * @param int $productId
     * @param float $step
     * @return int $totalRating
     */
    public static function getOverallRating($productId, $step = 0.5)
    {
        $totalRating = 0;
        $starRating  = 0;
        $ratings     = ProductRating::find()->select('COUNT(*) AS cnt, rating')->where('product_id = :aId', [':aId' => $productId])->groupBy(['rating'])->asArray()->all();
        if (count($ratings) > 0)
        {
            $ratings     = ArrayUtil::map($ratings, 'rating', 'cnt');
            $cumulativeTotal = 0;
            $totalCount      = 0; 
            foreach($ratings as $rating => $cnt)
            {
                $cumulativeTotal += $rating * $cnt;
                $totalCount      += $cnt;
            }

            if($totalCount > 0)
            {
                $totalRating = $cumulativeTotal / $totalCount;
            }
            $starRating  = self::getStarRating($totalRating, $step);
        }
        return $starRating;
    }
    
    /**
     * Gets star rating based on total rating
     * @param float $totalRating
     * @param float $step
     * @return mixed
     */
    public static function getStarRating($totalRating, $step = 0.5)
    {
        $starRating = 0;
        $i = 1;
        while($i <= 5)
        {
            $i = floatval($i);
            $nextCount = $i + $step;
            if(NumberUtil::compareFloat($totalRating, $i))
            {
                $starRating = $i;
                break;
            }
            elseif(NumberUtil::compareFloat($totalRating, $nextCount))
            {
                $starRating = $nextCount;
                break;
            }
            elseif($totalRating > $i && $totalRating < $nextCount)
            {
                if($totalRating > $i + ($step / 2))
                {
                    $starRating = $nextCount;
                }
                else
                {
                    $starRating = $i;
                }
                break;
            }
            else
            {
                $i = $nextCount;
            }
        }
        return $starRating;
    }
}