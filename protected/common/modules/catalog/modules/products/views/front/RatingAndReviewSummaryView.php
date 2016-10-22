<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views\front;

use products\views\front\ReviewSummarySubView;
use products\views\front\RatingSubView;
use usni\library\views\UiView;
/**
 * RatingAndReviewSummaryView for rendering rating and review summary
 *
 * @package products\views
 */
class RatingAndReviewSummaryView extends UiView
{
    /**
     * @var int 
     */
    public $productId;
    
    /**
     * Count of reviews
     * @var int 
     */
    public $count;
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $reviewSubView = new ReviewSummarySubView(['productId' => $this->productId, 'reviewCount' => $this->count]);
        $ratingSubView = new RatingSubView(['productId' => $this->productId]);
        return $ratingSubView->render() . $reviewSubView->render();
    }
}