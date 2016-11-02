<?php
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;

return [
        'name'      => UsniAdaptor::t('shipping', 'Free Shipping'),
        'code'      => 'free',
        'author'    => 'WhatACart',
        'version'   => '1.0',
        'product_version' => '1.0.0',
        'status'    => Extension::STATUS_ACTIVE,
        'category'  => 'shipping'
    ];