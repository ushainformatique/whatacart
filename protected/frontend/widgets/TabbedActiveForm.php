<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\widgets;

/**
 * Override framework ActiveForm class for changes specific to frontend.
 * 
 * @package frontend\widgets
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