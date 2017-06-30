<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use products\utils\ProductUtil;
use usni\library\utils\Html;
use usni\fontawesome\FA;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\dto\FormDTO */

$model  = $formDTO->getModel();

if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('products', 'Option');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('products', 'Option');
}
$form = ActiveForm::begin([
        'id' => 'productoptioneditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'display_name')->textInput(); ?>
<?= $form->field($model, 'type')->select2input(ProductUtil::getProductOptionType());?>
<?php
$titleRow   = Html::tag('div', Html::tag('h4', UsniAdaptor::t('products', 'Option Values')), ['class' => 'col-xs-10']);
$titleRow  .= Html::tag('div', Html::tag('span', 
                                            Html::a(FA::icon('plus'), '#',
                                                       [
                                                          'class' => 'btn btn-primary add-optionvalue',
                                                          'type'  => 'button'
                                                       ]
                                                     )
                                            ), ['class' => 'col-xs-2']);
echo Html::tag('div', $titleRow, ['class' => 'row']);
?>
<div id="option-content-container">
<?php
if(!empty($model->optionValues))
{
    foreach($model->optionValues as $i => $optionValue)
    {
        $removeIcon = Html::a(FA::icon('minus'), '#', array('class'  => 'remove-optionvalue'));
        $config     = $form->fieldConfig;
        $config['template']         = "{beginWrapper}{input}{error}{endWrapper}";
        $config['inputTemplate']    = '{input}' . $removeIcon;
        $config['horizontalCssClasses'] = [
                                            'label'     => 'col-sm-2',
                                            'offset'    => '',
                                            'wrapper'   => 'col-xs-8 col-xs-offset-2 input-group',
                                            'error'     => '',
                                            'hint' 
                                          ];
        ?>
    <div class="option-value-field-container">
    <?php
        $id         = Html::getInputId($optionValue, 'value') . '-' . $i;
        echo $form->field($optionValue, "[$i]value", $config)->textInput(['id' => $id, 'value' => $optionValue['value']]);
        echo Html::activeHiddenInput($optionValue, "[$i]id", ['value' => $optionValue['id']]);
        ?>
    </div>
    <?php
    }
}
?>
</div>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('catalog/products/option/index')]);?>
<?php ActiveForm::end(); ?>
<?php
echo $this->render('/productoption/_optionDummy');
$this->registerJs("$('.add-optionvalue').click(function(){
                                                    var newTr       = $('.option-value-dummy').clone();
                                                    var itemCount   = parseInt($('#option-content-container .option-value-field-container').length);
                                                    $(newTr).removeClass('option-value-dummy');
                                                    var newId       = 'productoptionvalue-value-' + itemCount;
                                                    $(newTr).find('.form-control').addClass('field-productoptionvalue-value');
                                                    var trContent = $(newTr).html();
                                                    //http://www.w3schools.com/jsref/jsref_replace.asp
                                                    trContentModified = trContent.replace(/##rowCount##/g, itemCount);
                                                    $(newTr).html(trContentModified);
                                                    $(newTr).appendTo('#option-content-container');
                                                    $(newTr).show();
                                                    $('#' + newId).focus();
                                                    $('html, body').animate({ scrollTop: $('#' + newId).offset().top }, 'slow');
                                                 });
                                                 $('body').on('click', '.remove-optionvalue', function() {
                                                    $(this).parent().parent().parent().remove();
                                                 });
                                                 "
                 );
