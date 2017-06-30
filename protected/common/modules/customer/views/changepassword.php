<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \customer\dto\FormDTO */

$label      = UsniAdaptor::t('users', 'Change Password');
$model      = $formDTO->getModel();
$customer   = $model->user;
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('customer', 'Customers'),
        'url' => ['/customer/default/index']
    ],
        [
        'label' => $label
    ]
];
$this->title = $label;
$form       = ActiveForm::begin([
                                    'id' => 'changepasswordview',
                                    'layout' => 'horizontal',
                                    'caption' => $label . '(' . $customer['username'] . ')'
                               ]);
?>
<?= $form->field($model, 'newPassword')->passwordInput(); ?>
<?= $form->field($model, 'confirmPassword')->passwordInput(); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('customer/default/index')]);?>
<?php ActiveForm::end(); ?>
