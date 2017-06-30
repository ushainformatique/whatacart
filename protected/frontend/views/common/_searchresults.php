<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use yii\widgets\ListView;
use productCategories\widgets\ToolbarWidget;

/* @var $listViewDTO \frontend\dto\ListViewDTO */
/* @var $this \frontend\web\View */

$itemView           = '@products/views/front/_productitem';
//View params
$productWidth       = UsniAdaptor::app()->storeManager->getImageSetting('product_list_image_width', 150);
$productHeight      = UsniAdaptor::app()->storeManager->getImageSetting('product_list_image_height', 150);
$listDescrLimit     = UsniAdaptor::app()->storeManager->getSettingValue('list_description_limit');
$allowWishList      = UsniAdaptor::app()->storeManager->getSettingValue('allow_wishlist');
$allowCompare       = UsniAdaptor::app()->storeManager->getSettingValue('allow_compare_products');
$containerOptions   = ['class' => 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12'];
$viewParams         = ['productWidth'       => $productWidth, 
                       'productHeight'      => $productHeight,
                       'listDescrLimit'     => $listDescrLimit, 
                       'allowWishList'      => $allowWishList,
                       'allowCompare'       => $allowCompare,
                       'containerOptions'   => $containerOptions];
$listViewParams = [
                    'dataProvider'      => $listViewDTO->getDataprovider(),
                    'itemView'          => $itemView,
                    'viewParams'        => $viewParams,
                    'id'                => 'search-results-list-view',
                    'options'           => ['id' => 'searchresultslistview-pjax'],
                    'layout'            => "<div id='search-results-list-view'>
                                                <div class='row'>{items}</div>
                                                <div class='row'>
                                                    <div class='col-sm-6 text-left'>{pager}</div>
                                                    <div class='col-sm-6 text-right'>{summary}</div>
                                                </div>
                                            </div>",
                  ];
?>
<div class="row">
    <?php
    echo ToolbarWidget::widget();
    ?>
</div>
<br>
<?php
echo ListView::widget($listViewParams);