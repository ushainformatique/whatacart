<?php

/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
/**
 * Wrapper for ivaynberg jQuery select2 (https://github.com/ivaynberg/select2)
 *
 * @author Anggiajuang Patria <anggiaj@gmail.com>
 * @link http://git.io/Mg_a-w
 * @license http://www.opensource.org/licenses/apache2.0.php
 */
namespace usni\library\extensions\select2;

use yii\widgets\InputWidget;
use usni\library\extensions\select2\Select2Asset;
use usni\library\utils\ArrayUtil;
use yii\helpers\Json;
use usni\library\utils\Html;
use usni\UsniAdaptor;

class ESelect2 extends InputWidget
{
    /**
     * @var array select2 options
     */
    public $select2Options = array();
    /**
     * @var array Html::dropDownList $data param
     */
    public $data = array();
    /**
     * @var string html element selector
     */
    public $selector;
    /**
     * @var array javascript event handlers
     */
    public $events = array();
    
    /**
     * @var bool whether to show the toggle all button for selection all options in a multiple select.
     */
    public $showToggleAll = true;
    
    /**
     * @var array the toggle all button settings for selecting/unselecting all the options. This is applicable only for
     * multiple select. The following array key properties can be set:
     * - `selectLabel`: string, the markup to be shown to select all records. Defaults to `<i class="glyphicon
     *     glyphicon-unchecked"></i> Select all`.
     * - `unselectLabel`: string, the markup to be shown to unselect all records. Defaults to `<i class="glyphicon
     *     glyphicon-checked"></i> Unselect all`.
     * - `selectOptions`: array, the HTML attributes for the container wrapping the select label. Defaults to `[]`.
     * - `unselectOptions`: array, the HTML attributes for the container wrapping the unselect label. Defaults to `[]`.
     * - `options`: array, the HTML attributes for the toggle button container. Defaults to:
     *   `['class' => 's2-togall-button']`.
     */
    public $toggleAllSettings = [];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $view = $this->getView();
        if ($this->selector == null)
        {
            $this->selector = '#' . $this->options['id'];
        }
        //Multiple selection
        $multiple = ArrayUtil::getValue($this->select2Options, 'multiple', false);
        unset($this->select2Options['multiple']);
        $multiple = ArrayUtil::getValue($this->options, 'multiple', $multiple);
        $this->options['multiple'] = $multiple;

        //Set width
        if (empty($this->select2Options['width']))
        {
            $this->select2Options['width'] = '100%';
        }
        $this->initPlaceholder();
        if (!isset($this->options['multiple']))
        {
            $data = array();
            if (isset($this->select2Options['placeholder']))
            {
                $data[''] = '';
            }
            $this->data = $data + $this->data;
        }
        //Move to a sub method so that it could be extended easily
        $this->renderDropdownList();
        $this->renderToggleAll();
        Select2Asset::register($view);
        $options = Json::encode($this->select2Options);
        ob_start();
        echo "jQuery('select{$this->selector}').select2({$options})";
        foreach ($this->events as $event => $handler)
        {
            echo ".on('{$event}', " . Json::encode($handler) . ")";
        }
        $view->registerJs(ob_get_clean());
    }

    /**
     * Renders dropdown list
     */
    protected function renderDropdownList()
    {
        if ($this->hasModel())
        {
            $modelHints = $this->model->attributeHints();
            $hint       = null;
            if(!empty($modelHints))
            {
                $hint = ArrayUtil::getValue($modelHints, $this->attribute, null);
            }
            if($hint != null)
            {
                $this->options['data-hint'] = $hint;
            }
            
            echo Html::activeDropDownList($this->model, $this->attribute, $this->data, $this->options);
        }
        else
        {
            $this->options['id'] = $this->id;
            echo Html::dropDownList($this->name, $this->value, $this->data, $this->options);
        }
    }

    /**
     * Registers translations.
     */
    public function registerTranslations()
    {
        UsniAdaptor::app()->i18n->translations['select2'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@usni/library/extensions/select2/messages'
        ];
    }

    /**
     * Initializes the placeholder for Select2
     * @see https://github.com/kartik-v/yii2-widget-select2 
     */
    protected function initPlaceholder()
    {
        $isMultiple = ArrayUtil::getValue($this->options, 'multiple', false);
        if (isset($this->options['prompt']) && !isset($this->select2Options['placeholder']))
        {
            $this->select2Options['placeholder'] = $this->options['prompt'];
            if ($isMultiple)
            {
                unset($this->options['prompt']);
            }
            return;
        }
        if (isset($this->options['placeholder']))
        {
            $this->select2Options['placeholder'] = $this->options['placeholder'];
            unset($this->options['placeholder']);
        }
        if (isset($this->select2Options['placeholder']) && is_string($this->select2Options['placeholder']) && !$isMultiple)
        {
            $this->options['prompt'] = $this->select2Options['placeholder'];
        }
    }

    /**
     * Initializes and render the toggle all button
     * @see https://github.com/kartik-v/yii2-widget-select2 
     */
    protected function renderToggleAll()
    {
        if (!$this->options['multiple'] || !$this->showToggleAll)
        {
            return;
        }
        $settings = array_replace_recursive([
            'selectLabel' => '<i class="glyphicon glyphicon-unchecked"></i>' . UsniAdaptor::t('select2', 'Select all'),
            'unselectLabel' => '<i class="glyphicon glyphicon-check"></i>' . UsniAdaptor::t('select2', 'Unselect all'),
            'selectOptions' => [],
            'unselectOptions' => [],
            'options' => ['class' => 's2-togall-button']
            ], $this->toggleAllSettings);
        $sOptions = $settings['selectOptions'];
        $uOptions = $settings['unselectOptions'];
        $options = $settings['options'];
        $prefix = 's2-togall-';
        Html::addCssClass($options, "{$prefix}select");
        Html::addCssClass($sOptions, "s2-select-label");
        Html::addCssClass($uOptions, "s2-unselect-label");
        $options['id'] = $prefix . $this->options['id'];
        $labels = Html::tag('span', $settings['selectLabel'], $sOptions) .
            Html::tag('span', $settings['unselectLabel'], $uOptions);
        $out = Html::tag('span', $labels, $options);
        echo Html::tag('span', $out, ['id' => 'parent-' . $options['id'], 'style' => 'display:none']);
    }
}
