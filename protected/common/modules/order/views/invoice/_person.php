<?php
use usni\UsniAdaptor;
?>
<td>
    <address>
        <strong><?php echo UsniAdaptor::t('users', 'Email Address') . ':' ?></strong><br> 
        <?php echo $email ?><br>
        <strong><?php echo UsniAdaptor::t('users', 'Phone Number') . ':' ?></strong><br> 
        <?php echo $mobilephone ?><br>
    </address>
</td>