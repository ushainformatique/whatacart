<?php
use yii\helpers\Html;
use usni\UsniAdaptor;
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \frontend\web\View */
$tagList = $this->params['tagList'];
?>

<div class="col-sm-3 hidden-xs" id="column-left">
    <div class="list-group">
        <?php
        foreach($tagList as $tag)
        {
            if($tag['name'] == $_GET['name'])
            {
                $class = "list-group-item active";
            }
            else
            {
                $class = "list-group-item";
            }
        ?>
            <?php echo Html::a($tag['name'], UsniAdaptor::createUrl('catalog/products/site/tag-list', ['name' => $tag['name']]), ['class' => $class]);?>
        <?php
        }
        ?>
    </div>
</div>