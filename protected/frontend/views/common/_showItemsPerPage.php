<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use productCategories\utils\ProductCategoryUtil;
use usni\library\utils\Html;

$data       = ProductCategoryUtil::getItemsPerPageOptions();
$selection  = UsniAdaptor::app()->request->get('showItemsPerPage');
if($selection == null)
{
    $selection = UsniAdaptor::app()->storeManager->getSettingValue('showItemsPerPage');
}
?>
<div class='col-md-1 text-right'>
    <label class="control-label" for="showItemsPerPage"> 
        <?php echo UsniAdaptor::t('productCategories', 'Show');?> 
    </label>
</div>
<div class='col-md-2 text-right'>
    <?php echo Html::dropDownList('showItemsPerPage', $selection, $data, ['id' => 'showItemsPerPage', 'class' => 'form-control']);?>
</div>