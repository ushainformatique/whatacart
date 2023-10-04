<?php
use usni\fontawesome\FA;
?>
<div class="panel panel-default detail-container">
    <?php
     if($title != null)
     {
    ?>
        <div class="panel-heading">
            <h6 class="panel-title"><?php echo FA::icon('book') . $title;?></h6>
            <?php
                if($toolbar != null)
                {
                    echo $toolbar;
                }
              ?>
        </div>
    <?php
     }
     elseif($toolbar != null)
     {
    ?>
        <div class="panel-heading"><?php echo $toolbar;?></div>
    <?php
     }
    ?>
    <?php echo $content;?>
</div>

