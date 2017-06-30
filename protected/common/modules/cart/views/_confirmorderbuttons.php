<?php
use common\modules\order\widgets\ConfirmOrderFormButtons;
use usni\UsniAdaptor;

echo ConfirmOrderFormButtons::widget(['submitButtonLabel' => UsniAdaptor::t('application', 'Confirm Order'),
                             'cancelUrl' => UsniAdaptor::createUrl('cart/checkout/index'),
                             'cancelLinkLabel' => UsniAdaptor::t('cart', 'Back'),
                             'submitButtonOptions' => ['class' => 'btn btn-success', 'id' => 'save'],
                             'editCartUrl' => UsniAdaptor::createUrl('cart/default/view')
                             ]);

