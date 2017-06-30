<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use frontend\widgets\ActiveForm;
use frontend\widgets\FormButtons;

/* @var $this \frontend\web\View */
/* @var $formDTO \customer\dto\FormDTO */

$label      = UsniAdaptor::t('users', 'Change Password');
$model      = $formDTO->getModel();
$this->params['breadcrumbs'] = [
                                    [
                                        'label' => UsniAdaptor::t('customer', 'My Account'),
                                        'url'   => ['/customer/site/my-account']
                                    ],
                                    [
                                        'label' => $label
                                    ]
                                ];
$this->title        = $label;
$this->leftnavView  = '/front/_sidebar';
$form       = ActiveForm::begin([
                                    'id' => 'changepasswordformview',
                                    'layout' => 'horizontal',
                                    'caption' => $label
                               ]);
?>
<?= $form->field($model, 'newPassword')->passwordInput(); ?>
<?= $form->field($model, 'confirmPassword')->passwordInput(); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('customer/site/my-account')]);?>
<?php ActiveForm::end(); ?>
