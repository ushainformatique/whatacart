<?php
use products\utils\ProductUtil;
use usni\library\utils\StatusUtil;
use usni\library\utils\AdminUtil;
use dosamigos\datepicker\DatePicker;
use usni\library\utils\Html;
use usni\library\widgets\Thumbnail;

/* @var $formDTO \products\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$model = $formDTO->getModel();
?>
<?= $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown());?>
<?= $form->field($model, 'tax_class_id')->dropDownList($formDTO->getTaxClasses(), ['prompt' => Html::getDefaultPrompt()]);?>
<?= Thumbnail::widget(['model' => $model, 
                       'attribute' => 'image',
                       'showDeleteLink' => false]);?>
<?= $form->field($model, 'image')->fileInput();?>
<?= $form->field($model, 'minimum_quantity')->textInput();?>
<?= $form->field($model, 'stock_status')->dropDownList(ProductUtil::getOutOfStockSelectOptions());?>
<?= $form->field($model, 'subtract_stock')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $form->field($model, 'requires_shipping')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $form->field($model, 'location')->textInput();?>
<?= $form->field($model, 'date_available')->widget(DatePicker::className(), [
                                                        'template' => '{addon}{input}', 
                                                        'clientOptions' => [
                                                                                'autoclose' => true,
                                                                                'format'    => 'yyyy-m-dd',
                                                                             ], 
                                                        'options'   => ['class' => 'form-control']
]); ?>
<?= $form->field($model, 'length')->textInput();?>
<?= $form->field($model, 'width')->textInput();?>
<?= $form->field($model, 'height')->textInput();?>
<?= $form->field($model, 'weight')->textInput();?>
<?= $form->field($model, 'length_class')->dropDownList($formDTO->getLengthClasses());?>
<?= $form->field($model, 'weight_class')->dropDownList($formDTO->getWeightClasses());?>
<?= $form->field($model, 'upc')->textInput();?>
<?= $form->field($model, 'ean')->textInput();?>
<?= $form->field($model, 'jan')->textInput();?>
<?= $form->field($model, 'isbn')->textInput();?>
<?= $form->field($model, 'mpn')->textInput();?>
<?= $form->field($model, 'is_featured', ['horizontalCssClasses' => ['wrapper'   => 'col-sm-12'], 
                                         'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}"])->checkbox();?>