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

$label  = UsniAdaptor::t('users', 'User Settings');
$this->params['breadcrumbs'] = [
                                    [ 'label' => $label]
                               ];
$this->title    = $label;
$form           = ActiveForm::begin([
                                        'id' => 'changepasswordview',
                                        'layout' => 'horizontal',
                                        'caption' => $label
                                    ]);
?>
<?= $form->field($model, 'passwordTokenExpiry')->textInput(); ?>
<?= FormButtons::widget(['showCancelButton' => false]);?>
<?php ActiveForm::end(); ?>
