<?php
use usni\UsniAdaptor;

/* @var $this \usni\library\web\AdminView */
/* @var $dashboardDTO \backend\dto\DashboardDTO */
$this->title = $this->params['breadcrumbs'][] = UsniAdaptor::t('application', 'Dashboard');
?>
<div class="row">
    <div class="col-sm-6 col-xs-12">
        <?php echo $dashboardDTO->getLatestUsers();?>
    </div>
    <div class="col-sm-6 col-xs-12">
        <?php echo $dashboardDTO->getLatestProducts();?>
    </div>
    <div class="col-sm-6 col-xs-12">
        <?php echo $dashboardDTO->getLatestCustomers();?>
    </div>
    <div class="col-sm-6 col-xs-12">
        <?php echo $dashboardDTO->getLatestOrders();?>
    </div>
</div>


