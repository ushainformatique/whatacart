<?php
use yii\widgets\Breadcrumbs;
use usni\UsniAdaptor;
use yii\helpers\Url;
if(!empty($this->params['breadcrumbs']))
{
?>
<div class="container">
    <?php
        echo Breadcrumbs::widget(
                                [
                                    'links'                => $this->params['breadcrumbs'],
                                    'homeLink'             => [
                                                                'label' => UsniAdaptor::t('application', 'Home'),
                                                                'url'   => Url::home()
                                                              ],
                                ]
                            )
    ?>
</div>
<?php
}

