<nav id="top">
    <div class="container">
        <div class="hidden-xs hidden-sm hidden-md pull-left" id="local-options">
            <ul class="list-inline">
                <?php
                echo $currency;
                echo $store;
                echo $language;
                ?>
            </ul>
        </div>
        <?php
        echo $topNavLinks;
        ?>
    </div>
</nav>
<header>
    <div class="container header-row">
        <div class="row">
            <div class="col-sm-4">
                <div id="logo">
                    <?php echo $logo;?>
                </div>
            </div>
            <div class="col-sm-5">
                <?php echo $search;?>
            </div>
            <div class="col-sm-3"><?php echo $shoppingCart;?></div>
        </div>
    </div>
</header>