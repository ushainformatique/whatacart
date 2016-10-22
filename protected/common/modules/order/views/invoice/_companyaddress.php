<?php
use usni\UsniAdaptor;
?>
 
<address>
    <strong><?php echo UsniAdaptor::t('stores', $storeName); ?></strong><br/>
    <?php echo $country; ?>
</address>
<?php echo UsniAdaptor::t('users', 'Mobile') . ': ' . $mobile ?> <br/>
<?php echo UsniAdaptor::t('users', 'Email') . ': ' . $email ?> <br/>
