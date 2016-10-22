<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\views\UiView;
use products\models\Product;
use usni\library\components\UiHtml;
use products\utils\ProductUtil;
use usni\UsniAdaptor;
/**
 * DynamicOptionsEditView class file
 *
 * @package products\views
 */
class DynamicOptionsEditView extends UiView
{
    /**
     * Product Model
     * @var Product 
     */
    public $product;
    
    /**
     * Default field options
     * @var type 
     */
    public $fieldOptions = [];
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        if(empty($this->fieldOptions))
        {
            $this->fieldOptions = $this->getDefaultFieldOptions();
        }
        //extract($fieldOptions);
        
        $language      = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $records       = ProductUtil::getAssignedOptions($this->product['id'], $language);
        $modifiedRecords = [];
        foreach($records as $record)
        {
            $modifiedRecords[$record['optionId']][] = $record;
        } 
        $valueContent = null;
        foreach($modifiedRecords as $optionId => $rows)
        {
            $type       = $rows[0]['type'];
            $displayName = $rows[0]['display_name'];
            $required    = $rows[0]['required'];
            if($required == true)
            {
                $this->fieldOptions['fieldContainerOptions']['class'] .= ' required';
            }
            $this->fieldOptions['fieldContainerOptions']['class'] .= ' field-productoptionmapping-' . $optionId;
            $name       = 'ProductOptionMapping[option][' . $optionId . ']';
            $label      = UiHtml::label($displayName, null, ['class' => $this->fieldOptions['labelOptions']['class'], 'for' => $name]);
            $items = [];
            foreach($rows as $row)
            {
               $items[$row['optionValueId']] = $row['value'] . ' (' . $row['price_prefix'] . ProductUtil::getFormattedPrice($row['price']) . ')'; 
            }
            if ($type == 'select')
            {
                $field = $this->renderSelectOption($name, $items, $this->fieldOptions['inputOptions']['class'], $optionId);
            }
            if($type == 'radio')
            {
                $field = $this->renderRadioOption($name, $items, $optionId);

            }
            if($type == 'checkbox')
            {
                $field = $this->renderCheckboxOption($name, $items, $optionId);
            }   
            $errorContainer = UiHtml::tag('div', '', ['class' => 'help-block help-block-error']);
            //Wrap input into container if available
            if(!empty($this->fieldOptions['inputContainerOptions']['class']))
            {
                $inputContainer = UiHtml::tag('div', $field . $errorContainer, $this->fieldOptions['inputContainerOptions']); 
            }
            else
            {
                $inputContainer = $field . $errorContainer;
            }
            $valueContent .= UiHtml::tag('div', $label . $inputContainer, 
                                         ['class' => $this->fieldOptions['fieldContainerOptions']['class']]);
        }
        return $valueContent;
    }
    
    /**
     * Get default field options
     * @return array
     */
    protected function getDefaultFieldOptions()
    {
        return [
                'inputOptions'  => ['class' => 'form-control'],
                'labelOptions'  => ['class' => 'control-label'],
                'inputContainerOptions' => [],
                'fieldContainerOptions' => ['class' => 'form-group'],
                'checkboxContainerOptions' => ['class' => 'checkbox']
               ];
    }
    
    /**
     * Render radio option
     * @param string $name
     * @param array $items
     * @param int $optionId
     * @return string
     */
    protected function renderRadioOption($name, $items, $optionId)
    {
        $field  = null;
        foreach ($items as $value => $item)
        {
            $field .= UiHtml::tag('div', UiHtml::radio($name, false, 
                                                         ['label' => $item,
                                                          'value' => $value]), 
                                    ['class' => 'radio']);
        }
        return UiHtml::tag('div', $field, ['data-productid' => $this->product['id'], 'data-optionid'  => $optionId]);
    }
    
    /**
     * Render checkbox option
     * @param string $name
     * @param array $items
     * @param int $optionId
     * @return string
     */
    protected function renderCheckboxOption($name, $items, $optionId)
    {
        $field  = null;
        foreach ($items as $value => $item)
        {
            $field .= UiHtml::tag('div', UiHtml::checkbox($name . '[]', false, 
                                                         ['label' => $item,
                                                          'value' => $value]), 
                                    $this->fieldOptions['checkboxContainerOptions']);
        }
        return UiHtml::tag('div', $field, ['data-productid' => $this->product['id'], 'data-optionid'  => $optionId]);
    }
    
    /**
     * Render select option
     * @param string $name
     * @param array $items
     * @param string $inputClass
     * @param int $optionId
     * @return string
     */
    protected function renderSelectOption($name, $items, $inputClass, $optionId)
    {
        $id             = 'input-option' . $optionId;
        return UiHtml::dropDownList($name, '', $items, 
                                    [
                                     'class' => $inputClass, 
                                     'id'    => $id,
                                     'prompt' => UiHtml::getDefaultPrompt(),
                                     'data-productid' => $this->product['id'],
                                     'data-optionid'  => $optionId]
                                    );
    }
}