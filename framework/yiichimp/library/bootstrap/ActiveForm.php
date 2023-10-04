<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\bootstrap;

use usni\library\bootstrap\ActiveField;
/**
 * Override yii2 bootstrap ActiveForm class for changes specific to framework.
 * 
 * @package usni\library\bootstrap
 */
class ActiveForm extends \yii\bootstrap\ActiveForm
{
    /**
     * @inheritdoc
     * @see fieldConfig
     */
    public $fieldClass = 'usni\library\bootstrap\ActiveField';
    
    /**
     * @inheritdoc
     */
    public $fieldConfig = [ 'template' => "{beginLabel}{labelTitle}{endLabel}{beginWrapper}{input}{error}{endWrapper}",
                            'horizontalCssClasses' => [
                                                        'label'     => 'col-sm-2',
                                                        'offset'    => '',
                                                        'wrapper'   => 'col-sm-10',
                                                        'error'     => '',
                                                        'hint'      => '',
                                                   ]];
    /**
     * View using which form is decorated. If false no decoration would be done
     * @var string 
     */
    public $decoratorView = '@usni/library/views/layouts/edit.php';
    
    /**
     * @var string the caption for the form
     */
    public $caption;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        //ob_start();
        //ob_implicit_flush(false);
        parent::init();
    }
    
    /**
     * @inheritdoc
     * Register script related to submit
     */
    public function run()
    {
        $formContent = parent::run();
        //Get the form content
        //$formContent = ob_get_clean();
        
        //Get form content decorated
        if($this->decoratorView !== false)
        {
            echo $this->getView()->render($this->decoratorView, ['title' => $this->caption,
                                                                  'content' => $formContent]);
        }
        else
        {
            echo $formContent;
        }
        if ($this->enableClientScript)
        {
            $js = "$(function () {
                      $('[data-toggle=\"tooltip\"]').tooltip()
            })";
            $this->getView()->registerJs($js);
            $formId             = $this->getId();
            $script             = "$('#{$formId}').on('beforeSubmit',
                                         function(event)
                                         {
                                            var form = $(this);
                                            if(form.find('.has-error').length) {
                                                    return false;
                                            }
                                            attachButtonLoader(form);
                                            return true;
                                         }
                                    );";
            $this->getView()->registerJs($script); 
            $script = '$(".select2-container").tooltip({
                            title: function() {
                                return $(this).next().data("hint");
                            },
                        });';
            $this->getView()->registerJs($script);
        }
    }
    
    /**
     * inheritdoc
     * @return ActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = array())
    {
        return parent::field($model, $attribute, $options);
    }
}