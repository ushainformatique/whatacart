<?php
use marqu3s\summernote\Summernote;
use usni\library\widgets\forms\NameWithAliasFormField;
use products\utils\ProductUtil;
use dosamigos\selectize\SelectizeTextInput;

/* @var $formDTO \products\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */
$model = $formDTO->getModel();
?>
<?= $form->field($model, 'name')->widget(NameWithAliasFormField::className()); ?>
<?= $form->field($model, 'alias')->textInput();?>
<?= $form->field($model, 'type')->dropDownList(ProductUtil::getProductTypeList());?>
<?= $form->field($model, 'description')->widget(Summernote::className()); ?>
<?= $form->field($model, 'metakeywords')->textarea();?>
<?= $form->field($model, 'metadescription')->textarea();?>
<?= $form->field($model, 'tagNames')->widget(SelectizeTextInput::className(), [
                                                        'loadUrl' => ['default/tags'], 
                                                        'clientOptions' => [
                                                                            'plugins' => ['remove_button'],
                                                                            'valueField' => 'name',
                                                                            'labelField' => 'name',
                                                                            'searchField' => ['name'],
                                                                            'create' => true,
                                                                        ], 
                                                        'options' => ['class' => 'form-control']
]);