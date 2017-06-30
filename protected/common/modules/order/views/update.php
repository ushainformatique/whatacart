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
        'label' => UsniAdaptor::t('application', 'Update') . " " . UsniAdaptor::t('order', 'Order')
    ]
];
$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('order', 'Order') . ' #' . $formDTO->getCheckout()->order->id;
echo $this->render("/_orderedit", ['formDTO' => $formDTO, 'caption' => $this->title]);