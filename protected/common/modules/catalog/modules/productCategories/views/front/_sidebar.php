<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use productCategories\widgets\CategoryMenuWidget;

/* @var $this \frontend\web\View */
?>

<div class="col-sm-3 hidden-xs" id="column-left">
    <div id="catgeory-sidebar-menu">
        <?php echo CategoryMenuWidget::widget(['model' => $this->params['productCategory']]); ?>
    </div>
</div>
