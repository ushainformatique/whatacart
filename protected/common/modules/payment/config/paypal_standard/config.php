<?php
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
return [
        'code'      => 'paypal_standard',
        'name'      => UsniAdaptor::t('payment', 'Paypal Standard'),
        'author'    => 'WhatACart',
        'version'   => '1.0',
        'product_version' => '2.0.0',
        'status'    => Extension::STATUS_INACTIVE,
        'category'  => 'payment'
        ];

