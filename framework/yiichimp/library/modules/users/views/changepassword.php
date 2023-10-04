<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\dto\FormDTO */

$label  = UsniAdaptor::t('users', 'Change Password');
$model  = $formDTO->getModel();
$user   = $model->user;
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('users', 'Users'),
        'url' => ['/users/default/index']
    ],
        [
        'label' => $label
    ]
];
$this->title = $label;
$form       = ActiveForm::begin([
                                    'id' => 'changepasswordview',
                                    'layout' => 'horizontal',
                                    'caption' => $label . '(' . $user['username'] . ')'
                               ]);
?>
<?= $form->field($model, 'newPassword')->passwordInput(); ?>
<?= $form->field($model, 'confirmPassword')->passwordInput(); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('users/default/index')]);?>
<?php ActiveForm::end(); ?>
