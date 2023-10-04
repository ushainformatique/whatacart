<?php
use yii\widgets\Breadcrumbs;
use usni\UsniAdaptor;
if(!empty($this->params['breadcrumbs']))
{
?>
<div class="breadcrumb-line" style="margin-top:20px;">
    <?php
    echo Breadcrumbs::widget(
                                        [
                                            'links'                => $this->params['breadcrumbs'],
                                            'homeLink'             => ['label' => UsniAdaptor::t('application', 'Dashboard'),
                                                                       'url'   => UsniAdaptor::createUrl('home/default/dashboard')],
                                        ]);
    ?>
</div>
<?php
}
?>

