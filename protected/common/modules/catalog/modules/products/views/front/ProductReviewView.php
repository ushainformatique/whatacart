<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views\front;

use products\models\ProductReview;
use products\views\front\ReviewFormView;
use products\views\front\ReviewListView;
use usni\library\components\UiHtml;
/**
 * ProductReviewView renders both review form and review list
 *
 * @package products\views\front
 */
class ProductReviewView extends \usni\library\views\UiView
{
    /**
     * @var int 
     */
    public $productId;
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $productReview              = new ProductReview();
        $productReview->product_id  = $this->productId;
        $productReview->status      = ProductReview::STATUS_PENDING;
        $reviewFormView             = new ReviewFormView($productReview);
        $productReviewListView      = new ReviewListView(['productId' => $this->productId]);
        return UiHtml::tag('div', $reviewFormView->render(), ['id' => 'reviewformcontainer']) . "<br/>" . $productReviewListView->render();
    }
}