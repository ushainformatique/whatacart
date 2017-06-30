<?php
use usni\library\utils\CountryUtil;
use usni\library\utils\TimezoneUtil;

/* @var $formDTO \common\modules\stores\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$model = $formDTO->getModel()->storeLocal;
?>
<?= $form->field($model, 'country')->select2input(CountryUtil::getCountries());?>
<?= $form->field($model, 'state')->textInput();?>
<?= $form->field($model, 'language')->select2input($formDTO->getLanguages());?>
<?= $form->field($model, 'currency')->select2input($formDTO->getCurrencies());?>
<?= $form->field($model, 'timezone')->select2input(TimezoneUtil::getTimezoneSelectOptions());?>
<?= $form->field($model, 'length_class')->select2input($formDTO->getLengthClasses());?>
<?= $form->field($model, 'weight_class')->select2input($formDTO->getWeightClasses());?>