<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use products\views\DynamicOptionsEditView;
use usni\library\components\UiHtml;
use common\modules\manufacturer\utils\ManufacturerUtil;
use common\modules\stores\utils\StoreUtil;
use products\views\front\InputRatingSubView;
use products\models\ProductSpecial;
if ($data['manufacturer'] != null)
{
    $manufacturerRec = ManufacturerUtil::getManufacturer($data['manufacturer']);
    $url = UsniAdaptor::createUrl('manufacturer/site/list', ['manufacturerId' => $manufacturerRec['id']]);
    $manufacturerName = UiHtml::a($manufacturerRec['name'], $url);
}
else
{
    $manufacturerName = UsniAdaptor::t('application', '(not set)');
}
$optionsEditView = new DynamicOptionsEditView(['product' => $data]);
$valueContent = $optionsEditView->render();
$image = null;

$uniqueId = uniqid('image-');
$productImages = ProductUtil::renderImages($data, $uniqueId);

$notSet                 = UsniAdaptor::t('application', '(not set)');
$customer               = UsniAdaptor::app()->user->getUserModel();
$productSpecialCount    = ProductSpecial::find()->where('product_id = :pid', [':pid' => $data['id']])->count();
$discountStr            = null;
if($productSpecialCount == 0)
{
    $discountStr    = ProductUtil::getDiscounts($data, UsniAdaptor::app()->user->getUserModel(), UsniAdaptor::app()->storeManager->getCurrentStore(), '<li>{#discount#}</li>');
}
?>
<div class="row">
    <div class="col-sm-8">
        <?php echo $productImages; ?>
        <br/>
        <div class="row text-center">

            <?php
            $wishlistSetting = StoreUtil::getSettingValue('allow_wishlist');
            if ($wishlistSetting)
            {
                ?>
                <button type="button" data-toggle="tooltip" class="btn btn-success product-wishlist" title="" data-productid = "<?php echo $data['id']; ?>" data-original-title="Add to Wish List">
                    <?php echo UsniAdaptor::t('products', 'Add to Wishlist');?>
                </button>
                <?php
            }
            ?>

            <?php
            $compareProductsSetting = StoreUtil::getSettingValue('allow_compare_products');
            if ($compareProductsSetting)
            {
                ?>
                    <button type="button" data-toggle="tooltip" class="btn btn-success add-product-compare" title="" data-productid = "<?php echo $data['id']; ?>" data-original-title="Compare this Product">
                        <?php echo UsniAdaptor::t('products', 'Add to Compare');?>
                    </button>
                <?php
            }
            ?>
        </div>
        <br/>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo UsniAdaptor::t('application', 'Description'); ?></a></li>
            <?php
            $reviewSetting = StoreUtil::getSettingValue('allow_reviews');
            if ($reviewSetting && UsniAdaptor::app()->user->isGuest === false)
            {
                ?>
                <li><a href="#tab-review" data-toggle="tab">
                        <?php echo UsniAdaptor::t('products', 'Reviews'); ?> (<?php echo $reviewCount; ?>)</a>
                </li>
                <?php
            }
            ?>

            <?php
            //Check for guest  reviews.
            $guestReviewSetting = StoreUtil::getSettingValue('allow_guest_reviews');
            if ($reviewSetting && $guestReviewSetting && UsniAdaptor::app()->user->isGuest === true)
            {
                ?>
                <li><a href="#tab-review" data-toggle="tab">
                        <?php echo UsniAdaptor::t('products', 'Reviews'); ?> (<?php echo $reviewCount; ?>)</a>
                </li>
                <?php
            }
            ?>
            <?php echo $specifications; ?>
        </ul>
        <div class="tab-content">
            <?php echo $tabContent; ?>                                          
        </div>
    </div>
    <div class="col-sm-4">
        <h1><?php echo $title; ?></h1>
        <ul class="list-unstyled">
            <li><?php echo UsniAdaptor::t('products', 'Brand'); ?></span>:<?php echo str_repeat("&nbsp", 4) ?><?php echo $manufacturerName; ?></li>
            <li><?php echo UsniAdaptor::t('products', 'SKU') ?>:</span><?php echo str_repeat("&nbsp", 4) ?><?php echo $data['sku'] == null ? $notSet : $data['sku']; ?><li>
                <?php
                $displayStockSetting = StoreUtil::getSettingValue('display_stock');
                if ($displayStockSetting)
                {
                    $availability = $data['quantity'];
                }
                else
                {
                    $availability = $data['stock_status'] == 1 ? UsniAdaptor::t('products', 'In Stock') : UsniAdaptor::t('products', 'Out Of Stock');
                }
                ?>
            <li><?php echo UsniAdaptor::t('products', 'Availability') ?></span>:<?php echo str_repeat("&nbsp", 4) ?><?php echo $availability ?></li>
        </ul>
        <ul class="list-unstyled">
            <li>
                <?php
                echo UsniAdaptor::t('products', 'Price') . ': ';
                echo ProductUtil::getDisplayedPrice($data, UsniAdaptor::app()->user->getUserModel(), UsniAdaptor::app()->storeManager->getCurrentStore(), true);
                ?>
            </li>
            <li>
                <?php
                $displayWeightSettings = StoreUtil::getSettingValue('display_weight');
                if ($displayWeightSettings)
                {
                    echo UsniAdaptor::t('products', 'Weight') . ': ';
                    echo UsniAdaptor::app()->productWeightManager->getProductWeight($data['id']);
                }
                ?>
            </li>
            <li>
                <?php
                $displayDimensionSettings = StoreUtil::getSettingValue('display_dimensions');
                if ($displayDimensionSettings)
                {
                    echo UsniAdaptor::app()->productDimensionManager->getProductDimensions($data['id']);
                }
                ?>
            </li>
            <?php
            if ($discountStr != null)
            {
                ?>
                <li>
                    <hr/>
                </li>
                <?php
                echo '<h3>'.UsniAdaptor::t('products', 'Discounted Price').'</h3>';
                echo $discountStr;
            }
            ?>
        </ul>
        <div id="product">
            <hr/>
            <form id="detailaddtocart">
                <?php
                if ($valueContent != null)
                {
                    ?>
                    <h3><?php echo UsniAdaptor::t('products', 'Available Options'); ?></h3>
                    <?php echo $valueContent; ?>
                    <?php
                }
                ?>
                <div class="form-group">
                    <label class="control-label" for="input-quantity"><?php echo UsniAdaptor::t('products', 'Quantity'); ?></label>
                    <input type="hidden" name="product_id" value="<?php echo $data['id']; ?>" />
                    <input type="hidden" name="minimum_quantity" value="<?php echo $data['minimum_quantity']; ?>" id="product_minimum_quantity"/>
                    <input type="text" name="quantity" size="5" value="1" id="product_quantity"/>&nbsp;&nbsp;
                    <button type="button" id="button-cart" class="btn btn-success add-cart-detail" data-productid = "<?php echo $data['id']; ?>">
                        <?php echo UsniAdaptor::t('cart', 'Add to Cart'); ?>
                    </button>
                    <div class="hidden" id="inputquantity-error"><?php echo UsniAdaptor::t('products', 'Input quantity should be >= minimum quantity'); ?></div>
                </div>
            </form>
            <?php
            if ($data['minimum_quantity'] > 1)
            {
                ?>
                <div class="alert alert-warning"><i class="fa fa-info-circle"></i>
                    <?php echo UsniAdaptor::t('products', "This product has a minimum quantity of ") . $data['minimum_quantity'] ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        if ($customer != null)
        {
            ?>
            <div class="well">
                <?php
                $inputRating = new InputRatingSubView(['productId' => $data['id']]);
                echo $inputRating->render();
                ?>
            </div>
            <?php
        }
        ?>
        <div class="rating">
            <?php echo $reviewSummary; ?>
        </div>
        <?php
        if ($tags != null)
        {
            ?>
            <div class="tags">
                <hr/>
                <?php echo $tags; ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
$count = ProductUtil::getRelatedProductsCount($data['id']);
if ($count > 0)
{
    ?>
    <h3><?php echo UsniAdaptor::t('products', 'Related Products'); ?></h3>
    <div class="row">
        <?php echo $relatedProducts; ?>
    </div>
    <?php
}