<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\grid\front;

use kartik\rating\StarRating;
/**
 * RatingDataColumn renders rating widget
 *
 * @package products\grid\front
 */
class RatingDataColumn extends \yii\grid\DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return StarRating::widget([
                    'name' => 'rating_' . $model['id'],
                    'value' => $model['overallRating'],
                    'pluginOptions' => [
                        'readonly' => true,
                        'showClear' => false,
                        'showCaption' => false,
                        'size' => 'sm'
                    ],
                ]);
    }
}
