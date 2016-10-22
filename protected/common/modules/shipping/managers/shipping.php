<?php
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;

return [
    'flat' => [
        'name'      => UsniAdaptor::t('shipping', 'Flat Rate'),
        'author'    => 'WhatACart',
        'version'   => '1.0',
        'product_version' => '1.0.0',
        'status'    => Extension::STATUS_ACTIVE
    ],
    'free' => [
        'name'      => UsniAdaptor::t('shipping', 'Free Shipping'),
        'author'    => 'WhatACart',
        'version'   => '1.0',
        'product_version' => '1.0.0',
        'status'    => Extension::STATUS_ACTIVE
    ]
];

