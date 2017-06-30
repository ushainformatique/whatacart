<?php
use usni\UsniAdaptor;
use frontend\widgets\ActiveForm;
use yii\captcha\Captcha;
use frontend\widgets\FormButtons;

/* @var $this \frontend\web\View */

$model          = $formDTO->getModel();
$title          = UsniAdaptor::t('application', 'Contact Us');
$this->title    = $title;
?>
<?php
$this->params['breadcrumbs'] = [
                                    ['label' => $title]
                                ];
$form = ActiveForm::begin([
                            'id'          => 'contactformview', 
                            'layout'      => 'horizontal',
                            'caption'     => $title
                         ]);
?>
<?= $form->field($model, 'name')->textInput();?>
<?= $form->field($model, 'email')->textInput();?>
<?= $form->field($model, 'subject')->textInput();?>
<?= $form->field($model, 'message')->textarea();?>
<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), ['captchaAction' => '/site/default/captcha']);?>
<?= FormButtons::widget(['submitButtonLabel' => UsniAdaptor::t('application', 'Submit'), 'showCancelButton' => false]);?>
<?php ActiveForm::end();