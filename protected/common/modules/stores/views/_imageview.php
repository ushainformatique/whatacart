<?php
use usni\library\widgets\DetailView;
use usni\library\utils\FileUploadUtil;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */

$model          = $detailViewDTO->getModel();
$imageSettings  = $model['imageSettings'];
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $imageSettings,
                    'attributes'    => [
                                            [
                                                'attribute' => 'store_logo', 
                                                'value'     => FileUploadUtil::getThumbnailImage($imageSettings, 'store_logo'),
                                                'format'    => 'raw'
                                            ],
                                            [
                                                'attribute' => 'icon', 
                                                'value'     => FileUploadUtil::getImage($imageSettings, 'icon'),
                                                'format'    => 'raw'
                                            ],
                                            'category_image_width',
                                            'category_image_height',
                                            'product_list_image_width',
                                            'product_list_image_height',
                                            'related_product_image_width',
                                            'related_product_image_height',
                                            'compare_image_width',
                                            'compare_image_height',
                                            'wishlist_image_width',
                                            'wishlist_image_height',
                                            'cart_image_width',
                                            'cart_image_height',
                                            'store_image_width',
                                            'store_image_height'
                                       ]
                  ];
echo DetailView::widget($widgetParams);