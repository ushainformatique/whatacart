<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
    
$assetsUrl  = UsniAdaptor::app()->urlManager->baseUrl;
?>
<div class="carousel slide hidden-xs" data-ride="carousel" id="carousel-captions">
    <ol class="carousel-indicators">
        <li class="active" data-slide-to="0" data-target="#carousel-captions">&nbsp;</li>
        <li data-slide-to="1" data-target="#carousel-captions">&nbsp;</li>
        <li data-slide-to="2" data-target="#carousel-captions">&nbsp;</li>
    </ol>

    <div class="carousel-inner" style="">
        <div class="item active"><?php echo Html::img($assetsUrl . '/images/MacBookAir.jpg');?></div>

        <div class="item "><?php echo Html::img($assetsUrl . '/images/iPhone6.jpg');?></div>

        <div class="item "><?php echo Html::img($assetsUrl . '/images/slide4-1140x380.png');?></div>
    </div>
    <a class="left carousel-control" data-slide="prev" href="#carousel-captions"><span class="icon-prev"></span> </a>
    <a class="right carousel-control" data-slide="next" href="#carousel-captions"> <span class="icon-next"></span> </a>
</div>