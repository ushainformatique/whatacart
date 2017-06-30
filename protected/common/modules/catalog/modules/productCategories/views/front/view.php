<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\library\widgets\Thumbnail;

/* @var $listViewDTO \productCategories\dto\ProductCategoryListViewDTO */
/* @var $this \frontend\web\View */

$productCat         = $listViewDTO->getProductCategory();
$title              = $productCat['name'];
$this->title        = $this->params['breadcrumbs'][] = $title;

$this->params['productCategory'] = $productCat;
$this->leftnavView  = '/front/_sidebar';
?>
<h2><?php echo $productCat['name']?></h2>
<div class="row">
    <div class="col-sm-2">
        <?php
        if(!empty($productCat))
        {
            echo Thumbnail::widget(['model' => $productCat, 
                                    'attribute' => 'image',
                                    'showDeleteLink' => false,
                                    'htmlOptions' => ['thumbWidth'  => 90, 
                                                      'thumbHeight' => 90,
                                                      'cssClass'    => 'img-thumbnail']
                                                    ]);
        }
        ?>
    </div>
    <div class="col-sm-10">
        <p><?php echo $productCat['description']?></p>
    </div>
</div>
<hr>
<?php
echo $this->render('//common/_searchresults', ['listViewDTO' => $listViewDTO, 'title' => $title]);
    