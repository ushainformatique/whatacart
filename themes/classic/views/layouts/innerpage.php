<?php
/**
 * Layout for the inner page for example home page except header, breadcrumb and footer.
 * The layout would decorate the inner content of the page.
 * @see HomePageView
 */
?>
<div class="container">
    <div class="row">
        <?php 
            echo $columnLeft;
            if ($columnLeft && $columnRight) 
            {
                $class = 'col-sm-6';
            } 
            elseif ($columnLeft || $columnRight) 
            {
                $class = 'col-sm-9';
            }
            else 
            { 
                $class = 'col-sm-12';
            } 
        ?>
        <div id="content" class="<?php echo $class; ?>">
            <?php echo $content;?>
        </div>
        <?php echo $columnRight; ?>
    </div>
</div>