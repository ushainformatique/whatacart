<?php
use usni\UsniAdaptor;

$listDescrLimit     = UsniAdaptor::app()->storeManager->getSettingValue('list_description_limit');
$allowWishList      = UsniAdaptor::app()->storeManager->getSettingValue('allow_wishlist');
$allowCompare       = UsniAdaptor::app()->storeManager->getSettingValue('allow_compare_products');
//Product image width and geight
$productWidth       = UsniAdaptor::app()->storeManager->getImageSetting('related_product_image_width', 150);
$productHeight      = UsniAdaptor::app()->storeManager->getImageSetting('related_product_image_height', 150);

if(!empty($products))
{
?>
<div class="row">
<?php
    foreach($products as $product)
    {
        echo $this->render('@products/views/front/_productitem', [
                                                'model' => $product,
                                                'listDescrLimit' => $listDescrLimit,
                                                'productWidth' => $productWidth,
                                                'productHeight'=> $productHeight,
                                                'allowWishList' => $allowWishList,
                                                'allowCompare' => $allowCompare,
                                                'containerOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-6 col-xs-12']
            ]);
    }
?>
</div>
<?php
}