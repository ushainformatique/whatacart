<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\utils\AdminUtil;
use usni\library\utils\Html;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \products\dto\AssignOptionDTO */

$this->title                = UsniAdaptor::t('products', 'Assign Product Options');
$this->params['breadcrumbs']= [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('products', 'Products'),
                                        'url'   => UsniAdaptor::createUrl('/catalog/products/default/index')
                                    ],
                                    [
                                        'label' => $formDTO->product['name'],
                                        'url'   => UsniAdaptor::createUrl('/catalog/products/default/view', ['id' => $formDTO->product['id']])
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('products', 'Assign Options')
                                    ]
                            ];
$model      = $formDTO->model;

$caption    = $this->title;
$form       = ActiveForm::begin([
                    'id' => 'assignproductoptionseditview',
                    'layout' => 'horizontal',
                    'caption' => $caption
                ]);
?>
<?= $form->field($model, 'option_id')->select2input($formDTO->getOptions());?>
<?= Html::activeHiddenInput($model, 'product_id');?>
<?= $form->field($model, 'required')->dropDownList(AdminUtil::getYesNoOptions()); ?>
<!-- Load the options here on change -->
<div id="options-view-container">
    
</div>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('catalog/products/default/index')]);?>
<?php ActiveForm::end();?>
<div id="product-option-values-container">
    <?php echo $this->render('/_manageOptionValuesSubView', ['assignedOptions' => $formDTO->getAssignedOptions()]);?>
</div>
<?php
$url                = UsniAdaptor::createUrl('/catalog/products/option/save-assignment');
$productId          = $formDTO->model->product_id;
$formId             = 'assignproductoptionseditview';
$script             = "$('#{$formId}').on('beforeSubmit',
                             function(event)
                             {
                                var form = $(this);
                                if(form.find('.has-error').length) {
                                        return false;
                                }
                                $.ajax({
                                            url: '{$url}',
                                            type: 'post',
                                            beforeSend: function()
                                                        {
                                                            $.fn.attachLoader('#{$formId}');
                                                        },
                                            data: form.serialize()
                                        })
                                .done(function(data, statusText, xhr){
                                                        console.log(data);
                                                        //Timeout is critical here else pjax expires and
                                                        //and page got refreshed
                                                        $.fn.removeLoader('#{$formId}');
                                                        //remove button loader
                                                        removeButtonLoader($('#{$formId}'));
                                                        $('#options-view-container').html('');
                                                        $('#productoptionmapping-option_id').select2('val', null);
                                                        $('#product-option-values-container').html(data);
                                                      });

                                        return false;
                             })";
$this->registerJs($script);
$url                = UsniAdaptor::createUrl('/catalog/products/option/get-product-values');
$script             = "$('#productoptionmapping-option_id').on('change',
                            function(event, jqXHR, settings)
                            {
                                var dropDown    = $(this);
                                var value       = $(this).val();
                                if(value == '')
                                {
                                    return false;
                                }
                                else
                                {
                                    $.ajax({
                                            url: '{$url}',
                                            type: 'get',
                                            data: 'productId={$productId}&optionId=' + value,
                                            beforeSend: function()
                                                        {
                                                            $.fn.attachLoader('#productoptionmapping-option_id');
                                                        },
                                            success: function(data){
                                                $.fn.removeLoader('#productoptionmapping-option_id');
                                                $('#options-view-container').html(data);
                                            }
                                        });
                                }
                            }
                        )";
$this->registerJs($script);
$script     = "$('body').on('click', '#add-option-value-row',
                                    function(event, jqXHR, settings)
                                    {
                                        var optionValueTable = $('#option-value-table');
                                        var rowCount         = $('#option-value-table tr').length;
                                        var newTr            = $('.option-value-row-dummy').clone();
                                        $(newTr).removeClass('option-value-row-dummy').addClass('option-value-row');
                                        var newId            = 'option-value-row-' + (rowCount);
                                        $(newTr).attr('id', newId);
                                        $(newTr).find('.dummy-option').attr('name', 'ProductOptionMapping[option_value_id][]').removeClass('dummy-option');
                                        $(newTr).appendTo('#option-value-table tbody');
                                        $(newTr).show();
                                        $('html, body').animate({ scrollTop: $('#options-view-container').offset().top}, 'slow');
                                    }
                                )";
$this->registerJs($script);