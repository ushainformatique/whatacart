<?php
use kartik\mpdf\Pdf;

$imageManagerClass  = 'usni\library\components\ImageManager';
$fileManagerClass   = 'usni\library\components\FileManager';
$videoManagerClass  = 'usni\library\components\VideoManager';
return [
    'vendorPath'    => VENDOR_PATH,
    'installed'     => $installed,
    'name'          => $siteName,
    'environment'   => $environment,
    'components' => [
        'cache' => [
                        'class'     => 'usni\library\caching\FileCache',
                        'keyPrefix' => 'whatacart', //This is very important as it differntiates application cache
                   ],
        'globalDataManager'         => ['class' => 'backend\managers\ApplicationDataManager'],
        'productWeightManager'      => ['class' => 'products\managers\ProductWeightManager'],
        'productDimensionManager'   => ['class' => 'products\managers\ProductDimensionManager'],
        'assetManager'      => [
                                    'class'     => 'usni\library\components\UiAssetManager',
                                    'basePath'  => '@webroot/assets',
                                    'resourcesPath' => APPLICATION_PATH . '/resources',
                                    'fileUploadPath' => APPLICATION_PATH . '/resources/files',
                                    'imageUploadPath' => APPLICATION_PATH . '/resources/images',
                                    'thumbUploadPath' => APPLICATION_PATH . '/resources/images/thumbs',
                                    'videoUploadPath' => APPLICATION_PATH . '/resources/videos',
                                    'videoThumbUploadPath'  => APPLICATION_PATH . '/resources/videos/thumbs',
                                    'imageManagerClass'  => $imageManagerClass,
                                    'fileManagerClass'   => $fileManagerClass,
                                    'videoManagerClass'  => $videoManagerClass
                                ]
    ],
    'as beforeRequest'  => ['class' => 'usni\library\behaviors\BeginRequestBehavior'],
];
