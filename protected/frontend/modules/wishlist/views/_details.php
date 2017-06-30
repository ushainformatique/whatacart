<?php
use usni\UsniAdaptor;
?>
<div id="wishlist-full">
<?php
if(!$isEmpty)
{
?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <td class="text-center"><?php echo UsniAdaptor::t('products', 'Image')?></td>
                <td class="text-left"><?php echo UsniAdaptor::t('application', 'Name')?></td>
                <td class="text-left"><?php echo UsniAdaptor::t('products', 'Model')?></td>
                <td class="text-right"><?php echo UsniAdaptor::t('products', 'Unit Price')?></td>
                <td class="text-right"><?php echo UsniAdaptor::t('wishlist', 'Action')?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $items;?>
        </tbody>
    </table>
<?php
}
else
{
?>
    <table class="table">
        <thead>
            <tr>
                <td class="text-center"><?php echo $items;?></td>
            </tr>
        </thead>
    </table>
<?php
} 
?>
</div>