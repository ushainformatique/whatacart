<?php
use usni\library\utils\TimezoneUtil;
use customer\models\Customer;
use yii\helpers\Html;

$model   = $formDTO->getModel();
?>

<?php
if($model->scenario != 'editprofile')
{
?>
<?= $form->field($model, 'username')->textInput();?>
<?php
}
?>
<?php
if($model->scenario == 'registration')
{
?>
<?= Html::activeHiddenInput($model, 'status', ['value' => Customer::STATUS_PENDING]);?>
<?php
}
else
{
?>
<?= Html::activeHiddenInput($model, 'status', ['value' => $model->status]);?>
<?php
}
?>
<?= $form->field($model, 'timezone')->select2input(TimezoneUtil::getTimezoneSelectOptions());?>
<?= Html::activeHiddenInput($model, 'groups', ['value' => $formDTO->getGroups()]);?>
<?php
if($model->scenario == 'create' || $model->scenario == 'registration')
{
?>
    <?= $form->field($model, 'password')->passwordInput();?>
    <?= $form->field($model, 'confirmPassword')->passwordInput();?>
<?php
}
?>