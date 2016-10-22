<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiHtml;
use products\utils\ProductUtil;
use usni\fontawesome\FA;
use usni\UsniAdaptor;
use products\models\ProductOptionValue;
use products\models\ProductOption;
/**
 * ProductOptionEditView class file
 *
 * @package products\views
 */
class ProductOptionEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'              => ['type' => 'text'],
                        'display_name'      => ['type' => 'text'],
                        'type'              => UiHtml::getFormSelectFieldOptions(ProductUtil::getProductOptionType()),
                     ];
        $metadata =  [
                        'elements' => $elements,
                        'buttons'  => ButtonsUtil::getDefaultButtonsMetadata('catalog/products/option/manage')
                     ];
        return $metadata;
    }
    
    /**
     * Is form data multipart.
     * @return boolean
     */
    public function isMultiPartFormData()
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderElements($elements)
    {
        $content    = parent::renderElements($elements);
        $titleRow   = UiHtml::tag('div', 
                                    UiHtml::tag('h4', ProductOptionValue::getLabel(2)),
                                   ['class' => 'col-xs-10']);
        
        $titleRow   .= UiHtml::tag('div', UiHtml::tag('span', 
                                                     UiHtml::a(FA::icon('plus'), '#',
                                                                [
                                                                   'class' => 'btn btn-primary add-optionvalue',
                                                                   'type'  => 'button'
                                                                ]
                                                              )
                                                     ), ['class' => 'col-xs-2']);
        $content    .= UiHtml::tag('div', $titleRow, ['class' => 'row']);
        $optionContent  = null;
        if(!empty($this->model->optionValues))
        {
            foreach($this->model->optionValues as $i => $optionValue)
            {
                $config     = $this->getValueOptions();
                $id         = UiHtml::getInputId($optionValue, 'value') . '-' . $i;
                if($this->model->scenario == 'update')
                {
                    $field      = $this->form->field($optionValue, 'value[' . $optionValue->id . ']', $config)->textInput(['id' => $id, 'value' => $optionValue->value]);
                }
                else
                {
                    $field      = $this->form->field($optionValue, 'value[]', $config)->textInput(['id' => $id, 'value' => $optionValue->value]);
                }
                $optionContent .= $field;
            }
        }
        $optionContent = UiHtml::tag('div', $optionContent, ['id' => 'option-content-container']);
        $content       .= $optionContent;
        return $content;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $content = parent::renderContent();
        return $content . $this->renderDummyOptionField();
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        parent::registerScripts();
        $script = "$('.add-optionvalue').click(function(){
                                                    var newTr       = $('.option-value-dummy').clone();
                                                    var itemCount   = parseInt($('#option-content-container').children().length);
                                                    $(newTr).removeClass('option-value-dummy');
                                                    var newId       = 'productoptionvalue-value-' + (itemCount);
                                                    $(newTr).find('.form-control').attr('id', newId);
                                                    $(newTr).addClass('field-productoptionvalue-value');
                                                    $(newTr).appendTo('#option-content-container');
                                                    $(newTr).show();
                                                    $('#' + newId).focus();
                                                    $('html, body').animate({ scrollTop: $('#' + newId).offset().top }, 'slow');
                                                 });
                                                 $('body').on('click', '.remove-optionvalue', function() {
                                                    $(this).parent().parent().remove();
                                                 });
                                                 ";
        $this->getView()->registerJs($script);
    }
    
    /**
     * Gets option value field options.
     * @return array
     */
    protected function getValueOptions()
    {
        $removeIcon     = UiHtml::a(FA::icon('minus'), '#', array('class'  => 'remove-optionvalue'));
        $options        = $this->getDefaultAttributeOptions();
        $options['template'] = "{beginWrapper}\n{input}\n{error}\n{endWrapper}";
        $options['horizontalCssClasses'] = $this->getValueHorizontalCssClasses();
        $options['options']  = ['class' => 'form-group'];
        $options['inputTemplate']  = '{input}' . $removeIcon;
        return $options;
    }
    
    /**
     * Get horizontal css classes for value fields.
     * @return array
     */
    protected function getValueHorizontalCssClasses()
    {
        return [
                    'offset'    => '',
                    'wrapper'   => 'col-xs-8 col-xs-offset-2 input-group',
                    'error'     => '',
                    'hint'      => '',
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        if($this->model->scenario == 'update')
        {
            $option         = new ProductOption();
            $viewClassName  = static::resolveBrowseModelViewClassName();
            $view           = new $viewClassName(['model' => $option, 
                                                  'attribute' => $this->resolveDefaultBrowseByAttribute(), 
                                                  'shouldRenderOwnerCreatedModelsForBrowse' => $this->shouldRenderOwnerCreatedModels()]);
            return $view->render();
        }
        return null;
    }
    
    /**
     * Renders dummy option field
     * @return string
     */
    protected function renderDummyOptionField()
    {
        $filePath = UsniAdaptor::getAlias('@products/views/_optionDummy') . '.php';
        return $this->getView()->renderPhpFile($filePath);
    }
}