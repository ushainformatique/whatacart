<?php
/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \common\modules\order\dto\AdminCheckoutDTO */

use usni\UsniAdaptor;
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('order', 'Orders'),
        'url' => ['/order/default/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Create')
    ]
];
$this->title = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('order', 'Order');
echo $this->render("/_orderedit", ['formDTO' => $formDTO, 'caption' => $this->title]);