<?php
use usni\library\widgets\DetailView;
use usni\library\utils\FileUploadUtil;

/* @var $detailViewDTO \usni\library\modules\users\dto\UserDetailViewDTO */

$thumbnailImage = FileUploadUtil::getThumbnailImage($detailViewDTO->getPerson(), 'profile_image');
$model          = $detailViewDTO->getPerson();
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $model,
                    'attributes'    => [
                                            [
                                                'attribute' => 'profile_image', 
                                                'value'     => $thumbnailImage, 
                                                'format'    => 'raw'
                                            ],
                                            'fullName',
                                            'mobilephone',
                                            'email'
                                       ]
                  ];
echo DetailView::widget($widgetParams);