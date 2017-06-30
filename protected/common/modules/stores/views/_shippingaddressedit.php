<?php
use common\modules\stores\utils\StoreScriptUtil;

/* @var $form \usni\library\bootstrap\ActiveForm */
/* @var $this \usni\library\web\AdminView */
$model = $formDTO->getModel()->shippingAddress;
?>
<?= $form->field($model, 'useBillingAddress', ['horizontalCssClasses' => ['wrapper'   => 'col-sm-12'], 
                                      'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}"])->checkbox();?>
<?php 
echo $this->render('/_addressedit', ['form' => $form, 'model' => $model]);
StoreScriptUtil::registerSameAsBillingAddressScript($this);