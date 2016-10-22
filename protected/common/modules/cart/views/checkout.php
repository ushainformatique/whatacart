<?php
use usni\UsniAdaptor;
?>
<?php echo $begin;?>
<div class='panel panel-default'>
    <div class='panel-heading'>
        <h6 class='panel-title'><?php echo UsniAdaptor::t('cart', 'Checkout');?></h6>
    </div>
    <div class='panel-body'>
            <div class="row">
                <div class="col-sm-6">
                    <legend><span class="badge">1</span> <?php echo UsniAdaptor::t('customer', 'Billing Address');?></legend>
                    <?php echo $billingContent;?>
                </div>
                <?php
                if($shippingContent != null)
                {
                ?>
                    <div class="col-sm-6">
                        <legend><span class="badge">2</span> <?php echo UsniAdaptor::t('customer', 'Shipping Address');?></legend>
                        <?php echo $deliveryContent;?>
                    </div>
                    <div class="col-sm-6">
                        <legend><span class="badge">3</span> <?php echo UsniAdaptor::t('shipping', 'Shipping Method');?></legend>
                        <?php echo $shippingContent;?>
                    </div>
                    <div class="col-sm-6">
                        <legend><span class="badge">4</span> <?php echo UsniAdaptor::t('payment', 'Payment Method');?></legend>
                        <?php echo $paymentContent;?>
                    </div>
                <?php
                }
                else
                {
                ?>
                    <div class="col-sm-6">
                        <legend><span class="badge">2</span> <?php echo UsniAdaptor::t('payment', 'Payment Method');?></legend>
                        <?php echo $paymentContent;?>
                    </div>
                <?php
                }
                ?>
            </div>
    </div>
    <div class="panel-footer">
        <div class="form-actions text-right">
            <button type="submit" id="save" class="btn btn-primary" name="continue"><?php echo UsniAdaptor::t('application', 'Continue');?></button>
            <a href="<?php echo UsniAdaptor::createUrl('order/default/add-to-cart');?>" class="btn btn-default"><?php echo UsniAdaptor::t('order', 'Previous');?></a>
        </div>
    </div>
</div>
<?php echo $end;?>

