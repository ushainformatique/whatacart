<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\utils\FileUploadUtil;
use products\widgets\PriceWidget;
use usni\library\utils\Html;

$addCartLabel       = UsniAdaptor::t('cart', 'Add to Cart');
$addWishListLabel   = UsniAdaptor::t('wishlist', 'Add to Wish List');
$addCompareLabel    = UsniAdaptor::t('products', 'Add to Compare');
?>
<?php echo Html::beginTag('div', $containerOptions);?>
    <div class="product-thumb transition">
        <div class="image">
            <a href="<?php echo UsniAdaptor::createUrl('/catalog/products/site/detail', ['id' => $model['id']]); ?>">
                <?php echo FileUploadUtil::getThumbnailImage($model, 'image', ['thumbWidth' => $productWidth, 
                                                                                'thumbHeight' => $productHeight]); ?>
            </a>
        </div>
        <div class="caption">  
            <h4>
                <a href="<?php echo UsniAdaptor::createUrl('/catalog/products/site/detail', ['id' => $model['id']]); ?>">
                    <?php echo $model['name']; ?>
                </a>
            </h4>
            <p>
                <?php 
                        $desc = strip_tags($model['description']);
                        if(strlen($desc) > $listDescrLimit)
                        {
                            echo substr($desc, 0, $listDescrLimit) . '...';
                        }
                        else
                        {
                            echo $desc;
                        }
                    ?>
            </p>
            <p class="price"><?php echo PriceWidget::widget(['priceExcludingTax' => $model['finalPriceExcludingTax'],
                                                             'tax'  => $model['tax'],
                                                             'defaultPrice' => $model['price']]); ?></p>
        </div>
        <div class="button-group">
        <?php
                if($model['requiredOptionsCount'] == 0)
                {
                ?>

                    <input type="hidden" name="quantity" value="1" />
                        <button type="button" data-toggle="tooltip" title="<?php echo $addCartLabel;?>" class="add-cart" data-productid = "<?php echo $model['id'];?>">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="hidden-xs hidden-sm hidden-md"><?php echo $addCartLabel;?></span>
                        </button>
                <?php
                }
                else
                {
                    $url   = UsniAdaptor::createUrl('/catalog/products/site/detail', ['id' => $model['id']]);
                ?>
                    <button type="button" data-toggle="tooltip" title="<?php echo $addCartLabel;?>">
                        <a href="<?php echo $url;?>"><i class="fa fa-shopping-cart"></i></a>
                        <a href="<?php echo $url;?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $addCartLabel;?></span></a>
                    </button>
                <?php    
                }
                ?>
                <?php
                if($allowWishList)
                {
                ?>
                    <button type="button" data-toggle="tooltip" title="<?php echo $addWishListLabel;?>" class="product-wishlist" data-productid = "<?php echo $model['id'];?>" name="<?php echo $addWishListLabel;?>">
                        <i class="fa fa-heart" id="add-to-wish-list-<?php echo $model['id'];?>"></i>
                </button>
                <?php
                }
                ?>
                
                <?php
                if($allowCompare)
                {
                ?>
                    <button type="button" data-toggle="tooltip" title="<?php echo $addCompareLabel;?>" class="add-product-compare" data-productid = "<?php echo $model['id'];?>" id="<?php echo $addCompareLabel . '-' .$model['id'];?>">
                    <i class="fa fa-exchange"></i>
                </button>
                <?php
                }
                ?>
        </div>
    </div>
<?php echo Html::endTag('div');