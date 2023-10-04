<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\bootstrap;

use usni\library\utils\Html;
use usni\UsniAdaptor;

/**
 * FormButtons renders form buttons which would be mainly save and cancel.
 * This could be used for both admin and frontend. 
 *
 * @package usni\library\bootstrap
 */
class FormButtons extends \yii\bootstrap\Widget
{
    /**
     * Layout under which buttons would be rendered
     * @var string 
     */
    public $layout = "<div class='form-actions text-right'>{submit}\n{cancel}</div>";
    
    /**
     * Html options for the submit button
     * @var array 
     */
    public $submitButtonOptions = ['class' => 'btn btn-primary', 'id' => 'save'];
    
    /**
     * Label for the submit button
     * @var string 
     */
    public $submitButtonLabel;
    
    /**
     * Html options for the cancel button
     * @var array 
     */
    public $cancelButtonOptions = ['id' => 'cancel-button', 'class' => 'btn btn-default'];
    
    /**
     * Label for the cancel link
     * @var string 
     */
    public $cancelLinkLabel;
    
    /**
     * Cancel button url
     * @var array 
     */
    public $cancelUrl;
    
    /**
     * Show cancel button
     * @var boolean 
     */
    public $showCancelButton = true;
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        return $content;
    }
    
    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{label}`, `{field}`.
     * @return string|boolean the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) 
        {
            case '{submit}':
                return $this->renderSubmitButton();
            case '{cancel}':
                return $this->renderCancelButton();
            default:
                return false;
        }
    }
    
    /**
     * Renders submit button
     * @return string
     */
    public function renderSubmitButton()
    {
        if($this->submitButtonLabel == null)
        {
            $this->submitButtonLabel = UsniAdaptor::t('application', 'Save');
        }
        return Html::submitButton($this->submitButtonLabel, $this->submitButtonOptions);
    }
    
    /**
     * Renders cancel button
     * @return string
     */
    public function renderCancelButton()
    {
        if($this->showCancelButton)
        {
            if($this->cancelLinkLabel == null)
            {
                $this->cancelLinkLabel = UsniAdaptor::t('application', 'Cancel');
            }
            return Html::a($this->cancelLinkLabel, $this->cancelUrl, $this->cancelButtonOptions);
        }
        return null;
    }
}
