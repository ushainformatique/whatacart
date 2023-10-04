<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\utils\Html;
use usni\library\bootstrap\ActiveForm;
use usni\fontawesome\FA;
use usni\library\web\AdminAssetBundle;

/* @var $model \usni\library\modules\users\models\LoginForm */
/* @var $userFormDTO \usni\library\modules\users\dto\UserFormDTO */
/* @var $this \usni\library\web\AdminView */

$this->params['breadcrumbs'] = [];
$this->title = UsniAdaptor::t('users', 'CPanel Login');
AdminAssetBundle::register($this);
echo $this->renderHeader();

$model          = $userFormDTO->getModel();
?>
<div class="login-wrapper">
    	<?php $form = ActiveForm::begin(['id' => 'login-form', 'decoratorView' => false]);?>
			<div class="popup-header">
                <span class="text-semibold"><?php echo UsniAdaptor::t('application', 'CPanel Login');?></span>
			</div>
			<div class="well">
                <?php echo $form->field($model, 'username');?>
                <?php echo $form->field($model, 'password')->passwordInput();?>
				<div class="row form-actions">
					<div class="col-xs-6">
						<div class="checkbox checkbox-admin">
                            <?php echo Html::activeCheckbox($model, 'rememberMe', ['class' => 'checked']);?>
						</div>
					</div>

					<div class="col-xs-6">
                        <button type="submit" class="btn btn-warning pull-right"><?php echo FA::icon('bars')->size('lg');?>
 <?php echo UsniAdaptor::t('users', 'Sign In');?></button>
					</div>
				</div>
			</div>
    	<?php ActiveForm::end();?>
</div>
<?php echo $this->renderFooter();