<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\library\utils\Html;
use frontend\assets\AppAsset;
use usni\library\widgets\Alert;

/* @var $this \frontend\web\View */

AppAsset::register($this);
$columnLeft     = $this->renderLeftColumn();
$columnRight    = $this->renderRightColumn();

//Figure out number of columns based on columnleft and columnright content
if ($columnLeft && $columnRight)
{
    $numberOfColumns = 3;
}
elseif ($columnLeft || $columnRight)
{
    $numberOfColumns = 2;
}
else
{
    $numberOfColumns = 1;
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="icon" type="image/ico" href="<?php echo $this->getFavIcon(); ?>" />
        <?php echo Html::csrfMetaTags() ?>
        <title><?php echo Html::encode($this->title); ?></title>
        <?php $this->head() ?>
    </head>
    <?php
    if($this->bodyClass == null)
    {
    ?>
        <body>
    <?php
    }
    else
    {
    ?>
            <body class="<?php echo $this->bodyClass;?>">
    <?php
    }
        $this->beginBody();
        echo $this->renderHeader();
        echo $this->renderNavBar();
        echo $this->renderBreadcrumb();
        if ($numberOfColumns == 3 || $numberOfColumns == 2)
        {
        ?>
            <div class="container">
                <div class="row">
                    <?php
                    echo $columnLeft;
                    if ($numberOfColumns == 3)
                    {
                        $class = 'col-sm-6';
                    }
                    elseif ($numberOfColumns == 2)
                    {
                        $class = 'col-sm-9';
                    }
                    ?>
                    <div id="content" class="<?php echo $class; ?>">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php echo Alert::widget() ?>
                                <?php echo $content; ?>
                            </div>
                        </div>
                    </div>
                    <?php echo $columnRight; ?>
                </div>
            </div>
        <?php
        }
        else
        {
            ?>
            <div id="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo Alert::widget() ?>
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        echo $this->renderFooter();
        $this->endBody(); 
        ?>
    </body>
</html>
<?php $this->endPage();