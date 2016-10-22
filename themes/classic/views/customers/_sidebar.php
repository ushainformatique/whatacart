<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\library\components\UiHtml;
use usni\UsniAdaptor
?>

<!-- Sidebar navigation -->
<nav>
  <ul id="accountsidebarlist">
      <li><?php echo UiHtml::a(UsniAdaptor::t('users', 'My Account'), UsniAdaptor::createUrl('/customer/site/my-account')); ?></li>
      <li><?php echo UiHtml::a(UsniAdaptor::t('users', 'Edit Profile'), UsniAdaptor::createUrl('/customer/site/edit-profile')); ?></li>
      <li><?php echo UiHtml::a(UsniAdaptor::t('users', 'Change Password'), UsniAdaptor::createUrl('/customer/site/change-password')) ?></li>    
      <li><?php echo UiHtml::a(UsniAdaptor::t('order', 'My Orders'), UsniAdaptor::createUrl('/customer/site/order-history')) ?></li>
      <li><?php echo UiHtml::a(UsniAdaptor::t('wishlist', 'Wishlist'), UsniAdaptor::createUrl('wishlist/default/view')) ?></li>
  </ul>
</nav>

