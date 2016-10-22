<?php
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use productCategories\models\ProductCategory;

$category   = new ProductCategory();
$items      = $category->getMultiLevelSelectOptions('name', 0, '-', true, false);
?>
<form id="searchcriteriaview" class="uiform" action="<?php echo UsniAdaptor::createUrl('site/default/search');?>" method="get">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><?php echo UsniAdaptor::t('application', 'Search Criteria');?></div>
        </div>
        <div class="panel-body">
            <div class="form-group field-searchform-keyword">
                <?php echo UiHtml::activeLabel($model, 'keyword');?>                
                <?php echo UiHtml::textInput('keyword', $model->keyword, ['class' => 'form-control']);?>
            </div>
            <div class="form-group field-searchform-categoryid">
                <?php echo UiHtml::activeLabel($model, 'categoryId');?>
                <?php
                    $selection = $model->categoryId;
                    echo UiHtml::dropDownList('categoryId', $selection, $items, ['class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="panel-footer">
            <div class="form-actions text-right">
                <button type="submit" id="searchformbtn" class="btn btn-success" name="search"><?php echo UsniAdaptor::t('application', 'Search');?></button>
            </div>
        </div>
    </div>
</form>