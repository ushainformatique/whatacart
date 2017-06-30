<?php
use usni\UsniAdaptor;

/* @var $this \frontend\web\View */
?>
<div class="row">
    <div class="col-sm-6">
        <div class="well">
            <h2><?php echo UsniAdaptor::t('customer', 'New Customer');?></h2>
            <p><strong><?php echo UsniAdaptor::t('customer', 'Register Account');?></strong></p>
            <p><?php echo UsniAdaptor::t('customer', 'Creating an account will make your shopping a nice experience. It would make your order management and tracking much friendly.')?></p>
            <a href="<?php echo UsniAdaptor::createUrl('/customer/site/register');?>" class="btn btn-success"><?php echo UsniAdaptor::t('application', 'Continue');?></a>
        </div>
    </div>	 
    <div class="col-sm-6">
        <div class="well">
            <?php echo $this->render('/front/_loginform', ['formDTO' => $formDTO]);?>
        </div>
    </div>
</div>
        
