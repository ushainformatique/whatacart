<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\widgets;

use usni\library\utils\Html;
use usni\UsniAdaptor;
use products\behaviors\PriceBehavior;
/**
 * DynamicOptionsEditView class file
 *
 * @package products\widgets
 */
class DynamicOptionsEditView extends \yii\bootstrap\Widget
{
    /**
     * @var integer 
     */
    public $productId;
    
    /**
     * Default field options
     * @var type 
     */
    public $fieldOptions = [];
    
    /**
     * @var array 
     */
    public $assignedOptions;
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            PriceBehavior::className()
        ];
    }
    
    /**
     * inheritdoc
     */
    public function run()
    {
        if(empty($this->fieldOptions))
        {
            $this->fieldOptions = $this->getDefaultFieldOptions();
        }
        $records       = $this->assignedOptions;
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
            $label      = Html::label($displayName, null, ['class' => $this->fieldOptions['labelOptions']['class'], 'for' => $name]);
            $items = [];
            foreach($rows as $row)
            {
               $items[$row['optionValueId']] = $row['value'] . ' (' . $row['price_prefix'] . $this->getFormattedPrice($row['price'], $this->getSelectedCurrency()) . ')'; 
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
            $errorContainer = Html::tag('div', '', ['class' => 'help-block help-block-error']);
            //Wrap input into container if available
            if(!empty($this->fieldOptions['inputContainerOptions']['class']))
            {
                $inputContainer = Html::tag('div', $field . $errorContainer, $this->fieldOptions['inputContainerOptions']); 
            }
            else
            {
                $inputContainer = $field . $errorContainer;
            }
            $valueContent .= Html::tag('div', $label . $inputContainer, 
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
            $field .= Html::tag('div', Html::radio($name, false, 
                                                         ['label' => $item,
                                                          'value' => $value]), 
                                    ['class' => 'radio']);
        }
        return Html::tag('div', $field, ['data-productid' => $this->productId, 'data-optionid'  => $optionId]);
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
            $field .= Html::tag('div', Html::checkbox($name . '[]', false, 
                                                         ['label' => $item,
                                                          'value' => $value]), 
                                    $this->fieldOptions['checkboxContainerOptions']);
        }
        return Html::tag('div', $field, ['data-productid' => $this->productId, 'data-optionid'  => $optionId]);
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
        return Html::dropDownList($name, '', $items, 
                                    [
                                     'class' => $inputClass, 
                                     'id'    => $id,
                                     'prompt' => Html::getDefaultPrompt(),
                                     'data-productid' => $this->productId,
                                     'data-optionid'  => $optionId]
                                    );
    }
    
    /**
     * Get selected currency
     * @return string
     */
    protected function getSelectedCurrency()
    {
        return UsniAdaptor::app()->currencyManager->selectedCurrency;
    }
}