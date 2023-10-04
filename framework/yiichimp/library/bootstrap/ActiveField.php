<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\bootstrap;

use usni\library\utils\ArrayUtil;
use usni\library\extensions\select2\ESelect2;
use usni\library\utils\Html;
/**
 * Override yii2 bootstrap ActiveField class for changes specific to admin.
 * 
 * @package usni\library\bootstrap
 */
class ActiveField extends \yii\bootstrap\ActiveField
{
    /**
     * Bootstrap tooltip hint display for the field
     * @var boolean 
     */
    public $enableTooltipHint = true;
    
    /**
     * Get field hint
     * @return string
     */
    public function getHint()
    {
        $hint       = null;
        if(method_exists($this->model, 'attributeHints'))
        {
            $modelHints = $this->model->attributeHints();
            if(!empty($modelHints))
            {
                $hint = ArrayUtil::getValue($modelHints, $this->attribute, null);
            }
        }
        return $hint;
    }
    
    /**
     * inheritdoc
     */
    public function textInput($options = [])
    {
        $this->addTooltipOptions($options);
        return parent::textInput($options);
    }
    
    /**
     * inheritdoc
     */
    public function textarea($options = [])
    {
        $this->addTooltipOptions($options);
        return parent::textarea($options);
    }
    
    /**
     * inheritdoc
     */
    public function passwordInput($options = [])
    {
        $this->addTooltipOptions($options);
        return parent::passwordInput($options);
    }
    
    /**
     * inheritdoc
     */
    public function radio($options = [], $enclosedByLabel = true)
    {
        $this->addTooltipOptions($options);
        return parent::radio($options, $enclosedByLabel);
    }
    
    /**
     * inheritdoc
     */
    public function checkbox($options = [], $enclosedByLabel = true)
    {
        $this->addTooltipOptions($options);
        return parent::checkbox($options, $enclosedByLabel);
    }
    
    /**
     * inheritdoc
     */
    public function dropDownList($items, $options = [])
    {
        $this->addTooltipOptions($options);
        return parent::dropDownList($items, $options);
    }
    
    /**
     * inheritdoc
     */
    public function listBox($items, $options = [])
    {
        $this->addTooltipOptions($options);
        return parent::listBox($items, $options);
    }
    
    /**
     * inheritdoc
     */
    public function checkboxList($items, $options = [])
    {
        $this->addTooltipOptions($options);
        return parent::checkboxList($items, $options);
    }
    
    /**
     * inheritdoc
     */
    public function radioList($items, $options = [])
    {
        $this->addTooltipOptions($options);
        return parent::radioList($items, $options);
    }
    
    /**
     * Add tooltip options
     * @param array $options
     * @return array
     */
    protected function addTooltipOptions(& $options)
    {
        if($this->enableTooltipHint)
        {
            $hint = $this->getHint();
            if($hint != null)
            {
                $options = ArrayUtil::merge(['data-title'  => $hint,
                                            'data-toggle' => 'tooltip',
                                            'data-trigger' => 'hover',
                                            'data-placement' => 'top'], $options);
            }
        }
        return $options;
    }
    
    /**
     * Select2 input field
     * @param array $items List of items
     * @param boolean $enableSearch
     * @param array $options for select2 widget
     * @return $this the field object itself
     */
    public function select2Input($items, $enableSearch = true, $options = [], $select2Options = [])
    {
        if($enableSearch == false)
        {
            $select2Options['minimumResultsForSearch'] = -1;
        }
        $options['placeholder'] = Html::getDefaultPrompt();
        return $this->widget(ESelect2::className(), ['data' => $items, 'select2Options' => $select2Options, 'options' => $options]);
    }
}
