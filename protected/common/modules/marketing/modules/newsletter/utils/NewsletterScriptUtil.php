<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\utils;

/**
 * NewsletterScriptUtil class file.
 * 
 * @package newsletter\utils
 */
class NewsletterScriptUtil
{   
    /**
     * Send newsletter script.
     * @param \yii\web\View $view
     * @param string $url
     * @param string $formId
     * @return void.
     */
    public static function registerSendNewsletterScripts($view, $url, $formId)
    {
        $script             = "$('#{$formId}').on('beforeSubmit',
                                     function(event)
                                     {
                                        var form = $(this);
                                        if(form.find('.has-error').length) {
                                                return false;
                                        }
                                        $.ajax({
                                                    url: '{$url}',
                                                    type: 'post',
                                                    data: form.serialize(),
                                                    'beforeSend' : function()
                                                                {
                                                                    attachButtonLoader(form);
                                                                    $('.alert-newsletter').hide();
                                                                },
                                                })
                                        .done(function(data, statusText, xhr){
                                                                $('#newsletterform').hide();
                                                                $('#newslettersuccessmessage').show();
                                                                removeButtonLoader(form);
                                                              });

                                                return false;
                                     })";
        $view->registerJs($script);
    }
}
