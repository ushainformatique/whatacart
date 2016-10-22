<?php
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;

return [
    'cashondelivery' => [
        'name'      => UsniAdaptor::t('payment', 'Cash On Delivery'),
        'author'    => 'WhatACart',
        'version'   => '1.0',
        'product_version' => '1.0.0',
        'status'    => Extension::STATUS_ACTIVE
        ],
    'paypal_standard' => [
        'name'      => UsniAdaptor::t('payment', 'Paypal Standard'),
        'author'    => 'WhatACart',
        'version'   => '1.0',
        'product_version' => '1.0.0',
        'status'    => Extension::STATUS_ACTIVE
    ]
];