<?php
use usni\UsniAdaptor;
use usni\fontawesome\FA;
?>
<div class="navbar-header">
    <a class="navbar-brand" href="<?php echo UsniAdaptor::createUrl('/home/default/dashboard'); ?>"><?php echo $title;?></a>
    <?php
    if (!UsniAdaptor::app()->user->isGuest && UsniAdaptor::app()->isRebuildInProgress() === false)
    {
        ?>
        <a class="sidebar-toggle">
            <?php echo FA::icon('navicon')->size(FA::SIZE_LARGE); ?>
        </a>
        <?php
    }
    ?>
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons">
        <span class="sr-only">Toggle navbar</span>
        <?php echo FA::icon('th-large')->size(FA::SIZE_LARGE); ?>
    </button>
    <button type="button" class="navbar-toggle offcanvas">
        <span class="sr-only">Toggle navigation</span>
        <?php echo FA::icon('align-justify'); ?>
    </button>
</div>