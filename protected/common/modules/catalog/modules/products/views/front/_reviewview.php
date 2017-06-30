<?php
use products\models\ProductReview;
use products\widgets\ReviewListView;

$productReview              = new ProductReview();
$productReview->product_id  = $this->product['id'];
$productReview->status      = ProductReview::STATUS_PENDING;
$formContent                = $this->render("/front/_reviewform.php", ['model' => $productReview]);
$reviewListView             = ReviewListView::widget(['dataProvider' => $reviewListDataProvider]);

echo $formContent . "<br/>" . $reviewListView;

