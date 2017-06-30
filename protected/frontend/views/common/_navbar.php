<?php
use usni\UsniAdaptor;
use frontend\widgets\GlobalMenu;
?>
<div class="container">
  <nav id="menu" class="navbar">
      <div class="navbar-header"><span id="category" class="visible-xs"><?php echo UsniAdaptor::t('productCategories', 'Categories'); ?></span>
      <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <?php echo GlobalMenu::widget();?>
    </div>
  </nav>
</div>