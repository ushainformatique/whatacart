<?php
use usni\library\modules\settings\widgets\Thumbnail;
use usni\UsniAdaptor;

$model  = $formDTO->getModel();
?>

<?= Thumbnail::widget(['model' => $model, 
                       'attribute' => 'logo',
                       'deleteUrl' => UsniAdaptor::createUrl('settings/default/delete-image')]);?>
<?= $form->field($model, 'logo')->fileInput(); ?>
<?= $form->field($model, 'tagline')->textInput(); ?>
<?= $form->field($model, 'logoAltText')->textInput(); ?>