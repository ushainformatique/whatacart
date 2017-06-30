<?php
use cart\widgets\HeaderCartSubView;

/* @var $this \frontend\web\View */

?>
<div id="cart" class="btn-group btn-block">
    <?php echo HeaderCartSubView::widget();?>
</div>
<?php
$script = "$('body').on('click', '#cart > .heading a', function() {
                    $('#cart').addClass('active');

                    $('body').on('mouseleave', '#cart', function() {
                        $(this).removeClass('active');
                    });
                });";
$this->registerJs($script);