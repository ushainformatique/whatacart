<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use frontend\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this \frontend\web\View */

$title              = UsniAdaptor::t('users', 'Login');
$this->title        = $title;
$model              = $formDTO->getModel();
$forgotPasswordLink = Html::a(UsniAdaptor::t('users', 'Forgot Password'), UsniAdaptor::createUrl('customer/site/forgot-password'));
$passwordTemplate   = "{beginLabel}\n{labelTitle}\n{endLabel}\n{input}\n" . $forgotPasswordLink . "{error}";
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
                                    'id'            => 'loginview', 
                                    'fieldConfig'   => ['template'     => "{beginLabel}\n{labelTitle}\n{endLabel}\n{input}\n{error}",
                                                        'labelOptions' => ['class' => '']],
                                    'decoratorView' => false
                               ]);
?>
<h2><?php echo UsniAdaptor::t('customer', 'Returning Customer');?></h2>
<p><strong><?php echo UsniAdaptor::t('customer', 'I am a returning customer')?></strong></p>
<?= $form->field($model, 'username')->textInput();?>
<?= $form->field($model, 'password', ['template' => $passwordTemplate])->passwordInput();?>
<?= $form->field($model, 'rememberMe', ['horizontalCssClasses' => ['wrapper'   => '', 'offset' => '']])->checkbox();?>
<?= Html::submitButton(UsniAdaptor::t('users', 'Login'), ['id' => 'savebutton', 'class' => 'btn btn-success']);?>
<?php ActiveForm::end();?>