<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use productCategories\utils\ProductCategoryUtil;
use usni\library\utils\Html;

$data       = ProductCategoryUtil::getSortingOptions();
$selection  = UsniAdaptor::app()->request->get('sort');
?>
<div class='col-md-2 text-right'>
    <label class="control-label" for="sortBy"> 
        <?php echo UsniAdaptor::t('application', 'Sort By');?>
    </label>
</div>
<div class='col-md-3 text-right'>
    <?php echo Html::dropDownList('sortBy', $selection, $data, ['id' => 'sortBy', 'class' => 'form-control']);?>
</div>