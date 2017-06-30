<?php
use usni\UsniAdaptor;
use cart\widgets\SiteCartSubView;
use yii\bootstrap\Alert;

$this->title = $this->params['breadcrumbs'][] = UsniAdaptor::t('cart', 'Shopping Cart');
if(UsniAdaptor::app()->session->hasFlash('outOfStockCheckoutNowAllowed'))
{
    echo Alert::widget(['options' => ['class' => 'alert-danger'], 
                                      'body' => UsniAdaptor::app()->session->getFlash('outOfStockCheckoutNowAllowed')]);
}
?>
<h2><?php echo $this->title;?></h2>
<div id="shopping-container">
    <?php
    echo SiteCartSubView::widget();
    ?>
</div>

