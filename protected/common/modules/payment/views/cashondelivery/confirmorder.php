<?php
use frontend\widgets\ActiveForm;
use usni\UsniAdaptor;

$form = ActiveForm::begin([
                                    'id'     => 'codconfirmview', 
                                    'layout' => 'horizontal',
                                    'caption'=> '',
                                    'decoratorView' => false,
                                    'action' => UsniAdaptor::createUrl('/cart/checkout/complete-order')
                               ]);
echo $this->render('@cart/views/_confirmorderbuttons');
ActiveForm::end();

