<?php
return [
    'auth'      => ['dataManagerPath' => ['common\db']],
    'install'   => ['moduleDataInstallSequence' => [
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
                    ]]
];
