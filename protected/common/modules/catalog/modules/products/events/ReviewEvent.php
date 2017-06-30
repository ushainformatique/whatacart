<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\events;

use products\models\ProductReview;
/**
 * ReviewEvent class file.
 * 
 * @package products\events
 */
class ReviewEvent extends \yii\base\Event
{
    /**
     * ProductReview model.
     * @var ProductReview 
     */
    public $productReview;
}