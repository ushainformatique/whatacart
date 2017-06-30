<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/lgpl.html
 */
use usni\UsniAdaptor;
?>
<?php
if(empty(strip_tags($customMessage)))
{
?>
<h1><?php echo UsniAdaptor::t('service', 'Site is temporarily unavailable.'); ?></h1>
<p><?php echo UsniAdaptor::t('service', 'Scheduled maintenance is currently in progress. Please check back soon.');?></p>
<p><?php echo UsniAdaptor::t('service', 'We apologize for any inconvenience.')?></p>
<?php
}
else
{
?>
<?php echo $customMessage;?>
<?php 
}
