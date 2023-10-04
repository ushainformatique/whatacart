<?php
/* @var $formDTO \usni\library\modules\install\dto\InstallFormDTO */
/* @var $model \usni\library\modules\install\models\SettingsForm */
/* @var $form \usni\library\bootstrap\ActiveForm */

$model  = $formDTO->getModel();

if($model->dbHost == null)
{
    $model->dbHost = 'localhost';
}
if($model->dbPort == null)
{
    $model->dbPort = 3306;
}
?>

<?= $form->field($model, 'dbAdminUsername')->textInput();?>
<?= $form->field($model, 'dbAdminPassword')->passwordInput();?>
<?= $form->field($model, 'dbHost')->textInput();?>
<?= $form->field($model, 'dbPort')->textInput();?>
<?= $form->field($model, 'dbName')->textInput();?>
<?= $form->field($model, 'dbUsername')->textInput();?>
<?= $form->field($model, 'dbPassword')->passwordInput();?>