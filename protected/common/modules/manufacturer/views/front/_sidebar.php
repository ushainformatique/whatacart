<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \frontend\web\View */
$manList = $this->params['manList'];
?>

<div class="col-sm-3 hidden-xs" id="column-left">
    <div class="list-group">
        <?php
        foreach($manList as $manufacturer)
        {
            if($manufacturer['id'] == $_GET['manufacturerId'])
            {
                $class = "list-group-item active";
            }
            else
            {
                $class = "list-group-item";
            }
        ?>
            <a class="<?php echo $class;?>" href="/manufacturer/site/list?manufacturerId=<?php echo $manufacturer['id'];?>"><?php echo $manufacturer['name'];?></a>
        <?php
        }
        ?>
    </div>
</div>