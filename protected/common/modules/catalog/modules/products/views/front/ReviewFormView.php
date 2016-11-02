<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views\front;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\UsniAdaptor;
use usni\library\utils\ButtonsUtil;
use frontend\utils\FrontUtil;
use usni\library\utils\ArrayUtil;

/**
 * ReviewFormView class file.
 *
 * @package products\views\front
 */
class ReviewFormView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $userModel = UsniAdaptor::app()->user->getUserModel();
        if($userModel == null)
        {
            $condElements['name'] = array('type' => 'text');
        }
        else
        {
            if($userModel->person->firstname == null)
            {
                $fullName = $userModel->username;
            }
            else
            {
                $fullName = $userModel->person->getFullName();
            }
            $condElements['name'] = array('type' => 'hidden', 'value' => $fullName);
        }
        $elements = array(
            'review'           => array('type' => 'textarea', 'cols' => 10, 'rows' => 10),
            'product_id'       => array('type' => 'hidden'),
            'status'           => array('type' => 'hidden'),
        );
        $elements = ArrayUtil::merge($condElements, $elements);
        $metadata = array(
            'elements' => $elements,
            'buttons' => array(
                                'submit' => ButtonsUtil::getSubmitButton(UsniAdaptor::t('application', 'Submit')),
                              )
        );

        return $metadata;
    }

    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('products', 'Write Review');
    }

    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        $message = UsniAdaptor::t('productflash', 'Thank you for your review. It has been submitted to the admin for approval.');
        $flash   = '<div class="alert alert-success alert-review">' . $message . '</div>';
        return $flash;
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        $url            = UsniAdaptor::createUrl('catalog/products/site/review');
        $formId         = static::getFormId();
        $js             = "$('#{$formId}').on('beforeSubmit',
                                     function(event, jqXHR, settings)
                                     {
                                        var form = $(this);
                                        if(form.find('.has-error').length) {
                                                return false;
                                        }
                                        $.ajax({
                                                'type':'POST',
                                                'url': '{$url}',
                                                'data':form.serialize(),
                                                'beforeSend' : function()
                                                                {
                                                                    attachButtonLoader(form);
                                                                    $('.alert-review').hide();
                                                                },

                                                'success':function(data)
                                                          {
                                                              $('#{$formId}')[0].reset();
                                                              $('.alert-review').show();
                                                              removeButtonLoader(form);
                                                          },
                                                });
                                              return false;
                                    })";
        $this->getView()->registerJs($js);
        $js = "$( document ).ready(function() {
                    $('.alert-review').hide();
            });";
        $this->getView()->registerJs($js);
    }
    
    /**
     * @inheritdoc
     */
    public function resolveFormViewPath()
    {
        $theme = FrontUtil::getThemeName();
        return '@themes/' . $theme . '/views/products/_reviewform';
    }
    
    /**
     * @inheritdoc
     */
    protected function buttonOptions()
    {
        return ['submit' => ['class' => 'btn btn-success']];
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return ['review' => ['inputOptions' => ['maxlength' => 200]]];
    }
}
