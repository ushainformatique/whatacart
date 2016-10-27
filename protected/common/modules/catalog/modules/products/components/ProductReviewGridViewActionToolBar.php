<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\components;

use usni\library\extensions\bootstrap\widgets\UiGridViewActionToolBar;
/**
 * ProductReviewGridViewActionToolBar class file.
 * 
 * @package products\views
 */
class ProductReviewGridViewActionToolBar extends UiGridViewActionToolBar
{
    /**
     * @inheritdoc
     */
    public function getGridViewActionButtonGroup()
    {
        return ProductReviewGridViewActionButtonGroup::className();
    }
}
