<?php
use usni\library\widgets\DetailView;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */

$model          = $detailViewDTO->getModel();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            'catalog_items_per_page',
                                            'list_description_limit',
                                            'display_price_with_tax', 
                                            'tax_calculation_based_on', 
                                            'customer_online', 
                                            'default_customer_group', 
                                            'customer_prefix',
                                            'order_prefix',
                                            'guest_checkout', 
                                            'order_status', 
                                            'display_stock', 
                                            'show_out_of_stock_warning',
                                            'allow_out_of_stock_checkout', 
                                            'allow_reviews', 
                                            'allow_guest_reviews',
                                            'allow_wishlist', 
                                            'allow_compare_products', 
                                            'display_dimensions', 
                                            'display_weight'
                                       ]
                  ];
echo DetailView::widget($widgetParams);