<?php
/* @var $formDTO \products\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */
$model = $formDTO->getModel();
?>
<?= $form->field($model, 'model')->textInput();?>
<?= $form->field($model, 'sku')->textInput();?>
<?= $form->field($model, 'price')->textInput();?>
<?= $form->field($model, 'quantity')->textInput();?>