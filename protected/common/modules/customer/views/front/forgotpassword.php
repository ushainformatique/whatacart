<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use frontend\widgets\ActiveForm;
use frontend\widgets\FormButtons;

$title              = UsniAdaptor::t('users', 'Forgot Password');
$this->title        = $title;
$model              = $formDTO->getModel();
$descriptionText    = '<p style="margin:10px">' . UsniAdaptor::t('customer', 'Enter the e-mail address associated with your account. Click submit to have your information e-mailed to you.') . "</p>";
$this->params['breadcrumbs'] = [    
                                    [
                                        'label' => UsniAdaptor::t('customer', 'My Account'),
                                        'url'   => ['/customer/site/my-account']
                                    ],
                                    [
                                        'label' => $title
                                    ]
                               ];
$form = ActiveForm::begin([
                            'id'          => 'forgotpasswordformview',
                            'layout'      => 'horizontal',
                            'caption'     => UsniAdaptor::t('users', 'Forgot Password') . '?'
                       ]);
?>
<?= $descriptionText;?>
<?= $form->field($model, 'email')->textInput();?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('customer/site/login'), 'submitButtonLabel' => UsniAdaptor::t('application', 'Submit')]);?>
<?php ActiveForm::end();?>
