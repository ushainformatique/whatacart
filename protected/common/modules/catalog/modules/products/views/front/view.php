<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
use usni\UsniAdaptor;
use yii\bootstrap\Tabs;
use products\widgets\DynamicOptionsEditView;
use products\widgets\InputRatingSubView;
use products\widgets\PriceWidget;

/* @var $this \products\web\ProductView */
/* @var $productDTO \products\dto\ProductDTO*/

$notSet     = UsniAdaptor::t('application', '(not set)');
$customer   = UsniAdaptor::app()->user->getIdentity();

$this->params['breadcrumbs'] = ['label' => $this->product['name']];
$this->title                 = $this->product['name'];
?>
                <div class="row">
                    <div class="col-sm-8">
                        <?php echo $this->renderImages(); ?>
                        <br/>
                        <div class="row text-center">

                            <?php
                            if ($this->product['allowWishlist'])
                            {
                                ?>
                                <button type="button" data-toggle="tooltip" class="btn btn-success product-wishlist" title="" data-productid = "<?php echo $this->product['id']; ?>" data-original-title="Add to Wish List">
                                    <?php echo UsniAdaptor::t('products', 'Add to Wishlist'); ?>
                                </button>
                                <?php
                            }
                            ?>

                            <?php
                            if ($this->product['allowCompare'])
                            {
                                ?>
                                <button type="button" data-toggle="tooltip" class="btn btn-success add-product-compare" title="" data-productid = "<?php echo $this->product['id']; ?>" data-original-title="Compare this Product">
                                    <?php echo UsniAdaptor::t('products', 'Add to Compare'); ?>
                                </button>
                                <?php
                            }
                            ?>
                        </div>
                        <br/>
                        <?php
                        $items[] = [
                                        'options' => ['id' => 'tab-description'],
                                        'label' => UsniAdaptor::t('application', 'Description'),
                                        'active' => 'true',
                                        'content' => $this->product['description'] == null ? UsniAdaptor::t('application', '(not set)') : $this->product['description']
                                    ];
                        if (($this->product['allowReviews'] && UsniAdaptor::app()->user->isGuest === false)
                                || ($this->product['allowReviews'] && $this->product['allowGuestReviews'] && UsniAdaptor::app()->user->isGuest === true))
                        {
                            $items[] = [
                                            'options' => ['id' => 'tab-review'],
                                            'label' => UsniAdaptor::t('products', 'Reviews') . "(" . $this->product['reviewCnt'] . ")",
                                            'content' => $this->render('/front/_reviewview', ['reviewListDataProvider' => $productDTO->getReviewListDataProvider()])
                                        ];
                        }
                        if(!empty($productDTO->getGroupedAttributes()))
                        {
                            $items[] = [
                                        'options' => ['id' => 'tab-specifications'],
                                        'label' => UsniAdaptor::t('products', 'Specifications'),
                                        'content' => $this->render('/front/_attributes', ['data' => $productDTO->getGroupedAttributes()])
                                    ];
                        }
                        echo Tabs::widget(['items' => $items]);
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <h1><?php echo $this->product['name']; ?></h1>
                        <ul class="list-unstyled">
                            <li>
                                <?php echo UsniAdaptor::t('products', 'Brand'); ?></span>:<?php echo str_repeat("&nbsp", 4) . $this->getManufacturerName(); ?>
                            </li>
                            <li>
                                <?php echo UsniAdaptor::t('products', 'SKU') ?>:</span><?php echo str_repeat("&nbsp", 4) ?>
                                    <?php echo $this->product['sku'] == null ? $notSet : $this->product['sku']; ?>
                            <li>
                            <li>
                                <?php echo UsniAdaptor::t('products', 'Availability') ?></span>:<?php echo str_repeat("&nbsp", 4) ?>
                                <?php echo $this->product['availability']; ?>
                            </li>
                        </ul>
                        <ul class="list-unstyled">
                            <li>
                                <?php
                                echo UsniAdaptor::t('products', 'Price') . ': ' . PriceWidget::widget(['priceExcludingTax' => $this->product['priceExcludingTax'],
                                                             'tax'  => $this->product['tax'],
                                                             'defaultPrice' => $this->product['price'],
                                                             'isDetail' => true]);
                                ?>
                            </li>
                            <li>
                                <?php
                                if (!empty($this->product['weight']))
                                {
                                    echo UsniAdaptor::t('products', 'Weight') . ': ' . $this->product['weight'];
                                }
                                ?>
                            </li>
                            <li>
                                <?php
                                if (!empty($this->product['dimensions']))
                                {
                                    echo $this->product['dimensions'];
                                }
                                ?>
                            </li>
                            <?php
                            if ($this->getDiscountText() != null)
                            {
                                ?>
                                <li>
                                    <hr/>
                                </li>
                                <?php
                                echo '<h3>' . UsniAdaptor::t('products', 'Discounted Price') . '</h3>';
                                echo $this->getDiscountText();
                            }
                            ?>
                        </ul>
                        <div id="product">
                            <hr/>
                            <form id="detailaddtocart">
                                <?php
                                $valueContent = DynamicOptionsEditView::widget(['productId' => $this->product['id'], 'assignedOptions' => $productDTO->getAssignedOptions()]);
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
                                    <input type="hidden" name="product_id" value="<?php echo $this->product['id']; ?>" />
                                    <input type="hidden" name="minimum_quantity" value="<?php echo $this->product['minimum_quantity']; ?>" id="product_minimum_quantity"/>
                                    <input type="text" name="quantity" size="5" value="1" id="product_quantity"/>&nbsp;&nbsp;
                                    <button type="button" id="button-cart" class="btn btn-success add-cart-detail" data-productid = "<?php echo $this->product['id']; ?>">
                                        <?php echo UsniAdaptor::t('cart', 'Add to Cart'); ?>
                                    </button>
                                    <div class="hidden" id="inputquantity-error"><?php echo UsniAdaptor::t('cart', 'Input quantity should be >= minimum quantity'); ?></div>
                                </div>
                            </form>
                            <?php
                            if ($this->product['minimum_quantity'] > 1)
                            {
                                ?>
                                <div class="alert alert-warning"><i class="fa fa-info-circle"></i>
                                    <?php echo UsniAdaptor::t('products', "This product has a minimum quantity of ") . $this->product['minimum_quantity'] ?>
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
                                echo InputRatingSubView::widget(['product' => $this->product, 'view' => $this]);
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="rating">
                            <?php echo $this->getReviewSummary(); ?>
                        </div>
                        <?php
                        if (!empty($productDTO->getTags()))
                        {
                            $tags = $this->renderTags($productDTO->getTags());
                            ?>
                            <div class="tags">
                                <hr/>
                                <?php echo UsniAdaptor::t('products', 'Tags') . ': ' . rtrim($tags, ","); ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                if ($this->product['relatedProductCount'] > 0)
                {
                    ?>
                    <h3><?php echo UsniAdaptor::t('products', 'Related Products'); ?></h3>
                    <div class="row">
                        <?php echo $this->render('/front/_relatedproductslist', ['products' => $productDTO->getRelatedProducts()]); ?>
                    </div>
                    <?php
                }
                $this->registerScripts();