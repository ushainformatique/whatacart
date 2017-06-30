<?php
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;

return [
        'name'      => UsniAdaptor::t('shipping', 'Flat Rate'),
        'code'      => 'flat',
        'author'    => 'WhatACart',
        'version'   => '1.0',
        'product_version' => '2.0.0',
        'status'    => Extension::STATUS_INACTIVE,
        'category'  => 'shipping'
    ];

