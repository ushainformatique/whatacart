<?php
use usni\UsniAdaptor;
use frontend\widgets\ActiveForm;
use frontend\widgets\FormButtons;
use usni\library\utils\Html;

/* @var $this \frontend\web\View */
/* @var $model \frontend\models\SearchForm */

$model = $this->params['model'];
?>
<div id="column-left" class="col-sm-3 hidden-xs">
<?php
$form = ActiveForm::begin([
        'id' => 'searchformview',
        'caption' => UsniAdaptor::t('application', 'Search Criteria'),
        'method' => 'get',
        'action'  => UsniAdaptor::createUrl('site/default/search'),
        'fieldConfig' => [ 'template' => "{beginLabel}{labelTitle}{endLabel}{beginWrapper}{input}{error}{endWrapper}",
                            'horizontalCssClasses' => [
                                                        'label'     => '',
                                                        'offset'    => '',
                                                        'wrapper'   => '',
                                                        'error'     => '',
                                                        'hint'      => '',
                                                   ]]
    ]);
?>
<?= $form->field($model, 'keyword')->textInput(); ?>
<?= $form->field($model, 'categoryId')->dropDownList($this->params['categoryList'], ['prompt' => Html::getDefaultPrompt()]); ?>
<?= FormButtons::widget(['submitButtonLabel' => UsniAdaptor::t('application', 'Search'),
                         'showCancelButton' => false]);
ActiveForm::end();
?>
</div>