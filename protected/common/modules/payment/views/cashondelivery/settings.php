<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\dto\FormDTO */

use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

$model          = $formDTO->getModel();
$dropdownData   = $formDTO->getOrderStatusDropdownData();
$this->params['breadcrumbs'] = [
        [
            'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('payment', 'Payments'),
            'url'   => ['/payment/default/index']
        ],
        [
            'label' => UsniAdaptor::t('payment', 'Cash On Delivery Settings')
        ]
];
$title = UsniAdaptor::t('payment', 'Cash On Delivery Settings');
$this->title = $title;
$form = ActiveForm::begin([
        'id' => 'cashondeliverysettingseditview',
        'layout' => 'horizontal',
        'caption' => $title
    ]);
?>
<?= $form->field($model, 'order_status')->select2input($dropdownData);?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('payment/default/index')]);?>
<?php ActiveForm::end();

