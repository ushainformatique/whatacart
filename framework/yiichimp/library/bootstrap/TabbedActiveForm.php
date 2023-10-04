<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\bootstrap;

/**
 * Override bootstrap ActiveForm class for changes specific to tabbed form.
 * 
 * @package usni\library\bootstrap
 */
class TabbedActiveForm extends ActiveForm
{
    /**
     * @inheritdoc
     * Register script related to errors
     */
    public function run()
    {
        parent::run();
        if ($this->enableClientScript)
        {
            $formId             = $this->getId();
            $script             = "$('#{$formId}').on('afterValidate',
                                         function(event, jqXHR, settings)
                                         {
                                            var form = $(this);
                                            if(form.find('.has-error').length) {
                                                $('#formErrorsInfo').show();
                                                return false;
                                            }
                                            $('#formErrorsInfo').hide();
                                            return true;
                                         });";
            $this->getView()->registerJs($script);
        }
    }
}