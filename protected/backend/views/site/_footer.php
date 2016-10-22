<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use common\utils\ApplicationUtil;

$storeName      = null;
if(UsniAdaptor::app()->installed === true && YII_ENV != 'test')
{
    $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
    if(!empty($currentStore))
    {
        if($currentStore->name == 'Default')
        {
            $storeName  = UsniAdaptor::t('stores', 'Default Store');
        }
        else
        {
            $storeName = $currentStore->name;
        }
    }
    else
    {
        $storeName  = UsniAdaptor::t('stores', 'Default Store');
    }
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
        <?php echo UsniAdaptor::app()->powered() . " " . UsniAdaptor::t('application', 'Version') . ' ' . ApplicationUtil::getVersion(); ?>
    </div>
</div><!-- footer -->
