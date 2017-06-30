<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

$storeName      = null;
if(UsniAdaptor::app()->installed === true && YII_ENV != 'test')
{
    $currentStore   = UsniAdaptor::app()->storeManager->selectedStore;
    $storeName      = $currentStore['name'];
}
else
{
    $storeName  = UsniAdaptor::t('stores', 'Default Store');
}
?>
<div class="footer clearfix">
    <div class="pull-left">
        Copyright &copy; <?php echo date('Y'); ?> <?php echo $storeName . ' ' . UsniAdaptor::t('application', 'All Rights Reserved.');?>
        
    </div>
    <div class="pull-right">
        <?php echo UsniAdaptor::app()->powered() . " " . UsniAdaptor::t('application', 'Release') . ' ' . UsniAdaptor::app()->version; ?>
    </div>
</div><!-- footer -->
