<?php
return [
    'auth'      => [
                        'dataManagerPath' => ['common\db']
                   ],
    'install'   => ['controllerMap' => ['default' => 'backend\controllers\install\DefaultController'],
                    'moduleDataInstallSequence' => [
                        'language', 
                        'notification',
                        'users', 
                        'auth', 
                        'localization/country',
                        'localization/state',
                        'localization/city',
                        'localization/currency',
                        'localization/lengthclass',
                        'localization/weightclass',
                        'localization/orderstatus',
                        'localization/stockstatus',
                        'localization/tax',
                        'manufacturer',
                        'cms',
                        'dataCategories',
                        'stores',
                        'payment',
                        'shipping',
                        'sequence',
                        'catalog/productCategories',
                        'catalog/products',
                        'order',
                        'marketing',
                        'marketing/newsletter',
                        'customer'
                    ]],
    'home'      => ['controllerMap' => ['default' => 'backend\controllers\home\DefaultController']],
    'localization/lengthclass'      => [
                        'dataManager' => 'common\modules\localization\modules\lengthclass\db\LengthClassDataManager'
                   ],
    'localization/weightclass'      => [
                        'dataManager' => 'common\modules\localization\modules\weightclass\db\WeightClassDataManager'
                   ],
    'localization/orderstatus'      => [
                        'dataManager' => 'common\modules\localization\modules\orderstatus\db\OrderStatusDataManager'
                   ],
    'localization/stockstatus'      => [
                        'dataManager' => 'common\modules\localization\modules\stockstatus\db\StockStatusDataManager'
                   ],
];
