<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use usni\library\utils\DAOUtil;
use usni\library\components\UiActiveForm;
use products\models\ProductOption;
use products\views\AssignProductOptionsListView;
use products\models\Product;
use usni\library\utils\AdminUtil;
/**
 * AssignProductOptionEditView class file
 * @package products\views
 */
class AssignProductOptionEditView extends UiBootstrapEditView
{
    /**
     * ProductOptionMapping model.
     * @var ProductOptionMapping
     */
    public $model;
    
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $data = DAOUtil::getDropdownDataBasedOnModel(ProductOption::className());
        $elements = [
            'option_id'        => UiHtml::getFormSelectFieldOptions($data, ['allowClear' => true], ['placeholder' => UiHtml::getDefaultPrompt()]),
            'product_id'       => ['type' => UiActiveForm::INPUT_HIDDEN],
            'required'         => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions())
        ];
        $metadata =  [
                        'elements' => $elements,
                        'buttons'  => ButtonsUtil::getDefaultButtonsMetadata('catalog/products/default/manage')
                     ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderElements($elements)
    {
        $content = parent::renderElements($elements);
        $content .= UiHtml::tag('div', '', ['id' => 'options-view-container']);
        return $content;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $product    = Product::findOne($this->model->product_id);
        $content    = parent::renderContent();
        $listView   = new AssignProductOptionsListView(['product' => $product, 'shouldRenderActionColumn' => false]);
        $listViewContent = UiHtml::tag('div', $listView->render(), ['id' => "product-option-values-container"]);
        return $content . $listViewContent;
    }
    
    /**
     * @inheritdoc
     */
    public function renderTitle()
    {
        return UsniAdaptor::t('products', 'Assign Product Options');
    }
    
    /**
     * Override to register form submit script
     */
    protected function registerScripts()
    {
        $formId             = static::getFormId();
        $url                = UsniAdaptor::createUrl('/catalog/products/option/assign');
        $productId          = $this->model->product_id;
        $script             = "$('#{$formId}').on('beforeSubmit',
                                     function(event, jqXHR, settings)
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
                                                                $('#options-view-container').html('');
                                                                $('#productoptionmapping-option_id').select2('val', null);
                                                                $('#product-option-values-container').html(data);
                                                              });

                                                return false;
                                     })";
        $this->getView()->registerJs($script);
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
        $this->getView()->registerJs($script);
        
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
        $this->getView()->registerJs($script);
    }
}
?>