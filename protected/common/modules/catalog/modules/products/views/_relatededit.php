<?php
use products\utils\DownloadUtil;

/* @var $formDTO \products\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */
$model = $formDTO->getModel();
?>
<?= $form->field($model, 'manufacturer')->select2input($formDTO->getManufacturers());?>
<?= $form->field($model, 'categories')->select2input($formDTO->getCategories(), true, ['multiple' => 'multiple'], ['closeOnSelect' => false]);?>
<?= $form->field($model, 'relatedProducts')->select2input($formDTO->getRelatedProducts(), true, ['multiple' => 'multiple'], ['closeOnSelect' => false]);?>
<?= $form->field($model, 'download_option')->dropDownList(DownloadUtil::getOptions());?>
<?= $form->field($model, 'downloads')->select2input($formDTO->getDownloads(), true, ['multiple' => 'multiple'], ['closeOnSelect' => false]);?>