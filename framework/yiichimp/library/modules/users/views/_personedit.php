<?php
use usni\library\widgets\Thumbnail;

$model  = $formDTO->getPerson();
?>
<?= $form->field($model, 'firstname')->textInput();?>
<?= $form->field($model, 'lastname')->textInput();?>
<?= $form->field($model, 'email')->textInput();?>
<?= $form->field($model, 'mobilephone')->textInput();?>
<?= Thumbnail::widget(['model' => $model, 
                       'attribute' => 'profile_image',
                       'deleteUrl' => $deleteUrl]);?>
<?= $form->field($model, 'profile_image')->fileInput();?>
