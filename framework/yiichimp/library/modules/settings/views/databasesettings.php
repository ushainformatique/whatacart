<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\modules\settings\dto\FormDTO */

use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;

$model          = $formDTO->getModel();
$title          = UsniAdaptor::t('settings', 'Database Settings');
$this->title    = $this->params['breadcrumbs'][] = $title;
$form = ActiveForm::begin([
        'id' => 'databasesettingsview',
        'layout' => 'horizontal',
        'caption' => $title
    ]);
?>
<?= $form->field($model, 'enableSchemaCache', ['horizontalCssClasses' => ['wrapper'   => 'col-sm-12'], 
                                         'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}"])->checkbox();?>
<?= $form->field($model, 'schemaCachingDuration')->textInput(); ?>
<?= FormButtons::widget(['showCancelButton' => false]);?>
<?php ActiveForm::end(); ?>
